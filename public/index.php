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
        __DIR__ . "/../app/core/",
        __DIR__ . "/../app/controllers/",
        __DIR__ . "/../app/models/",
        __DIR__ . "/../app/helpers/",
        __DIR__ . "/../app/listeners/",
        __DIR__ . "/../app/events/",
        __DIR__ . "/../app/endor/PHPMailer/"
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
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../app/helpers/BadgeHelper.php";

/*
 |-------------------------------------------------------
 | Register Events (AUTOLOADED)
 |-------------------------------------------------------
 */
EventRegistry::register();

/*
 |-------------------------------------------------------
 | Dispatch Router
 |-------------------------------------------------------
 */
Router::dispatch();
