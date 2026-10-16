<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('notices', 'is_active')) {

            Schema::table('notices', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('attachment_path');
            });

            /* Backfill: mark all existing notices as active */
            DB::table('notices')->update(['is_active' => true]);

            Schema::table('notices', function (Blueprint $table) {
                $table->index('is_active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('notices', 'is_active')) {
            Schema::table('notices', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
                $table->dropColumn('is_active');
            });
        }
    }
};