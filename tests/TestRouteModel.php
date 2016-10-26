<?php

namespace Vista\TinyRouter\Tests;

use Vista\TinyRouter\RouteModelInterface;

class TestRouteModel implements RouteModelInterface
{
    public $paragraph;

    public $default;

    public function __construct($paragraph, $default)
    {
        $this->paragraph = $paragraph;

        $this->default = $default;
    }
}