<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

/**
 * Require composer auto-loading
 */
require_once '../vendor/autoload.php';

/**
 * Creates the DI container
 */
$container = new \Quizzes\Bootstrap\Core\Container();

/**
 * Creates application
 * @noinspection PhpUnhandledExceptionInspection
 * @var \Quizzes\Bootstrap\Application $application
 */
$application = $container->make(\Quizzes\Bootstrap\Application::class);

/**
 * Boots the application
 * @noinspection PhpUnhandledExceptionInspection
 */
$application->boot();

/**
 * Fetches HTTP Router from booted application
 * @var \Quizzes\Bootstrap\Core\Http\Router $router
 */
$router = $application->getRouter();

/**
 * Dispatches the request to according controller and
 * returns a response to client
 */
$router->dispatch();
