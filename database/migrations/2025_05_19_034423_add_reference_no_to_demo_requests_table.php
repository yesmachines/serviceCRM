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
        Schema::table('demo_requests', function (Blueprint $table) {
            $table->string('reference_no')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
   /**
 * Reverse the migrations.
 */
        public function down(): void
        {
            if (Schema::hasColumn('demo_requests', 'reference_no')) {
                Schema::table('demo_requests', function (Blueprint $table) {
                    $table->dropColumn('reference_no');
                });
            }
        }

};
