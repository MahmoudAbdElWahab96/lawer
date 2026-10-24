<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedFields;
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
        'youtube',
        'years_experience',
        'cases_count',
        'clients_count',
        'success_rate',
        'lawyers_count',
        'logo_path',
        'hero_image_path',
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
        return static::query()->first() ?? new static();
    }

    public function whatsappLink(): ?string
    {
        if (! $this->whatsapp) {
            return null;
        }

        return 'https://wa.me/' . preg_replace('/[^0-9]/', '', $this->whatsapp);
    }

    public function socialLinks(): array
    {
        return array_filter([
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'x' => $this->x_url,
            'youtube' => $this->youtube,
        ]);
    }
}
