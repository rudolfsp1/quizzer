<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Http\Responses;

use Quizzes\Bootstrap\Core\Http\Response;

/**
 * Class JsonResponse
 * @package Quizzes\Http\Responses
 */
final class JsonResponse implements Response
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $code;

    /**
     * JsonResponse constructor.
     * @param array $data
     * @param int $code
     */
    public function __construct(array $data, int $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    /**
     * Returns the response body
     * @return string
     */
    public function getBody(): string
    {
        return json_encode($this->data);
    }

    /**
     * Returns response headers
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            [
                'content' => 'Content-Type: application/json',
                'code' => $this->code
            ]
        ];
    }
}
