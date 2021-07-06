<?php
switch ($path[2]){
    case 'addoil':
        $group_id = [
            'citypost_test_notice' => '-589881611'
        ];
        $request    = json_decode(file_get_contents('php://input'), true);
        $telegram   = new Telegram('citypost_notice');
        $check      = new user($database);
        /*-----------------------*/
        $user       = $request['user'];     // Người đổ dầu
        $bsx        = $request['bsx'];      // Biển số xe
        $km         = $request['km'];       // Số Km
        $price      = $request['price'];    // Đơn giá
        $amount     = $request['amount'];   // Số lượng dầu (Lít)
        $numbill    = $request['numbill'];  // Số phiếu
        $location   = $request['location']; // Chi nhánh
        $token      = $request['token'];    // Token
        /*-----------------------*/
        if(!$request['token']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu Mã Access Token.']);
            break;
        }
        if(!$check->check_access_token($token)){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ.']);
            break;
        }
        if(!$request['user']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu người đổ dầu.']);
            break;
        }
        if(!$request['bsx']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu trường biển số xe.']);
            break;
        }
        if(!$request['price']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu đơn giá.']);
            break;
        }
        if(!$request['amount']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu số lượng dầu đã đổ.']);
            break;
        }
        if(!$request['numbill']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu số phiếu.']);
            break;
        }
        /*-----------------------*/
        $message = "-----------------\n";
        $message .= "[Thông báo đổ dầu]\nLái xe {$request['user']} đổ {$request['amount']} Lít dầu xe {$request['bsx']}.\n";
        $message .= "- Số phiếu: {$request['numbill']}\n";
        $message .= "- Đơn giá: {$request['price']}\n";
        $message .= "- Thời gian: ". date('H:i:s d/m/Y') ."\n";
        $message .= "-----------------";

        $telegram->set_chatid($group_id['citypost_test_notice']);
        $telegram->sendMessage($message);
        echo json_encode(['response' => 200, 'message' => 'Send Message To Telegram Group Success.']);
        break;
    default:
        $data = [
            'user'  => 'Nguyễn Văn Đông',
            'bsx'   => '29H70562',
            'price' => '17777',
            'amount' => '70',
            'numbill'   => '321',
            'location'  => 'HN'
        ];
        echo json_encode($data);
        break;
}