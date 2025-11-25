<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('tenders')) {
            Schema::table('tenders', function (Blueprint $table) {
                if (!Schema::hasColumn('tenders', 'cover_image')) {
                    $table->string('cover_image')->nullable()->after('total_with_vat');
                }
                if (!Schema::hasColumn('tenders', 'cover_image_url')) {
                    $table->string('cover_image_url', 1024)->nullable()->after('cover_image');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tenders')) {
            Schema::table('tenders', function (Blueprint $table) {
                if (Schema::hasColumn('tenders', 'cover_image_url')) {
                    $table->dropColumn('cover_image_url');
                }
                if (Schema::hasColumn('tenders', 'cover_image')) {
                    $table->dropColumn('cover_image');
                }
            });
        }
    }
};
