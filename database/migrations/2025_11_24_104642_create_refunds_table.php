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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('refund_no')->unique();
            $table->decimal('refund_amount', 10, 2)->default(0);
            $table->enum('reason', [
                'customer_request',
                'defective_item',
                'wrong_item',
                'not_as_described',
                'others'
            ]);
            $table->text('reason_description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed']);
            $table->enum('refund_type', ['full', 'partial']);
            $table->enum('refund_method', [
                'original_payment',
                'store_credit',
                'bank_transfer'
            ]);
            $table->text('admin_notes')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
