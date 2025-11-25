<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('partners') && Schema::hasColumn('partners', 'slug')) {
            $exists = collect(DB::select("SHOW INDEX FROM partners WHERE Key_name = 'partners_slug_unique'"))->isNotEmpty();
            if (!$exists) {
                Schema::table('partners', function (Blueprint $table) {
                    $table->unique('slug', 'partners_slug_unique');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('partners')) {
            $exists = collect(DB::select("SHOW INDEX FROM partners WHERE Key_name = 'partners_slug_unique'"))->isNotEmpty();
            if ($exists) {
                Schema::table('partners', function (Blueprint $table) {
                    $table->dropUnique('partners_slug_unique');
                });
            }
        }
    }
};
