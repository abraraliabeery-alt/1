<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'video_url')) {
                $table->string('video_url')->nullable()->after('gallery');
            }
            if (!Schema::hasColumn('properties', 'video_path')) {
                $table->string('video_path')->nullable()->after('video_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $drops = [];
            if (Schema::hasColumn('properties', 'video_url')) {
                $drops[] = 'video_url';
            }
            if (Schema::hasColumn('properties', 'video_path')) {
                $drops[] = 'video_path';
            }
            if ($drops) {
                $table->dropColumn($drops);
            }
        });
    }
};
