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
        Schema::create('service_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_schedule_id')->nullable()->constrained('job_schedules')->onDelete('cascade');
            $table->foreignId('service_type_id')->nullable()->constrained('service_types')->onDelete('cascade');
            $table->string('machine_type')->nullable();
            $table->string('is_warranty'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_jobs');
    }
};
