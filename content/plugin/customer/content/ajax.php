<?php
switch ($path[2]){
    case 'add':
        // Kiểm tra đăng nhập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }
        // Kiểm tra quyền truy cập
        if(!$role['customer']['add']){
            echo encode_json(get_response_array(403));
            break;
        }


        break;
}