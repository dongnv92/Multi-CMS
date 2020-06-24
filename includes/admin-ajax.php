<?php
require_once '../init.php';
if(!$me){
    redirect(URL_LOGIN);
    exit();
}

switch ($path[1]){
    case 'user':
        switch ($path[2]){
            case 'role':
                switch ($path[3]){
                    case 'add':
                        $role   = new meta($database, 'role');
                        $add    = $role->add();
                        echo encode_json($add);
                        break;
                }
                break;
        }
        break;
    case 'login':
        $login = new user($database);
        $login = $login->login();
        echo encode_json($login);
        break;
    default:
        print_r($path);
        break;
}