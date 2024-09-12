<?php
function get_path_params($template, $path)
{
    $params = [];
    $pathsParts = explode("/", $path);
    $i = 0;
    foreach(explode("/", $template) as $chunk)
    {
        if(preg_match("/\{[a-z0-9]*\}/", $chunk))
        {
            $params[preg_replace("/[(\{)|(\})]{1}/", "", $chunk)] = $pathsParts[$i];
        }   
        $i++;
    }
    return $params;
}
?>