<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, ['ar', 'en'], true)) {
            $locale = 'ar';
        }

        app()->setLocale($locale);

        view()->share('locale', $locale);
        view()->share('dir', $locale === 'ar' ? 'rtl' : 'ltr');
        view()->share('settings', Setting::findOrNew());

        return $next($request);
    }
}
