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
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique()->index();
            $table->string('status', 30)->default('pending')->index(); // pending, confirmed, processing, shipped, delivered, cancelled
            
            // Customer Snapshot (Preserved even if user profile edits)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->index();
            $table->string('shipping_city')->index();
            $table->text('shipping_address');
            $table->text('shipping_notes')->nullable();

            // Financials in Moroccan Dirhams (DECIMAL 12,2)
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('total', 12, 2);
            $table->string('currency', 10)->default('MAD');

            // Payment tracking
            $table->string('payment_method', 30)->default('cod'); // cod (cash on delivery)
            $table->string('payment_status', 30)->default('pending'); // pending, paid, refunded

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            
            // Product Snapshot at purchase moment
            $table->string('product_name');
            $table->string('sku');
            $table->decimal('unit_price', 12, 2);
            $table->integer('quantity');
            $table->decimal('total', 12, 2);
            $table->json('variant_attributes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
