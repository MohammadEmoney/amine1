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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('type'); // student|staff
            $table->string('father_name')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('landline_phone')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('address')->nullable();
            $table->string('job')->nullable();
            $table->string('education')->nullable();
            $table->string('preferd_course')->nullable();
            $table->string('initial_level')->nullable();
            $table->timestamp('register_date')->nullable();
            $table->string('email')->nullable();
            $table->string('refferal_name')->nullable();
            $table->string('refferal_national_code')->nullable();
            $table->string('refferal_phone')->nullable();
            $table->boolean('mariage_status')->nullable(); // married = true | not_married = false
            $table->string('military_status')->nullable(); // done|exemption|not_done
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
