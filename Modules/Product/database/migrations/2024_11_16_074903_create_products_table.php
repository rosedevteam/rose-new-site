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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('short_description');
            $table->integer('price');
            $table->integer('sale_price')->nullable();
            $table->integer('content')->nullable();
            $table->enum('status', ['public', 'draft', 'hidden' , 'outofstock'])->default('draft');
            $table->boolean('comment_status')->default(true);
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->string('spot_player_key')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('is_free')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
