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
        Schema::table('demo_request_details', function (Blueprint $table) {
            $table->unsignedBigInteger('job_schedule_id')->nullable()->after('demo_request_id');

            $table->foreign('job_schedule_id')
                  ->references('id')
                  ->on('job_schedules')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_request_details', function (Blueprint $table) {
            $table->dropForeign(['job_schedule_id']);
            $table->dropColumn('job_schedule_id');
        });
    }
};
