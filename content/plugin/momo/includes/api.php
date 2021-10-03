<?php
error_reporting(0);
switch ($path[2]){
    case 'history_receive':
        $token  = $_REQUEST['access_token'];
        $day    = $_REQUEST['day'];
        $phone  = $path[3];
        if(!$token){
            echo encode_json(['response' => '503', 'message' => 'Thiếu mã Access Token để truy cập.']);
            break;
        }
        $get_user       = new user($database);
        $check_token    = $get_user->check_access_token($token);
        if(!$check_token){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ, vui lòng thử lại.']);
            break;
        }
        $account = new MomoAccount();
        if(!$account->checkPhoneNumber($phone)){
            echo encode_json(['response' => 208, 'message' => 'Số điện thoại không hợp lệ.']);
            break;
        }
        $user_info = $get_user->get_user(['user_token' => $token], 'user_id');
        if(!$account->checkPhoneByUserId($phone, $user_info['user_id'])){
            echo encode_json(['response' => 503, 'message' => 'Truy cập bị từ chối, bạn không thể xem tài khoản này.']);
            break;
        }

        // Check ngày
        if($day && !in_array($day, [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30])){
            echo encode_json(['response' => 503, 'message' => 'Chọn ngày từ 1 đến 30.']);
            break;
        }
        if(!$day){
            $day = 5;
        }
        $momo = new Momo($phone);
        $init = $momo->getBalance();
        if($init['response'] != 200){
            echo encode_json($init);
            break;
        }
        $history = $momo->getTransactionReceive($day);
        if($history['response'] != 200){
            echo encode_json($history);
            break;
        }
        $data = $history['data'];
        $account->syncHistory($data, $user_info['user_id']);
        echo encode_json(['response' => 200, 'message' => 'Đồng bộ dữ liệu thành công']);
        break;
    case 'history':
        $token  = $_REQUEST['access_token'];
        $limit  = ($_REQUEST['limit'] ? $_REQUEST['limit'] : 50);
        $phone  = $path[3];
        if(!$token){
            echo encode_json(['response' => '503', 'message' => 'Thiếu mã Access Token để truy cập.']);
            break;
        }
        $get_user       = new user($database);
        $check_token    = $get_user->check_access_token($token);
        if(!$check_token){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ, vui lòng thử lại.']);
            break;
        }
        $account = new MomoAccount();
        if(!$account->checkPhoneNumber($phone)){
            echo encode_json(['response' => 208, 'message' => 'Số điện thoại không hợp lệ.']);
            break;
        }
        $user_info = $get_user->get_user(['user_token' => $token], 'user_id');
        if(!$account->checkPhoneByUserId($phone, $user_info['user_id'])){
            echo encode_json(['response' => 503, 'message' => 'Truy cập bị từ chối, bạn không thể xem tài khoản này.']);
            break;
        }
        $history = $account->getHistoryByPhone($phone);
        echo encode_json([
            'response'  => 200,
            'message'   => 'Success',
            'phone'     => $phone,
            'limit'     => $limit,
            'count'     => count($history),
            'data'      => $history
        ]);
        break;
    case 'cronjob':
        $token  = $_REQUEST['access_token'];
        $day    = $_REQUEST['day'];
        $phone  = $path[3];
        if(!$token){
            echo encode_json(['response' => '503', 'message' => 'Thiếu mã Access Token để truy cập.']);
            break;
        }
        $get_user       = new user($database);
        $check_token    = $get_user->check_access_token($token);
        if(!$check_token){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ, vui lòng thử lại.']);
            break;
        }
        $account = new MomoAccount();
        if(!$account->checkPhoneNumber($phone)){
            echo encode_json(['response' => 208, 'message' => 'Số điện thoại không hợp lệ.']);
            break;
        }
        $user_info = $get_user->get_user(['user_token' => $token], 'user_id');
        if(!$account->checkPhoneByUserId($phone, $user_info['user_id'])){
            echo encode_json(['response' => 503, 'message' => 'Truy cập bị từ chối, bạn không thể xem tài khoản này.']);
            break;
        }

        // Check ngày
        if($day && !in_array($day, [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30])){
            echo encode_json(['response' => 503, 'message' => 'Chọn ngày từ 1 đến 30.']);
            break;
        }
        if(!$day){
            $day = 5;
        }
        $momo = new Momo($phone);
        $init = $momo->getBalance();
        if($init['response'] != 200){
            echo encode_json($init);
            break;
        }
        $momo = new Momo($phone);
        $history = $momo->getTransactionHistory($day);
        if($history['response'] != 200){
            echo encode_json($history);
            break;
        }
        $data = $history['data'];
        $account->syncHistory($data, $user_info['user_id']);
        echo encode_json(['response' => 200, 'message' => 'Đồng bộ dữ liệu thành công']);
        break;
    case 'info':
        $token  = $_REQUEST['access_token'];
        $phone  = $path[3];
        if(!$token){
            echo encode_json(['response' => '503', 'message' => 'Thiếu mã Access Token để truy cập.']);
            break;
        }
        $get_user       = new user($database);
        $check_token    = $get_user->check_access_token($token);
        if(!$check_token){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ, vui lòng thử lại.']);
            break;
        }
        $account = new MomoAccount();
        if(!$account->checkPhoneNumber($phone)){
            echo encode_json(['response' => 208, 'message' => 'Số điện thoại không hợp lệ.']);
            break;
        }
        $user_info = $get_user->get_user(['user_token' => $token], 'user_id');
        if(!$account->checkPhoneByUserId($phone, $user_info['user_id'])){
            echo encode_json(['response' => 503, 'message' => 'Truy cập bị từ chối, bạn không thể xem tài khoản này.']);
            break;
        }
        $info = $account->getAccount($phone);
        echo encode_json([
            'response'  => 200,
            'message'   => 'Success',
            'data'      => [
                'phone'         => $phone,
                'balance'       => $info['account_balance'],
                'status'        => $info['account_status'],
                'last_update'   => $info['account_last_update']
            ]
        ]);
        break;
    default:

        break;
}