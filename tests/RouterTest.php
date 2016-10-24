<?php

use Vista\TinyRouter\Router;

/**
 * @coversDefaultClass \Vista\TinyRouter\Tests
 */
class TinyRouter extends PHPUnit_Framework_TestCase
{
    private $router;

    public function setup()
    {
        $this->router = new Router();
    }, 

    public function testSetNamespace()
    {
        $namespace = '\\Vista\\TinyRouter\\Tests\\';

        $this->router->setNamespace($namespace);
    }

    public function testSetRule()
    {
        $this->router->get('')
    }
}