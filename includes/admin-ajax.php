<?php
require_once '../init.php';

switch ($path[1]){
    case 'login':
        $login = new user($database);
        $login = $login->login();
        echo encode_json($login);
        break;
    default:
        print_r($path);
        break;
}