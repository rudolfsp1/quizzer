<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap\Core\Configuration;

/**
 * Class RoutesRegistry
 * @package Quizzes\Bootstrap\Core\Configuration
 */
class RoutesRegistry extends ConfigRegistry
{
    public function getByPathAndMethod(?string $path, string $method): array
    {
        return array_filter($this->items, function (array $route) use ($path, $method) {
            return $route['uri'] === $path && $route['method'] === $method;
        });
    }
}
