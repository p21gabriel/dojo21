<?php

namespace App\Http\Api;

use App\Http\AbstractController;

abstract class AbstractControllerApi extends AbstractController
{
    /**
     * @param $json
     * @param int $code
     * @return void
     */
    protected function responseJson($json, int $code = 200): void
    {
        http_response_code($code);

        echo json_encode($json);exit();
    }
}