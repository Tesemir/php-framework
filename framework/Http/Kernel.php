<?php

namespace Somecode\Framework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {

        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route)
            {
                $collector->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        $response = call_user_func_array([new $controller(), $method], $vars);
        return $response;
    }
}