<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('price');
            $table->string('notes')->nullable()->default(null);
            $table->enum('status', ['pending', 'completed', 'cancelled', 'returned'])->default('pending');
            $table->enum('payment_method', ['shaparak', 'card'])->default('shaparak');
            $table->foreignId('wallet_transaction_id')->nullable()->default(null)->constrained('wallet_transactions')->nullOnDelete();
            $table->longText('spot_player_log')->nullable();
            $table->longText('spot_player_id')->nullable();
            $table->longText('spot_player_licence')->nullable();
            $table->text('spot_player_watermark')->nullable();
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
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
