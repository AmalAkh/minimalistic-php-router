<?php
class Router
{
    protected $path;
    private $handlers = [];
    function __construct($path)
    {
        $this->path = $path;
    }
    /**
     * @param string $method HTTP method
     * @param string $path path for the request
     * @param mixed[] $handlers handlers for the reqest
     * 
     */
    function route($method, $path, ...$handlers)
    {   
        if(isset($handlers[$path]))
        {
            $handlers[$path] = [];
            
        }
        if(isset($handlers[$path][$method]))
        {
            $handlers[$path][$method] = [];
        }
        foreach($handlers as $handler)
        {
            array_push($handlers[$path][$method], $handler);
        }
    }

    function run()
    {

         
    }

}
?>