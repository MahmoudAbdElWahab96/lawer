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

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return __('المحتوى');
    }

    public static function getModelLabel(): string
    {
        return __('مقال');
    }

    public static function getPluralModelLabel(): string
    {
        return __('المقالات');
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
                        ->label(__('عنوان المقال (عربي)'))
                        ->required(fn (string $operation) => $operation === 'create')
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, callable $set) {
                            if ($operation === 'create' && filled($state)) {
                                $set('slug', Str::slug(Str::transliterate($state)) ?? $set('slug'));
                            }
                        }),
                    TextInput::make('title.en')
                        ->label(__('عنوان المقال (إنجليزي)'))
                        ->maxLength(255),
                ]),
                Grid::make(2)->columnSpanFull()->schema([
                    Textarea::make('excerpt.ar')
                        ->label(__('مقدمة مختصرة (عربي) تظهر في نتائج البحث'))
                        ->rows(3)
                        ->maxLength(300),
                    Textarea::make('excerpt.en')
                        ->label(__('مقدمة مختصرة (إنجليزي) تظهر في نتائج البحث'))
                        ->rows(3)
                        ->maxLength(300),
                ]),
                Grid::make(2)->columnSpanFull()->schema([
                    RichEditor::make('body.ar')
                        ->label(__('نص المقال (عربي)'))
                        ->columnSpanFull(),
                ]),
                Grid::make(2)->columnSpanFull()->schema([
                    RichEditor::make('body.en')
                        ->label(__('نص المقال (إنجليزي)')),
                ]),
                Section::make(__('النشر والصورة'))->schema([
                    TextInput::make('slug')
                        ->label(__('الرابط (slug)'))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->regex('/^[a-z0-9-]+$/')
                        ->helperText(__('حروف إنجليزية صغيرة وأرقام فقط (مثال: example-my-article)'))
                        ->maxLength(255),
                    FileUpload::make('cover_path')
                        ->label(__('صورة الغلاف'))
                        ->image()
                        ->imageEditor()
                        ->directory('articles')
                        ->disk('public')
                        ->columnSpanFull(),
                    Grid::make(2)->schema([
                        Toggle::make('is_published')
                            ->label(__('منشور'))
                            ->default(false)
                            ->live(),
                        DateTimePicker::make('published_at')
                            ->label(__('تاريخ النشر'))
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
                    ->label(__('الغلاف'))
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('العنوان'))
                    ->state(fn (Article $record) => $record->t('title'))
                    ->searchable(query: fn ($query, $search) => $query->where('title->ar', 'like', "%{$search}%")->orWhere('title->en', 'like', "%{$search}%"))
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('منشور'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('تاريخ النشر'))
                    ->date('Y/m/d')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label(__('منشور')),
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
            ->emptyStateHeading(__('لا توجد مقالات بعد'))
            ->emptyStateDescription(__('المقالات أهم أداة لتحسين ترتيب الموقع في محركات البحث'));
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
