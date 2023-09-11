<?php

use App\App;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('assets')) {
    /**
     * @param $assetPathName
     * @return string
     */
    function assets($assetPathName): string
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/assets/' . $assetPathName;
    }
}

if (!function_exists('dd')) {
    /**
     * @param $content
     * @return void
     */
    #[NoReturn] function dd($content): void
    {
        if (is_array($content)) {
            print_r($content);exit();
        }

        var_dump($content);exit();
    }
}

if (!function_exists('redirect')) {
    /**
     * @param $route
     * @return void
     */
    #[NoReturn] function redirect($route): void
    {
        header("Location: {$route}");
        exit();
    }
}

if (!function_exists('version')) {
    /**
     * @return string
     */
    function version(): string
    {
        return App::version();
    }
}