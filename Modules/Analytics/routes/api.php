<?php

use Modules\Analytics\Http\client\ApiClient;

Route::controller(ApiClient::class)->group(function () {
    Route::get('getCompanies', 'getCompanies');
    Route::get('getIndices', 'getIndices');
    Route::get('getBourseData', 'getBourseData');
    Route::get('getFarabourseData', 'getFarabourseData');
});
