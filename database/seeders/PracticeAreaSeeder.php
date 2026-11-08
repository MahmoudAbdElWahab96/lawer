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
                'name' => ['ar' => 'الأحوال الشخصية', 'en' => 'Family & Personal Status'],
                'slug' => 'family-law',
                'description' => [
                    'ar' => "قضايا الطلاق والخلع\nالنفقة والحضانة والرؤية\nالميراث وتقسيم التركات",
                    'en' => "Divorce & Khul'\nAlimony, Custody & Visitation\nInheritance & Estate Distribution",
                ],
                'icon' => 'd6be1.svg',
                'sort_order' => 3,
            ],
            [
                'name' => ['ar' => 'القانون المدني', 'en' => 'Civil Law'],
                'slug' => 'civil-law',
                'description' => [
                    'ar' => "نزاعات العقود\nدعاوى التعويض\nالإيجارات والحيازة",
                    'en' => "Contract Disputes\nCompensation Lawsuits\nTenancy & Possession",
                ],
                'icon' => '8ee21.svg',
                'sort_order' => 2,
            ],
            [
                'name' => ['ar' => 'القانون الجنائي', 'en' => 'Criminal Law'],
                'slug' => 'criminal-law',
                'description' => [
                    'ar' => "الحضور في التحقيقات\nالدفاع في الجنح\nالدفاع في الجنايات",
                    'en' => "Investigation Attendance\nMisdemeanor Defense\nFelony Defense",
                ],
                'icon' => 'fd282.svg',
                'sort_order' => 1,
            ],
            [
                'name' => ['ar' => 'الشهر العقاري', 'en' => 'Real Estate Registration'],
                'slug' => 'real-estate-registry',
                'description' => [
                    'ar' => "تسجيل العقارات\nنقل الملكية\nالتصالح على مخالفات البناء",
                    'en' => "Property Registration\nOwnership Transfer\nBuilding Violation Settlements",
                ],
                'icon' => '630cd.svg',
                'sort_order' => 6,
            ],
            [
                'name' => ['ar' => 'القانون التجاري', 'en' => 'Commercial Law'],
                'slug' => 'commercial-law',
                'description' => [
                    'ar' => "تأسيس الشركات\nصياغة ومراجعة العقود\nالنزاعات التجارية",
                    'en' => "Company Incorporation\nContract Drafting & Review\nCommercial Disputes",
                ],
                'icon' => '3d433.svg',
                'sort_order' => 5,
            ],
            [
                'name' => ['ar' => 'إدارة الأملاك', 'en' => 'Property Management'],
                'slug' => 'property-management',
                'description' => [
                    'ar' => "عقود الإيجار\nعقود البيع\nمتابعة الأملاك",
                    'en' => "Lease Agreements\nSales Contracts\nEstate Asset Follow-up",
                ],
                'icon' => '2fdca.svg',
                'sort_order' => 4,
            ],
        ];

        foreach ($areas as $data) {
            PracticeArea::query()->updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
