<?php

require_once "../vendor/autoload.php";

use App\App;
use App\Service\Session;
use App\Service\ErrorHandler;

Session::sessionStart();
(new ErrorHandler)->handle();

(new App())->run();
