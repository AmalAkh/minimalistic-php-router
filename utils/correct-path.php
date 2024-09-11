<?php

function correct_path($path)
{
    if(!preg_match("/\/\z/i", $path))
    {
        $path = "/".$path;
    }
    return $path;
}
?>