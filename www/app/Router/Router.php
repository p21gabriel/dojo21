<?php

namespace App\Router;

use App\Utils\Session;

class Router
{
    /**
     * @var array
     */
    private array $routes;

    /**
     * @var array
     */
    private array $session_protected;

    /**
     *
     */
    public function __construct()
    {
        $this->routes = (require_once ROOT_DIR . '/config/routes.php');
        $this->session_protected = (require_once ROOT_DIR . '/config/session_protected_routes.php');
    }

    /**
     * @return void
     */
    public function route(): void
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        $parameters = $this->getParameters($url, $method);

        if (count($parameters)) {
            $url = $parameters['route'];
        }

        $this->tratarUsuarioDeslogado($url);
        $this->tratarUsuarioLogado($url);

        $this->routeNotFound($url, $method);

        list($controller, $method) = $this->routes[$method][$url];

        if (count($parameters)) {
            unset($parameters['route']);

            (new $controller())->{$method}(reset($parameters['parameters']));
        } else {
            (new $controller())->{$method}();
        }
    }

    /**
     * Isso aqui poderia ser um middleware
     *
     * @param string $url
     * @return void
     */
    public function tratarUsuarioDeslogado(string $url): void
    {
        if (!Session::isLoogedIn() && in_array($url, array_values($this->session_protected))) {
            redirect('/login');
        }

        if (!Session::isLoogedIn() && $url == '/') {
            redirect('/login');
        }
    }

    /**
     * Isso aqui poderia ser um middleware
     *
     * @param string $url
     * @return void
     */
    public function tratarUsuarioLogado(string $url): void
    {
        if (Session::isLoogedIn() && in_array($url, ['/', '/login'])) {
            redirect('/dashboard');
        }
    }

    /**
     * @param string $url
     * @param string $method
     * @return void
     */
    public function routeNotFound(string $url, string $method): void
    {
        $notFound = false;

        if (!in_array($url, array_keys($this->routes[$method]))) {
            $notFound = true;
        }

        if ($notFound && Session::isLoogedIn()) {
            redirect('/dashboard');
        }

        if ($notFound && !Session::isLoogedIn()) {
            redirect('/login');
        }
    }

    /**
     * @param string $url
     * @param string $method
     * @return array
     */
    private function getParameters(string $url, string $method): array
    {
        $parameters = [];

        preg_match_all("/\d+/", $url, $result);

        if (count($result[0]) < 1) {
            return $parameters;
        }

        $parameters[] = $result[0];

        $routeThatMatch = false;

        foreach (array_keys($this->routes[$method]) as $route) {
            $routeFound = explode('/', $route);
            $routeImprove = explode('/', $url);

            if (
                !$routeThatMatch &&
                str_contains($route, ":") &&
                count($routeFound) == count($routeImprove) &&
                $this->checkIfSimilar($routeFound, $routeImprove)
            ) {
                $routeThatMatch = $route;
            }
        }

        if ($routeThatMatch) {
            return ['route' => $routeThatMatch, 'parameters' => $parameters];
        }

        return [];
    }

    /**
     * @param array $routeFound
     * @param array $routeImprove
     * @return bool
     */
    private function checkIfSimilar(array $routeFound, array $routeImprove): bool
    {
        if (count($routeFound) == 4 && count($routeImprove) == 4) {
            //controller/id/method
            $pattern1 = $routeFound[1] == $routeImprove[1] && $routeFound[3] == $routeImprove[3];

            //controller/method/id
            $pattern2 = $routeFound[1] == $routeImprove[1] && $routeFound[2] == $routeImprove[2];

            return $pattern1 || $pattern2;
        }

        if (count($routeFound) == 5 && count($routeImprove) == 5) {
            //controller/id/method/action
            return $routeFound[1] == $routeImprove[1] && $routeFound[4] == $routeImprove[4];
        }

        if (count($routeFound) == 6 && count($routeImprove) == 6) {
            //controller/id/resource/id/action
            return
                $routeFound[1] == $routeImprove[1] &&
                $routeFound[3] == $routeImprove[3] &&
                $routeFound[5] == $routeImprove[5];
        }

        return false;
    }
}
