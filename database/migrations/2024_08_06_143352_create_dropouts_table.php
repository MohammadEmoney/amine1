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
        Schema::create('dropouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('delete_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reasons')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('date_left')->nullable();
            $table->timestamp('date_return')->nullable();
            $table->boolean('has_returned')->default(0);
            $table->boolean('end_follow_up')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropouts');
    }
};
