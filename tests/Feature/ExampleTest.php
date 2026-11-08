<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test root redirects to default locale.
     */
    public function test_root_redirects_to_default_locale(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/ar');
    }

    /**
     * Test homepage returns 200.
     */
    public function test_homepage_returns_successful_response(): void
    {
        Setting::create([
            'lawyer_name' => ['ar' => 'علي الديب', 'en' => 'Ali El-Deeb'],
            'lawyer_title' => ['ar' => 'محامٍ بالنقض', 'en' => 'Attorney'],
        ]);

        $responseAr = $this->get('/ar');
        $responseAr->assertStatus(200);
        $responseAr->assertSee('dir="rtl"', false);
        $responseAr->assertSee('علي الديب');

        $responseEn = $this->get('/en');
        $responseEn->assertStatus(200);
        $responseEn->assertSee('dir="ltr"', false);
        $responseEn->assertSee('Ali El-Deeb');
    }

    /**
     * Test contact form stores submission.
     */
    public function test_contact_form_stores_submission(): void
    {
        Setting::create([
            'lawyer_name' => ['ar' => 'علي الديب', 'en' => 'Ali El-Deeb'],
        ]);

        $response = $this->post('/ar/contact', [
            'name' => 'أحمد إبراهيم',
            'phone' => '01012345678',
            'message' => 'استشارة قانونية في عقد تجاري',
        ]);

        $response->assertSessionHas('contact_success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'أحمد إبراهيم',
            'phone' => '01012345678',
        ]);
    }
}
