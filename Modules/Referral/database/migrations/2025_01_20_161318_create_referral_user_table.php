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
        Schema::create('referral_user' , function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('used_by');
            $table->foreign('used_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('referral_id');
            $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('cascade');
            $table->boolean('signed_up')->default(0);
            $table->boolean('has_bought')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_user');
    }
};
