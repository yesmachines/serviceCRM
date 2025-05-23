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
        Schema::create('installation_technician_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installation_report_id')->nullable();
            $table->text('label');
            $table->string('feedback')->nullable();
            $table->longText('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Manually name the foreign key constraint
            $table->foreign('installation_report_id', 'fk_feedback_report')
                  ->references('id')
                  ->on('installation_reports')
                  ->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installation_technician_feedbacks');
    }
};
