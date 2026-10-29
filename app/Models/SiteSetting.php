<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['data'];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::query()->first() ?? static::query()->create(['data' => []]);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->data ?? [], $key, $default);
    }

    public function put(string $key, mixed $value): self
    {
        $data = $this->data ?? [];
        data_set($data, $key, $value);
        $this->data = $data;

        return $this;
    }
}
