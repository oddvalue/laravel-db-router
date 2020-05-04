<?php

namespace Oddvalue\DbRouter\Contracts;

use Illuminate\Support\Collection;
use Oddvalue\DbRouter\Contracts\Routable;

interface ChildRouteGenerator
{
    public function getRouteChildren(Routable $instance) : Collection;
}
