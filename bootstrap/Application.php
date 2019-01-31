<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap;

use Quizzes\Bootstrap\Core\Configuration\ConfigRegistry;
use Quizzes\Bootstrap\Core\Container;
use Quizzes\Bootstrap\Core\Http\Router;

/**
 * Class Application
 * @package Quizzes\Bootstrap
 */
final class Application
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * Application constructor.
     * @param Kernel $kernel
     * @param Container $container
     */
    public function __construct(Kernel $kernel, Container $container)
    {
        $this->kernel = $kernel;
        $this->container = $container;
    }

    /**
     * @return void
     * @throws Core\Exceptions\MissingConfiguration
     */
    public function boot(): void
    {
        /**
         * Allow application to be injected itself
         */
        $this->container->push(self::class, $this);

        /**
         * Sets application to the kernel
         */
        $this->kernel->setApplication($this);

        /**
         * Starts the application kernel
         */
        $this->kernel->start();
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return ConfigRegistry
     * @throws Core\Exceptions\MissingDependency When application isn't booted
     */
    public function getConfiguration(): ConfigRegistry
    {
        return $this->container->get(ConfigRegistry::class);
    }

    /**
     * @param Router $router
     */
    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
}


