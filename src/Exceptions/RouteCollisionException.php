<?php

namespace Oddvalue\DbRouter\Exceptions;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class RouteCollisionException extends Exception
{
    public static function fromQueryException(QueryException $e)
    {
        $message = 'There is already a page with the url ' . url(Str::replaceArray('?', $e->getBindings(), '\?'));

        return new static($message);
    }
}
