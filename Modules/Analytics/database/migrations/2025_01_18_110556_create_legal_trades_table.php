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
        Schema::create('legal_trades', function (Blueprint $table) {
            $table->id();
            $table->string('com_ID');
            $table->string('tseCode');
            $table->string('tseCIsinCode');
            $table->string('bourseSymbol');
            $table->string('companyTitle');
            $table->string('date');
            $table->boolean('isBuy');
            $table->boolean('isLegal');
            $table->string('amount');
            $table->string('amountType');
            $table->string('amountTypeTitle');
            $table->string('closingPrice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_trades');
    }
};
