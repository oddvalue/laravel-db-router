<?php

namespace Oddvalue\DbRouter\Test\Http\Controllers;

use Illuminate\Routing\Controller;
use Oddvalue\DbRouter\Test\Models\Example;

class ExampleController extends Controller
{
    public function show(Example $model)
    {
        return $model->name;
    }
}
