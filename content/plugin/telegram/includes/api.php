<?php
header('Content-Type: application/json');

switch ($path[2]){
    case 'rentcode':
        $rentcode_apikey    = 'MsxlaU40YLImmynR8ByMAGEaosizG9YOeNa9TI/RpsQ=';
        $rentcode_service   = 258; // 258: Kplus, Dịch vụ khác: 2
        $update             = json_decode(file_get_contents("php://input"), TRUE);
        $chatId             = $update["message"]["chat"]["id"];
        $message            = strtolower($update["message"]["text"]);
        $message            = explode(' ', $message);
        $telegram           = new Telegram('rentcode');
        $telegram->set_chatid($chatId);
        switch ($message[0]){
            case 'new':
                $url_fetch  = 'https://api.rentcode.net/api/v2/order/request';
                if(isset($message[1]) && in_array($message[1], [258, 2])){
                    $rentcode_service = $message[1];
                }
                $fetch  = curl($url_fetch, ['apiKey' => $rentcode_apikey, 'ServiceProviderId' => $rentcode_service], 'GET');
                $fetch  = json_decode($fetch, true);
                if(validate_int($fetch['id'])){
                    $telegram->sendMessage("Tạo vận đơn mới thành công.");
                    $telegram->sendMessage("check {$fetch['id']}");
                }else{
                    $telegram->sendMessage("Tạo vận đơn mới không thành công.");
                }
                break;
            case 'check':
                if(!$message[1]){
                    $telegram->sendMessage("Thiếu mã đơn.");
                    break;
                }
                if(!validate_int($message[1])){
                    $telegram->sendMessage("Mã đơn sai định dạng.");
                    break;
                }
                $url_fetch  = "https://api.rentcode.net/api/v2/order/{$message[1]}/check";
                $fetch  = curl($url_fetch, ['apiKey' => $rentcode_apikey], 'GET');
                $fetch  = json_decode($fetch, true);
                if(!$fetch['phoneNumber']){
                    $telegram->sendMessage("Chưa tính toán được số điện thoại.");
                    break;
                }
                $telegram->sendMessage($fetch['phoneNumber']);
                if(!$fetch['messages'][0]['message']){
                    $telegram->sendMessage("Chưa có mã gửi đến.");
                    break;
                }
                $telegram->sendMessage($fetch['messages'][0]['message']);
                break;
            default:
                $telegram->sendMessage("Câu lệnh không được hỗ trợ.");
                break;
        }
        break;
}