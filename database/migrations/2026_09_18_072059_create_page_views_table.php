<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 512);
            $table->string('title')->nullable();
            $table->string('referrer', 2048)->nullable();
            $table->string('referrer_host')->nullable()->index();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('session_id', 64)->index();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('country', 8)->nullable();
            $table->string('language', 32)->nullable();
            $table->timestamp('occurred_at')->index();
            $table->timestamps();

            $table->index(['occurred_at', 'referrer_host']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
