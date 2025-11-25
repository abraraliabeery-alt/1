<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop obsolete tables if they exist
        Schema::disableForeignKeyConstraints();
        foreach (['favorites','marketing_requests'] as $tbl) {
            if (Schema::hasTable($tbl)) {
                Schema::drop($tbl);
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Intentionally left blank (cannot restore dropped tables without original migrations)
    }
};
