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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type');
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('categoryables', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->morphs('categoryable');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
