<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('محتوى الموقع');
    }

    public static function getModelLabel(): string
    {
        return __('سؤال شائع');
    }

    public static function getPluralModelLabel(): string
    {
        return __('الأسئلة الشائعة');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('السؤال والإجابة'))
                    ->icon('heroicon-o-language')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Textarea::make('question.ar')
                            ->label(__('السؤال (عربي)'))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->rows(2),
                        Textarea::make('question.en')
                            ->label(__('السؤال (إنجليزي)'))
                            ->rows(2),
                        Textarea::make('answer.ar')
                            ->label(__('الإجابة (عربي)'))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->rows(6),
                        Textarea::make('answer.en')
                            ->label(__('الإجابة (إنجليزي)'))
                            ->rows(6),
                    ]),
                Section::make(__('إعدادات العرض'))
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->label(__('ترتيب العرض'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('ظاهر في الموقع'))
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label(__('السؤال'))
                    ->state(fn (Faq $record) => Str::limit($record->t('question'), 80))
                    ->searchable(query: fn ($query, $search) => $query->where('question->ar', 'like', "%{$search}%")->orWhere('question->en', 'like', "%{$search}%"))
                    ->wrap(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('الترتيب'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('ظاهر'))
                    ->boolean(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('ظاهر في الموقع')),
            ])
            ->actions([
                Actions\EditAction::make()->label(__('تعديل')),
                Actions\DeleteAction::make()->label(__('حذف')),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()->label(__('حذف المحدد')),
                ]),
            ])
            ->emptyStateHeading(__('لا توجد أسئلة بعد'))
            ->emptyStateDescription(__('أضف الأسئلة الشائعة لتظهر في الموقع وتُحَسِّن الظهور في محركات البحث'));
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
