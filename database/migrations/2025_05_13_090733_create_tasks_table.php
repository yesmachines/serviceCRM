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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_schedule_id')->nullable()->constrained('job_schedules')->onDelete('cascade');
            $table->foreignId('task_status_id')->nullable()->constrained('task_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('vehicle_id')->nullable()->constrained('vehicles')->onDelete('cascade');
            $table->dateTime('start_datetime')->nullable(); 
            $table->dateTime('end_datetime')->nullable(); 
            $table->longText('task_details')->nullable(); 
            $table->text('reason')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
