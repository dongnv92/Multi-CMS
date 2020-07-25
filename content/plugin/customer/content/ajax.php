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
        $customer   = new Customer($database, $_REQUEST['customer_type']);
        $add        = $customer->add();
        echo encode_json($add);
        break;
}