<?php

namespace App\Http\Controllers\Site;

use App\Models\Article;
use App\Models\Setting;

class SitemapController
{
    public function __invoke()
    {
        $settings = Setting::findOrNew();

        $articles = Article::published()->get();

        $urls = [];

        foreach (['ar', 'en'] as $locale) {
            $urls[] = [$this->url('home', $locale), 'weekly', '1.0'];
            $urls[] = [$this->url('blog.index', $locale), 'weekly', '0.8'];

            foreach ($articles as $article) {
                $urls[] = [
                    route('blog.show', ['locale' => $locale, 'article' => $article->slug]),
                    'monthly',
                    '0.6',
                ];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        if ($settings->seo_robots_index) {
            foreach ($urls as [$loc, $freq, $priority]) {
                $xml .= '  <url>'.PHP_EOL;
                $xml .= '    <loc>'.htmlspecialchars($loc, ENT_XML1).'</loc>'.PHP_EOL;
                $xml .= "    <changefreq>{$freq}</changefreq>".PHP_EOL;
                $xml .= "    <priority>{$priority}</priority>".PHP_EOL;
                $xml .= '  </url>'.PHP_EOL;
            }
        }

        $xml .= '</urlset>'.PHP_EOL;

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function url(string $name, string $locale): string
    {
        return route($name, ['locale' => $locale]);
    }
}
