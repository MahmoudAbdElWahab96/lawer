<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-newspaper';

    protected static \UnitEnum|null|string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'مقال';

    protected static ?string $pluralModelLabel = 'المقالات';

    protected static ?int $navigationSort = 4;

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
                        ->label('عنوان المقال (عربي)')
                        ->required(fn (string $operation) => $operation === 'create')
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, callable $set) {
                            if ($operation === 'create' && filled($state)) {
                                $set('slug', Str::slug(Str::transliterate($state)) ?? $set('slug'));
                            }
                        }),
                    TextInput::make('title.en')
                        ->label('Title (English)')
                        ->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('excerpt.ar')
                        ->label('مقدمة مختصرة (عربي) تظهر في نتائج البحث')
                        ->rows(3)
                        ->maxLength(300),
                    Textarea::make('excerpt.en')
                        ->label('Excerpt (English)')
                        ->rows(3)
                        ->maxLength(300),
                ]),
                Grid::make(2)->schema([
                    RichEditor::make('body.ar')
                        ->label('نص المقال (عربي)')
                        ->columnSpanFull(),
                ]),
                Grid::make(2)->schema([
                    RichEditor::make('body.en')
                        ->label('Article body (English)'),
                ]),
                Section::make('النشر والصورة')->schema([
                    TextInput::make('slug')
                        ->label('الرابط (slug)')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->regex('/^[a-z0-9-]+$/')
                        ->helperText('حروف إنجليزية صغيرة وأرقام فقط (مثال: example-my-article)')
                        ->maxLength(255),
                    FileUpload::make('cover_path')
                        ->label('صورة الغلاف')
                        ->image()
                        ->imageEditor()
                        ->directory('articles')
                        ->disk('public')
                        ->columnSpanFull(),
                    Grid::make(2)->schema([
                        Toggle::make('is_published')
                            ->label('منشور')
                            ->default(false)
                            ->live(),
                        DateTimePicker::make('published_at')
                            ->label('تاريخ النشر')
                            ->default(now())
                            ->required(fn (callable $get) => $get('is_published'))
                            ->maxTime(now()->format('H:i:s')),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_path')
                    ->label('الغلاف')
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->state(fn (Article $record) => $record->t('title'))
                    ->searchable(query: fn ($query, $search) => $query->where('title->ar', 'like', "%{$search}%")->orWhere('title->en', 'like', "%{$search}%"))
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->date('Y/m/d')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('منشور'),
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
            ->emptyStateHeading('لا توجد مقالات بعد')
            ->emptyStateDescription('المقالات أهم أداة لتحسين ترتيب الموقع في محركات البحث');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
