<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('installation_reports', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('job_schedule_id')->nullable()->constrained('job_schedules')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
    
            // Datetime fields
            $table->dateTime('created_date')->nullable();
            $table->dateTime('job_start_datetime')->nullable();
            $table->dateTime('job_end_datetime')->nullable();

            // Other fields
            $table->string('serial_no')->nullable();
            $table->text('names_of_participants')->nullable();
            $table->string('client_representative')->nullable();
            $table->string('designation')->nullable();
            $table->string('client_signature')->nullable(); // Will store image path
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installation_reports');
    }
};
