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
        Schema::table('installation_attendees', function (Blueprint $table) {
            // Drop old foreign key if it exists
            $table->dropForeign(['technician_id']);

            // Re-add technician_id referencing users table instead
            $table->foreign('technician_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('installation_attendees', function (Blueprint $table) {
            $table->dropForeign(['technician_id']);

            // Restore original constraint (if needed)
            $table->foreign('technician_id')
                ->references('id')
                ->on('technicians')
                ->onDelete('cascade');
      
        });
    }
};
