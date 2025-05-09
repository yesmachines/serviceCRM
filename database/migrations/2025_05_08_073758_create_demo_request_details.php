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
        Schema::create('demo_request_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demo_request_id')->nullable(); 
            $table->unsignedBigInteger('product_id')->nullable();      
            // Main fields
            $table->text('description')->nullable();
            $table->float('qty')->nullable();
            $table->longText('remarks')->nullable();
            $table->dateTime('machine_out')->nullable();
            $table->dateTime('machine_in')->nullable();
            $table->string('product_type')->nullable(); // e.g., machine or consumable
            $table->string('is_out_from_stock')->nullable();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('demo_request_id')->references('id')->on('demo_requests')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
           
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_request_details');
    }
};
