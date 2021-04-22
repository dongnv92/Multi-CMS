<?php
switch ($path[2]){
    case 'report':
        switch ($path[3]){
            case 'add':
                if(!$me) {
                    echo encode_json(get_response_array(400));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['business']['report']){
                    echo encode_json(get_response_array(401));
                    break;
                }
                $business   = new pBusiness();
                $add        = $business->add();
                echo encode_json($add);
                break;
        }
    break;
}