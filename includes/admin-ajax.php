<?php
require_once '../init.php';
switch ($path[1]){
    case 'plugin':
            switch ($path[2]){
                default:
                    // Kiểm tra đăng nhập
                    if(!$me) {
                        echo encode_json(get_response_array(400));
                        break;
                    }
                    // Kiểm tra quyền truy cập
                    if(!$role['plugin']['manager']){
                        echo encode_json(get_response_array(401));
                        break;
                    }

                    if(!in_array($_REQUEST['status'], ['active', 'not_active'])){
                        echo encode_json(get_response_array(402));
                        break;
                    }

                    if(!in_array($_REQUEST['plugin'], get_list_plugin())){
                        echo encode_json(get_response_array(403));
                        break;
                    }

                    $path_config    = ABSPATH . PATH_PLUGIN . "{$_REQUEST['plugin']}/config.json";
                    $config         = file_get_contents($path_config);

                    if($_REQUEST['status'] == 'active'){
                        $config = json_decode($config, true);
                        $config['status'] = 'active';
                        $config = json_encode($config, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
                        //$config = str_replace('"status":"not_active"', '"status":"active"',  $config);
                    }else{
                        $config = json_decode($config, true);
                        $config['status'] = 'not_active';
                        $config = json_encode($config, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
                        //$config = str_replace('"status":"active"', '"status":"not_active"',  $config);
                    }

                    if(file_put_contents($path_config, $config)){
                        echo encode_json(['response' => 200, 'message' => 'Cập nhật thành công.']);
                    }else{
                        echo encode_json(['response' => 404, 'message' => 'Cập nhật không thành công.']);
                    }
                    break;
            }
        break;
    case 'blog':
        switch ($path[2]){
            case 'delete':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['user']['delete']){
                    echo encode_json(get_response_array(403));
                    break;
                }

                $post   = new Post($database, 'blog');
                $delete = $post->delete($path[3]);
                echo encode_json($delete);
                break;
            case 'create_url':
                $title = sanitize_title($_REQUEST['post_title']);
                echo $title;
                break;
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
        if(in_array($path[1], get_list_plugin())){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . $path[1] . '/config.json');
            $config = json_decode($config, true);
            if($config['status'] == 'active'){
                require_once ABSPATH . PATH_PLUGIN . $path[1] . "/{$config['source']['ajax']}";
            }
        }
        break;
}