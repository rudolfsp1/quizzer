<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap\Core;

use Quizzes\Bootstrap\Core\Exceptions\MissingDependency;
use Quizzes\Bootstrap\Core\Exceptions\UninstantiableObject;
use ReflectionClass;
use ReflectionParameter;

/**
 * Class Container
 * @package Quizzes\Bootstrap\Core
 */
final class Container
{
    /**
     * @var array
     */
    private $dependencies = [];

    /**
     * Container constructor.
     */
    public function __construct()
    {
        /**
         * Makes container itself injectable in application constructor
         */
        $this->dependencies[self::class] = $this;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws MissingDependency
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            $this->missingDependencyError();
        }

        return $this->dependencies[$name];
    }

    /**
     * @param string $name
     * @param $dependency
     */
    public function push(string $name, $dependency): void
    {
        $this->dependencies[$name] = $dependency;
    }

    /**
     * @throws MissingDependency
     */
    private function missingDependencyError(): void
    {
        throw new MissingDependency('Dependency not found in application container');
    }

    /**
     * @throws UninstantiableObject
     */
    private function uninstantiableError(): void
    {
        throw new UninstantiableObject('Dependency not found in application container');
    }

    /**
     * @param string $class
     * @return mixed
     * @throws UninstantiableObject
     * @throws \ReflectionException
     */
    public function make(string $class)
    {
        if (!class_exists($class)) {
            $this->uninstantiableError();
        }

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class;
        }

        $getDependency = function (ReflectionParameter $dependency) {
            $class = $dependency->getClass();

            if (!$class) {
                return null;
            }

            $name = $class->getName();

            if ($this->has($name)) {
                return $this->get($name);
            }

            return $this->make($class->getName());
        };

        $dependencies = array_map($getDependency, $constructor->getParameters());

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->dependencies);
    }
}
