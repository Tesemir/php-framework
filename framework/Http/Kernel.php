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

//            $collector->get( '/', function () {
//
//                $content = '<h1>Gamer</h1>';
//                return new Response($content);
//            });
//
//            $collector->get( '/posts/{id}', function (array $vars) {
//                $content = "<h1>Post - {$vars['id']}</h1>";
//
//                return new Response($content);
//            });
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