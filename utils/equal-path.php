<?php
function equal_path($template, $path)
{
    $template = str_replace("/", "\/", $template);
   // $path = str_replace("/", "\/", $path);

    $regexTemplate = preg_replace("/\{.+\}/i", ".+", $template);
   

    if(preg_match("/{$regexTemplate}\z/i", $path))
    {
        return true;
    }
    return false;
}
?>