<?php

namespace Vista\TinyRouter;

use ReflectionMethod;
use ReflectionFunction;
use RuntimeException;
use Psr\Http\Message\ServerRequestInterface;
use Vista\TinyRouter\RouteModelInterface;

class Router
{
    protected $root = '';
    protected $rules = [];
    protected $callbacks = [];

    public function setNamespace(string $namespace)
    {
        $this->root = trim($namespace, '\\');
    }

    public function dispatch(ServerRequestInterface $request)
    {
        $request_uri = $request->getServerParams()['REQUEST_URI'];
        $uri_path = trim(parse_url($request_uri)['path'], '/');

        if (($index = $this->compareUri($uri_path)) < 0) {
            $processor = $this->resolveUri($uri_path);
            $reflector = $this->reflectMethod($processor->class, $processor->method);

            // if ()
            // $params = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
        } else {
            $reflector = $this->reflectCallback($index);
            $params = $this->getParamsByUri($index, $uri_path);
        }

        $arguments = $this->bindArguments($reflector, $params);
        $reflector->invokeArgs($arguments);
    }

    protected function compareUri(string $uri)
    {
        foreach ($this->rules as $key => $rule) {
            $rule_regex = preg_replace('/\{\w+\}/', '(\w+)', $rule);
            $pattern = '/' + str_replace('/', '\/', $rule_regex) + '/';

            if (preg_match($pattern, $uri) === 1) {
                return $key;
            }
        }
        return -1;
    }

    protected function resolveUri(string $uri)
    {
        $segments = explode('/', $uri);
        $method = array_pop($segments);
        
        foreach ($segments as $key => $segment) {
            if (!(strpos($segment, '_') === false)) {
                $segment = implode(array_map(function ($segment) {
                    $segment = ucfirst(strtolower($segment));
                    return $segment;
                }, explode('_', $segment)));
            } else {
                $segment = ucfirst($segment);
            }
            $segments[$key] = $segment;
        }
        $class = $this->root . '\\' . implode('\\', $segments);

        return (object)(['class' => $class, 'method' => $method]);
    }

    protected function reflectMethod(string $class, string $method)
    {
        $object = new $class;
        $reflector_method = new ReflectionMethod($object, $method);
        $closure = $reflector_method->getClosure($object);
        return new ReflectionFunction($closure);
    }

    protected function reflectCallback(int $index, ServerRequestInterface $request)
    {
        $request_method = $request->getServerParams()['REQUEST_METHOD'];
        $request_method = strtolower($request_method);
        $callback = $callbacks[$request_method];

        if (is_callable($callback)) {
            return new ReflectionFunction($callback);
        } elseif (is_array($callback) && is_string($callback[0]) && is_string($callback[1])) {
            return $this->reflectMethod($callback[0], $callback[1]);
        }
        return null;
    }

    protected function getParamsByUri(string $index, string $uri)
    {
        $rule_segments = explode('/', $this->rules[$index]);
        $uri_segments = explode('/', $uri);

        foreach ($rule_segments as $index => $segment) {
            if (preg_match('/\{(\w+)\}/', $segment, $matches) === 1) {
                $key = $matches[1];
                $value = $uri_segments[$index];
                $params[$key] = $value;
            }
        }

        return $params ?? [];
    }

    protected function bindArguments(ReflectionFunction $reflector, array $params)
    {
        $parameters = $reflector->getParameters();
        
        if (!empty($parameters)) {
            $reflector = $parameters[0]->getClass();
            
            if (count($parameter) == 1 && !is_null($reflector)) {
                if ($reflector->implementsInterface(RouteModelInterface::class)) {
                    $constructor = $reflector->getConstructor();                
                    if (!is_null($constructor)) {
                        foreach ($constructor->getParameters() as $key => $parameter) {
                            if (isset($params[$parameter->name])) {
                                $value = $params[$parameter->name];
                                $arguments[$key] = $value;
                            }
                        }
                        $arguments = [$reflector->newInstanceArgs(($arguments ?? []))];
                    }
                } else {
                    if (isset($params[$parameters[0]->name])) {
                        $arguments[] = $params[$parameters[0]->name];
                    }
                }
            } else {
                foreach ($parameters as $key => $parameter) {
                    if (isset($params[$parameter->name])) {
                        $value = $params[$parameter->name];
                        $arguments[$key] = $value;
                    }
                }
            }
        }

        return $arguments ?? [];
    }

    public function __call($method, $arguments)
    {
        $valid_verb = ["post", "get", "put", "delete", "header", "patch", "options"];
        
        if (in_array($method, $valid_verb)) {
            $method = strtoupper($method);
            $keys = array_keys($this->rules, $arguments[0]);

            if (count($keys) > 0) {
                $key = current($keys);
                $this->callbacks[$key][$method] = $arguments[1];
            } else {
                $callbacks[$method] = $arguments[1];
                $this->rules[] = $arguments[0];
                $this->callbacks[] = $callbacks;
            }
        } else {
            throw new RuntimeException('');
        }
    }
}
