<?php
function equal_path($template, $path)
{
    $template = str_replace("/", "\/", $template);
    $regexTemplate = preg_replace("/\{[a-z0-9]+\}/", "[a-z0-9]+", $template);
   
    if(preg_match("/{$regexTemplate}\z/", $path))
    {
        return true;
    }
    return false;
}
?>