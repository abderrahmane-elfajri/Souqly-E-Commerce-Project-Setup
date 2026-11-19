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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            
            // Movement classification: sale, restock, cancellation_return, adjustment, loss
            $table->string('type', 30)->index();
            $table->integer('quantity'); // Positive for additions, negative for deductions
            $table->integer('stock_before');
            $table->integer('stock_after');
            
            // Reference (e.g. Order # SQL-202611-XXXXX, supplier invoice, or adjustment ticket)
            $table->string('reference')->nullable()->index();
            $table->text('notes')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
