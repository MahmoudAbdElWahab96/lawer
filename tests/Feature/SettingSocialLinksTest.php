<?php

namespace Tests\Feature;

use App\Models\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingSocialLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_the_tiktok_link_when_it_is_set(): void
    {
        $this->seed(SettingSeeder::class);
        Setting::query()->firstOrFail()->update(['tiktok' => 'https://www.tiktok.com/@office']);

        $this->get('/ar')
            ->assertOk()
            ->assertSee('https://www.tiktok.com/@office')
            ->assertSee('تيك توك');
    }

    public function test_home_page_hides_the_tiktok_link_when_it_is_empty(): void
    {
        $this->seed(SettingSeeder::class);
        Setting::query()->firstOrFail()->update(['tiktok' => null]);

        $this->get('/ar')
            ->assertOk()
            ->assertDontSee('تيك توك');
    }
}
