<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTagsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_valid_json_ld_and_og_image(): void
    {
        Setting::create([
            'lawyer_name' => ['ar' => 'علي الديب', 'en' => 'Ali El-Deeb'],
            'lawyer_title' => ['ar' => 'محامٍ بالاستئناف', 'en' => 'Attorney'],
            'hero_image_path' => 'images/landing/497c8.png',
            'seo_robots_index' => true,
        ]);

        Faq::create([
            'question' => ['ar' => 'سؤال تجريبي', 'en' => 'Test question'],
            'answer' => ['ar' => 'إجابة تجريبية', 'en' => 'Test answer'],
            'sort_order' => 1,
        ]);

        $response = $this->get('/ar');
        $response->assertStatus(200);

        $html = $response->getContent();
        $this->assertStringNotContainsString('<?php', $html);
        $this->assertStringContainsString('"@context":"https://schema.org"', $html);
        $this->assertStringContainsString('"@type":"Attorney"', $html);
        $this->assertStringContainsString('"@type":"FAQPage"', $html);
        $this->assertStringContainsString('<meta property="og:image" content="'.asset('images/landing/497c8.png').'">', $html);
        $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image">', $html);
    }

    public function test_sitemap_and_robots_render_when_indexing_enabled(): void
    {
        Setting::create([
            'lawyer_name' => ['ar' => 'علي الديب', 'en' => 'Ali El-Deeb'],
            'seo_robots_index' => true,
        ]);

        $this->get('/robots.txt')
            ->assertStatus(200)
            ->assertSee('Allow: /', false)
            ->assertSee('Sitemap:', false);

        $this->get('/sitemap.xml')
            ->assertStatus(200)
            ->assertSee('/ar', false)
            ->assertSee('/en', false);
    }

    public function test_blog_index_renders_localized_titles_without_raw_translation_keys(): void
    {
        Setting::create([
            'lawyer_name' => ['ar' => 'علي الديب', 'en' => 'Ali El-Deeb'],
            'seo_robots_index' => true,
        ]);

        $this->get('/ar/blog')
            ->assertStatus(200)
            ->assertDontSee('site.blog.title')
            ->assertSee('المقالات والاستشارات القانونية | علي الديب');

        $this->get('/en/blog')
            ->assertStatus(200)
            ->assertDontSee('site.blog.title')
            ->assertSee('Legal Articles &amp; Insights | Ali El-Deeb', false);
    }
}
