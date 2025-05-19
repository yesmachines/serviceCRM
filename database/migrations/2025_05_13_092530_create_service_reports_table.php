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
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            // Foreign key to tasks table
            $table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('cascade');
            // Report fields
            $table->longText('description')->nullable();
            $table->longText('observations')->nullable();
            $table->longText('actions_taken')->nullable();
            $table->longText('client_remark')->nullable();
            // Technicians
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('cascade'); 
            // Job attended 
            $table->foreignId('concluded_by')->nullable()->constrained('users')->onDelete('cascade'); // Job concluded by
            // Client details
            $table->string('client_representative')->nullable();
            $table->string('designation')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('client_signature')->nullable(); 
            $table->timestamps();
        });
    }



	

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};
