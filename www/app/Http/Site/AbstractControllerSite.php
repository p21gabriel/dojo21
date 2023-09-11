<?php

namespace App\Http\Site;

use App\Http\AbstractController;
use App\View\View;

abstract class AbstractControllerSite extends AbstractController
{
    /**
     * @var View
     */
    private View $view;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->view = new View(ROOT_DIR . '/resources/views');
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