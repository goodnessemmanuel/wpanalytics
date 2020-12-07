<?php


namespace App;


class Router
{
    protected array $serverInfo;

    protected string $requestedUrl = "/";
    protected string $requestMethod = "get";
    public static array $routes = [];
    public static array $allowedHttpMethods = ["get", "post", "put", "patch", "delete"];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->serverInfo = $_SERVER;
    }

    /**
     * @return mixed
     */
    public function getRequestedUrl() :string
    {
        $this->requestedUrl = $this->serverInfo['PATH_INFO']?? "/";
        $this->requestedUrl = trim($this->requestedUrl, "/");
        if(!self::startsWith($this->requestedUrl, "/")){
            $this->requestedUrl = "/" . $this->requestedUrl;
        }
        return $this->requestedUrl;
    }

    public function executeUrl(){
        $url = $this->getRequestedUrl();
        $foundRoute = null;

       foreach (self::$routes as $route){
           if(!self::startsWith($route['path'], "/")){
               $route['path'] = "/" . $route['path'];
           }
           $this->requestMethod = strtolower($this->serverInfo["REQUEST_METHOD"]);
          if($route['path'] === $url && $route['method'] === $this->requestMethod) {
              $foundRoute = $route;
              break;
          }
       }

        if($foundRoute) {
            $arguments = explode('@', $foundRoute['callback']);
            $classController = 'App\\controllers\\' . $arguments[0];
            $targetMethod = $arguments[1];
           return call_user_func_array(array(new $classController, $targetMethod), array());
        }

        $classController = 'App\\controllers\\NotFoundController';
        return call_user_func_array(array(new $classController, 'index'), array());
    }

    public static function addRoute($path, $callback, $method = "get"){
        $routeExist = false;
        foreach (self::$routes as $route){
            if($route['path'] === $path && $method == $route['method']){
                $routeExist = true;
                break;
            }
        }
        if(!$routeExist){
            self::$routes[] = ["path" => $path, "callback" => $callback, "method" => $method];
        }
    }

    /**
     * @param $str
     * @param $char
     * @return bool
     */
    public static function startsWith($str, $char):bool{
        return substr($str, 0, 1) === $char;
    }

    /**
     * @param $name
     * @param $arguments
     * this php inbuilt magic function will track all static method
     * of this class that does exist check core/routes.php for sample.
     */
    public static function __callStatic($name, $arguments)
    {
        if(in_array($name, self::$allowedHttpMethods)) {
            self::addRoute($arguments[0], $arguments[1], $name);
            return;
        }
        throw new \BadMethodCallException("Method not found " . $name);
    }
}