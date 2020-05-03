<?php

namespace Oddvalue\DbRouter\Contracts;

interface RouteGenerator
{
    public function getRoutes(Routeable $instance);

    public function getRouteController() : string;

    public function getRouteAction() : string;
}
