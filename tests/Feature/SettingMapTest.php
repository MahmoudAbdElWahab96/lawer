<?php

namespace Tests\Feature;

use App\Models\Setting;
use Tests\TestCase;

class SettingMapTest extends TestCase
{
    public function test_fallback_map_centers_on_the_place_coordinates_of_a_google_maps_link(): void
    {
        $setting = new Setting;
        $setting->map_embed_url = 'https://www.google.com/maps/place/Office/@29.94,31.10,17z/data=!8m2!3d29.5!4d31.25!16s';

        $this->assertTrue($setting->usesFallbackMap());
        $this->assertStringContainsString('bbox=31.23%2C29.486%2C31.27%2C29.514', $setting->mapEmbedSrc());
    }

    public function test_pasted_google_embed_is_not_treated_as_the_fallback_map(): void
    {
        $setting = new Setting;
        $setting->map_embed_url = 'https://www.google.com/maps/embed?pb=abc';

        $this->assertFalse($setting->usesFallbackMap());
        $this->assertSame('https://www.google.com/maps/embed?pb=abc', $setting->mapEmbedSrc());
    }
}
