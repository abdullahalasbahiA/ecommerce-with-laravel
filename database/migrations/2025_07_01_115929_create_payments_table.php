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
        Schema::create('payments', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('payment_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users'); // Better foreign key
            $table->string('product_name')->nullable(); // Now properly nullable
            $table->integer('quantity')->default(1); // Changed to integer
            $table->decimal('amount', 10, 2); // Correct decimal type for monetary values
            $table->string('currency', 3)->default('USD'); // Limited to 3 chars for currency code
            $table->string('payer_name')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payment_status', 20)->default('pending');
            $table->string('payment_method', 50)->nullable();
            $table->text('response')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('order_id')->nullable();
            $table->string('status', 20)->default('pending');
            $table->string('ip_address', 45)->nullable(); // IPv6 can be 45 chars
            $table->text('user_agent')->nullable(); // Changed to text as can be long
            $table->text('notes')->nullable(); // Changed to text
            $table->text('shipping_address')->nullable(); // Changed to text
            $table->text('billing_address')->nullable(); // Changed to text
            $table->json('custom_field')->nullable(); // Better as JSON for structured data
            $table->string('discount_code', 50)->nullable();
            $table->string('coupon_code', 50)->nullable();
            $table->string('referral_code', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
