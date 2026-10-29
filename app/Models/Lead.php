<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'page_url',
        'meta',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }
}
