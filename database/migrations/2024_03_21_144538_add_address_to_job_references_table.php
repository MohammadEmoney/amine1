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
        Schema::table('job_references', function (Blueprint $table) {
            $table->string('work_address')->nullable()->after('still_working');
            $table->string('work_phone')->nullable()->after('still_working');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_references', function (Blueprint $table) {
            $table->dropColumn(['work_address', 'work_phone']);
        });
    }
};
