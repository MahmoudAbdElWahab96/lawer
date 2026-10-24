<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(['id' => 1], [
            'lawyer_name' => [
                'ar' => 'أحمد محمود عبد الله',
                'en' => 'Ahmed Mahmoud Abdullah',
            ],
            'lawyer_title' => [
                'ar' => 'محامٍ ومستشار قانوني — عضو نقابة المحامين المصرية',
                'en' => 'Attorney & Legal Consultant — Egyptian Bar Association Member',
            ],
            'hero_headline' => [
                'ar' => 'خبرة قانونية تحمي حقوقك وترافقك خطوة بخطوة',
                'en' => 'Legal expertise that protects your rights, every step of the way',
            ],
            'hero_subheadline' => [
                'ar' => 'أكثر من 15 عامًا من الخبرة في القضايا الأسرية والتجارية والجنائية، مع فريق قانوني متكامل واستشارات واضحة من أول اجتماع.',
                'en' => 'Over 15 years of experience in family, commercial, and criminal cases, with a full legal team and clear advice from the very first meeting.',
            ],
            'about_title' => [
                'ar' => 'عن المكتب',
                'en' => 'About the Office',
            ],
            'about_text' => [
                'ar' => 'مكتب أحمد محمود عبد الله للمحاماة والاستشارات القانونية يؤمن بأن لكل موكل قضية تستحق دفاعًا كاملًا. نعمل على دراسة كل ملف بعمق قبل رسم خطة الدفاع، ونحرص على تواصل مستمر وواضح مع عميلنا حتى صدور الحكم.',
                'en' => 'The Law Office of Ahmed Mahmoud Abdullah believes every client deserves a complete defense. We study each file in depth before mapping out a strategy, and we keep communication clear and continuous until a verdict is reached.',
            ],
            'phone' => '+20 100 000 0000',
            'whatsapp' => '+20 100 000 0000',
            'email' => 'info@lawyer-office.example',
            'address' => [
                'ar' => 'القاهرة، وسط البلد، شارع قصر النيل، برج النيل، الدور الخامس',
                'en' => 'Cairo, Downtown, Kasr El Nil St., Nile Tower, 5th Floor',
            ],
            'working_hours' => [
                'ar' => 'السبت إلى الخميس: 9 صباحًا – 6 مساءً',
                'en' => 'Saturday to Thursday: 9 AM – 6 PM',
            ],
            'map_embed_url' => null,
            'facebook' => 'https://facebook.com/example',
            'instagram' => 'https://instagram.com/example',
            'linkedin' => 'https://linkedin.com/in/example',
            'x_url' => null,
            'youtube' => null,
            'years_experience' => 15,
            'cases_count' => 850,
            'clients_count' => 600,
            'success_rate' => 92,
            'lawyers_count' => 12,
            'logo_path' => null,
            'hero_image_path' => null,
            'seo_meta_title' => [
                'ar' => 'مكتب أحمد محمود للمحاماة والاستشارات القانونية | محامي في القاهرة',
                'en' => 'Ahmed Mahmoud Law Office | Attorney & Legal Consultant in Cairo',
            ],
            'seo_meta_description' => [
                'ar' => 'محامٍ ومستشار قانوني بخبرة تتجاوز 15 عامًا في القضايا الأسرية والتجارية والجنائية والعقارية. استشارة قانونية واضحة وفريق متخصص يرافقك حتى الحكم.',
                'en' => 'Attorney & legal consultant with 15+ years of experience in family, commercial, criminal, and real estate cases. Clear advice and a dedicated team until verdict.',
            ],
            'seo_keywords' => [
                'ar' => 'محامي القاهرة، محامي أحوال شخصية، استشارات قانونية، محامي تجاري، محامي جنائي',
                'en' => 'lawyer in Cairo, family lawyer, legal consultation, commercial lawyer, criminal lawyer',
            ],
            'seo_og_image_path' => null,
            'seo_robots_index' => true,
            'google_verification' => null,
        ]);
    }
}
