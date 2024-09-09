<?php
include "abstractions/Router.php";
/**
 * Main class for application
 */
class App extends Router
{
    function __construct()
    {
        $this->path = join_paths(str_replace($_SERVER["DOCUMENT_ROOT"],"", getcwd()));
      
    }
    public function run()
    {
        
        $requestedURI = str_replace($this->path, "",$_SERVER["REQUEST_URI"]);
        var_dump($this->handlers);
        if(!isset($this->handlers[$requestedURI]) || !isset($this->handlers[$requestedURI][$_SERVER["REQUEST_METHOD"]]))
        {
            http_response_code(404);
            die("Path was not found");
            return;
        }
        foreach($this->handlers[$requestedURI][$_SERVER["REQUEST_METHOD"]] as $handler)
        {
            $handler();
        }
    }
}
?>