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
        Schema::create('client_feedbacks', function (Blueprint $table) {
            $table->id();

            // Foreign key to job_schedules table
            $table->unsignedBigInteger('job_schedule_id')->nullable();
            $table->foreign('job_schedule_id')
                  ->references('id')->on('job_schedules')
                  ->onDelete('cascade');

            // Foreign key to service_types table
            $table->unsignedBigInteger('job_type')->nullable();
            $table->foreign('job_type')
                  ->references('id')->on('service_types')
                  ->onDelete('cascade');

            $table->text('label')->nullable();                  // textarea
            $table->string('feedback')->nullable();             // varchar
            $table->longText('remark')->nullable();             // long textarea

            $table->text('demo_objective')->nullable();         // textarea
            $table->text('result')->nullable();                 // textarea
            $table->string('client_representative')->nullable(); // varchar
            $table->string('designation')->nullable();          // varchar
            $table->string('client_signature')->nullable();     // varchar (can store path)
            $table->integer('rating')->nullable();              // int
            $table->longText('comment')->nullable();            // long textarea

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_feedbacks');
    }
};
