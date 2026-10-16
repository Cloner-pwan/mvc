<?php

require_once "../core/Controller.php";
require_once "../core/Router.php";
require_once "../core/Config.php";
require_once "../core/DataBase.php";
require_once "../core/Api.php";

spl_autoload_register(function ($class) {

    $paths = [
        "../core/$class.php",
        "../app/controllers/$class.php",
        "../app/models/$class.php"
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

Router::route();