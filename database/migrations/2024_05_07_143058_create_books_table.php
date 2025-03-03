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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('sale_price')->default(0);
            $table->string('age')->nullable(); /// children || teens || adults
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->bigInteger('inventory')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
