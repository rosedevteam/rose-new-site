<?php

use Modules\Podcast\Http\Controllers\admin\PodcastController;


Route::resource('podcasts', PodcastController::class);
