<?php

namespace App\Http\Site\Login;

use App\Http\Site\AbstractControllerSite;
use App\Utils\Session;

class Login extends AbstractControllerSite
{
    /**
     * @return string
     */
    public function index(): string
    {
        return $this->view('login/login.twig');
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        Session::sessionDestroy();

        redirect('/login');
    }
}