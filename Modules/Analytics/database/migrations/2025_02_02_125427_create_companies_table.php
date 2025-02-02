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
            // نام نماد
            $table->string('name')->unique();
            // نام کامل
            $table->string('full_name');
            // اولین قیمت
            $table->string('first_price');
            // اخرین قیمت
            $table->string('close_price');
            // مقدار تغییرات قیمت آخرین معامله
            $table->string('close_price_change');
            // درصد تغییرات قیمت اخرین معامله
            $table->string('close_price_change_percent');
            // قیمت پایانی
            $table->string('final_price');
            // مقدار تغیرات قیمت پایانی
            $table->string('final_price_change');
            // درصد تغییرات قیمت پایانی
            $table->string('final_price_change_percent');
            // قیمت دیروز
            $table->string('yesterday_price');
            // تعداد معاملات
            $table->string("trade_number");
            // حجم معاملات
            $table->string("trade_volume");
            // ارزش معاملات
            $table->string("trade_value");
            // ارزش بازار
            $table->string("market_value");
            // تعداد سهام
            $table->string("all_stocks");
            // حجم خرید حقیقی
            $table->string("real_buy_volume");
            // حجم خرید حقوقی
            $table->string("co_buy_volume");
            // حجم فروش حقیقی
            $table->string('real_sell_volume');
            // حجم فروش حقوقی
            $table->string("co_sell_volume");
            // تعداد خریدار حقیقی
            $table->string("real_buy_count");
            // تعداد خریدار حقوقی
            $table->string("co_buy_count");
            // تعداد فروشنده حقیقی
            $table->string("real_sell_count");
            // تعداد فروشنده حقوقی
            $table->string("co_sell_count");
            //
            $table->string("eps");
            $table->string("p_e");
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
