<?php

namespace Tests\Feature;

use App\Http\Middleware\SetAdminLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLocaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_panel_is_arabic_and_right_to_left_by_default(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('dir="rtl"', false)
            ->assertSee('English');
    }

    public function test_language_switch_turns_the_admin_panel_english_and_left_to_right(): void
    {
        $this->get(route('admin.locale', ['locale' => 'en']))
            ->assertRedirect()
            ->assertSessionHas(SetAdminLocale::SESSION_KEY, 'en');

        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('dir="ltr"', false)
            ->assertSee('العربية');
    }

    public function test_language_switch_rejects_unsupported_locales(): void
    {
        $this->get('/admin-locale/fr')->assertNotFound();
    }
}
