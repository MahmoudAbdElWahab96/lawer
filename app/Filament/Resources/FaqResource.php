<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static \UnitEnum|null|string $navigationGroup = 'محتوى الموقع';

    protected static ?string $modelLabel = 'سؤال شائع';

    protected static ?string $pluralModelLabel = 'الأسئلة الشائعة';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)->schema([
                    Textarea::make('question.ar')
                        ->label('السؤال (عربي)')
                        ->required(fn (string $operation) => $operation === 'create')
                        ->rows(2),
                    Textarea::make('question.en')
                        ->label('Question (English)')
                        ->rows(2),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('answer.ar')
                        ->label('الإجابة (عربي)')
                        ->required(fn (string $operation) => $operation === 'create')
                        ->rows(5),
                    Textarea::make('answer.en')
                        ->label('Answer (English)')
                        ->rows(5),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('sort_order')
                        ->label('ترتيب العرض')
                        ->numeric()
                        ->default(0),
                    Toggle::make('is_active')
                        ->label('ظاهر في الموقع')
                        ->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('السؤال')
                    ->state(fn (Faq $record) => Str::limit($record->t('question'), 80))
                    ->searchable(query: fn ($query, $search) => $query->where('question->ar', 'like', "%{$search}%")->orWhere('question->en', 'like', "%{$search}%"))
                    ->wrap(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('ظاهر')
                    ->boolean(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('ظاهر في الموقع'),
            ])
            ->actions([
                Actions\EditAction::make()->label('تعديل'),
                Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ])
            ->emptyStateHeading('لا توجد أسئلة بعد')
            ->emptyStateDescription('أضف الأسئلة الشائعة لتظهر في الموقع وتُحَسِّن الظهور في محركات البحث');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
