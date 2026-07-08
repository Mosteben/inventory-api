<?php

namespace App\Router;

use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => []
        ];
    }

    /**
     * Register GET Route
     */
    public function get(
        string $path,
        array $action,
        array $middleware = []
    ): void {
        $this->addRoute(
            'GET',
            $path,
            $action,
            $middleware
        );
    }

    /**
     * Register POST Route
     */
    public function post(
        string $path,
        array $action,
        array $middleware = []
    ): void {
        $this->addRoute(
            'POST',
            $path,
            $action,
            $middleware
        );
    }

    /**
     * Register PUT Route
     */
    public function put(
        string $path,
        array $action,
        array $middleware = []
    ): void {
        $this->addRoute(
            'PUT',
            $path,
            $action,
            $middleware
        );
    }

    /**
     * Register DELETE Route
     */
    public function delete(
        string $path,
        array $action,
        array $middleware = []
    ): void {
        $this->addRoute(
            'DELETE',
            $path,
            $action,
            $middleware
        );
    }

    /**
     * Add Route
     */
    private function addRoute(
        string $method,
        string $path,
        array $action,
        array $middleware
    ): void {

        $this->routes[$method][$path] = [

            'action' => $action,

            'middleware' => $middleware

        ];
    }

    /**
     * Resolve Request
     */
    public function resolve(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $path = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        /*
        |--------------------------------------------------------------------------
        | Remove project folder from URI
        |--------------------------------------------------------------------------
        */

        $basePath = '/inventory-api/public';

        if (str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        if ($path === '') {
            $path = '/';
        }

        foreach ($this->routes[$method] as $route => $data) {

            $routeSegments = explode(
                '/',
                trim($route, '/')
            );

            $pathSegments = explode(
                '/',
                trim($path, '/')
            );

            if (
                count($routeSegments)
                !==
                count($pathSegments)
            ) {
                continue;
            }

            $params = [];

            $matched = true;

            foreach (
                $routeSegments as $index => $segment
            ) {

                $current =
                    $pathSegments[$index];

                if (
                    str_starts_with($segment, '{')
                    &&
                    str_ends_with($segment, '}')
                ) {

                    $paramName = trim(
                        $segment,
                        '{}'
                    );

                    $params[$paramName] =
                        $current;

                    continue;
                }

                if ($segment !== $current) {

                    $matched = false;

                    break;
                }
            }

            if (!$matched) {
                continue;
            }

            /*
             * Run Middlewares
             */
            $this->runMiddlewares(
                $data['middleware']
            );

            /*
             * Run Controller
             */
            call_user_func_array(

                $data['action'],

                array_values($params)

            );

            return;
        }

        http_response_code(404);

        echo json_encode([

            'success' => false,

            'message' => 'Route Not Found'

        ]);
    }

    /**
     * Execute Middlewares
     */
    private function runMiddlewares(
        array $middlewares
    ): void {

        foreach ($middlewares as $middleware) {

            if ($middleware === 'auth') {

                AuthMiddleware::handle();

                continue;
            }

            if (
                str_starts_with(
                    $middleware,
                    'role:'
                )
            ) {

                $roles = explode(

                    ',',

                    substr(
                        $middleware,
                        5
                    )

                );

                RoleMiddleware::handle(
                    $roles
                );
            }
        }
    }
}