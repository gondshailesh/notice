<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('notices', 'published_at')) {

            Schema::table('notices', function (Blueprint $table) {
                $table->timestamp('published_at')->nullable()->after('is_active');
            });

            /* Backfill: copy created_at into published_at for existing rows */
            DB::table('notices')
                ->whereNull('published_at')
                ->update(['published_at' => DB::raw('created_at')]);

            Schema::table('notices', function (Blueprint $table) {
                $table->index('published_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('notices', 'published_at')) {
            Schema::table('notices', function (Blueprint $table) {
                $table->dropIndex(['published_at']);
                $table->dropColumn('published_at');
            });
        }
    }
};