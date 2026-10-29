<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('leads')->where('email', '')->update(['email' => null]);

        DB::table('leads')->whereNotNull('email')->update([
            'email' => DB::raw('LOWER(TRIM(email))'),
        ]);

        $keepIds = DB::table('leads')
            ->selectRaw('MIN(id) as id')
            ->whereNotNull('email')
            ->groupBy('email', 'type')
            ->pluck('id');

        DB::table('leads')
            ->whereNotNull('email')
            ->whereNotIn('id', $keepIds)
            ->delete();

        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex('leads_email_index');
            $table->unique(['email', 'type'], 'leads_email_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropUnique('leads_email_type_unique');
            $table->index('email', 'leads_email_index');
        });
    }
};
