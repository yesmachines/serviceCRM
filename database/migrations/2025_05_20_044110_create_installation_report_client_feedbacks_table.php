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
        Schema::create('installation_report_client_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installation_report_id')->nullable();
            // Shorter, custom foreign key name
            $table->foreign('installation_report_id', 'fk_ir_feedback')
                  ->references('id')
                  ->on('installation_reports')
                  ->onDelete('cascade');
        
            $table->text('label');
            $table->string('feedback')->nullable();
            $table->longText('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installation_report_client_feedbacks');
    }
};
