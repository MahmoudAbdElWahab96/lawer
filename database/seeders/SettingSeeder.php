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
                'ar' => 'علي الديب',
                'en' => 'Ali El-Deeb',
            ],
            'lawyer_title' => [
                'ar' => 'المحامي بالاستئناف العالي ومجلس الدولة · مقيد بنقابة المحامين الغربية',
                'en' => 'Attorney at the High Court of Appeal & State Council · Egyptian Bar Association',
            ],
            'hero_headline' => [
                'ar' => 'قضيتك تستحق من يقرأها بعناية',
                'en' => 'Your case deserves someone who reads it with care',
            ],
            'hero_subheadline' => [
                'ar' => 'نستمع لك أولًا، ثم نضع لقضيتك خطة مكتوبة في الأسرة والمدني والتجاري والجنائي، وبسرية تامة حتى صدور الحكم.',
                'en' => 'We listen to you first, then establish a written roadmap for your case in family, civil, commercial, and criminal law with full confidentiality.',
            ],
            'about_title' => [
                'ar' => 'نبدأ بالاستماع قبل المرافعة',
                'en' => 'We start by listening before pleading',
            ],
            'about_text' => [
                'ar' => '<p>أعمل في المحاماة في قضايا الأسرة والمدني والتجاري والجنائي. وتعلّمت أن جزءًا كبيرًا من القضية يُحسم قبل الجلسة: في الاستماع الجيد، وفي قراءة كل ورقة.</p><p>لهذا يبدأ كل ملف عندنا بجلسة استماع كاملة، ثم خطة مكتوبة تعرف فيها خطواتك وتكلفتك قبل أن نبدأ.</p>',
                'en' => '<p>I practice law across family, civil, commercial, and criminal matters. I have learned that a substantial part of any case is resolved before the hearing: in deep listening and meticulous review of every document.</p><p>That is why every file begins with a full listening session, followed by a written action plan detailing your steps and costs before we commence.</p>',
            ],
            'phone' => '+201101201034',
            'whatsapp' => '+201101201034',
            'email' => 'AlyEldeebLaw@gmail.com',
            'address' => [
                'ar' => '٢٧ ص، حدائق الاهرام - الدور الأول ، القاهرة',
                'en' => '27 S Street, Hadayek Al Ahram, First Floor, Cairo, Egypt.',
            ],
            'working_hours' => [
                'ar' => 'السبت إلى الخميس من ٥ مساءً حتى ١٠ مساءً (بموعد مسبق)',
                'en' => 'Saturday to Thursday from 5 PM to 10 PM (By appointment)',
            ],
            'map_embed_url' => 'https://www.google.com/maps/place/%D9%85%D9%83%D8%AA%D8%A8+%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D8%A7%D8%B0+%D8%B9%D9%84%D9%8A+%D8%A7%D9%84%D8%AF%D9%8A%D8%A8+%D8%A7%D9%84%D9%85%D8%AD%D8%A7%D9%85%D9%8A%E2%80%AD/@29.9484421,31.1000124,17z/data=!3m1!4b1!4m6!3m5!1s0x145847361d13d82f:0xe801f585ba9a3e85!8m2!3d29.9484375!4d31.0974375!16s%2Fg%2F11zzsg365p',
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'linkedin' => 'https://linkedin.com',
            'x_url' => null,
            'tiktok' => 'https://www.tiktok.com',
            'youtube' => 'https://youtube.com',
            'years_experience' => 15,
            'cases_count' => 2000,
            'clients_count' => 2000,
            'success_rate' => 96,
            'lawyers_count' => 20,
            'bar_admission_year' => '2009',
            'logo_path' => null,
            'hero_image_path' => 'images/landing/497c8.png',

            // Section 3: Practice Areas
            'practice_title' => [
                'ar' => 'ملفات نحملها عنك',
                'en' => 'Cases We Handle for You',
            ],
            'practice_subtitle' => [
                'ar' => 'لكل قضية ملف مستقل، يتابعه محامٍ يعرفك باسمك لا برقمك. اختر المجال الأقرب لقضيتك.',
                'en' => 'Every case has a dedicated file handled by an attorney who knows you by name, not by number. Choose the practice area closest to your case.',
            ],
            'practice_banner_title' => [
                'ar' => 'لا تعرف من أين تبدأ؟',
                'en' => 'Not sure where to start?',
            ],
            'practice_banner_text' => [
                'ar' => 'اكتب لنا موقفك في رسالة قصيرة، وسنخبرك بالمجال المناسب وخطوتك التالية. دون أي التزام.',
                'en' => 'Send us a brief message about your situation, and we will tell you the right practice area and next step. Without any obligation.',
            ],

            // Section 4: Pledge
            'pledge_title' => [
                'ar' => "أربعة بنود\nنلتزم بها في كل ملف",
                'en' => "Four Commitments\nWe Uphold in Every Case",
            ],
            'pledge_subtitle' => [
                'ar' => "كبيرًا كان الملف أو صغيرًا،\nهذه التزاماتنا معك.",
                'en' => "Whether your case is large or small,\nthese are our commitments to you.",
            ],
            'pledge_sign_text' => [
                'ar' => 'هذا ما نتعهد به لك',
                'en' => 'This is our pledge to you',
            ],
            'pledge_clauses' => [
                [
                    'ordinal' => ['ar' => 'أولًا', 'en' => 'First'],
                    'title' => ['ar' => 'نستمع أولًا', 'en' => 'We Listen First'],
                    'text' => [
                        'ar' => "جلسة استماع كاملة قبل أي رأي قانوني،\nلأن التفاصيل الصغيرة تغيّر القضية.",
                        'en' => "A full listening session before any legal opinion,\nbecause small details can change the entire case.",
                    ],
                ],
                [
                    'ordinal' => ['ar' => 'ثانيًا', 'en' => 'Second'],
                    'title' => ['ar' => 'خطة مكتوبة', 'en' => 'A Written Plan'],
                    'text' => [
                        'ar' => "مسار واضح وتكلفة واضحة،\nمكتوبان ومتفق عليهما قبل أن نبدأ.",
                        'en' => "A clear roadmap and transparent costs,\nwritten and agreed upon before we begin.",
                    ],
                ],
                [
                    'ordinal' => ['ar' => 'ثالثًا', 'en' => 'Third'],
                    'title' => ['ar' => 'سرية تامة', 'en' => 'Full Confidentiality'],
                    'text' => [
                        'ar' => 'ما تقوله لنا يبقى بيننا، من أول مكالمة حتى بعد صدور الحكم.',
                        'en' => 'What you tell us stays strictly between us, from the very first call until after judgment.',
                    ],
                ],
                [
                    'ordinal' => ['ar' => 'رابعًا', 'en' => 'Fourth'],
                    'title' => ['ar' => 'متابعة مستمرة', 'en' => 'Continuous Follow-up'],
                    'text' => [
                        'ar' => "نطلعك على كل تطور في ملفك\nأولًا بأول، دون أن تضطر للسؤال.",
                        'en' => "We proactively update you on every development in your file,\nwithout you having to ask.",
                    ],
                ],
            ],

            // Section 5: Route Tracker
            'route_title' => [
                'ar' => 'من أول مكالمة حتى إغلاق الملف',
                'en' => 'From First Call to Case Closure',
            ],
            'route_subtitle' => [
                'ar' => 'أربع مراحل واضحة، تعرف في كل لحظة أين وصل ملفك.',
                'en' => 'Four clear stages so you always know where your file stands.',
            ],

            // Section 6: WhatsApp Messages
            'messages_title' => [
                'ar' => "رسائل وصلتنا\nبعد إغلاق الملف",
                'en' => "Client Messages\nAfter Case Closure",
            ],
            'messages_subtitle' => [
                'ar' => "لا نكتب شهادات عن أنفسنا.\nهذه رسائل موكلينا كما أرسلوها، ننشرها بموافقتهم.",
                'en' => "We do not write testimonials about ourselves.\nThese are real messages from our clients, published with their permission.",
            ],

            // Section 7: FAQ
            'faq_title' => [
                'ar' => 'قبل أن تسأل',
                'en' => 'Frequently Asked Questions',
            ],
            'faq_subtitle' => [
                'ar' => 'أكثر ما يسألنا عنه الموكلون في أول مكالمة.',
                'en' => 'Clear and straightforward answers to what matters most before you begin.',
            ],

            // Section 8: Booking
            'booking_title' => [
                'ar' => "افتح ملفك\nمعنا اليوم",
                'en' => "Open Your Case File\nWith Us Today",
            ],
            'booking_subtitle' => [
                'ar' => 'خطوتان فقط: اختر مجال قضيتك، واترك رقمك، ونتواصل معك لتحديد موعد الاستشارة.',
                'en' => 'Just two steps: choose your case area, enter your phone number, and we will contact you to schedule your consultation.',
            ],

            // Section 9: Contact
            'contact_title' => [
                'ar' => 'زورنا في المكتب',
                'en' => 'Visit Us at the Office',
            ],
            'contact_subtitle' => [
                'ar' => 'لو تفضّل الكلام وجهًا لوجه، مكتبنا مفتوح لك بموعد مسبق.',
                'en' => 'If you prefer speaking face-to-face, our office is open by prior appointment.',
            ],

            // Section 10: Footer
            'footer_text' => [
                'ar' => 'مكتب محاماة في الغربية. قضايا الأسرة والمدني والتجاري والجنائي.',
                'en' => 'Law office in Gharbia. Family, civil, commercial, and criminal litigation.',
            ],

            // SEO
            'seo_meta_title' => [
                'ar' => 'علي الديب للمحاماة والاستشارات القانونية | القاهرة والغربية',
                'en' => 'Ali El-Deeb Law Firm | Legal Consultations Egypt',
            ],
            'seo_meta_description' => [
                'ar' => 'مكتب المحامي علي الديب: قضايا الأسرة والمدني والتجاري والجنائي والشهر العقاري، مع مسار واضح وسرية تامة.',
                'en' => 'The Law Office of Ali El-Deeb: Family, civil, commercial, criminal, and property registration law with clear path and strict confidentiality.',
            ],
            'seo_keywords' => [
                'ar' => 'محامي طنطا, محامي حدائق الاهرام, علي الديب, قضايا أسرة, محامي جنايات, شهر عقاري, استشارات قانونية',
                'en' => 'lawyer Cairo, attorney Hadayek Al Ahram, Ali El-Deeb, Egypt legal consultant',
            ],
            'seo_robots_index' => true,
        ]);
    }
}
