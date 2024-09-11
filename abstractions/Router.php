<?php
include "../utils/join-paths.php";
class Router
{
    protected $path = "";
    private $handlers = [];
    private $routers = [];
    function __construct()
    {
        //$this->path = join_paths(str_replace($_SERVER["DOCUMENT_ROOT"],"", getcwd()),$path);
    }

    /**
     * @param string $method HTTP method
     * @param string $path path for the request
     * @param mixed[] $handlers handlers for the reqest
     * Adds new route
     */
    function addRoute($method, $path, ...$handlers)
    {   
       
     
        $method = strtoupper($method);
        if(!isset($this->handlers[$path]))
        {
            $this->handlers[$path] = [];
            
        }
        
        if(!isset($handlers[$path][$method]))
        {
            $this->handlers[$path][$method] = [];
        }
        
        foreach($handlers as $handler)
        {
            array_push($this->handlers[$path][$method], $handler);
        }
    }
    function addRouter($path, $router)
    {
        if(!isset($this->routers[$path]))
        {
            $this->routers[$path] = [$router];
        }else
        {
            array_push($this->routers[$path], $router);
        }
    }
    function get($path, ...$handlers)
    {
        $this->addRoute("GET", $path, ...$handlers);
    }
    function post($path, ...$handlers)
    {
        $this->addRoute("POST", $path, ...$handlers);
    }
    function patch($path, ...$handlers)
    {
        $this->addRoute("PATCH", $path, ...$handlers);
    }
    function put($path, ...$handlers)
    {
        $this->addRoute("PUT", $path, ...$handlers);
    }
    function delete($path, ...$handlers)
    {
        $this->addRoute("DELETE", $path, ...$handlers);
    }
    function head($path, ...$handlers)
    {
        $this->addRoute("HEAD", $path, ...$handlers);
    }
    
    /**
     * Handle current route
     */
    function run($prevPath)
    { 
      
        $routerUsed = false;
        foreach($this->routers as $path=>$routersList)
        {
            
            if(strpos($prevPath, $path) == 0)
            {
                
                foreach($routersList as $router)
                {
                    $routerUsed = true;
                    $router->run(str_replace($path, "",$prevPath));
                }
            }
        }
       

        if(!$routerUsed && ( !isset($this->handlers[$prevPath]) || !isset($this->handlers[$prevPath][$_SERVER["REQUEST_METHOD"]])))
        {
            http_response_code(404);
            die("Path was not found");
            return;
        }
        foreach($this->handlers[$prevPath][$_SERVER["REQUEST_METHOD"]] as $handler)
        {
            $handler();
        }
    }   

}
?>