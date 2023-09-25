<?php

namespace App\Http\Site;

use App\Http\AbstractController;
use App\View\Render;

abstract class AbstractControllerSite extends AbstractController
{
    /**
     * @var Render
     */
    private Render $view;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->view = new Render(ROOT_DIR . '/resources/views');
    }

    /**
     * @param $template
     * @param array $variables
     * @return string
     */
    protected function view($template, array $variables = []): string
    {
        return $this->view->render($template, $variables);
    }
}