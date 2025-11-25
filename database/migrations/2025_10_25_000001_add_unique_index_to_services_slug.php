<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'slug')) {
            $exists = collect(DB::select("SHOW INDEX FROM services WHERE Key_name = 'services_slug_unique'"))->isNotEmpty();
            if (!$exists) {
                Schema::table('services', function (Blueprint $table) {
                    $table->unique('slug', 'services_slug_unique');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('services')) {
            $exists = collect(DB::select("SHOW INDEX FROM services WHERE Key_name = 'services_slug_unique'"))->isNotEmpty();
            if ($exists) {
                Schema::table('services', function (Blueprint $table) {
                    $table->dropUnique('services_slug_unique');
                });
            }
        }
    }
};
