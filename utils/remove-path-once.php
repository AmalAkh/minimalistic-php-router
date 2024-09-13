<?php
function remove_path_once($pattern, $subject)
{
    $pos = strpos($subject, $pattern);
  
    $result = substr_replace($subject, "", $pos, $pos+strlen($pattern));
   
    return $result;

}
?>