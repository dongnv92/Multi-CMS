<?php
require_once '../init.php';
switch ($path[1]){
    case 'user':
        switch ($path[2]){
            case 'add':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['user']['add']){
                    echo encode_json(get_response_array(403));
                    break;
                }
                $add = new user($database);
                $add = $add->add();
                echo encode_json($add);
                break;
            case 'role':
                switch ($path[3]){
                    case 'delete':
                        // Kiểm tra đăng nhập
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }
                        // Kiểm tra quyền truy cập
                        if(!$role['user']['role']){
                            echo encode_json(get_response_array(403));
                            break;
                        }
                        $role   = new meta($database, 'role');
                        $delete = $role->delete($path[4]);
                        echo encode_json($delete);
                        break;
                    case 'update':
                        // Kiểm tra đăng nhập
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }
                        // Kiểm tra quyền truy cập
                        if(!$role['user']['role']){
                            echo encode_json(get_response_array(403));
                            break;
                        }

                        $role   = new meta($database, 'role');
                        $update = $role->update($path[4]);
                        echo encode_json($update);
                        break;
                    case 'add':
                        // Kiểm tra đăng nhập
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }
                        // Kiểm tra quyền truy cập
                        if(!$role['user']['role']){
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