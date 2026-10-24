<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'practice_area_id',
        'message',
        'locale',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function practiceArea()
    {
        return $this->belongsTo(PracticeArea::class);
    }
}
