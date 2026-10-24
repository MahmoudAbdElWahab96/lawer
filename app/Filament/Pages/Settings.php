<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components;

class Settings extends Page
{
    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.settings';

    protected static \UnitEnum|null|string $navigationGroup = 'الإعدادات';

    protected static ?string $navigationLabel = 'إعدادات الموقع';

    protected static ?string $title = 'إعدادات الموقع';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $settings = Setting::findOrNew();

        $this->form->fill($settings->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->officeSection(),
                $this->heroSection(),
                $this->contactSection(),
                $this->statsSection(),
                $this->seoSection(),
            ])
            ->statePath('data');
    }

    protected function officeSection(): Section
    {
        return Section::make('بيانات المحامي والمكتب')
            ->icon('heroicon-o-briefcase')
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('lawyer_name.ar')->label('اسم المحامي (عربي)')->maxLength(255),
                    TextInput::make('lawyer_name.en')->label('Name (English)')->maxLength(255),
                    TextInput::make('lawyer_title.ar')->label('المسمى/الصفة (عربي)')->maxLength(255),
                    TextInput::make('lawyer_title.en')->label('Title (English)')->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('about_title.ar')->label('عنوان قسم «عن المكتب» (عربي)')->maxLength(255),
                    TextInput::make('about_title.en')->label('About title (English)')->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    RichEditor::make('about_text.ar')->label('نبذة عن المكتب (عربي)')->columnSpanFull(),
                ]),
                Grid::make(2)->schema([
                    RichEditor::make('about_text.en')->label('About the office (English)')->columnSpanFull(),
                ]),
            ]);
    }

    protected function heroSection(): Section
    {
        return Section::make('الواجهة الرئيسية')
            ->icon('heroicon-o-home')
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('hero_headline.ar')->label('العنوان الرئيسي (عربي)')->maxLength(255),
                    TextInput::make('hero_headline.en')->label('Headline (English)')->maxLength(255),
                    Textarea::make('hero_subheadline.ar')->label('العنوان الفرعي (عربي)')->rows(3),
                    Textarea::make('hero_subheadline.en')->label('Sub-headline (English)')->rows(3),
                ]),
                Grid::make(2)->schema([
                    FileUpload::make('logo_path')
                        ->label('شعار المكتب (لوجو)')
                        ->image()
                        ->directory('settings')
                        ->disk('public')
                        ->imageEditor(),
                    FileUpload::make('hero_image_path')
                        ->label('صورة الواجهة الرئيسية')
                        ->image()
                        ->directory('settings')
                        ->disk('public')
                        ->imageEditor(),
                ]),
            ]);
    }

    protected function contactSection(): Section
    {
        return Section::make('بيانات التواصل والسوشيال ميديا')
            ->icon('heroicon-o-phone')
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('phone')->label('رقم الهاتف')->tel()->maxLength(255),
                    TextInput::make('whatsapp')->label('رقم الواتساب')->tel()->helperText('بصيغة دولية مثل +201000000000')->maxLength(255),
                    TextInput::make('email')->label('البريد الإلكتروني')->email()->maxLength(255),
                    TextInput::make('map_embed_url')->label('رابط تضمين خريطة جوجل (اختياري)')->maxLength(1000)->helperText('من خرائط جوجل: مشاركة ← تضمين خريطة ← انسخ قيمة src فقط'),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('address.ar')->label('العنوان (عربي)')->maxLength(500),
                    TextInput::make('address.en')->label('Address (English)')->maxLength(500),
                    TextInput::make('working_hours.ar')->label('مواعيد العمل (عربي)')->maxLength(255),
                    TextInput::make('working_hours.en')->label('Working hours (English)')->maxLength(255),
                ]),
                Grid::make(3)->schema([
                    TextInput::make('facebook')->label('فيسبوك')->url()->maxLength(255),
                    TextInput::make('instagram')->label('إنستجرام')->url()->maxLength(255),
                    TextInput::make('linkedin')->label('لينكدإن')->url()->maxLength(255),
                    TextInput::make('x_url')->label('X (تويتر)')->url()->maxLength(255),
                    TextInput::make('youtube')->label('يوتيوب')->url()->maxLength(255),
                ]),
            ]);
    }

    protected function statsSection(): Section
    {
        return Section::make('أرقام وإحصائيات')
            ->icon('heroicon-o-chart-bar')
            ->description('تظهر في قسم الأرقام بالصفحة الرئيسية — اتركها صفرًا لإخفاء القسم')
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('years_experience')->label('سنوات الخبرة')->numeric()->minValue(0),
                    TextInput::make('cases_count')->label('عدد القضايا')->numeric()->minValue(0),
                    TextInput::make('clients_count')->label('عدد العملاء')->numeric()->minValue(0),
                ]),
            ]);
    }

    protected function seoSection(): Section
    {
        return Section::make('إعدادات SEO — تحسين محركات البحث')
            ->icon('heroicon-o-magnifying-glass')
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('seo_meta_title.ar')->label('عنوان الصفحة في نتائج البحث (عربي)')->maxLength(70)->helperText('يفضل 50–60 حرفًا'),
                    TextInput::make('seo_meta_title.en')->label('Meta title (English)')->maxLength(70),
                    Textarea::make('seo_meta_description.ar')->label('وصف الصفحة في نتائج البحث (عربي)')->rows(3)->maxLength(170)->helperText('يفضل 140–160 حرفًا'),
                    Textarea::make('seo_meta_description.en')->label('Meta description (English)')->rows(3)->maxLength(170),
                    Textarea::make('seo_keywords.ar')->label('الكلمات المفتاحية (عربي)')->rows(2)->helperText('افصل بينها بفاصلة'),
                    Textarea::make('seo_keywords.en')->label('Keywords (English)')->rows(2),
                ]),
                FileUpload::make('seo_og_image_path')
                    ->label('صورة المشاركة الاجتماعية (Open Graph)')
                    ->image()
                    ->directory('settings')
                    ->disk('public')
                    ->imageEditor()
                    ->helperText('مقاس مثالي 1200×630 — تظهر عند مشاركة الموقع على فيسبوك وواتساب'),
                Grid::make(2)->schema([
                    Toggle::make('seo_robots_index')->label('السماح لمحركات البحث بفهرسة الموقع')->default(true),
                    TextInput::make('google_verification')->label('كود التحقق من Google Search Console')->maxLength(255)->helperText('يُضاف تلقائيًا كوسم meta في الصفحة الرئيسية'),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ الإعدادات')
                ->icon('heroicon-o-check-circle')
                ->action(fn () => $this->save()),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['logo_path', 'hero_image_path', 'seo_og_image_path'] as $uploadField) {
            $data[$uploadField] = data_get($data, $uploadField . '.0');
        }

        Setting::query()->updateOrCreate(['id' => 1], $data);

        Notification::make()
            ->title('تم حفظ الإعدادات')
            ->success()
            ->send();
    }
}
