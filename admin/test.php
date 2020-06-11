<?php
require_once '../init.php';

print_r($path);
echo "<br />";
echo "<br />";

$root = ROOTPATH;
$path = explode('/', $path);

foreach ($path AS $key => $value){
    if($value == $root){
        unset($path[$key]);
        break;
    }else{
        unset($path[$key]);
    }
}
$path = implode('/', $path);
$path = explode('/', $path);
print_r($path);
