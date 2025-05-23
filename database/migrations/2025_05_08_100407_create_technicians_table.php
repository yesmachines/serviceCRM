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
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Nullable fields
            $table->unsignedBigInteger('vehicle_assigned')->nullable(); // could reference vehicles table if needed
            $table->foreign('vehicle_assigned')->references('id')->on('users')->onDelete('cascade');
            $table->string('technician_level')->nullable();
            $table->float('standard_charge')->nullable();
            $table->float('additional_charge')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
