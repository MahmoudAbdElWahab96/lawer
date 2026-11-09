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

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public static function getNavigationGroup(): string
    {
        return __('الإعدادات');
    }

    public static function getNavigationLabel(): string
    {
        return __('إعدادات الموقع واللاندنج بيج');
    }

    public function getTitle(): string
    {
        return __('إعدادات الموقع والواجهة');
    }

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
        return Section::make(__('1. بيانات المحامي والمكتب الأساسية'))
            ->icon('heroicon-o-identification')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('lawyer_name.ar')->label(__('اسم المحامي (عربي)'))->required()->maxLength(255),
                    TextInput::make('lawyer_name.en')->label(__('اسم المحامي (إنجليزي)'))->required()->maxLength(255),
                    TextInput::make('lawyer_title.ar')->label(__('المسمى / الصفة (عربي)'))->maxLength(255),
                    TextInput::make('lawyer_title.en')->label(__('المسمى / الصفة (إنجليزي)'))->maxLength(255),
                    TextInput::make('bar_admission_year')->label(__('سنة القيد بنقابة المحامين (مثال: 2009)'))->maxLength(50),
                    TextInput::make('email')->label(__('البريد الإلكتروني'))->email()->maxLength(255),
                ]),
            ]);
    }

    protected function heroSection(): Section
    {
        return Section::make(__('2. الواجهة الأولى (Hero Section)'))
            ->icon('heroicon-o-sparkles')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('hero_headline.ar')->label(__('العنوان الرئيسي (عربي)'))->maxLength(255),
                    TextInput::make('hero_headline.en')->label(__('العنوان الرئيسي (إنجليزي)'))->maxLength(255),
                    Textarea::make('hero_subheadline.ar')->label(__('العنوان الفرعي (عربي)'))->rows(3),
                    Textarea::make('hero_subheadline.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(3),
                ]),
                FileUpload::make('hero_image_path')
                    ->label(__('صورة المحامي في الواجهة (اختياري)'))
                    ->image()
                    ->directory('settings')
                    ->disk('public')
                    ->imageEditor()
                    ->helperText(__('إذا تُركت فارغة تُستخدم صورة التصميم الأصلية')),
            ]);
    }

    protected function statsSection(): Section
    {
        return Section::make(__('3. شريط أرقام وإحصائيات الهيرو'))
            ->icon('heroicon-o-chart-bar')
            ->collapsible()
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('years_experience')
                        ->label(__('سنوات الخبرة'))
                        ->helperText(__('تظهر: +15 عامًا من الممارسة / Years of Practice'))
                        ->numeric()
                        ->minValue(0),
                    TextInput::make('clients_count')
                        ->label(__('عدد الموكلين'))
                        ->helperText(__('تظهر: +2000 موكل وثقوا بنا / Clients Trusted Us'))
                        ->numeric()
                        ->minValue(0),
                    TextInput::make('lawyers_count')
                        ->label(__('محامو الفريق'))
                        ->helperText(__('تظهر: +20 محاميًا في الفريق / Lawyers in the Team'))
                        ->numeric()
                        ->minValue(0),
                ]),
            ]);
    }

    protected function aboutSection(): Section
    {
        return Section::make(__('4. قسم «عن المستشار»'))
            ->icon('heroicon-o-user')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('about_title.ar')->label(__('عنوان القسم (عربي)'))->maxLength(255),
                    TextInput::make('about_title.en')->label(__('عنوان القسم (إنجليزي)'))->maxLength(255),
                ]),
                RichEditor::make('about_text.ar')->label(__('نبذة عن المستشار (عربي)'))->columnSpanFull(),
                RichEditor::make('about_text.en')->label(__('نبذة عن المستشار (إنجليزي)'))->columnSpanFull(),
            ]);
    }

    protected function practiceSection(): Section
    {
        return Section::make(__('5. قسم مجالات الممارسة: ملفات نحملها عنك'))
            ->icon('heroicon-o-scale')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('practice_title.ar')->label(__('عنوان السكشن (عربي)'))->maxLength(255),
                    TextInput::make('practice_title.en')->label(__('عنوان السكشن (إنجليزي)'))->maxLength(255),
                    Textarea::make('practice_subtitle.ar')->label(__('العنوان الفرعي (عربي)'))->rows(2),
                    Textarea::make('practice_subtitle.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(2),
                    TextInput::make('practice_banner_title.ar')->label(__('عنوان بانر لا تعرف من أين تبدأ (عربي)'))->maxLength(255),
                    TextInput::make('practice_banner_title.en')->label(__('عنوان بانر لا تعرف من أين تبدأ (إنجليزي)'))->maxLength(255),
                    Textarea::make('practice_banner_text.ar')->label(__('نص بانر الواتساب (عربي)'))->rows(2),
                    Textarea::make('practice_banner_text.en')->label(__('نص بانر الواتساب (إنجليزي)'))->rows(2),
                ]),
            ]);
    }

    protected function pledgeSection(): Section
    {
        return Section::make(__('6. قسم التعهدات: أربعة بنود نلتزم بها'))
            ->icon('heroicon-o-document-check')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    Textarea::make('pledge_title.ar')->label(__('عنوان سكشن التعهد (عربي)'))->rows(2),
                    Textarea::make('pledge_title.en')->label(__('عنوان سكشن التعهد (إنجليزي)'))->rows(2),
                    Textarea::make('pledge_subtitle.ar')->label(__('العنوان الفرعي للتعهد (عربي)'))->rows(2),
                    Textarea::make('pledge_subtitle.en')->label(__('العنوان الفرعي للتعهد (إنجليزي)'))->rows(2),
                    TextInput::make('pledge_sign_text.ar')->label(__('نص توقيع القلم (عربي)'))->maxLength(255),
                    TextInput::make('pledge_sign_text.en')->label(__('نص توقيع القلم (إنجليزي)'))->maxLength(255),
                ]),
            ]);
    }

    protected function routeSection(): Section
    {
        return Section::make(__('7. قسم مسار الملف: من أول مكالمة حتى إغلاق الملف'))
            ->icon('heroicon-o-map')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('route_title.ar')->label(__('عنوان السكشن (عربي)'))->maxLength(255),
                    TextInput::make('route_title.en')->label(__('عنوان السكشن (إنجليزي)'))->maxLength(255),
                    Textarea::make('route_subtitle.ar')->label(__('العنوان الفرعي (عربي)'))->rows(2),
                    Textarea::make('route_subtitle.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(2),
                ]),
            ]);
    }

    protected function messagesSection(): Section
    {
        return Section::make(__('8. قسم محاكاة محادثة الواتساب: محاميك في جيبك'))
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('messages_title.ar')->label(__('عنوان السكشن (عربي)'))->maxLength(255),
                    TextInput::make('messages_title.en')->label(__('عنوان السكشن (إنجليزي)'))->maxLength(255),
                    Textarea::make('messages_subtitle.ar')->label(__('العنوان الفرعي (عربي)'))->rows(2),
                    Textarea::make('messages_subtitle.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(2),
                ]),
            ]);
    }

    protected function faqSection(): Section
    {
        return Section::make(__('9. قسم الأسئلة الشائعة'))
            ->icon('heroicon-o-question-mark-circle')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('faq_title.ar')->label(__('عنوان السكشن (عربي)'))->maxLength(255),
                    TextInput::make('faq_title.en')->label(__('عنوان السكشن (إنجليزي)'))->maxLength(255),
                    Textarea::make('faq_subtitle.ar')->label(__('العنوان الفرعي (عربي)'))->rows(2),
                    Textarea::make('faq_subtitle.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(2),
                ]),
            ]);
    }

    protected function bookingSection(): Section
    {
        return Section::make(__('10. قسم حجز الاستشارة: افتح ملفك معنا اليوم'))
            ->icon('heroicon-o-clipboard-document-list')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    Textarea::make('booking_title.ar')->label(__('عنوان السكشن (عربي)'))->rows(2),
                    Textarea::make('booking_title.en')->label(__('عنوان السكشن (إنجليزي)'))->rows(2),
                    Textarea::make('booking_subtitle.ar')->label(__('العنوان الفرعي (عربي)'))->rows(2),
                    Textarea::make('booking_subtitle.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(2),
                ]),
            ]);
    }

    protected function contactSection(): Section
    {
        return Section::make(__('11. بيانات التواصل، موقع المكتب والخريطة'))
            ->icon('heroicon-o-map-pin')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('contact_title.ar')->label(__('عنوان السكشن (عربي)'))->maxLength(255),
                    TextInput::make('contact_title.en')->label(__('عنوان السكشن (إنجليزي)'))->maxLength(255),
                    Textarea::make('contact_subtitle.ar')->label(__('العنوان الفرعي (عربي)'))->rows(2),
                    Textarea::make('contact_subtitle.en')->label(__('العنوان الفرعي (إنجليزي)'))->rows(2),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('phone')->label(__('رقم الهاتف'))->tel()->maxLength(255),
                    TextInput::make('whatsapp')->label(__('رقم الواتساب'))->tel()->helperText(__('بصيغة دولية مثل +201101201034'))->maxLength(255),
                    TextInput::make('map_embed_url')
                        ->label(__('موقع المكتب في خرائط جوجل'))
                        ->maxLength(1000)
                        ->helperText(__('يمكنك وضع رابط المشاركة (maps.app.goo.gl)، أو رابط التضمين، أو كود iframe، حيث يتم التعرف عليه وتضمينه تلقائيًا.')),
                ]),
                Grid::make(2)->schema([
                    TextInput::make('address.ar')->label(__('العنوان (عربي)'))->maxLength(500),
                    TextInput::make('address.en')->label(__('العنوان (إنجليزي)'))->maxLength(500),
                    TextInput::make('working_hours.ar')->label(__('مواعيد العمل (عربي)'))->maxLength(255),
                    TextInput::make('working_hours.en')->label(__('مواعيد العمل (إنجليزي)'))->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Textarea::make('footer_text.ar')->label(__('نص الفوتر التعريفي (عربي)'))->rows(2)->maxLength(255),
                    Textarea::make('footer_text.en')->label(__('نص الفوتر التعريفي (إنجليزي)'))->rows(2)->maxLength(255),
                ]),
                Grid::make(3)->schema([
                    TextInput::make('facebook')->label(__('فيسبوك'))->url()->maxLength(255),
                    TextInput::make('instagram')->label(__('إنستجرام'))->url()->maxLength(255),
                    TextInput::make('linkedin')->label(__('لينكدإن'))->url()->maxLength(255),
                    TextInput::make('x_url')->label(__('X (تويتر)'))->url()->maxLength(255),
                    TextInput::make('youtube')->label(__('يوتيوب'))->url()->maxLength(255),
                    TextInput::make('tiktok')->label(__('تيك توك'))->url()->maxLength(255),
                ]),
            ]);
    }

    protected function seoSection(): Section
    {
        return Section::make(__('12. إعدادات SEO وكود التحقق من Google'))
            ->icon('heroicon-o-globe-alt')
            ->collapsible()
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('seo_meta_title.ar')->label(__('عنوان الصفحة في نتائج البحث (عربي)'))->maxLength(70),
                    TextInput::make('seo_meta_title.en')->label(__('عنوان الصفحة في نتائج البحث (إنجليزي)'))->maxLength(70),
                    Textarea::make('seo_meta_description.ar')->label(__('وصف الصفحة في نتائج البحث (عربي)'))->rows(3)->maxLength(170),
                    Textarea::make('seo_meta_description.en')->label(__('وصف الصفحة في نتائج البحث (إنجليزي)'))->rows(3)->maxLength(170),
                    Textarea::make('seo_keywords.ar')->label(__('الكلمات المفتاحية (عربي)'))->rows(2),
                    Textarea::make('seo_keywords.en')->label(__('الكلمات المفتاحية (إنجليزي)'))->rows(2),
                ]),
                FileUpload::make('seo_og_image_path')
                    ->label(__('صورة المشاركة الاجتماعية (Open Graph)'))
                    ->image()
                    ->directory('settings')
                    ->disk('public')
                    ->imageEditor(),
                Grid::make(2)->schema([
                    Toggle::make('seo_robots_index')->label(__('السماح لمحركات البحث بفهرسة الموقع'))->default(true),
                    TextInput::make('google_verification')->label(__('كود التحقق من Google Search Console'))->maxLength(255),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('حفظ جميع الإعدادات'))
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
            ->title(__('تم حفظ وتحديث جميع إعدادات الموقع بنجاح'))
            ->success()
            ->send();
    }
}
