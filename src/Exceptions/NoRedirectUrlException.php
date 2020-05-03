<?php

namespace Oddvalue\DbRouter\Exceptions;

use Exception;
use Oddvalue\DbRouter\Route;

class NoRedirectUrlException extends Exception
{
    public static function forRoute(Route $route)
    {
        return new static("Route #{$route->id} has no redirect URL.");
    }
}
