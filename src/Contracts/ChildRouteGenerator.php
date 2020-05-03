<?php

namespace Oddvalue\DbRouter\Contracts;

use Illuminate\Support\Collection;
use Oddvalue\DbRouter\Contracts\Routeable;

interface ChildRouteGenerator
{
    public function getRouteChildren(Routeable $instance) : Collection;
}
