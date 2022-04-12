<?php
error_reporting(0);
set_time_limit(0);
switch ($path[2]){
    // Bot Telegram
    case 'telegram_bot':
        $input              = json_decode(file_get_contents("php://input"), TRUE);
        $chatId             = $input["message"]["chat"]["id"];
        $message_chat       = $input["message"]["text"];
        $message            = explode('_', $message_chat);
        $message_key        = $message[0];
        $message_value      = str_replace("{$message_key}_", '', $message_chat);
        $telegram           = new Telegram('momonotice_bot');
        $account            = new MomoAccount();
        $telegram->set_chatid($chatId);
        switch ($message_key){
            case '/sodu':
                $phone = $message_value;
                // kiểm tra số điện thoại có hợp lệ không
                if(!$account->checkPhoneNumber($phone)){
                    $telegram->sendMessage("Số điện thoại <strong>$phone</strong> không hợp lệ.", ['parse_mode' => 'html']);
                    break;
                }

                // Kiểm tra xem số điện thoại và mã chat id có cùng 1 account momo không.
                if(!$account->checkChatIdAndPhone($phone, $chatId)){
                    $telegram->sendMessage("Bạn không có quyền truy cập tài khoản <strong>$phone</strong>.", ['parse_mode' => 'html']);
                    break;
                }
                $info       = $account->getAccount($phone);
                $message    = "Thông tin tài khoản <strong>$phone</strong>\n";
                $message   .= "Số dư: <strong>". convert_number_to_money($info['account_balance']) ."</strong>\n";
                $message   .= "Cập nhật lần cuối: <strong>{$info['account_last_update']}</strong> (<i>". (human_time_diff(strtotime($info['account_last_update']), time())) ."</i>)\n";
                $telegram->sendMessage($message, ['parse_mode' => 'html']);
                break;
            case '/ci':
                $telegram->sendMessage("Mã ID của bạn là: <strong>$chatId</strong>", ['parse_mode' => 'html']);
                break;
            default:
                $telegram->sendMessage('Không có lệnh nào. Vui lòng xem lại.');
                break;
        }
        break;
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

        for ($i=0; $i<3; $i++){
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
            sleep(20);
        }

        echo encode_json(['response' => 200, 'message' => 'Đồng bộ dữ liệu thành công', 'data' => $history]);
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
    // Link để refresh trực tiếp
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
        echo encode_json(['response' => 200, 'message' => 'Đồng bộ dữ liệu thành công', 'data' => $history]);
        break;
    // Lấy thông tin tài khoản
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