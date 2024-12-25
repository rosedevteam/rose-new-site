<?php

Route::get('pagebuilder', [\Modules\PageBuilder\Http\Controllers\PageBuilderController::class, 'index'])->name('pagebuilder');
