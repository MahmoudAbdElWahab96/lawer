<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedFields;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasLocalizedFields;

    protected $fillable = [
        'client_name',
        'client_role',
        'content',
        'rating',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'client_role' => 'array',
            'content' => 'array',
            'rating' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
