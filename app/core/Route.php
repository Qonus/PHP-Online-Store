<?php

class Route
{
    private $routes = [];

    public function add($pattern, $callback)
    {
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($matches) {
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $pattern);
        $pattern = '#^' . $pattern . '$#';
        $this->routes[$pattern] = $callback;
    }

    public function dispatch($uri)
    {
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $uri, $params)) {
                $params = array_filter($params, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($callback, $params);
            }
        }
        // 404 Not Found
        http_response_code(404);
        $not_found_page = new View();
        $not_found_page->render("layouts/not-found", ['title' => "Not found"]);
    }
}