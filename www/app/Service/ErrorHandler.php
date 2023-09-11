<?php

namespace App\Service;

use App\Http\Api\Error\ErrorControllerApi;
use App\Http\Site\Error\ErrorControllerSite;
use Throwable;

class ErrorHandler
{
    /**
     * @return void
     */
    public static function handle(): void
    {
        set_exception_handler(function (Throwable $exception) {

            $isApi = (str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

            if (!$isApi) {
                (new ErrorControllerSite())->index($exception);
            } else {
                (new ErrorControllerApi())->index($exception);
            }
        });
    }
}