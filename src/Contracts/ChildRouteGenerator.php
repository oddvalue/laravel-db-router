<?php

namespace Oddvalue\DbRouter\Contracts;

use Illuminate\Support\Collection;
use Oddvalue\DbRouter\Contracts\Routable;

interface ChildRouteGenerator
{
    /**
     * @return Collection<int, Routable>
     */
    public function getRouteChildren(Routable $instance) : Collection;
}
