<?php

namespace App\Support;

use Illuminate\Support\Facades\Route as RouteFacade;

/**
 * توليد رابط الصفحة الحالية بلغة أخرى — للـ lang switcher و hreflang.
 */
class LocalizedUrl
{
    public static function current(string $locale): string
    {
        $route = request()->route();

        if ($route && $route->getName()) {
            $parameters = $route->parameters();
            $parameters['locale'] = $locale;

            try {
                return route($route->getName(), $parameters);
            } catch (\Throwable) {
                // بعض المسارات (مثل 404) ليس لها اسم — نرجع للرئيسية
            }
        }

        return url('/' . $locale);
    }
}
