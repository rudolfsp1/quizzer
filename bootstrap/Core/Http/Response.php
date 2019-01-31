<?php

namespace Quizzes\Bootstrap\Core\Http;

/**
 * Interface Response
 * @package Quizzes\Bootstrap\Core\Http
 */
interface Response
{
    /**
     * Returns the response body
     * @return string
     */
    public function getBody(): string;

    /**
     * Returns response headers
     * @return array
     */
    public function getHeaders(): array;
}

