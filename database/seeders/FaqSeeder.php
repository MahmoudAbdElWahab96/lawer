<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'question' => [
                    'ar' => 'هل الاستشارة الأولى مجانية؟',
                    'en' => 'Is the first consultation free?',
                ],
                'answer' => [
                    'ar' => 'الاستشارة الأولى عبر الموقع أو الهاتف مجانية تمامًا، وفيها نحدد موقفك القانوني بشكل مبدئي وخطة العمل المتوقعة. الاجتماع التفصيلي في المكتب يكون بمقابل يُتفق عليه مسبقًا.',
                    'en' => 'The first consultation via the website or phone is completely free, where we assess your legal position and expected plan of action. A detailed in-office meeting is subject to a pre-agreed fee.',
                ],
                'sort_order' => 1,
            ],
            [
                'question' => [
                    'ar' => 'كم تستغرق القضية عادة؟',
                    'en' => 'How long does a case usually take?',
                ],
                'answer' => [
                    'ar' => 'المدة تختلف حسب نوع القضية ودرجات التقاضي: قضايا الأحوال الشخصية قد تستغرق من 6 أشهر إلى سنتين، والقضايا التجارية والجنائية تختلف حسب تعقيد الملف. نلتزم بإبلاغك بجدول زمني واقعي من البداية.',
                    'en' => 'Duration varies by case type and litigation level: personal status cases may take 6 months to 2 years, while commercial and criminal cases depend on complexity. We commit to a realistic timeline from the start.',
                ],
                'sort_order' => 2,
            ],
            [
                'question' => [
                    'ar' => 'كيف يتم تحديد الأتعاب؟',
                    'en' => 'How are fees determined?',
                ],
                'answer' => [
                    'ar' => 'الأتعاب تُحدد بعد دراسة القضية وتُوضح كتابةً قبل بدء العمل، وقد تكون مقطوعة أو بالنسبة من قيمة المطالبة حسب نوع القضية. لا توجد أي رسوم مفاجئة.',
                    'en' => 'Fees are set after studying the case and confirmed in writing before work begins — either a flat fee or a percentage of the claim depending on the case type. No surprise charges.',
                ],
                'sort_order' => 3,
            ],
            [
                'question' => [
                    'ar' => 'هل معلوماتي وبياناتي محفوظة بسرية؟',
                    'en' => 'Is my information kept confidential?',
                ],
                'answer' => [
                    'ar' => 'السرية التامة التزام قانوني وأخلاقي علينا. كل ما تشاركه مع المكتب من بيانات ومستندات لا يُفصح عنه لأي طرف إلا بأمر قضائي وبعلمك.',
                    'en' => 'Complete confidentiality is our legal and ethical duty. Any data or documents you share is never disclosed to any party except by court order and with your knowledge.',
                ],
                'sort_order' => 4,
            ],
            [
                'question' => [
                    'ar' => 'هل تتابعون القضايا في المحافظات الأخرى؟',
                    'en' => 'Do you handle cases in other governorates?',
                ],
                'answer' => [
                    'ar' => 'نعم، لدينا شبكة مراسلين تغطي محاكم الجمهورية، ونمثل عملاءنا أمام المحاكم الاقتصادية ومحكمة النقض ومجلس الدولة.',
                    'en' => 'Yes, we have a correspondents network covering courts nationwide, and we represent clients before economic courts, the Court of Cassation, and the Council of State.',
                ],
                'sort_order' => 5,
            ],
        ];

        foreach ($items as $item) {
            Faq::query()->updateOrCreate(
                ['question' => $item['question']],
                $item + ['is_active' => true],
            );
        }
    }
}
