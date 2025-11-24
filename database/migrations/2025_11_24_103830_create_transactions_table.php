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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('transaction_ref')->unique();
            $table->string('payment_gateway');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'transfer']);
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->enum('status',['pending', 'completed', 'failed', 'refunded', 'cancelled']);
            $table->json('gateway_response');
//            $table->text('failure_reason')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
