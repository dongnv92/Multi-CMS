<?php
header('Content-Type: application/json');

switch ($path[2]){
    case 'bot':
        $rentcode_apikey    = 'MsxlaU40YLImmynR8ByMAGEaosizG9YOeNa9TI/RpsQ=';
        $rentcode_service   = 258; // 258: Kplus, Dịch vụ khác: 2
        $update             = json_decode(file_get_contents("php://input"), TRUE);
        $chatId             = $update["message"]["chat"]["id"];
        $message_chat       = strtolower($update["message"]["text"]);
        $message            = explode('_', $message_chat);
        $telegram           = new Telegram('rentcode');
        $telegram->set_chatid($chatId);
        $list_user = [
            '823657709'         // Me
        ];
        switch ($message[0]){
            case '/rentcode':
                switch ($message[1]){
                    case 'new':
                        // Check quyền truy cập
                        if(!in_array($chatId, ['823657709'])){
                            $telegram->sendMessage("Xin lỗi, bạn không có quyền truy cập tính năng này.");
                            exit();
                        }
                        $url_fetch  = 'https://api.rentcode.net/api/v2/order/request';
                        if(isset($message[2]) && in_array($message[2], [258, 2])){
                            $rentcode_service = $message[2];
                        }
                        $fetch  = curl($url_fetch, ['apiKey' => $rentcode_apikey, 'ServiceProviderId' => $rentcode_service], 'GET');
                        $fetch  = json_decode($fetch, true);
                        if(validate_int($fetch['id'])){
                            $telegram->sendMessage("Tạo vận đơn mới thành công.\n/rentcode_check_{$fetch['id']}");
                        }else{
                            $telegram->sendMessage("Tạo vận đơn mới không thành công.\nTạo vận đơn khác.\n/rentcode_new");
                        }
                        break;
                    case 'check':
                        if(!$message[2]){
                            $telegram->sendMessage("Thiếu mã đơn.");
                            break;
                        }
                        if(!validate_int($message[2])){
                            $telegram->sendMessage("Mã đơn sai định dạng.");
                            break;
                        }
                        $url_fetch  = "https://api.rentcode.net/api/v2/order/{$message[2]}/check";
                        $fetch  = curl($url_fetch, ['apiKey' => $rentcode_apikey], 'GET');
                        $fetch  = json_decode($fetch, true);
                        if(!$fetch['phoneNumber']){
                            $telegram->sendMessage("Chưa tính toán được số điện thoại. Click lệnh dưới đây để check lại.\n/rentcode_check_{$message[2]}");
                            break;
                        }
                        $telegram->sendMessage($fetch['phoneNumber']);
                        if(!$fetch['messages'][0]['message']){
                            $telegram->sendMessage("Chưa có mã gửi đến. Click lệnh dưới đây để check lại.\n/rentcode_check_{$message[2]}");
                            break;
                        }
                        $telegram->sendMessage($fetch['messages'][0]['message']);
                        break;
                    default:
                        $telegram->sendMessage("Câu lệnh không được hỗ trợ.\n/rentcode_new : Tạo mã đơn hàng mới.\n/rentcode_new 2: Tạo mã đơn hàng mới với dịch vụ khác.\n/rentcode_check_{id}: Check đơn hàng.");
                        break;
                }
                break;
            case '/getchatid':
                $telegram->sendMessage("Mã chát ID của bạn là: $chatId");
                break;
            case '/kplus':
                switch ($message[1]){
                    case 'new':
                        // Check quyền truy cập
                        if(!in_array($chatId, ['823657709'])){
                            $telegram->sendMessage("Xin lỗi, bạn không có quyền truy cập tính năng này.");
                            exit();
                        }
                        if(!$message[2] || !in_array($message[2], [3,4,5,6,7,8,9,10,11,12])){
                            $telegram->sendMessage("Số tháng không hợp lệ. Vui lòng nhập lại.");
                            exit();
                        }
                        $kplus  = new Kplus($database);
                        $search = $kplus->searchCode($message[2]);
                        if(!$search){
                            $telegram->sendMessage("Hiện tài khoản ứng với số tháng bạn chọn hiện không còn. Vui lòng chọn tháng khác.");
                            exit();
                        }
                        $update = $kplus->updateSearchCode($search['kplus_code'], $chatId);
                        if(!$update){
                            $telegram->sendMessage("Có sự cố khi cập nhật mã thẻ.");
                            exit();
                        }
                        $telegram->sendMessage("Lấy thông tin mã thẻ thành công.");
                        $telegram->sendMessage($search['kplus_code']);
                        $telegram->sendMessage($search['kplus_expired']);
                        $telegram->sendMessage($kplus->caculatorDate($search['kplus_expired']));
                        break;
                    case 'update-status-reg': // Update trạng thái đã đăng ký thành công.

                        break;
                    case 'update-status-unreg': // Update trạng thái lỗi không đăng ký được.

                        break;
                    case 'update-status-remove': // Update không dùng mã thẻ nữa.

                        break;
                    default:
                        $telegram->sendMessage("Câu lệnh không được hỗ trợ.");
                        $telegram->sendMessage("/kplus_new_3 - Lấy mã 3 tháng.\n
                        /kplus_new_4 - Lấy mã 4 tháng.\n
                        /kplus_new_5 - Lấy mã 5 tháng.\n
                        /kplus_new_6 - Lấy mã 6 tháng.\n
                        /kplus_new_7 - Lấy mã 7 tháng.\n
                        /kplus_new_8 - Lấy mã 8 tháng.\n
                        /kplus_new_9 - Lấy mã 9 tháng.\n
                        /kplus_new_10 - Lấy mã 10 tháng.\n
                        /kplus_new_11 - Lấy mã 11 tháng.\n
                        /kplus_new_12 - Lấy mã 12 tháng.");
                        break;
                }
                break;
            default:
                $telegram->sendMessage("Câu lệnh không được hỗ trợ.");
                break;
        }
        break;
}