@php($targetLocale = app()->getLocale() === 'ar' ? 'en' : 'ar')
<x-filament::button tag="a" :href="route('admin.locale', ['locale' => $targetLocale])" color="gray" size="sm" outlined>
    {{ $targetLocale === 'en' ? 'English' : 'العربية' }}
</x-filament::button>
