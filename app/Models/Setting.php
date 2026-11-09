<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedFields;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * صف إعدادات واحد (id = 1) يغذي كل بيانات الموقع القابلة للتعديل من الداشبورد.
 */
class Setting extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'lawyer_name',
        'lawyer_title',
        'hero_headline',
        'hero_subheadline',
        'about_title',
        'about_text',
        'phone',
        'whatsapp',
        'email',
        'address',
        'working_hours',
        'map_embed_url',
        'facebook',
        'instagram',
        'linkedin',
        'x_url',
        'tiktok',
        'youtube',
        'years_experience',
        'cases_count',
        'clients_count',
        'success_rate',
        'lawyers_count',
        'bar_admission_year',
        'logo_path',
        'hero_image_path',
        'practice_title',
        'practice_subtitle',
        'practice_banner_title',
        'practice_banner_text',
        'pledge_title',
        'pledge_subtitle',
        'pledge_sign_text',
        'pledge_clauses',
        'route_title',
        'route_subtitle',
        'route_stages',
        'messages_title',
        'messages_subtitle',
        'messages_items',
        'faq_title',
        'faq_subtitle',
        'booking_title',
        'booking_subtitle',
        'contact_title',
        'contact_subtitle',
        'footer_text',
        'seo_meta_title',
        'seo_meta_description',
        'seo_keywords',
        'seo_og_image_path',
        'seo_robots_index',
        'google_verification',
    ];

    protected function casts(): array
    {
        return [
            'lawyer_name' => 'array',
            'lawyer_title' => 'array',
            'hero_headline' => 'array',
            'hero_subheadline' => 'array',
            'about_title' => 'array',
            'about_text' => 'array',
            'address' => 'array',
            'working_hours' => 'array',
            'years_experience' => 'integer',
            'cases_count' => 'integer',
            'clients_count' => 'integer',
            'success_rate' => 'integer',
            'lawyers_count' => 'integer',
            'practice_title' => 'array',
            'practice_subtitle' => 'array',
            'practice_banner_title' => 'array',
            'practice_banner_text' => 'array',
            'pledge_title' => 'array',
            'pledge_subtitle' => 'array',
            'pledge_sign_text' => 'array',
            'pledge_clauses' => 'array',
            'route_title' => 'array',
            'route_subtitle' => 'array',
            'route_stages' => 'array',
            'messages_title' => 'array',
            'messages_subtitle' => 'array',
            'messages_items' => 'array',
            'faq_title' => 'array',
            'faq_subtitle' => 'array',
            'booking_title' => 'array',
            'booking_subtitle' => 'array',
            'contact_title' => 'array',
            'contact_subtitle' => 'array',
            'footer_text' => 'array',
            'seo_meta_title' => 'array',
            'seo_meta_description' => 'array',
            'seo_keywords' => 'array',
            'seo_robots_index' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }

    public static function findOrNew(): self
    {
        return static::query()->first() ?? new static;
    }

    public static function formatNumber(int|string|null $number, ?string $locale = null): string
    {
        if ($number === null || $number === '') {
            return '';
        }

        $locale = $locale ?: app()->getLocale();

        if ($locale !== 'ar') {
            return (string) $number;
        }

        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $eastern, (string) $number);
    }

    public function whatsappLink(): ?string
    {
        if (! $this->whatsapp) {
            return null;
        }

        return 'https://wa.me/'.preg_replace('/[^0-9]/', '', $this->whatsapp);
    }

    public function socialLinks(): array
    {
        return array_filter([
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'x' => $this->x_url,
            'tiktok' => $this->tiktok,
            'youtube' => $this->youtube,
        ]);
    }

    public function mapOpenUrl(): string
    {
        $url = $this->map_embed_url;

        if ($url && filter_var($url, FILTER_VALIDATE_URL) && ! str_contains($url, '/maps/embed')) {
            return $url;
        }

        $address = $this->t('address') ?: '27 ص، حدائق الاهرام، الجيزة، مصر';

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode($address);
    }

    /**
     * Whether the map is the OpenStreetMap fallback rather than an embed pasted from Google Maps.
     */
    public function usesFallbackMap(): bool
    {
        $url = (string) $this->map_embed_url;

        return ! preg_match('/src=["\']([^"\']+)["\']/', $url) && ! str_contains($url, '/maps/embed');
    }

    public function mapEmbedSrc(): string
    {
        $url = $this->map_embed_url;

        // 1. If an <iframe> tag was pasted, extract src
        if ($url && preg_match('/src=["\']([^"\']+)["\']/', $url, $matches)) {
            return $matches[1];
        }

        // 2. If it is already a valid embed URL
        if ($url && str_contains($url, '/maps/embed')) {
            return $url;
        }

        // 3. Fallback to OpenStreetMap; the landing page draws its own pin at the center
        $lat = 29.9484375;
        $lng = 31.0974375;

        if ($url && (preg_match('/!3d(-?[0-9.]+)!4d(-?[0-9.]+)/', $url, $matches) || preg_match('/@(-?[0-9.]+),(-?[0-9.]+)/', $url, $matches))) {
            $lat = (float) $matches[1];
            $lng = (float) $matches[2];
        }

        $bboxLeft = $lng - 0.020;
        $bboxBottom = $lat - 0.014;
        $bboxRight = $lng + 0.020;
        $bboxTop = $lat + 0.014;

        return "https://www.openstreetmap.org/export/embed.html?bbox={$bboxLeft}%2C{$bboxBottom}%2C{$bboxRight}%2C{$bboxTop}&layer=mapnik";
    }

    protected function googleVerification(): Attribute
    {
        return Attribute::make(
            set: function (?string $value): ?string {
                if (! $value) {
                    return null;
                }

                if (preg_match('/content=["\']([^"\']+)["\']/', $value, $matches)) {
                    return $matches[1];
                }

                return trim(strip_tags($value));
            }
        );
    }
}
