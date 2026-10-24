<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            PracticeAreaSeeder::class,
            FeatureSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            ArticleSeeder::class,
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@lawyer.test'],
            [
                'name' => 'المحامي — مدير الموقع',
                'password' => Hash::make('Lawyer#2026!Admin'),
            ],
        );
    }
}
