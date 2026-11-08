<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\PracticeArea;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'practiceAreas' => PracticeArea::active()->get(),
            'faqs' => Faq::active()->get(),
        ]);
    }
}
