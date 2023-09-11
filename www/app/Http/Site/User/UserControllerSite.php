<?php

namespace App\Http\Site\User;

use App\Http\Site\AbstractControllerSite;

class UserControllerSite extends AbstractControllerSite
{
    /**
     * @return string
     */
    public function index(): string
    {
        return $this->view('signup/index.twig');
    }
}