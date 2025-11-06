<?php

use Oddvalue\DbRouter\Route;

return [
    'route_class' => Route::class,

    'setup_catchall_route' => env('DBROUTER_CATCHALL', false),
];
