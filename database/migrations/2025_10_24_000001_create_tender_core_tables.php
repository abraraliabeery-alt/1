<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // clients
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('sector')->nullable();
                $table->string('city')->nullable();
                $table->string('contact_ref')->nullable();
                $table->timestamps();
            });
        }

        // files library
        if (!Schema::hasTable('files')) {
            Schema::create('files', function (Blueprint $table) {
                $table->id();
                $table->string('storage_path');
                $table->string('original_name');
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('size_bytes')->default(0);
                $table->string('sha256', 64)->nullable()->index();
                $table->unsignedInteger('pages_count')->nullable();
                $table->enum('ocr_status', ['none','pending','done','failed'])->default('none');
                $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('file_text_pages')) {
            Schema::create('file_text_pages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('file_id')->constrained('files')->cascadeOnDelete();
                $table->unsignedInteger('page_no');
                $table->longText('text')->nullable();
                $table->string('hash', 64)->nullable();
                $table->unique(['file_id','page_no']);
                $table->timestamps();
            });
        }

        // attachments bound to tenders
        if (!Schema::hasTable('attachments')) {
            Schema::create('attachments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->foreignId('file_id')->constrained('files')->cascadeOnDelete();
                $table->enum('category', ['boq','invoice','license','certificate','letter','technical','financial','other'])->default('other');
                $table->string('label')->nullable();
                $table->text('notes')->nullable();
                $table->unsignedInteger('page_start')->nullable();
                $table->unsignedInteger('page_end')->nullable();
                $table->unsignedInteger('version_no')->default(1);
                $table->boolean('is_current')->default(true);
                $table->unsignedInteger('display_order')->default(0);
                $table->timestamps();
                $table->index(['tender_id','category','is_current']);
            });
        }

        // BOQ headers and items
        if (!Schema::hasTable('boq_headers')) {
            Schema::create('boq_headers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->string('currency', 8)->default('SAR');
                $table->unsignedInteger('version_no')->default(1);
                $table->boolean('is_current')->default(true);
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->index(['tender_id','is_current']);
            });
        }

        if (!Schema::hasTable('boq_items')) {
            Schema::create('boq_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('boq_id')->constrained('boq_headers')->cascadeOnDelete();
                $table->string('item_code')->nullable();
                $table->string('item_name');
                $table->text('spec')->nullable();
                $table->string('unit', 16)->nullable();
                $table->decimal('quantity', 18, 3)->default(0);
                $table->decimal('unit_price', 18, 4)->default(0);
                $table->decimal('total_line', 18, 2)->default(0)->index();
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
                $table->index(['boq_id','sort_order']);
            });
        }

        // previous projects
        if (!Schema::hasTable('previous_projects')) {
            Schema::create('previous_projects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->string('project_name');
                $table->string('client_name')->nullable();
                $table->year('year')->nullable();
                $table->unsignedInteger('team_members')->nullable();
                $table->decimal('cost', 18, 2)->nullable();
                $table->text('description')->nullable();
                $table->foreignId('evidence_file_id')->nullable()->constrained('files')->nullOnDelete();
                $table->timestamps();
            });
        }

        // licenses
        if (!Schema::hasTable('licenses')) {
            Schema::create('licenses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->string('license_type');
                $table->string('issuing_authority')->nullable();
                $table->string('license_no')->nullable();
                $table->date('issue_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->string('verification_url')->nullable();
                $table->foreignId('file_id')->nullable()->constrained('files')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->index(['tender_id','expiry_date']);
            });
        }

        // certificates
        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->string('certificate_name');
                $table->string('authority')->nullable();
                $table->string('certificate_no')->nullable();
                $table->date('issue_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->string('verification_url')->nullable();
                $table->foreignId('file_id')->nullable()->constrained('files')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->index(['tender_id','expiry_date']);
            });
        }

        // letters
        if (!Schema::hasTable('letters')) {
            Schema::create('letters', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->enum('letter_type', ['submission','pricing','award','other'])->default('other');
                $table->string('subject')->nullable();
                $table->date('issue_date')->nullable();
                $table->foreignId('file_id')->nullable()->constrained('files')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // tender sections map (optional)
        if (!Schema::hasTable('tender_sections')) {
            Schema::create('tender_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
                $table->string('title');
                $table->unsignedInteger('page_start')->nullable();
                $table->unsignedInteger('page_end')->nullable();
                $table->unsignedInteger('section_order')->default(0);
                $table->timestamps();
                $table->index(['tender_id','section_order']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_sections');
        Schema::dropIfExists('letters');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('previous_projects');
        Schema::dropIfExists('boq_items');
        Schema::dropIfExists('boq_headers');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('file_text_pages');
        Schema::dropIfExists('files');
        Schema::dropIfExists('clients');
    }
};
