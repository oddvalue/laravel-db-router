<?php

use Oddvalue\DbRouter\Http\Controllers\DbRouterController;
use Illuminate\Support\Facades\Route;

if (config('dbrouter.setup_catchall_route')) {
    Route::get('{url}', DbRouterController::class)->where('url', '.*');
}
