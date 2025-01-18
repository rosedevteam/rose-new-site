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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->string('coID');
            $table->boolean('precedencyRight');
            $table->string('bourseSymbol');
            $table->string('fullTitle');
            $table->string('tseSymbolCode');
            $table->string('tradeDateGre');
            $table->string('tradeDate');
            $table->string('maxPrice');
            $table->string('minPrice');
            $table->string('openingPrice');
            $table->string('closingPrice');
            $table->string('tradeVolume');
            $table->string('tradeValue');
            $table->string('tradeQty');
            $table->string('previousClosingPrice');
            $table->string('lastPrice');
            $table->string('closingPriceChange');
            $table->string('closingPChgPercent');
            $table->string('shareCount');
            $table->string('marketValue');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
