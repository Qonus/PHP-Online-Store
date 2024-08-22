<?php

ini_set("display_errors", 1);
session_start();

require_once __DIR__ . '/../app/bootstrap.php';

// Определение функции для подключения контроллеров
function loadController($controllerName) {
    $filePath = __DIR__ . '/../app/Controllers/' . $controllerName . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    } else {
        throw new Exception("Controller file not found: " . $filePath);
    }
}

$route = new Route();

// Добавление маршрутов
$route->add('/', function() {
    loadController('HomeController');
    $controller = new HomeController();
    $controller->index();
});

$route->add('/categories/', function() {
    loadController('CategoryController');
    $controller = new CategoryController();
    $controller->index();
});

$route->add('/category/{category_name}/', function($category_name) {
    loadController('CategoryController');
    $controller = new CategoryController();
    $controller->show($category_name);
});

$route->add('/orders/', function() {
    loadController('OrdersController');
    $controller = new OrdersController();
    $controller->index();
});

$route->add('/products/', function() {
    loadController('ProductController');
    $controller = new ProductController();
    $controller->index();
});

$route->add('/product/{id}/', function($id) {
    loadController('ProductController');
    $controller = new ProductController();
    $controller->show($id);
});

$route->add('/login/', function() {
    loadController('UserController');
    $controller = new UserController();
    $controller->login();
});

$route->add('/profile/', function() {
    loadController('UserController');
    $controller = new UserController();
    $controller->index();
});

$route->add('/register/', function() {
    loadController('UserController');
    $controller = new UserController();
    $controller->register();
});

$route->add('/logout/', function() {
    loadController('UserController');
    $controller = new UserController();
    $controller->logout();
});

// Получение URI
$uri = $_SERVER['REQUEST_URI'];
$route->dispatch($uri);