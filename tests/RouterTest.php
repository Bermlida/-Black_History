<?php

use Phly\Http\ServerRequest;
use Vista\TinyRouter\Router;
use Vista\TinyRouter\Tests\TestHandler;

/**
 * @coversDefaultClass \Vista\TinyRouter\Tests
 */
class RouterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @codeCoverageIgnore
     */
    public function requestProvider()
    {
        return array_map([$this, 'getRequest'], [
            [
                'uri' => '/test_handler/process',
                'method' => 'put'
            ],
            [
                'uri' => '/user/account/settings/subscription/true',
                'method' => 'post'
            ],
            [
                'uri' => '/user/profiles/picture/111/222',
                'method' => 'get'
            ],
            [
                'uri' => '/user/profiles/brief/3/this is brief sample',
                'method' => 'header'
            ]
        ]);
    }

    public function testRoute()
    {
        return new Router();
    }

    /**
     * @depends testRoute
     */
    public function testSetNamespace(Router $router)
    {
        $namespace = '\\Vista\\TinyRouter\\Tests\\';

        $router->setNamespace($namespace);
    }

    /**
     * @depends testRoute
     */
    public function testSetRule(Router $router)
    {
        $router->post(
            'user/account/settings/{setting_item}/{setting_value}',
            function ($setting_item, $setting_value) {
                if ($setting_item == 'subscription' && $setting_value == 'true') {
                    return 'correct';
                } else {
                    return 'error in Closure';
                }
            }
        );

        $router->get('/user/profiles/picture/{sort}/{top}', [TestHandler::class, 'processWithParams']);

        $router->header('/user/profiles/brief/{paragraph}/{default}', [new TestHandler(), 'processWithModel']);
    }

    /**
     * @dataProvider requestProvider
     * @depends  testRoute
     */
    public function testDispatch($request, Router $router)
    {
        $this->assertEquals($router->dispatch($request), 'correct');
    }

    /**
     * @codeCoverageIgnore
     */
    private function getRequest(array $params)
    {
        $request_params = [
            'REQUEST_URI' => $params['uri'],
            'REQUEST_METHOD' => $params['method']
        ];

        $request = (new ServerRequest($request_params))
                                ->withQueryParams(($params['query'] ?? []))
                                ->withParsedBody(($params['parsed_body'] ?? []))
                                ->withUploadedFiles(($params['uploaded_files'] ?? []));

        return [$request];
    }
}