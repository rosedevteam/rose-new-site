<?php


use Modules\Statistics\Http\Controllers\admin\StatisticsCartController;
use Modules\Statistics\Http\Controllers\admin\StatisticsOrderController;
use Modules\Statistics\Http\Controllers\admin\StatisticsRegisterController;
use Modules\Statistics\Http\Controllers\admin\StatisticsReserveController;
use Modules\Statistics\Http\Controllers\admin\StatisticsTelegramController;

Route::prefix('/statistics')->name('statistics.')->group(function () {
    Route::get('orders', [StatisticsOrderController::class, 'index'])->name('orders');
    Route::get('orders/all', [StatisticsOrderController::class, 'orders'])->name('orders.all');
    Route::get('registers', [StatisticsRegisterController::class, 'index'])->name('registers');
    Route::get('registers/all', [StatisticsRegisterController::class, 'registers'])->name('registers.all');
    Route::get('carts', [StatisticsCartController::class, 'index'])->name('carts');
    Route::get('carts/all', [StatisticsCartController::class, 'carts'])->name('carts.all');
    Route::get('reserves', [StatisticsReserveController::class, 'index'])->name('reserves');
    Route::get('reserves/all', [StatisticsReserveController::class, 'reserves'])->name('reserves.all');
    Route::get('telegrams', [StatisticsTelegramController::class, 'index'])->name('telegrams');
    Route::get('telegrams/all', [StatisticsTelegramController::class, 'telegrams'])->name('telegrams.all');
});
