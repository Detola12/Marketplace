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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->string('payout_ref')->unique();
            $table->decimal('amount', 10, 2);
            $table->decimal('commission_deducted', 10, 2);
            $table->decimal('net_amount', 10, 2);
            $table->string('currency');
            $table->enum('status', ['pending', 'completed', 'failed', 'processing', 'cancelled']);
            $table->string('payout_method');
            $table->timestamp('payout_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->string('gateway_ref')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('period_start');
            $table->timestamp('period_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
