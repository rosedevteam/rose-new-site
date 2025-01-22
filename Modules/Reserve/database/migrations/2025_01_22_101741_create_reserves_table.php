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

        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->string('know');
            $table->timestamps();
        });

        Schema::create('product_reserve', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('reserve_id')->constrained('reserves')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
