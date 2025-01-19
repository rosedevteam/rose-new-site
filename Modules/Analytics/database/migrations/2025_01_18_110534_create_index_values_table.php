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
        Schema::create('index_values', function (Blueprint $table) {
            $table->id();
            $table->string('indexID');
            $table->string('indexTitle');
            $table->string('industryId')->nullable();
            $table->string('dateTimeGre');
            $table->string('dateTime');
            $table->string('openingValue');
            $table->string('lastValue');
            $table->string('maxValue');
            $table->string('minValue');
            $table->string('indexID1');
            $table->string('maxDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_values');
    }
};
