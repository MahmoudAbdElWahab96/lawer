<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureResource\Pages;
use App\Models\Feature;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-star';

    protected static \UnitEnum|null|string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'ميزة';

    protected static ?string $pluralModelLabel = 'مميزات المكتب (لماذا تختارنا)';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('title.ar')
                        ->label('عنوان الميزة (عربي)')
                        ->required(fn (string $operation) => $operation === 'create')
                        ->maxLength(255),
                    TextInput::make('title.en')
                        ->label('Title (English)')
                        ->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('text.ar')
                        ->label('الشرح (عربي)')
                        ->rows(3),
                    Textarea::make('text.en')
                        ->label('Description (English)')
                        ->rows(3),
                ]),
                Grid::make(3)->schema([
                    Select::make('icon')
                        ->label('الأيقونة')
                        ->options([
                            'experience' => 'خبرة',
                            'strategy' => 'استراتيجية',
                            'trophy' => 'إنجازات',
                            'shield' => 'سرية وحماية',
                            'clock' => 'سرعة استجابة',
                            'users' => 'فريق عمل',
                        ]),
                    TextInput::make('sort_order')->label('ترتيب العرض')->numeric()->default(0),
                    Toggle::make('is_active')->label('ظاهر في الموقع')->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('الميزة')
                    ->state(fn (Feature $record) => $record->t('title'))
                    ->searchable(query: fn ($query, $search) => $query->where('title->ar', 'like', "%{$search}%")->orWhere('title->en', 'like', "%{$search}%"))
                    ->wrap(),
                Tables\Columns\TextColumn::make('text')
                    ->label('الشرح')
                    ->state(fn (Feature $record) => Str::limit($record->t('text'), 60))
                    ->wrap()
                    ->toggleable(),
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
                Tables\Filters\TernaryFilter::make('is_active')->label('ظاهر في الموقع'),
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
            ->emptyStateHeading('لا توجد مميزات بعد')
            ->emptyStateDescription('أضف ما يميز مكتبك لتظهر في قسم «لماذا تختارنا»');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
