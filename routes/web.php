<?php

if (config('dbrouter.setup_catchall_route')) {
    Route::get('{url}', 'Oddvalue\DbRouter\Http\Controllers\DbRouterController')->where('url', '.*');
}
