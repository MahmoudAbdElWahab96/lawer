<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
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

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static \UnitEnum|null|string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'رأي عميل';

    protected static ?string $pluralModelLabel = 'آراء العملاء';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('client_name')
                    ->label('اسم العميل')
                    ->required()
                    ->maxLength(255),
                Grid::make(2)->schema([
                    TextInput::make('client_role.ar')
                        ->label('وصف/نوع القضية (عربي)')
                        ->maxLength(255),
                    TextInput::make('client_role.en')
                        ->label('Description (English)')
                        ->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('content.ar')
                        ->label('نص الرأي (عربي)')
                        ->required(fn (string $operation) => $operation === 'create')
                        ->rows(4),
                    Textarea::make('content.en')
                        ->label('Testimonial (English)')
                        ->rows(4),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('rating')
                        ->label('التقييم (من 5)')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(5)
                        ->default(5),
                    Toggle::make('is_active')
                        ->label('ظاهر في الموقع')
                        ->default(true),
                ]),
                TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('الرأي')
                    ->state(fn (Testimonial $record) => Str::limit($record->t('content'), 60))
                    ->wrap(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state).str_repeat('☆', 5 - $state)),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('ظاهر')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->emptyStateHeading('لا توجد آراء بعد')
            ->emptyStateDescription('أضف آراء عملائك لبناء الثقة مع الزوار');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
