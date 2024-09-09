<?php
include "../utils/join-paths.php";
class Router
{
    protected $path = "";
    private $handlers = [];
    function __construct($path = "")
    {
        $this->path = join_paths(str_replace($_SERVER["DOCUMENT_ROOT"],"", getcwd()),$path);
    }
    /**
     * @param string $method HTTP method
     * @param string $path path for the request
     * @param mixed[] $handlers handlers for the reqest
     * Adds new route
     */
    function route($method, $path, ...$handlers)
    {   
       
        $path = join_paths($this->path, $path);
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
    function get($path, ...$handlers)
    {
        $this->route("GET", $path, ...$handlers);
    }
    function post($path, ...$handlers)
    {
        $this->route("POST", $path, ...$handlers);
    }
    function patch($path, ...$handlers)
    {
        $this->route("PATCH", $path, ...$handlers);
    }
    function put($path, ...$handlers)
    {
        $this->route("PUT", $path, ...$handlers);
    }
    function delete($path, ...$handlers)
    {
        $this->route("DELETE", $path, ...$handlers);
    }
    function head($path, ...$handlers)
    {
        $this->route("HEAD", $path, ...$handlers);
    }
    
    /**
     * Handle current route
     */
    function run()
    {
        var_dump($this->handlers);
        if(!isset($this->handlers[$_SERVER["REQUEST_URI"]]) || !isset($this->handlers[$_SERVER["REQUEST_URI"]][$_SERVER["REQUEST_METHOD"]]))
        {
            http_response_code(404);
            die("Path was not found");
            return;
        }
        foreach($this->handlers[$_SERVER["REQUEST_URI"]][$_SERVER["REQUEST_METHOD"]] as $handler)
        {
            $handler();
        }
    }   

}
?>