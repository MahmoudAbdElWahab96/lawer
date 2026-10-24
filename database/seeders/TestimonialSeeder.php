<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'client_name' => 'م. خالد سمير',
                'client_role' => ['ar' => 'رجل أعمال — قضية تجارية', 'en' => 'Businessman — commercial case'],
                'content' => [
                    'ar' => 'تابع قضية تجارية معقدة استمرت أكثر من سنة، وكان الشرح في كل جلسة واضحًا والالتزام بالمواعيد ممتازًا. النتيجة كانت أفضل مما توقعت.',
                    'en' => 'He handled a complex commercial case that lasted over a year. Every session was explained clearly and deadlines were strictly met. The outcome exceeded my expectations.',
                ],
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'أ. منى عبد الرحمن',
                'client_role' => ['ar' => 'قضية حضانة', 'en' => 'Custody case'],
                'content' => [
                    'ar' => 'في أصعب فترة في حياتي تعاملت مع المكتب باحترافية وإنسانية نادرة. حصلت على حضانة ابنتي والملف كان معدًا بدقة شديدة.',
                    'en' => 'During the hardest period of my life, the office showed rare professionalism and humanity. I won custody of my daughter, and the file was prepared meticulously.',
                ],
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'شركة النور للمقاولات',
                'client_role' => ['ar' => 'تحكيم تجاري', 'en' => 'Commercial arbitration'],
                'content' => [
                    'ar' => 'استعنا بالمكتب في نزاع تحكيمي بقيمة كبيرة. الدراسة القانونية للملف كانت تفصيلية والتمثيل أمام هيئة التحكيم قويًا ومقنعًا.',
                    'en' => 'We engaged the office in a high-value arbitration dispute. The legal study of the file was thorough and the representation before the tribunal was compelling.',
                ],
                'rating' => 5,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'ح. مصطفى العدل',
                'client_role' => ['ar' => 'قضية عمالية', 'en' => 'Labor case'],
                'content' => [
                    'ar' => 'حصلت على كامل مستحقاتي بعد فصل تعسفي ظننت أني سأخسرها. نصيحتي لأي شخص: استشارة أولى واضحة وأمانة في التعامل.',
                    'en' => 'I received my full entitlements after a wrongful termination I thought I would lose. My advice to anyone: a clear first consultation and honest handling.',
                ],
                'rating' => 4,
                'sort_order' => 4,
            ],
        ];

        foreach ($items as $item) {
            Testimonial::query()->updateOrCreate(
                ['client_name' => $item['client_name']],
                $item + ['is_active' => true],
            );
        }
    }
}
