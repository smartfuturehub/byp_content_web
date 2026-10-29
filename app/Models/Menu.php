<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'location', 'items'];

    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }

    public static function location(string $location): array
    {
        return static::query()->where('location', $location)->value('items') ?? [];
    }
}
