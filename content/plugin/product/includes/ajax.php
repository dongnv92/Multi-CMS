<?php
switch ($path[2]){
    case 'category':
        // Kiểm tra quyền truy cập
        if(!$role['product']['manager']){
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

                $role   = new meta($database, 'product_category');
                $delete = $role->delete($path[4]);
                echo encode_json($delete);
                break;
            default:
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                $category   = new meta($database, 'product_category');
                $add        = $category->add();
                echo encode_json($add);
                break;
        }
        break;
}