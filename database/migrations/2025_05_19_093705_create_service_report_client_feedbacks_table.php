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
        Schema::create('service_report_client_feedbacks', function (Blueprint $table) {
         
            $table->id();
            $table->text('label')->nullable();                 
            $table->string('feedback')->nullable();            
            $table->longText('remark')->nullable();             
            $table->string('type')->nullable();  

            $table->unsignedBigInteger('service_report_id')->nullable();
            // Manually name the foreign key constraint
            $table->foreign('service_report_id', 'fk_service_report')
                  ->references('id')
                  ->on('service_reports')
                  ->onDelete('cascade');

                  

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_report_client_feedbacks');
    }
};

