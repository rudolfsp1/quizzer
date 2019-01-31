<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap\Core\Configuration;

/**
 * Class ConfigRegistry
 * @package Quizzes\Bootstrap\Core\Configuration
 */
class ConfigRegistry
{
    /**
     * @var array
     */
    protected $items;

    /**
     * ConfigRepository constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }
}
