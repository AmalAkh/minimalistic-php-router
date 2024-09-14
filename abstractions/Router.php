<?php
include "../utils/join-paths.php";
include "../utils/correct-path.php";
include "../utils/remove-path-once.php";
include "../utils/equal-path.php";
include "../utils/get-path-params.php";




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
       
        $path = correct_path($path);
        $method = strtoupper($method);
        if(!isset($this->handlers[$method]))
        {
            $this->handlers[$method] = [];
            
        }
        
        if(!isset($handlers[$method][$path]))
        {
            $this->handlers[$method][$path] = [];
        }
        
        foreach($handlers as $handler)
        {
            array_push($this->handlers[$method][$path], $handler);
        }
    }
    function addRouter($path, $router)
    {
        //remove / at the end of the router's path
        $path = preg_replace("/\/\z/i", "", $path);
       
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
     * @param string $prevPath - path part that was send from previous router 
     */
    protected function run($prevPath)
    { 
      
        $routerExecuted = false;
     
        foreach($this->routers as $path=>$routersList)
        {
            
            if(strpos($prevPath, $path) == 0)
            {
                $routerExecuted = true;
                foreach($routersList as $router)
                {
                    
                    //remove the path of target router and pass it 
                    $router->run(remove_path_once($path, $prevPath));
                }
            }
            
        }
        $handlerExecuted = false;
        if(isset($this->handlers[$_SERVER["REQUEST_METHOD"]]))
        {
            foreach($this->handlers[$_SERVER["REQUEST_METHOD"]] as $pathTemplate=>$handlers)
            {
           
                if(equal_path($pathTemplate, $prevPath))
                {
                 
                
                    $requestParams = get_path_params($pathTemplate, $prevPath);
                   
                    $requestData = ["request_params"=>$requestParams];
                    foreach($handlers as $handler)
                    {                      
                        $handler($requestData);
                    }
                    $handlerExecuted = true;
                }
            }
        }
        if($handlerExecuted)
        {
            http_response_code(200);
            die();
        }
        
        
        
        
    }   

}
?>