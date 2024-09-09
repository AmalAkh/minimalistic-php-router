<?php

    function join_paths(...$paths)
    {
        $result_path = "";
        foreach($paths as $path)
        {
            
            if(($result_path == "" || $result_path[strlen($result_path)-1] == '/') || $path[0] == '/')
            {
                $result_path .= $path;
            }else
            {
                $result_path .= "/".$path;

            }
        }
        $result_path = preg_replace("/\/\//i", "/", $result_path);  
        return $result_path;
    }
?>