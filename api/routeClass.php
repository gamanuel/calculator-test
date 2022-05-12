<?php
class Route {
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;
    public function __construct($url, $verb, $controller, $method){
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = [];
    }
    public function match($url, $verb) {
        if($this->verb != $verb){
            return false;
        }
        $partsURL = explode("/", trim($url,'/'));
        $partsRoute = explode("/", trim($this->url,'/'));
        if(count($partsRoute) != count($partsURL)){
            return false;
        }
        foreach ($partsRoute as $key => $part) {
            if($part[0] != ":"){
                if($part != $partsURL[$key])
                return false;
            }
            else
            $this->params[$part] = $partsURL[$key];
        }
        return true;
    }
    public function run(){
        $controller = $this->controller;
        $method = $this->method;
        $params = $this->params;

        (new $controller())->$method($params);
    }
}
class Router{
    private $routeTable = [];

    public function route($url, $verb) {
        foreach ($this->routeTable as $route) {
            if($route->match($url, $verb)){
                // send parameters
                $route->run();
                return;
            }
            //default route
            else if($route->match("calculator", "GET")){
                $route->run();
                return;
            }
        }
    }

    public function addRoute ($url, $verb, $controller, $method) {
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }

}