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

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('المحتوى');
    }

    public static function getModelLabel(): string
    {
        return __('ميزة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('مميزات المكتب (لماذا تختارنا)');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)->columnSpanFull()->schema([
                    TextInput::make('title.ar')
                        ->label(__('عنوان الميزة (عربي)'))
                        ->required(fn (string $operation) => $operation === 'create')
                        ->maxLength(255),
                    TextInput::make('title.en')
                        ->label(__('عنوان الميزة (إنجليزي)'))
                        ->maxLength(255),
                ]),
                Grid::make(2)->columnSpanFull()->schema([
                    Textarea::make('text.ar')
                        ->label(__('الشرح (عربي)'))
                        ->rows(3),
                    Textarea::make('text.en')
                        ->label(__('الشرح (إنجليزي)'))
                        ->rows(3),
                ]),
                Grid::make(3)->columnSpanFull()->schema([
                    Select::make('icon')
                        ->label(__('الأيقونة'))
                        ->options([
                            'experience' => __('خبرة'),
                            'strategy' => __('استراتيجية'),
                            'trophy' => __('إنجازات'),
                            'shield' => __('سرية وحماية'),
                            'clock' => __('سرعة استجابة'),
                            'users' => __('فريق عمل'),
                        ]),
                    TextInput::make('sort_order')->label(__('ترتيب العرض'))->numeric()->default(0),
                    Toggle::make('is_active')->label(__('ظاهر في الموقع'))->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('الميزة'))
                    ->state(fn (Feature $record) => $record->t('title'))
                    ->searchable(query: fn ($query, $search) => $query->where('title->ar', 'like', "%{$search}%")->orWhere('title->en', 'like', "%{$search}%"))
                    ->wrap(),
                Tables\Columns\TextColumn::make('text')
                    ->label(__('الشرح'))
                    ->state(fn (Feature $record) => Str::limit($record->t('text'), 60))
                    ->wrap()
                    ->toggleable(),
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
                Tables\Filters\TernaryFilter::make('is_active')->label(__('ظاهر في الموقع')),
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
            ->emptyStateHeading(__('لا توجد مميزات بعد'))
            ->emptyStateDescription(__('أضف ما يميز مكتبك لتظهر في قسم «لماذا تختارنا»'));
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
