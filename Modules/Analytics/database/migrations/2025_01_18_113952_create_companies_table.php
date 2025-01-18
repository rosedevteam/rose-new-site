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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('coID');
            $table->string('coCode');
            $table->string('coTitle');
            $table->string('coTitleEnglish')->nullable();
            $table->string('coSymbol')->nullable();
            $table->string('coSymbolEnglish')->nullable();
            $table->string('floorID')->nullable();
            $table->string('floorTitle')->nullable();
            $table->string('industryID')->nullable();
            $table->string('industryTitle')->nullable();
            $table->string('tseCode')->nullable();
            $table->string('tseCIsinCode')->nullable();
            $table->string('tseSIsinCode')->nullable();
            $table->string('marketID')->nullable();
            $table->string('marketTitle')->nullable();
            $table->string('precedencyRight')->nullable();
            $table->string('acceptionDate')->nullable();
            $table->string('acceptionDateGre')->nullable();
            $table->string('enlistedDate')->nullable();
            $table->string('enlistedDateGre')->nullable();
            $table->string('ipoDate')->nullable();
            $table->string('ipoDateGre')->nullable();
            $table->string('fundTypeID')->nullable();
            $table->string('fundTypeTitle')->nullable();
            $table->string('coSymbolPinglish')->nullable();
            $table->string('nationalID')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
