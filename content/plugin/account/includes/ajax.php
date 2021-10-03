<?php
switch ($path[2]){
    case 'delete':
        // Kiểm tra đăng nhập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }
        if(!$role['account']['manager']){
            exit('Forbidden');
        }
        $account    = new pAccount();
        $action     = $account->delete($path['3']);
        echo encode_json($action);
        break;
    case 'delete_image':
        // Kiểm tra đăng nhập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }
        if(!$role['account']['manager']){
            exit('Forbidden');
        }
        $media = new Media($database);
        $media = $media->delete_file('account', $path[3]);
        echo encode_json($media);
        break;
}