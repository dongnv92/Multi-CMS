<?php
require_once '../init.php';
switch ($path[1]){
    case 'user':
        switch ($path[2]){
            case 'role':
                switch ($path[3]){
                    case 'update':
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }
                        $role   = new meta($database, 'role');
                        $update = $role->update($path[4]);
                        echo encode_json($update);
                        break;
                    case 'add':
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }
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