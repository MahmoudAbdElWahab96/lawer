<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
{
    public const SESSION_KEY = 'admin_locale';

    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale($request->session()->get(self::SESSION_KEY, 'ar'));

        Filament::getCurrentPanel()?->navigationGroups([
            __('الاستشارات'),
            __('محتوى الموقع'),
            __('المحتوى'),
            __('الإعدادات'),
        ]);

        return $next($request);
    }
}
