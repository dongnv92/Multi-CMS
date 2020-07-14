<?php
require_once '../init.php';
switch ($path[1]){
    case 'upload':
        if(move_uploaded_file($_FILES['files']['tmp_name'], ABSPATH . '/content/uploads/' . $_FILES['files']['file_name'])){
            echo "OK {$_FILES['files']['file_name']}";
        }else{
            echo "False: {$_FILES['files']['file_name']}";
        }
        break;
    case 'blog':
        switch ($path[2]){
            case 'category':
                // Kiểm tra quyền truy cập
                if(!$role['blog']['manager']){
                    echo "Forbidden";
                    exit();
                }
                switch ($path[3]){
                    case 'update':
                        // Kiểm tra đăng nhập
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }

                        $cate   = new meta($database, 'blog_category');
                        $update = $cate->update($path[4]);
                        echo encode_json($update);
                        break;
                    case 'delete':
                        // Kiểm tra đăng nhập
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }

                        $role   = new meta($database, 'blog_category');
                        $delete = $role->delete($path[4]);
                        echo encode_json($delete);
                        break;
                    default:
                        // Kiểm tra đăng nhập
                        if(!$me) {
                            echo encode_json(get_response_array(403));
                            break;
                        }
                        $category   = new meta($database, 'blog_category');
                        $add        = $category->add();
                        echo encode_json($add);
                        break;
                }
                break;
        }
        break;
    case 'profile':
        switch ($path[2]){
            default:
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                $user   = new user($database);
                $update = $user->update_me();
                echo encode_json($update);
                break;
        }
        break;
    case 'user':
        switch ($path[2]){
            case 'update':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['user']['update']){
                    echo encode_json(get_response_array(403));
                    break;
                }
                $update = new user($database);
                $update = $update->update($path[3]);
                echo json_encode($update);
                break;
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
            case 'delete':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['user']['manager']){
                    echo encode_json(get_response_array(403));
                    break;
                }
                $user   = new user($database);
                $delete = $user->delete($path[3]);
                echo encode_json($delete);
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