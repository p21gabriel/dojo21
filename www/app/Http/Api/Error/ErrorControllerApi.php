<?php

namespace App\Http\Api\Error;

use App\Http\Api\AbstractControllerApi;
use Throwable;

class ErrorControllerApi extends AbstractControllerApi
{
    /**
     * @param Throwable $args
     * @return void
     */
    public function index(Throwable $args) : void
    {
        $errorMessage = "Contate o administrador e informe para eles os dados do erro: Código: %s | Menssagem: %s";

        $errorMessage = sprintf(
            $errorMessage,
            $args->getCode(),
            $args->getMessage()
        );

        $this->responseJson([
            'message' => $errorMessage,
        ], 500);
    }
}