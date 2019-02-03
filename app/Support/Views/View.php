<?php

/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 */
declare(strict_types=1);

namespace Quizzes\Support\Views;

use function Quizzes\Support\Helpers\get_captured;
use function Quizzes\Support\Helpers\start_capture;

/**
 * Class View
 * @package Quizzes\Support\Views
 */
class View
{
    protected const LAYOUTS_DIR = 'layouts';
    protected const PAGES_DIR = 'pages';
    protected const PATH_PATTERN = '%s/../../../resources/views/%s/%s.php';

    /**
     * @string Path to file containing view data
     */
    protected $template;

    /**
     * @var array Containing variables used in the view
     */
    protected $variables;

    /**
     * @var string Name of the layout used in view
     */
    protected $layout;

    /**
     * View constructor
     * @param string $template
     * @param array $variables
     * @param string $layout
     */
    public function __construct(string $template, array $variables = [], string $layout = 'main')
    {
        $this->template = $template;
        $this->variables = $variables;
        $this->layout = $layout;
    }

    /**
     * @return string The content of the view
     */
    public function render(): string
    {
        extract($this->variables);

        start_capture();

        /** @noinspection PhpIncludeInspection */
        require_once $this->getLayoutPath();

        $layout = get_captured();

        start_capture();

        /** @noinspection PhpIncludeInspection */
        require_once $this->getTemplatePath();

        return strtr($layout, [
            '@body' => get_captured()
        ]);
    }

    /**
     * @return string
     */
    protected function getLayoutPath(): string
    {
        return sprintf(self::PATH_PATTERN, __DIR__, static::LAYOUTS_DIR, $this->layout);
    }

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return sprintf(self::PATH_PATTERN, __DIR__, static::PAGES_DIR, $this->template);
    }
}