<?php

namespace App;

use App\Router\Router;

class App
{
    /**
     * @var string
     */
    private static string $version = '1.0.0';

    /**
     * @var string
     */
    private static string $develoment = 'DEVELOPMENT';

    /**
     * @var string
     */
    private static string $production = 'PRODUCTION';

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    private static function env(): string
    {
        $env = getenv('APP_ENV') ?: self::$develoment;

        return strtoupper($env);
    }

    /**
     * @return bool
     */
    public static function isProduction(): bool
    {
        return self::env() == self::$production;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        (new Router())->route();
    }

    /**
     * @return string
     */
    public static function version(): string
    {
        if (self::isProduction()) {
            return self::$version;
        }

        return uniqid('version:');
    }
}