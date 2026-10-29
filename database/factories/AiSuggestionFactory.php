<?php

namespace Database\Factories;

use App\Models\AiSuggestion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<AiSuggestion>
 */
class AiSuggestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_id' => (string) Str::uuid(),
            'type' => 'page',
            'payload' => [
                'title' => 'Workplace wellness programmes',
                'slug' => 'workplace-wellness',
                'outline' => '<p>A draft outline for workplace wellness kits.</p>',
                'reason' => 'Traffic to contact-us is high; a dedicated page could convert better.',
            ],
            'status' => 'pending',
        ];
    }
}
