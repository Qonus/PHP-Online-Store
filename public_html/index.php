<?php

ini_set("display_errors", 1);
session_start();

require_once __DIR__ . '/../app/bootstrap.php';

// Определение функции для подключения контроллеров
function loadController($controllerName)
{
    $filePath = __DIR__ . '/../app/Controllers/' . $controllerName . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    } else {
        throw new Exception("Controller file not found: " . $filePath);
    }
}

$route = new Route();

// Добавление маршрутов
$route->add('/', function () {
    loadController('HomeController');
    $controller = new HomeController();
    $controller->index();
});

// CATEGORY
$route->add('/categories', function () {
    loadController('CategoryController');
    $controller = new CategoryController();
    $controller->index();
});

$route->add('/category/{category_name}', function ($category_name) {
    loadController('CategoryController');
    $controller = new CategoryController();
    $controller->show($category_name);
});

// PRODUCTS
$route->add('/products', function () {
    loadController('ProductController');
    $controller = new ProductController();
    $controller->index();
});

$route->add('/product/{id}', function ($id) {
    loadController('ProductController');
    $controller = new ProductController();
    $controller->show($id);
});

// CART
$route->add('/cart', function () {
    loadController('CartController');
    $controller = new CartController();
    $controller->index();
});

$route->add('/cart/add/{id}', function ($id) {
    loadController('CartController');
    $controller = new CartController();
    $controller->add($id);
});

$route->add('/cart/remove/{id}', function ($id) {
    loadController('CartController');
    $controller = new CartController();
    $controller->remove($id);
});

$route->add('/cart/set/{id}/{quantity}', function ($id, $quantity) {
    loadController('CartController');
    $controller = new CartController();
    $controller->set($id, $quantity);
});

$route->add('/cart/clear', function () {
    loadController('CartController');
    $controller = new CartController();
    $controller->clear();
});

// USER
$route->add('/login', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->login();
});

$route->add('/register', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->register();
});

$route->add('/logout', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->logout();
});

// PROFILE
$route->add('/profile', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->index();
});

$route->add('/profile/settings', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->settings();
});

$route->add('/profile/privacy', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->privacy();
});

$route->add('/profile/address', function () {
    loadController('UserController');
    $controller = new UserController();
    $controller->address();
});

$route->add('/profile/address/remove/{address_id}', function ($address_id) {
    loadController('UserController');
    $controller = new UserController();
    $controller->removeAddress($address_id);
});

$route->add('/profile/address/edit/{address_id}', function ($address_id) {
    loadController('UserController');
    $controller = new UserController();
    $controller->editAddress($address_id);
});

// ORDERS
$route->add('/profile/orders', function () {
    loadController('OrderController');
    $controller = new OrderController();
    $controller->index();
});

$route->add('/profile/orders/{order}', function ($order) {
    loadController('OrderController');
    $controller = new OrderController();
    $controller->orderDetails($order);
});

$route->add('/checkout', function () {
    loadController('OrderController');
    $controller = new OrderController();
    $controller->checkout();
});

$route->add('/checkout/confirm', function () {
    loadController('OrderController');
    $controller = new OrderController();
    $controller->confirm();
});


// Получение URI
$uri = $_SERVER['REQUEST_URI'];
$route->dispatch($uri);