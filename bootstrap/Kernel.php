<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap;

use Quizzes\Bootstrap\Core\Configuration\ConfigRegistry;
use Quizzes\Bootstrap\Core\Configuration\RoutesRegistry;
use Quizzes\Bootstrap\Core\Container;
use Quizzes\Bootstrap\Core\Exceptions\MissingConfiguration;
use Quizzes\Bootstrap\Core\Http\Router;

/**
 * Class Kernel
 * @package Quizzes\Bootstrap
 */
final class Kernel
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Application $application
     */
    public function setApplication(Application $application): void
    {
        $this->application = $application;
        $this->container = $application->getContainer();
    }

    /**
     * @return void
     * @throws MissingConfiguration
     */
    public function start(): void
    {
        $this->loadConfiguration();
        $this->loadRouter();
    }

    /**
     * @throws MissingConfiguration
     */
    private function loadConfiguration(): void
    {
        $config = $this->getConfigFromFile(__DIR__ . '/../config/app.php');

        $this->container->push(
            ConfigRegistry::class,
            new ConfigRegistry($config)
        );
    }

    /**
     * @throws Core\Exceptions\UninstantiableObject
     * @throws MissingConfiguration
     * @throws \ReflectionException
     */
    private function loadRouter()
    {
        $routes = $this->getConfigFromFile(__DIR__ . '/../config/routes.php');

        $this->container->push(
            RoutesRegistry::class,
            new RoutesRegistry($routes)
        );

        $this->application->setRouter(
            $this->container->make(Router::class)
        );
    }

    /**
     * @param string $file
     * @return array
     * @throws MissingConfiguration
     */
    private function getConfigFromFile(string $file): array
    {
        if (!file_exists($file)) {
            throw new MissingConfiguration('Configuration not found in: ' . $file);
        }

        /** @noinspection UsingInclusionOnceReturnValueInspection */
        /** @noinspection PhpIncludeInspection */
        /**
         * Inspections disabled because configuration mustn't be loaded more than once
         * during the request lifecycle and there is already a check for the existence of file
         */
        return require_once $file;
    }
}
