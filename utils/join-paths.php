<?php

    function join_paths(...$paths)
    {
        $result_path = "";
        foreach($paths as $path)
        {
            $result_path = $result_path . $path;
        }
        $result_path = preg_replace("/\/\//i", "", $result_path);  
        return $result_path;
    }
?>