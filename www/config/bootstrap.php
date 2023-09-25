<?php

require_once "../vendor/autoload.php";

use App\App;
use App\Utils\ErrorHandler;
use App\Utils\Session;

define("ROOT_DIR", str_replace('/config', '', __DIR__));

Session::sessionStart();
(new ErrorHandler())->handle();

(new App())->run();
