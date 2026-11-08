<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_settings')) {
            foreach (DB::table('site_settings')->orderBy('id')->get() as $row) {
                $data = $this->asArray($row->data);

                if (! is_array($data)) {
                    $data = [];
                }

                $data = $this->replaceSalesEmail($data);
                $data['email'] = 'contact@byphealthtek.com';
                $data['phone_sg'] = '';
                $data['phone_us'] = '';
                $data['phone_ae'] = '';
                $data['whatsapp_url'] = '';

                DB::table('site_settings')->where('id', $row->id)->update([
                    'data' => json_encode($data),
                    'updated_at' => now(),
                ]);
            }
        }

        if (Schema::hasTable('pages')) {
            foreach (DB::table('pages')->orderBy('id')->get() as $page) {
                $blocks = $this->replaceSalesEmail($this->asArray($page->blocks));
                $blocks = $this->withoutPublicPhones($blocks);

                DB::table('pages')->where('id', $page->id)->update([
                    'blocks' => json_encode($blocks),
                    'seo_title' => $this->replaceSalesEmail($page->seo_title),
                    'seo_description' => $this->replaceSalesEmail($page->seo_description),
                    'updated_at' => now(),
                ]);
            }
        }

        if (Schema::hasTable('posts')) {
            foreach (DB::table('posts')->orderBy('id')->get() as $post) {
                DB::table('posts')->where('id', $post->id)->update([
                    'excerpt' => $this->replaceSalesEmail($post->excerpt),
                    'body' => $this->replaceSalesEmail($post->body),
                    'seo_title' => $this->replaceSalesEmail($post->seo_title),
                    'seo_description' => $this->replaceSalesEmail($post->seo_description),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Contact details were corrected in production content; do not restore the old sales address.
    }

    protected function asArray(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $value;
    }

    protected function replaceSalesEmail(mixed $value): mixed
    {
        if (is_string($value)) {
            return str_replace('sales@byphealthtek.com', 'contact@byphealthtek.com', $value);
        }

        if (! is_array($value)) {
            return $value;
        }

        foreach ($value as $key => $item) {
            $value[$key] = $this->replaceSalesEmail($item);
        }

        return $value;
    }

    protected function withoutPublicPhones(mixed $value): mixed
    {
        if (! is_array($value)) {
            return is_string($value) ? $this->stripPhoneNumbers($value) : $value;
        }

        $cleaned = [];

        foreach ($value as $key => $item) {
            if (is_array($item) && in_array($item['title'] ?? '', ['Phone', 'WhatsApp Us'], true)) {
                continue;
            }

            $cleaned[$key] = $this->withoutPublicPhones($item);
        }

        return array_is_list($value) ? array_values($cleaned) : $cleaned;
    }

    protected function stripPhoneNumbers(string $value): string
    {
        $value = str_replace([
            '+971 55 735 6736',
            '+65 8836 0984',
            '+1 (512) 717-6408',
        ], '', $value);

        return trim(preg_replace('/\s{2,}/', ' ', $value) ?? $value, " \t\n\r.");
    }
};
