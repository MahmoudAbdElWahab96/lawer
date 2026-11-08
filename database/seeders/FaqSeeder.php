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
                    'en' => 'Is the initial consultation free?',
                ],
                'answer' => [
                    'ar' => 'نحدد معك جلسة استماع أولية لفهم الأوراق وموقف الملف بدقة. رسوم الجلسة تكون محددة مسبقاً وتُخصم بالكامل من إجمالي أتعاب القضية عند الاتفاق على تولي الملف.',
                    'en' => 'We schedule an initial review session to examine your documents and legal position. The consultation fee is stated upfront and is fully credited toward the case retainer upon agreement.',
                ],
                'sort_order' => 1,
            ],
            [
                'question' => [
                    'ar' => 'هل معلوماتي سرية؟',
                    'en' => 'Are my details and files kept confidential?',
                ],
                'answer' => [
                    'ar' => 'السرية المطلقة هي التزامنا الأول: كل ما تتداوله معنا من مستندات وأسرار محفوظ بسرية تامة طبقاً لقانون المحاماة وأخلاقيات المهنة من أول مكالمة وحتى بعد صدور الحكم.',
                    'en' => 'Absolute confidentiality is our highest commitment. All discussions and documents are strictly protected under legal professional privilege from day one.',
                ],
                'sort_order' => 2,
            ],
            [
                'question' => [
                    'ar' => 'ما المستندات المطلوبة في أول زيارة؟',
                    'en' => 'What documents are required for the first visit?',
                ],
                'answer' => [
                    'ar' => 'بطاقة الرقم القومي سارية، وصور كافة المستندات، العقود، المحاضر، أو الإنذارات المتعلقة بالنزاع. لا يُشترط إحضار الأصول في الجلسة الأولى.',
                    'en' => 'A valid ID card along with copies of relevant contracts, notices, or official reports. Original documents are not required during the preliminary meeting.',
                ],
                'sort_order' => 3,
            ],
            [
                'question' => [
                    'ar' => 'هل يمكن الاستشارة أونلاين؟',
                    'en' => 'Can consultations be conducted online?',
                ],
                'answer' => [
                    'ar' => 'نعم، نقدم استشارات قانونية مخصصة عبر الهاتف، أو مكالمة فيديو، أو عبر واتساب، خاصة للموكلين خارج محافظة الغربية أو المقيمين بالخارج.',
                    'en' => 'Yes, we provide direct consultations via phone, video call, or WhatsApp, especially for clients located outside Gharbia or abroad.',
                ],
                'sort_order' => 4,
            ],
            [
                'question' => [
                    'ar' => 'كيف تُحدد الأتعاب؟',
                    'en' => 'How are legal fees calculated?',
                ],
                'answer' => [
                    'ar' => 'نعتمد مبدأ الشفافية: نحدد الأتعاب بعد دراسة الملف بدقة ونثبتها في اتفاق مكتوب ومحدد مع جدول دفعات ميسرة وفق مراحل الإجراءات دون أي رسوم مفاجئة.',
                    'en' => 'We follow total transparency: fees are determined after reviewing the case files, agreed in writing, and structured in flexible milestones without unexpected costs.',
                ],
                'sort_order' => 5,
            ],
            [
                'question' => [
                    'ar' => 'كم تستغرق القضية؟',
                    'en' => 'How long does a lawsuit take?',
                ],
                'answer' => [
                    'ar' => 'تختلف المدة الزمنية بحسب طبيعة النزاع ودرجة المحكمة، لكننا نضع جدولاً زمنياً تقديرياً لكل مرحلة ونطلعك دورياً على كل تطور أولاً بأول.',
                    'en' => 'Case duration varies according to dispute complexity and court schedules; however, we provide a projected timeline and keep you updated at each milestone.',
                ],
                'sort_order' => 6,
            ],
        ];

        Faq::query()->delete();
        foreach ($items as $item) {
            Faq::create($item);
        }
    }
}
