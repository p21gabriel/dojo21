<?php

namespace App\Http\Api\Login;

use App\Http\Api\AbstractControllerApi;
use App\Service\Auth;
use App\Service\Session;

class LoginControllerApi extends AbstractControllerApi
{
    /**
     * @return void
     */
    public function login(): void
    {
        Session::sessionDestroy();

        $body = $this->getParameters();

        $email = $body->email;
        $password = $body->password;

        if (!$email || !$password) {
            $this->responseJson([
                'result' => 'error',
                'message' => 'Usuário ou senha inválidos'
            ], 500);
        }

        $authService = new Auth();
        $autheticated = $authService->authenticate($email, $password);

        if (!$autheticated) {
            $this->responseJson([
                'result' => 'error',
                'message' => 'Usuário ou senha inválidos'
            ], 500);
        }

        $this->responseJson([]);
    }
}