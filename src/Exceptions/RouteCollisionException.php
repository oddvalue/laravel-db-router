<?php

namespace Oddvalue\DbRouter\Exceptions;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class RouteCollisionException extends Exception
{
    public static function fromQueryException(QueryException $e): self
    {
        /** @var array<int|string, string> $bindings */
        $bindings = array_map(
            function ($value): string {
                if (is_scalar($value) || $value === null) {
                    return (string) $value;
                }
                return '';
            },
            $e->getBindings()
        );
        $message = 'There is already a page with the url ' . url(Str::replaceArray('?', $bindings, '\?'));

        return new self($message);
    }
}
