<?php

function correct_path($path)
{
    if(!preg_match("/\A\//i", $path))
    {
        $path = "/".$path;
    }
    return $path;
}
?>