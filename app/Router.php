<?php
namespace App;

class Router {
    private $routes = []; // Tableau contenant les routes

    // Ajouter une route
    public function add($method, $path, $callback) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    // Dispatch de l'URI actuelle
    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $this->match($route['path'], $uri, $params)) {
                return call_user_func_array($route['callback'], $params);
            }
        }

        // Route non trouvée
        http_response_code(404);
        echo "404 Not Found";
    }

    // Vérifier si l'URL correspond à la route et extraire les paramètres
    private function match($path, $uri, &$params) {
        $pathRegex = preg_replace('/{(\w+):([^}]+)}/', '(?P<$1>$2)', $path);
        $pathRegex = '#^' . $pathRegex . '$#';

        if (preg_match($pathRegex, $uri, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }
        return false;
    }
}
