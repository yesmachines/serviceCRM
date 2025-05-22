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
        Schema::table('job_schedules', function (Blueprint $table) {
            $table->foreignId('demo_request_id')->nullable()->constrained('demo_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_schedules', function (Blueprint $table) {
            $table->dropForeign(['demo_request_id']);
            $table->dropColumn('demo_request_id');
        });
    }
};
