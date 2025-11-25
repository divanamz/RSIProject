<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $c = $_GET['c'] ?? "auth"; // controller
    $m = $_GET['m'] ?? "login"; // method (bukan MODEL)

    $controllerFile = "controllers/" . ucfirst($c) . "Controller.php";
    $controllerClass = ucfirst($c) . "Controller";

    include_once "controllers/Controller.php";
    include_once $controllerFile;

    $controller = new $controllerClass();
    $controller->$m();