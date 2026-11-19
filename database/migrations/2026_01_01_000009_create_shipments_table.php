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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            
            // Carrier in Morocco: Amana Express, Cathedis, Ozone Express, Aramex, Autre
            $table->string('carrier', 60)->default('Amana Express');
            $table->string('tracking_number', 100)->unique()->index();
            
            // Status: pending, picked_up, in_transit, out_for_delivery, delivered, failed, returned
            $table->string('status', 30)->default('pending')->index();
            $table->decimal('shipping_cost', 12, 2)->default(0.00);
            
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
