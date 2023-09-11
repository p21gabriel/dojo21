<?php

namespace App\Http\Site\Error;

use App\Http\Site\AbstractControllerSite;
use Throwable;

class ErrorControllerSite extends AbstractControllerSite
{
    /**
     * @param Throwable $args
     * @return string
     */
    public function index(Throwable $args): string
    {
        $errorCode = $args->getCode();
        $errorMessage = $args->getMessage();

        return $this->view(
            'exception/exception.twig',
            compact('errorCode', 'errorMessage')
        );
    }
}