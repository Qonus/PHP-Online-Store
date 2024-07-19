<?php

ini_set("display_errors", 1);

require_once __DIR__ . "/../app/bootstrap.php";

function loadController($controllerName) {
    $filePath = __DIR__ . "/../app/controllers/{$controllerName}.php";
    if (file_exists($filePath)) {
        require_once $filePath;
    } else {
        throw new Exception("Controller not found");
    }
}

$route = new Route();

$route->add("/", function() {
    loadController("HomeController");
    $controller = new HomeController;
    $controller->index();
});

$route->add("product/{id}", function($id) {
    loadController("ProductController");
    $controller = new ProductController;
    $controller->product($id);
});

$uri = $_SERVER["REQUEST_URI"];
$route->dispatch($uri);