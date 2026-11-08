<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Field;

/**
 * تسميات موحدة للحقول ثنائية اللغة في فورمات الداشبورد.
 */
class Bilingual
{
    public static function ar(Field $field, string $label): Field
    {
        return $field->label($label.' (عربي)');
    }

    public static function en(Field $field, string $label): Field
    {
        return $field->label($label.' (English)');
    }
}
