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
        Schema::create('telegrams', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone')->nullable();
            $table->string('telegram_id');
            $table->string('duration');
            $table->string('start_date');
            $table->string('end_date');
            $table->longText('desc');
            $table->boolean('is_notified')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->string('deleted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegrams');
    }
};
