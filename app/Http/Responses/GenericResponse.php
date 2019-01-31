<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Http\Responses;

use Quizzes\Bootstrap\Core\Http\Response;

/**
 * Class GenericResponse
 * @package Quizzes\Http\Responses
 */
final class GenericResponse implements Response
{
    /**
     * @var string
     */
    private $body;

    /**
     * GenericResponse constructor.
     * @param string $body
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * Returns the response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Returns response headers
     * @return array
     */
    public function getHeaders(): array
    {
        /**
         * No custom headers required
         */
        return [];
    }
}
