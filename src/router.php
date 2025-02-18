<?php
namespace App;

class router {
    private $router=[]; // C'est un tableau

    // Ajouter une route
    public function add($method, $path, $callback) {
        $this->router[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    // Traitons l'URI actuelle
    public function dispatch($method, $uri){
        foreach ($this->router as $route) {
            if($route['method'] == $method && $this->match($route['path'], $uri, $params)) {
                return call_user_func_array($route['callback'], $params);
            }
        }

        // Route non trouvée
        http_response_code(404);
        echo "404 Not Found";
    }

    // Verifier si l'URL correspond à la route
    private function match ($path, $uri, $params) {
        $pathRegex = preg_replace('/{(\w+)}/', '(?P<$1>[^/]+)', $path);
        $pathRegex = '#^'.$pathRegex.'$#';

        if(preg_match($pathRegex, $uri, $matches)){
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }
        return false;
    }
}