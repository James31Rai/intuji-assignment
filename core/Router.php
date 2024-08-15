<?php 

namespace Core;

class Router {
    protected $routes = [];

    /**
     * Add a new route
     * 
     * @param mixed $route
     * @param mixed $controller
     * @param mixed $action
     * @return void
     */
    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * Dispatch the route to the controller
     * 
     * @param mixed $uri
     * @throws \Exception
     * @return void
     */
    public function dispatch($uri) {
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        // escape for query string to pass to controller
        $uri = explode('?', $uri)[0];
        if (array_key_exists($uri, $this->routes)) {
            $controller = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            include_once('app/Views/404.php');
        }
    }
}