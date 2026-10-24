<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PracticeAreaResource\Pages;
use App\Models\PracticeArea;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PracticeAreaResource extends Resource
{
    protected static ?string $model = PracticeArea::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-scale';

    protected static \UnitEnum|null|string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'مجال ممارسة';

    protected static ?string $pluralModelLabel = 'مجالات الممارسة';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('name.ar')
                        ->label('اسم المجال (عربي)')
                        ->required(fn (string $operation) => $operation === 'create')
                        ->maxLength(255),
                    TextInput::make('name.en')
                        ->label('المجال (English)')
                        ->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('description.ar')
                        ->label('الوصف (عربي)')
                        ->rows(3),
                    Textarea::make('description.en')
                        ->label('Description (English)')
                        ->rows(3),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('slug')
                        ->label('المعرّف (بالإنجليزية)')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->regex('/^[a-z0-9-]+$/')
                        ->helperText('يُستخدم في الروابط — حروف إنجليزية صغيرة وأرقام وشرطات فقط')
                        ->maxLength(255),
                    Select::make('icon')
                        ->label('الأيقونة')
                        ->options([
                            'users' => 'الأسرة والأحوال الشخصية',
                            'gavel' => 'القضايا الجنائية',
                            'briefcase' => 'الأعمال والشركات',
                            'building' => 'العقارات',
                            'hard-hat' => 'القضايا العمالية',
                            'scroll' => 'الميراث والوصايا',
                            'scale' => 'التحكيم والنزاعات',
                            'shield' => 'الجرائم الإلكترونية',
                            'document' => 'صياغة العقود',
                            'globe' => 'عام',
                        ]),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('المجال')
                    ->state(fn (PracticeArea $record) => $record->t('name'))
                    ->searchable(query: fn ($query, $search) => $query->where('name->ar', 'like', "%{$search}%")->orWhere('name->en', 'like', "%{$search}%"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('المعرّف')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    -> sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('ظاهر')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->since()
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
            ->emptyStateHeading('لا توجد مجالات بعد')
            ->emptyStateDescription('أضف مجالات ممارستك القانونية لتظهر في الصفحة الرئيسية');
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
