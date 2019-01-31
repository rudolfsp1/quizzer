<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Support\Helpers;

/**
 * Alias function for OB start to make code more readable
 */
function start_capture(): bool
{
    return ob_start();
}

/**
 * @return string
 */
function get_captured(): string
{
    $captured = ob_get_contents();

    ob_end_clean();

    return $captured;
}

/**
 * @param string $layout
 * @param array $variables
 */
function extend_layout(string $layout, array $variables = [])
{
    $variables['body'] = get_captured();

    extract($variables, EXTR_SKIP);

    require $layout;
}
