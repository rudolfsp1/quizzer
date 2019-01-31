<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Bootstrap\Core\Http;

/**
 * Class Request
 * @package Quizzes\Bootstrap\Core\Http
 */
class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $method;

    /**
     * Request constructor.
     * @param array $data
     * @param $method
     */
    public function __construct(array $data, string $method)
    {
        $this->data = $data;
        $this->method = $method;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->data['path'] ?? null;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
