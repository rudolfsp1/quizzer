<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Http\Controllers;

use Quizzes\Bootstrap\Core\Http\Request;
use Quizzes\Http\Responses\GenericResponse;
use Quizzes\Http\Responses\JsonResponse;

/**
 * Class IndexController
 * @package Quizzes\Http\Controllers
 */
final class IndexController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * IndexController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        ob_start();

        require __DIR__ . '/../../../resources/views/pages/index.php';

        $view = ob_get_contents();

        ob_end_clean();

        return new GenericResponse($view);
    }

    /**
     * @return JsonResponse
     */
    public function tests(): JsonResponse
    {
        return new JsonResponse([
            'TODO:: RETURN A LIST OF TESTS HERE'
        ]);
    }
}
