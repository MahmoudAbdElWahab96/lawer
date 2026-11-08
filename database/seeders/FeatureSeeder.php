<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => [
                    'ar' => 'خبرة قانونية متنوعة تتجاوز 15 عامًا',
                    'en' => 'Diverse legal experience of over 15 years',
                ],
                'text' => [
                    'ar' => 'تعاملنا مع آلاف القضايا في مختلف فروع القانون، ما يمنحنا قراءة سريعة ودقيقة لموقفك القانوني من أول اجتماع.',
                    'en' => 'We have handled thousands of cases across all branches of law, giving us a fast and accurate reading of your legal position from the first meeting.',
                ],
                'icon' => 'experience',
                'sort_order' => 1,
            ],
            [
                'title' => [
                    'ar' => 'نهج شخصي واستراتيجية خاصة بكل موكل',
                    'en' => 'A personal approach and strategy for every client',
                ],
                'text' => [
                    'ar' => 'لا توجد خطة دفاع واحدة تصلح للجميع، ندرس ملفك بعمق ونرسم استراتيجية مخصصة لظروفك وأهدافك.',
                    'en' => 'No single defense plan fits everyone, we study your file in depth and craft a strategy tailored to your circumstances and goals.',
                ],
                'icon' => 'strategy',
                'sort_order' => 2,
            ],
            [
                'title' => [
                    'ar' => 'سجل ناجح من القضايا والحلول القانونية',
                    'en' => 'A proven track record of cases and legal solutions',
                ],
                'text' => [
                    'ar' => 'نسبة نجاح تتجاوز 90% في القضايا التي توليناها، مع حلول ودية وتفاوضية وفرت على موكلينا سنوات من التقاضي.',
                    'en' => 'A success rate exceeding 90% in the cases we handled, alongside amicable settlements that saved our clients years of litigation.',
                ],
                'icon' => 'trophy',
                'sort_order' => 3,
            ],
            [
                'title' => [
                    'ar' => 'سرية تامة وتواصل مستمر',
                    'en' => 'Complete confidentiality and continuous communication',
                ],
                'text' => [
                    'ar' => 'كل ما تشاركه معنا محفوظ بسرية قانونية كاملة، وتصلك تحديثات منتظمة بمستجدات قضيتك دون أن تضطر للسؤال.',
                    'en' => 'Everything you share is protected by full legal confidentiality, and you receive regular updates on your case without having to ask.',
                ],
                'icon' => 'shield',
                'sort_order' => 4,
            ],
        ];

        foreach ($items as $item) {
            Feature::query()->updateOrCreate(
                ['title' => $item['title']],
                $item + ['is_active' => true],
            );
        }
    }
}
