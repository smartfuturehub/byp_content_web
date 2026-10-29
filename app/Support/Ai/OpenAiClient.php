<?php

namespace App\Support\Ai;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiClient
{
    public function isConfigured(): bool
    {
        return filled(config('services.openai.key'));
    }

    /**
     * @param  list<array{role: string, content: string}>  $messages
     */
    public function chat(array $messages): string
    {
        $response = $this->request([
            'model' => $this->model(),
            'temperature' => 0.2,
            'messages' => $messages,
        ]);

        return trim((string) data_get($response, 'choices.0.message.content', ''));
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonCompletion(string $system, string $user): array
    {
        $response = $this->request([
            'model' => $this->model(),
            'temperature' => 0.2,
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $user],
            ],
        ]);

        $content = (string) data_get($response, 'choices.0.message.content', '{}');
        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function request(array $payload): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Set OPENAI_API_KEY in the environment to use the AI assistant.');
        }

        $response = Http::connectTimeout(5)
            ->timeout(60)
            ->withToken((string) config('services.openai.key'))
            ->acceptJson()
            ->post('https://api.openai.com/v1/chat/completions', $payload);

        if (! $response->successful()) {
            throw new RuntimeException('OpenAI request failed ('.$response->status().').');
        }

        return $response->json() ?? [];
    }

    protected function model(): string
    {
        return (string) config('services.openai.model', 'gpt-4o-mini');
    }
}
