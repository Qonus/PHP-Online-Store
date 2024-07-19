<?php

class Route {
    private $routes = [];
    
    public function add($pattern, $callback) {
        $pattern = preg_replace("/\{(\w+)\}/", "(?P</1>[^/]+)", $pattern);
        $pattern = "#^" . $pattern . "$#";
        $this->routes[$pattern] = $callback;
    }

    public function dispatch($uri) {
        foreach ($this->routes as $pattern => $callback) {
            if(preg_match($pattern, $uri, $params)) {
                $params = array_filter($params, "is_string", ARRAY_FILTER_USE_KEY);
                return call_user_func_array($callback, $params);
            }
        }
        http_response_code(404);
        echo "Page not found!";
    }
}

?>