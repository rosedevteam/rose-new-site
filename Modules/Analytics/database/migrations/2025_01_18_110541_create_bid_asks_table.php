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
        Schema::create('bid_asks', function (Blueprint $table) {
            $table->id();
            $table->string('coID');
            $table->boolean('precedencyRight');
            $table->string('tseCode');
            $table->string('tseCIsinCode');
            $table->string('coName');
            $table->string('recordNumber');
            $table->string('dateTime');
            $table->string('askOrderPrice');
            $table->string('askOrderVolume');
            $table->string('askOrderQty');
            $table->string('bidOrderPrice');
            $table->string('bidOrderVolume');
            $table->string('bidOrderQty');
            $table->string('coId1');
            $table->string('recordNumber1');
            $table->string('maxDateTime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_asks');
    }
};
