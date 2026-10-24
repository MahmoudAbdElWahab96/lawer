<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\PracticeArea;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'practiceAreas' => PracticeArea::active()->get(),
            'features' => Feature::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'faqs' => Faq::active()->get(),
            'articles' => Article::published()->limit(3)->get(),
        ]);
    }
}
