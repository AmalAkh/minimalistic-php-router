<?php
include "abstractions/Router.php";
/**
 * Main class for application
 */
class App extends Router
{
    function __construct()
    {
        $this->rootPath = join_paths(str_replace($_SERVER["DOCUMENT_ROOT"],"", getcwd()));
      
    }
    public function run()
    {
        
        parent::run(str_replace($this->rootPath, "", $_SERVER["REQUEST_URI"]));
    }
}
?>