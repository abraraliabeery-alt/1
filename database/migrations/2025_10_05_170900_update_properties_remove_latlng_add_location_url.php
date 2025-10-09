<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'lat')) {
                $table->dropColumn('lat');
            }
            if (Schema::hasColumn('properties', 'lng')) {
                $table->dropColumn('lng');
            }
            if (!Schema::hasColumn('properties', 'location_url')) {
                $table->string('location_url')->nullable()->after('gallery');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'location_url')) {
                $table->dropColumn('location_url');
            }
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
        });
    }
};
