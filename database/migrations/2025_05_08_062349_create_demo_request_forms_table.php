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
        Schema::create('demo_requests', function (Blueprint $table) {
           
            $table->id();         
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('demo_request_by')->nullable(); 
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('service_expert_id')->nullable();  //user_id

            $table->string('offer_submitted')->nullable();
            $table->dateTime('date_of_submission_of_offer')->nullable();
            $table->date('demo_date')->nullable();
            $table->time('demo_time')->nullable();
            $table->string('location')->nullable();
            $table->text('how_soon_client_needs_machine')->nullable();
            $table->longText('demo_objective')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('demo_request_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_expert_id')->references('id')->on('users')->onDelete('cascade');

           
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_requests');
    }
};
