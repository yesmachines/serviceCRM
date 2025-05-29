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
            
            $table->dropForeign(['job_owner_id']);

            // Change foreign key to reference users table
            $table->foreign('job_owner_id')->references('id')->on('users')->onDelete('cascade');

            // Add new foreign key column for created_by
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_schedules', function (Blueprint $table) {

                // Rollback created_by
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
    
                // Revert job_owner_id back to technicians
                $table->dropForeign(['job_owner_id']);
                $table->foreign('job_owner_id')->references('id')->on('technicians')->onDelete('cascade');
          
        });
    }
};
