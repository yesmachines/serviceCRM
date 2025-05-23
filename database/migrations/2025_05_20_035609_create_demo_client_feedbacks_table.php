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
        Schema::create('demo_client_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_schedule_id')->nullable();
            $table->foreign('job_schedule_id')
                  ->references('id')->on('job_schedules')
                  ->onDelete('cascade');

            $table->text('demo_objective')->nullable();        
            $table->text('result')->nullable();                
            $table->string('client_representative')->nullable();
            $table->string('designation')->nullable();          
            $table->string('client_signature')->nullable();   
            $table->integer('rating')->nullable();             
            $table->longText('comment')->nullable(); 
            $table->softDeletes();          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_client_feedbacks');
    }
};

	