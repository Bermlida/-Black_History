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
                'method' => 'put',
                'parsed_body' => ['profile_item' => 'brief', 'profile_value' => 'content']
            ],
            [
                'uri' => '/user/account/settings',
                'method' => 'post',
                'parsed_body' => ['setting_item' => 'subscription', 'setting_value' => true]
            ],
            [
                'uri' => '/user/profiles/picture',
                'method' => 'get',
                'query' => ['sort' => 111],
                'parsed_body' => ['top' => 222]
            ],
            [
                'uri' => '/user/profiles/brief',
                'method' => 'header',
                'query' => ['paragraph' => 3],
                'parsed_body' => ['default' => 'this is brief sample']
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
            'user/account/settings',
            function ($setting_item, $setting_value) {
                if ($setting_item == 'subscription' && $setting_value) {
                    return 'correct';
                } else {
                    return 'error in Closure';
                }
            }
        );

        $router->get('/user/profiles/picture', [TestHandler::class, 'processWithParams']);

        $router->header('/user/profiles/brief', [new TestHandler(), 'processWithModel']);
    }

    /**
     * @dataProvider requestProvider
     * @depends  testRoute
     */
    public function testDispatch($request, Router $router)
    {
        $this->assertEquals($router->dispatch($request), 'correct value');
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