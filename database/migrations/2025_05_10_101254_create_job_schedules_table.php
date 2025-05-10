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
        Schema::create('job_schedules', function (Blueprint $table) {
            $table->id();
              $table->string('job_no')->nullable();

            // Foreign keys
            $table->foreignId('job_type')->nullable()->constrained('service_types')->onDelete('set null');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('job_owner_id')->nullable()->constrained('technicians')->onDelete('set null');
            $table->foreignId('job_status_id')->nullable()->constrained('job_statuses')->onDelete('set null');

            $table->string('contact_no')->nullable();
            $table->string('location')->nullable();

            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();

            $table->longText('job_details')->nullable();
            $table->string('chargeable')->nullable();
            $table->dateTime('closing_date')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_schedules');
    }
};
