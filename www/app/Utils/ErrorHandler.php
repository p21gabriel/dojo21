<?php

namespace App\Utils;

use App\View\Render;
use Throwable;

class ErrorHandler
{
    /**
     * @return void
     */
    public static function handle(): void
    {
        set_exception_handler(function (Throwable $exception) {

            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();

            $isApi = (str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

            if (!$isApi) {
                return (new Render(ROOT_DIR . '/resources/views'))->render(
                    'exception/exception.twig',
                    compact('errorCode', 'errorMessage')
                );
            } else {
                http_response_code(500);

                echo json_encode([
                    'message' => $errorMessage,
                ]);

                exit();
            }
        });
    }
}