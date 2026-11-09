<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PracticeAreaResource\Pages;
use App\Models\PracticeArea;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PracticeAreaResource extends Resource
{
    protected static ?string $model = PracticeArea::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-scale';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('محتوى الموقع');
    }

    public static function getModelLabel(): string
    {
        return __('مجال ممارسة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('مجالات الممارسة');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('بيانات المجال'))
                    ->icon('heroicon-o-language')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name.ar')
                            ->label(__('اسم المجال (عربي)'))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->maxLength(255),
                        TextInput::make('name.en')
                            ->label(__('اسم المجال (إنجليزي)'))
                            ->maxLength(255),
                        Textarea::make('description.ar')
                            ->label(__('الوصف (عربي)'))
                            ->rows(4),
                        Textarea::make('description.en')
                            ->label(__('الوصف (إنجليزي)'))
                            ->rows(4),
                    ]),
                Section::make(__('إعدادات العرض'))
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('المعرّف (بالإنجليزية)'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->regex('/^[a-z0-9-]+$/')
                            ->extraInputAttributes(['dir' => 'ltr'])
                            ->helperText(__('يُستخدم في الروابط: حروف إنجليزية صغيرة وأرقام فقط'))
                            ->maxLength(255),
                        Select::make('icon')
                            ->label(__('الأيقونة'))
                            ->required()
                            ->native(false)
                            ->options([
                                'd6be1.svg' => __('الأحوال الشخصية'),
                                '8ee21.svg' => __('القانون المدني'),
                                'fd282.svg' => __('القانون الجنائي'),
                                '630cd.svg' => __('الشهر العقاري'),
                                '3d433.svg' => __('القانون التجاري'),
                                '2fdca.svg' => __('إدارة الأملاك'),
                            ]),
                        TextInput::make('sort_order')
                            ->label(__('ترتيب العرض'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('ظاهر في الموقع'))
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('المجال'))
                    ->state(fn (PracticeArea $record) => $record->t('name'))
                    ->searchable(query: fn ($query, $search) => $query->where('name->ar', 'like', "%{$search}%")->orWhere('name->en', 'like', "%{$search}%"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('المعرّف'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('الترتيب'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('ظاهر'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('آخر تحديث'))
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->emptyStateHeading(__('لا توجد مجالات بعد'))
            ->emptyStateDescription(__('أضف مجالات ممارستك القانونية لتظهر في الصفحة الرئيسية'));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPracticeAreas::route('/'),
            'create' => Pages\CreatePracticeArea::route('/create'),
            'edit' => Pages\EditPracticeArea::route('/{record}/edit'),
        ];
    }
}
