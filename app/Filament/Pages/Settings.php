<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Settings extends Page
{
    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.settings';

    protected static \UnitEnum|null|string $navigationGroup = 'الإعدادات';

    protected static ?string $navigationLabel = 'إعدادات الموقع واللاندنج بيج';

    protected static ?string $title = 'إعدادات الموقع والواجهة';

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
                $this->statsSection(),
                $this->aboutSection(),
                $this->practiceSection(),
                $this->pledgeSection(),
                $this->routeSection(),
                $this->messagesSection(),
                $this->faqSection(),
                $this->bookingSection(),
                $this->contactSection(),
                $this->seoSection(),
            ])
            ->statePath('data');
    }

    protected function officeSection(): Section
    {
        return Section::make('1. بيانات المحامي والمكتب الأساسية')
            ->icon('heroicon-o-identification')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('lawyer_name.ar')->label('اسم المحامي (عربي)')->required()->maxLength(255),
                    TextInput::make('lawyer_name.en')->label('Lawyer Name (English)')->required()->maxLength(255),
                    TextInput::make('lawyer_title.ar')->label('المسمى / الصفة (عربي)')->maxLength(255),
                    TextInput::make('lawyer_title.en')->label('Title / Credentials (English)')->maxLength(255),
                    TextInput::make('bar_admission_year')->label('سنة القيد بنقابة المحامين (مثال: 2009)')->maxLength(50),
                    TextInput::make('email')->label('البريد الإلكتروني')->email()->maxLength(255),
                ]),
            ]);
    }

    protected function heroSection(): Section
    {
        return Section::make('2. الواجهة الأولى (Hero Section)')
            ->icon('heroicon-o-sparkles')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('hero_headline.ar')->label('العنوان الرئيسي (عربي)')->maxLength(255),
                    TextInput::make('hero_headline.en')->label('Headline (English)')->maxLength(255),
                    Textarea::make('hero_subheadline.ar')->label('العنوان الفرعي (عربي)')->rows(3),
                    Textarea::make('hero_subheadline.en')->label('Sub-headline (English)')->rows(3),
                ]),
                FileUpload::make('hero_image_path')
                    ->label('صورة المحامي في الواجهة (اختياري)')
                    ->image()
                    ->directory('settings')
                    ->disk('public')
                    ->imageEditor()
                    ->helperText('إذا تُركت فارغة تُستخدم صورة التصميم الأصلية'),
            ]);
    }

    protected function statsSection(): Section
    {
        return Section::make('3. شريط أرقام وإحصائيات الهيرو')
            ->icon('heroicon-o-chart-bar')
            ->collapsible()
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('years_experience')
                        ->label('سنوات الخبرة')
                        ->helperText('تظهر: +15 عامًا من الممارسة / Years of Practice')
                        ->numeric()
                        ->minValue(0),
                    TextInput::make('clients_count')
                        ->label('عدد الموكلين')
                        ->helperText('تظهر: +2000 موكل وثقوا بنا / Clients Trusted Us')
                        ->numeric()
                        ->minValue(0),
                    TextInput::make('lawyers_count')
                        ->label('محامو الفريق')
                        ->helperText('تظهر: +20 محاميًا في الفريق / Lawyers in the Team')
                        ->numeric()
                        ->minValue(0),
                ]),
            ]);
    }

    protected function aboutSection(): Section
    {
        return Section::make('4. قسم «عن المستشار»')
            ->icon('heroicon-o-user')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('about_title.ar')->label('عنوان القسم (عربي)')->maxLength(255),
                    TextInput::make('about_title.en')->label('Section Title (English)')->maxLength(255),
                ]),
                RichEditor::make('about_text.ar')->label('نبذة عن المستشار (عربي)')->columnSpanFull(),
                RichEditor::make('about_text.en')->label('About the Counselor (English)')->columnSpanFull(),
            ]);
    }

    protected function practiceSection(): Section
    {
        return Section::make('5. قسم مجالات الممارسة: ملفات نحملها عنك')
            ->icon('heroicon-o-scale')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('practice_title.ar')->label('عنوان السكشن (عربي)')->maxLength(255),
                    TextInput::make('practice_title.en')->label('Section Title (English)')->maxLength(255),
                    Textarea::make('practice_subtitle.ar')->label('العنوان الفرعي (عربي)')->rows(2),
                    Textarea::make('practice_subtitle.en')->label('Subtitle (English)')->rows(2),
                    TextInput::make('practice_banner_title.ar')->label('عنوان بانر لا تعرف من أين تبدأ (عربي)')->maxLength(255),
                    TextInput::make('practice_banner_title.en')->label('Banner Title (English)')->maxLength(255),
                    Textarea::make('practice_banner_text.ar')->label('نص بانر الواتساب (عربي)')->rows(2),
                    Textarea::make('practice_banner_text.en')->label('Banner Text (English)')->rows(2),
                ]),
            ]);
    }

    protected function pledgeSection(): Section
    {
        return Section::make('6. قسم التعهدات: أربعة بنود نلتزم بها')
            ->icon('heroicon-o-document-check')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    Textarea::make('pledge_title.ar')->label('عنوان سكشن التعهد (عربي)')->rows(2),
                    Textarea::make('pledge_title.en')->label('Pledge Title (English)')->rows(2),
                    Textarea::make('pledge_subtitle.ar')->label('العنوان الفرعي للتعهد (عربي)')->rows(2),
                    Textarea::make('pledge_subtitle.en')->label('Pledge Subtitle (English)')->rows(2),
                    TextInput::make('pledge_sign_text.ar')->label('نص توقيع القلم (عربي)')->maxLength(255),
                    TextInput::make('pledge_sign_text.en')->label('Signature Text (English)')->maxLength(255),
                ]),
            ]);
    }

    protected function routeSection(): Section
    {
        return Section::make('7. قسم مسار الملف: من أول مكالمة حتى إغلاق الملف')
            ->icon('heroicon-o-map')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('route_title.ar')->label('عنوان السكشن (عربي)')->maxLength(255),
                    TextInput::make('route_title.en')->label('Section Title (English)')->maxLength(255),
                    Textarea::make('route_subtitle.ar')->label('العنوان الفرعي (عربي)')->rows(2),
                    Textarea::make('route_subtitle.en')->label('Subtitle (English)')->rows(2),
                ]),
            ]);
    }

    protected function messagesSection(): Section
    {
        return Section::make('8. قسم محاكاة محادثة الواتساب: محاميك في جيبك')
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('messages_title.ar')->label('عنوان السكشن (عربي)')->maxLength(255),
                    TextInput::make('messages_title.en')->label('Section Title (English)')->maxLength(255),
                    Textarea::make('messages_subtitle.ar')->label('العنوان الفرعي (عربي)')->rows(2),
                    Textarea::make('messages_subtitle.en')->label('Subtitle (English)')->rows(2),
                ]),
            ]);
    }

    protected function faqSection(): Section
    {
        return Section::make('9. قسم الأسئلة الشائعة')
            ->icon('heroicon-o-question-mark-circle')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('faq_title.ar')->label('عنوان السكشن (عربي)')->maxLength(255),
                    TextInput::make('faq_title.en')->label('Section Title (English)')->maxLength(255),
                    Textarea::make('faq_subtitle.ar')->label('العنوان الفرعي (عربي)')->rows(2),
                    Textarea::make('faq_subtitle.en')->label('Subtitle (English)')->rows(2),
                ]),
            ]);
    }

    protected function bookingSection(): Section
    {
        return Section::make('10. قسم حجز الاستشارة: افتح ملفك معنا اليوم')
            ->icon('heroicon-o-clipboard-document-list')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    Textarea::make('booking_title.ar')->label('عنوان السكشن (عربي)')->rows(2),
                    Textarea::make('booking_title.en')->label('Section Title (English)')->rows(2),
                    Textarea::make('booking_subtitle.ar')->label('العنوان الفرعي (عربي)')->rows(2),
                    Textarea::make('booking_subtitle.en')->label('Subtitle (English)')->rows(2),
                ]),
            ]);
    }

    protected function contactSection(): Section
    {
        return Section::make('11. بيانات التواصل، موقع المكتب والخريطة')
            ->icon('heroicon-o-map-pin')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('contact_title.ar')->label('عنوان السكشن (عربي)')->maxLength(255),
                    TextInput::make('contact_title.en')->label('Section Title (English)')->maxLength(255),
                    Textarea::make('contact_subtitle.ar')->label('العنوان الفرعي (عربي)')->rows(2),
                    Textarea::make('contact_subtitle.en')->label('Subtitle (English)')->rows(2),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('phone')->label('رقم الهاتف')->tel()->maxLength(255),
                    TextInput::make('whatsapp')->label('رقم الواتساب')->tel()->helperText('بصيغة دولية مثل +201101201034')->maxLength(255),
                    TextInput::make('map_embed_url')
                        ->label('موقع المكتب في خرائط جوجل')
                        ->maxLength(1000)
                        ->helperText('يمكنك وضع رابط المشاركة (maps.app.goo.gl)، أو رابط التضمين، أو كود iframe، حيث يتم التعرف عليه وتضمينه تلقائيًا.'),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('address.ar')->label('العنوان (عربي)')->maxLength(500),
                    TextInput::make('address.en')->label('Address (English)')->maxLength(500),
                    TextInput::make('working_hours.ar')->label('مواعيد العمل (عربي)')->maxLength(255),
                    TextInput::make('working_hours.en')->label('Working hours (English)')->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('footer_text.ar')->label('نص الفوتر التعريفي (عربي)')->rows(2)->maxLength(255),
                    Textarea::make('footer_text.en')->label('Footer Description Text (English)')->rows(2)->maxLength(255),
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

    protected function seoSection(): Section
    {
        return Section::make('12. إعدادات SEO وكود التحقق من Google')
            ->icon('heroicon-o-globe-alt')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('seo_meta_title.ar')->label('عنوان الصفحة في نتائج البحث (عربي)')->maxLength(70),
                    TextInput::make('seo_meta_title.en')->label('Meta Title (English)')->maxLength(70),
                    Textarea::make('seo_meta_description.ar')->label('وصف الصفحة في نتائج البحث (عربي)')->rows(3)->maxLength(170),
                    Textarea::make('seo_meta_description.en')->label('Meta Description (English)')->rows(3)->maxLength(170),
                    Textarea::make('seo_keywords.ar')->label('الكلمات المفتاحية (عربي)')->rows(2),
                    Textarea::make('seo_keywords.en')->label('Keywords (English)')->rows(2),
                ]),
                FileUpload::make('seo_og_image_path')
                    ->label('صورة المشاركة الاجتماعية (Open Graph)')
                    ->image()
                    ->directory('settings')
                    ->disk('public')
                    ->imageEditor(),
                Grid::make(2)->schema([
                    Toggle::make('seo_robots_index')->label('السماح لمحركات البحث بفهرسة الموقع')->default(true),
                    TextInput::make('google_verification')->label('كود التحقق من Google Search Console')->maxLength(255),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ جميع الإعدادات')
                ->icon('heroicon-o-check-circle')
                ->action(fn () => $this->save()),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['hero_image_path', 'seo_og_image_path'] as $uploadField) {
            $data[$uploadField] = data_get($data, $uploadField.'.0');
        }

        Setting::query()->updateOrCreate(['id' => 1], $data);

        Notification::make()
            ->title('تم حفظ وتحديث جميع إعدادات الموقع بنجاح')
            ->success()
            ->send();
    }
}
