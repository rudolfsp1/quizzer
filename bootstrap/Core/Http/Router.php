<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap\Core\Http;

use Phalcon\Http\ResponseInterface;
use Quizzes\Bootstrap\Core\Configuration\RoutesRegistry;
use Quizzes\Bootstrap\Core\Container;
use Quizzes\Bootstrap\Core\Exceptions\HttpNotFound;

/**
 * Class Router
 * @package Quizzes\Bootstrap\Core\Http
 */
final class Router
{
    private const PATH_INDEX = '/';

    /**
     * @var RoutesRegistry
     */
    private $routes;

    /**
     * @var Container
     */
    private $container;

    /**
     * Router constructor.
     * @param RoutesRegistry $routes
     */
    public function __construct(RoutesRegistry $routes, Container $container)
    {
        $this->routes = $routes;
        $this->container = $container;
    }

    /**
     * @return RoutesRegistry
     */
    public function getRoutes(): RoutesRegistry
    {
        return $this->routes;
    }

    /**
     * @return void
     * @throws \Quizzes\Bootstrap\Core\Exceptions\UninstantiableObject
     * @throws \ReflectionException
     * @throws HttpNotFound
     */
    public function dispatch(): void
    {
        $request = $this->createRequest();
        $path = $request->getPath();

        /**
         * The router is too strict
         */
        if ($path === self::PATH_INDEX) {
            $path = null;
        }

        $routes = $this->routes->getByPathAndMethod($path, $request->getMethod());
        $route = reset($routes);

        if (!$route) {
            throw new HttpNotFound('Couldn\'t find requested resource', 404);
        }

        [$controller, $action] = explode('@', $route['action']);

        $this->container->push(Request::class, $request);

        $controller = $this->container->make(
            sprintf('Quizzes\\Http\\Controllers\\%s', $controller)
        );

        $response = $controller->$action();

        if ($response instanceof Response) {
            foreach ($response->getHeaders() as $header) {
                header($header['content'], true, $header['code'] ?? 200);
            }

            die($response->getBody());
        }

        die($response);
    }

    /**
     * @return Request
     */
    private function createRequest(): Request
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? null;
        $data = array_merge($_GET, $_POST, compact('path'));

        return new Request($data, $method);
    }
}
