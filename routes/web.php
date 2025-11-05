<?php

use Illuminate\Support\Facades\Route;

if (config('dbrouter.setup_catchall_route')) {
    Route::get('{url}', \Oddvalue\DbRouter\Http\Controllers\DbRouterController::class)->where('url', '.*');
}
