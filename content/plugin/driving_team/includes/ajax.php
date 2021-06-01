<?php
switch ($path[2]){
    case 'oil':
        switch ($path[3]){
            case 'add':
                if(!$me) {
                    echo encode_json(get_response_array(400));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['oil_add']){
                    echo encode_json(get_response_array(401));
                    break;
                }
                break;
            case 'delete':
                if(!$me) {
                    echo encode_json(get_response_array(400));
                    break;
                }
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['oil_add']){
                    echo encode_json(get_response_array(401));
                    break;
                }
                $oil    = new pDriving();
                $delete = $oil->delete_oilcar($path[4]);
                echo encode_json($delete);
                break;
        }
    break;
}