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
            // Change existing column to enum
            $table->enum('is_out_from_stock', ['yes', 'no'])->default('yes')->change();
            $table->string('yes_no')->nullable()->after('is_out_from_stock');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_request_details', function (Blueprint $table) {
            // Revert column type back to string
            $table->string('is_out_from_stock')->change();

            // Drop new column
            $table->dropColumn('yes_no');
        });
    }
};
