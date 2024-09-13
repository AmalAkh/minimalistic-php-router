<?php
include "abstractions/Router.php";
include "../utils/remove-path-once.php";

/**
 * Main class for application
 */
class App extends Router
{
    function __construct()
    {
      
        $this->rootPath = join_paths(remove_path_once($_SERVER["DOCUMENT_ROOT"], getcwd()));
        
    }
    public function run()
    {
        
        parent::run(remove_path_once($this->rootPath, $_SERVER["REQUEST_URI"]));
        http_response_code(404);
        
        
    }
}
?>