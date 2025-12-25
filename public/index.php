<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/*
 |-------------------------------------------------------
 | Auto Loader
 |-------------------------------------------------------
 */
spl_autoload_register(function ($class) {
    $paths = [
        "../app/core/",
        "../app/controllers/",
        "../app/models/"
    ];

    foreach ($paths as $path) {
        $file = $path . $class . ".php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

/*
 |-------------------------------------------------------
 | Config
 |-------------------------------------------------------
 */
require_once "../config/config.php";

/*
 |-------------------------------------------------------
 | Dispatch Router
 |-------------------------------------------------------
 */
Router::dispatch();
