<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Contacts: referral and UTM fields
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'ref_code')) {
                $table->string('ref_code', 64)->nullable()->after('assigned_employee_id');
            }
            if (!Schema::hasColumn('contacts', 'ref_user_id')) {
                $table->foreignId('ref_user_id')->nullable()->constrained('users')->nullOnDelete()->after('ref_code');
            }
            if (!Schema::hasColumn('contacts', 'utm_source')) {
                $table->string('utm_source', 120)->nullable()->after('ref_user_id');
            }
            if (!Schema::hasColumn('contacts', 'utm_medium')) {
                $table->string('utm_medium', 120)->nullable()->after('utm_source');
            }
            if (!Schema::hasColumn('contacts', 'utm_campaign')) {
                $table->string('utm_campaign', 120)->nullable()->after('utm_medium');
            }
        });

        // Users: affiliate code
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'affiliate_code')) {
                $table->string('affiliate_code', 64)->nullable()->unique()->after('role');
            }
            if (!Schema::hasColumn('users', 'affiliate_active')) {
                $table->boolean('affiliate_active')->default(true)->after('affiliate_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'ref_user_id')) {
                $table->dropConstrainedForeignId('ref_user_id');
            }
            foreach (['ref_code','utm_source','utm_medium','utm_campaign'] as $col) {
                if (Schema::hasColumn('contacts', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
        Schema::table('users', function (Blueprint $table) {
            foreach (['affiliate_code','affiliate_active'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
