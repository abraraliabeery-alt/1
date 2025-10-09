<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('marketing_requests', function (Blueprint $table) {
            $table->id();
            // requester info
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 40)->nullable();
            // property info
            $table->string('property_title')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('type', 40)->nullable();
            $table->integer('price')->nullable();
            $table->integer('area')->nullable();
            $table->text('description')->nullable();
            // uploads (paths)
            $table->json('files')->nullable();
            // management fields
            $table->string('status', 30)->default('new');
            $table->foreignId('assigned_employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status','created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketing_requests');
    }
};
