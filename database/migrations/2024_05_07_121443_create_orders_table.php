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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->morphs('orderable');
            $table->string('type'); // Tiution or books
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('contract_number')->nullable();
            $table->string('contract_type')->nullable(); // is it the contract renewal or the new course [new_term, new_course]
            $table->bigInteger('tax')->default(0);
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('order_amount');
            $table->bigInteger('paid_amount')->nullable();
            $table->dateTime('register_date')->nullable();
            $table->text('description')->nullable();
            $table->string('payment_status')->default(0); // if its 1 then has debts and if its 0 then has cleard
            $table->string('payment_type')->nullable(); // Installment or full
            $table->string('payment_method')->nullable(); // cash, credit_card, cheque, online, ..
            $table->string('gateway')->nullable(); // zarinpal, mellat, parsian , ...
            $table->unsignedInteger('renewal_number')->nullable();
            $table->unsignedInteger('order_number')->default(1);
            $table->integer('total_installments')->nullable(); // total number of the installments
            $table->bigInteger('installment_amount')->nullable(); // Amount of payment per installment
            $table->date('installment_date')->nullable();
            $table->string('age_range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
