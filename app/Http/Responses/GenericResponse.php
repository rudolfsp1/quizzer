<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Http\Responses;

use Quizzes\Bootstrap\Core\Http\Response;
use Quizzes\Support\Views\View;

/**
 * Class GenericResponse
 * @package Quizzes\Http\Responses
 */
final class GenericResponse implements Response
{
    /**
     * @var string
     */
    private $view;

    /**
     * GenericResponse constructor.
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * Returns the response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->view->render();
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
