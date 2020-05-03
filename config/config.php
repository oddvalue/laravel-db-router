<?php

return [
    'route_class' => \Oddvalue\DbRouter\Route::class,

    'setup_catchall_route' => env('DBROUTER_CATCHALL', false),
];
