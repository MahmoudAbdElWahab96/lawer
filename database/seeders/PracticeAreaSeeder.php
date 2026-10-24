<?php

namespace Database\Seeders;

use App\Models\PracticeArea;
use Illuminate\Database\Seeder;

class PracticeAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            [
                'name' => ['ar' => 'الأحوال الشخصية والأسرة', 'en' => 'Family & Personal Status'],
                'slug' => 'family-law',
                'description' => [
                    'ar' => 'قضايا الطلاق والحضانة والنفقة والخلع وتقسيم الأموال، مع حرص كامل على خصوصية الأسرة وسرعة الحسم.',
                    'en' => 'Divorce, custody, alimony, khul\', and asset division cases, with full respect for family privacy and swift resolution.',
                ],
                'icon' => 'users',
                'sort_order' => 1,
            ],
            [
                'name' => ['ar' => 'القضايا الجنائية', 'en' => 'Criminal Defense'],
                'slug' => 'criminal-law',
                'description' => [
                    'ar' => 'الدفاع في القضايا الجنائية بكافة درجاتها، من مرحلة النيابة العامة حتى محكمة النقض.',
                    'en' => 'Defense in criminal cases at all levels, from the public prosecution stage up to the Court of Cassation.',
                ],
                'icon' => 'gavel',
                'sort_order' => 2,
            ],
            [
                'name' => ['ar' => 'الشركات والعقود التجارية', 'en' => 'Corporate & Commercial'],
                'slug' => 'corporate-law',
                'description' => [
                    'ar' => 'تأسيس الشركات وصياغة العقود والمراجعات القانونية وتسوية النزاعات التجارية والتحكيم.',
                    'en' => 'Company formation, contract drafting, legal review, commercial dispute resolution, and arbitration.',
                ],
                'icon' => 'briefcase',
                'sort_order' => 3,
            ],
            [
                'name' => ['ar' => 'العقارات والتسجيل', 'en' => 'Real Estate'],
                'slug' => 'real-estate-law',
                'description' => [
                    'ar' => 'نزاعات الملكية وعقود البيع والشراء والتسجيل العقاري ودعاوى البطلان والإزالة.',
                    'en' => 'Ownership disputes, sale contracts, property registration, and annulment and removal lawsuits.',
                ],
                'icon' => 'building',
                'sort_order' => 4,
            ],
            [
                'name' => ['ar' => 'القضايا العمالية', 'en' => 'Labor Law'],
                'slug' => 'labor-law',
                'description' => [
                    'ar' => 'التعويضات والفصل التعسفي ومستحقات نهاية الخدمة وصياغة عقود العمل للعاملين وأصحاب الأعمال.',
                    'en' => 'Compensation, wrongful termination, end-of-service entitlements, and employment contracts for employees and employers.',
                ],
                'icon' => 'hard-hat',
                'sort_order' => 5,
            ],
            [
                'name' => ['ar' => 'الميراث والوصايا', 'en' => 'Inheritance & Wills'],
                'slug' => 'inheritance-law',
                'description' => [
                    'ar' => 'تقسيم التركات وإعلام الوراثة وصياغة الوصايا وتسوية منازعات الورثة بالتفاوض أو التقاضي.',
                    'en' => 'Estate division, inheritance deeds, will drafting, and settling heir disputes by negotiation or litigation.',
                ],
                'icon' => 'scroll',
                'sort_order' => 6,
            ],
            [
                'name' => ['ar' => 'القانون المدني', 'en' => 'Civil Law'],
                'slug' => 'civil-law',
                'description' => [
                    'ar' => 'دعاوى التعويض والمسؤولية التقصيرية والعقود المدنية والمطالبات المالية بكافة أنواعها.',
                    'en' => 'Compensation claims, tort liability, civil contracts, and financial claims of all kinds.',
                ],
                'icon' => 'document',
                'sort_order' => 7,
            ],
            [
                'name' => ['ar' => 'الشهر العقاري وإدارة الأملاك', 'en' => 'Real Estate Registration & Property Management'],
                'slug' => 'property-registration',
                'description' => [
                    'ar' => 'إجراءات الشهر العقاري والتوثيق وتسجيل العقارات وإدارة الأملاك وتأجيرها وحماية ملكيتها.',
                    'en' => 'Real estate registration and documentation procedures, property management, leasing, and ownership protection.',
                ],
                'icon' => 'building',
                'sort_order' => 8,
            ],
            [
                'name' => ['ar' => 'التحكيم وتسوية النزاعات', 'en' => 'Arbitration & Dispute Resolution'],
                'slug' => 'arbitration',
                'description' => [
                    'ar' => 'تمثيل العملاء أمام هيئات التحكيم المحلية والدولية وصياغة بنود التحكيم في العقود.',
                    'en' => 'Representing clients before local and international arbitration bodies and drafting arbitration clauses.',
                ],
                'icon' => 'scale',
                'sort_order' => 9,
            ],
            [
                'name' => ['ar' => 'الجرائم الإلكترونية', 'en' => 'Cybercrime'],
                'slug' => 'cybercrime-law',
                'description' => [
                    'ar' => 'قضايا التشهير الإلكتروني والابتزاز واختراق الحسابات وحماية البيانات الشخصية.',
                    'en' => 'Online defamation, extortion, account hacking cases, and personal data protection.',
                ],
                'icon' => 'shield',
                'sort_order' => 10,
            ],
        ];

        foreach ($areas as $area) {
            PracticeArea::query()->updateOrCreate(['slug' => $area['slug']], $area + ['is_active' => true]);
        }
    }
}
