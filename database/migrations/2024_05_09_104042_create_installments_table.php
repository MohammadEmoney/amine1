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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('order_id')->constrained('orders')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->boolean('pre_paid')->default(0);
            $table->bigInteger('amount');
            $table->integer('installment_number')->nullable();
            $table->string('payment_status')->default('debt'); // if its 1 then has debts and if its 0 then has cleard
            $table->string('payment_method')->nullable(); // cash, credit_card, cheque, online, ..
            $table->string('gateway')->nullable(); // zarinpal, mellat, parsian , ...
            $table->text('description')->nullable();
            $table->date('date_paid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
