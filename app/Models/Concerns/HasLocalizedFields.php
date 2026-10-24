<?php

namespace App\Models\Concerns;


/**
 * حقول محتوى ثنائية اللغة (ar/en) مخزنة كأعمدة JSON.
 * الفورم في الداشبورد يحرر field.ar و field.en،
 * والواجهة تستخدم t('field') بترتيب fallback: اللغة الحالية ثم ar ثم en.
 */
trait HasLocalizedFields
{
    public function t(string $field, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        $value = $this->getAttributeValue($field);

        if (! is_array($value)) {
            return $value;
        }

        return $value[$locale]
            ?? $value['ar']
            ?? $value['en']
            ?? null;
    }

    public function hasLocale(string $field, string $locale): bool
    {
        $value = $this->getAttributeValue($field);

        return is_array($value) && filled($value[$locale] ?? null);
    }
}
