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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->nullable()->default(null)->constrained('users');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('birthday')->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->boolean('is_married')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
