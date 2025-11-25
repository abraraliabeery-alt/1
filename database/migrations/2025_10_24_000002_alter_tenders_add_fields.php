<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            if (!Schema::hasColumn('tenders','tender_no') && !Schema::hasColumn('tenders','competition_no')) {
                $table->string('tender_no')->nullable()->after('title');
            }
            if (!Schema::hasColumn('tenders','client_id')) {
                $table->foreignId('client_id')->nullable()->after('title')->constrained('clients')->nullOnDelete();
            }
            if (!Schema::hasColumn('tenders','validity_days')) {
                $table->unsignedInteger('validity_days')->nullable()->after('submission_date');
            }
            if (!Schema::hasColumn('tenders','total_before_vat')) {
                $table->decimal('total_before_vat', 18, 2)->nullable()->after('notes');
                $table->decimal('vat_amount', 18, 2)->nullable()->after('total_before_vat');
                $table->decimal('total_with_vat', 18, 2)->nullable()->after('vat_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            if (Schema::hasColumn('tenders','tender_no')) $table->dropColumn('tender_no');
            if (Schema::hasColumn('tenders','client_id')) $table->dropConstrainedForeignId('client_id');
            if (Schema::hasColumn('tenders','validity_days')) $table->dropColumn('validity_days');
            if (Schema::hasColumn('tenders','total_before_vat')) {
                $table->dropColumn(['total_before_vat','vat_amount','total_with_vat']);
            }
        });
    }
};
