<?php
header('Content-Type: application/json');

switch ($path[2]){
    case 'bot':
        $simthue_apikey     = 'GSp5Du68ELUTTWe9_d0Fw579j';
        $simthue_service    = 28; // 258: Kplus, Dịch vụ khác: 2
        $update             = json_decode(file_get_contents("php://input"), TRUE);
        $chatId             = $update["message"]["chat"]["id"];
        $message_chat       = strtolower($update["message"]["text"]);
        $message            = explode('_', $update["message"]["text"]);
        $telegram           = new Telegram('rentcode');
        $telegram->set_chatid($chatId);
        $list_user = [
            '823657709'         // Me
        ];
        switch ($message[0]){
            case '/r':
                switch ($message[1]){
                    case 'n':
                        // Check quyền truy cập
                        if(!in_array($chatId, ['823657709'])){
                            $telegram->sendMessage("Xin lỗi, bạn không có quyền truy cập tính năng này.");
                            exit();
                        }
                        $url_fetch  = 'http://api.simthue.com/request/create';
                        $fetch      = curl($url_fetch, ['key' => $simthue_apikey, 'service_id' => $simthue_service], 'GET');
                        $fetch      = json_decode($fetch, true);
                        if($fetch['id']){
                            $telegram->sendMessage("Tạo vận đơn mới thành công.\n/r_c_{$fetch['id']}");
                        }else{
                            $telegram->sendMessage("Tạo vận đơn mới không thành công.\nLỗi: {$fetch['message']}\nTạo vận đơn khác.\n/r_n");
                        }
                        break;
                    case 'c':
                        if(!$message[2]){
                            $telegram->sendMessage("Thiếu mã đơn.");
                            break;
                        }
                        $url_fetch  = "http://api.simthue.com/request/check";
                        $fetch  = curl($url_fetch, ['key' => $simthue_apikey, 'id' => $message[2]], 'GET');
                        $fetch  = json_decode($fetch, true);
                        if(!$fetch['number']){
                            $telegram->sendMessage("Chưa tính toán được số điện thoại. Click lệnh dưới đây để check lại.\n/r_c_{$message[2]}");
                            break;
                        }
                        $number = $fetch['number'];
                        $number = substr($number, 2, 9);
                        $number = "0$number";
                        $telegram->sendMessage($number);
                        if(!$fetch['sms'][0]){
                            $telegram->sendMessage("Chưa có mã gửi đến. Click lệnh dưới đây để check lại.\n/r_c_{$message[2]}");
                            break;
                        }
                        $code = explode('|', $fetch['sms'][0]);
                        $code = $code[2];
                        $code = explode(' ', $code);
                        $code = $code[0];
                        $telegram->sendMessage($code);
                        break;
                    default:
                        $telegram->sendMessage("Câu lệnh không được hỗ trợ.\n/r_n : Tạo mã đơn hàng mới.\n/r_n_2: Tạo mã đơn hàng mới với dịch vụ khác.\n/r_c_{id}: Check đơn hàng.");
                        break;
                }
                break;
            case '/getchatid':
                $telegram->sendMessage("Mã chát ID của bạn là: $chatId");
                break;
            case '/k':
                switch ($message[1]){
                    case 'n':
                        // Check quyền truy cập
                        if(!in_array($chatId, ['823657709', '1150103183'])){
                            $telegram->sendMessage("Xin lỗi, bạn không có quyền truy cập tính năng này.");
                            exit();
                        }
                        if(!$message[2] || !in_array($message[2], [3,4,5,6,7,8,9,10,11,12])){
                            $telegram->sendMessage("Số tháng không hợp lệ. Vui lòng nhập lại.");
                            exit();
                        }
                        $kplus  = new Kplus($database);
                        // Nếu 1 giao dịch chưa hoàn thành thì thông báo lỗi
                        if(!$kplus->checkChatId($chatId)){
                            $telegram->sendMessage("Bạn cần cập nhật trạng thái mã trẻ trước trước trước khi lấy mã mới.");
                            exit();
                        }

                        $search = $kplus->searchCode($message[2]);
                        if(!$search){
                            $telegram->sendMessage("Hiện tài khoản ứng với số tháng bạn chọn hiện không còn. Vui lòng chọn số tháng khác.");
                            exit();
                        }

                        $update = $kplus->updateSearchCode($search['kplus_code'], $chatId);
                        if(!$update){
                            $telegram->sendMessage("Có sự cố khi cập nhật mã thẻ.");
                            exit();
                        }
                        $kplus->updateRegisterMonth($search['kplus_code'], $message[2]);
                        $content = "- Lấy mã thẻ thành công.\n{$search['kplus_code']}\n". (date('d/m/Y', strtotime($search['kplus_expired'])))." - ".$kplus->caculatorDate($search['kplus_expired'])."\n";
                        $content .= "/k_u_{$search['kplus_code']}_registered - Thành công.\n/k_u_{$search['kplus_code']}_unregistered - Không dùng nữa.\n/k_u_{$search['kplus_code']}_error - Mã lỗi.";
                        $telegram->sendMessage($content);
                        break;
                    case 'u': // Update trạng thái đã đăng ký thành công.
                        // Check quyền truy cập
                        if(!in_array($chatId, ['823657709', '1150103183'])){
                            $telegram->sendMessage("Xin lỗi, bạn không có quyền truy cập tính năng này.");
                            exit();
                        }
                        $kplus_code     = $message[2];
                        $kplus_status   = $message[3];
                        $kplus  = new Kplus($database);
                        $update = $kplus->updateStatusBot($kplus_code, $chatId, $kplus_status);
                        if($update['response'] != 200){
                            $telegram->sendMessage("{$update['message']}.");
                            break;
                        }
                        $telegram->sendMessage($update['message']);
                        break;
                    case 'cp':
                        $kplus  = new Kplus($database);
                        $month  = $kplus->getMonthUnPaid($chatId);
                        $telegram->sendMessage("Số tháng bạn chưa thanh toán là: ". ($month > 0 ? $month : '0') ." tháng.");
                        break;
                    default:
                        $content = "Câu lệnh không được hỗ trợ.\n";
                        $content .= "/k_n_3 - Lấy mã 3 tháng.\n";
                        $content .= "/k_n_4 - Lấy mã 4 tháng.\n";
                        $content .= "/k_n_5 - Lấy mã 5 tháng.\n";
                        $content .= "/k_n_6 - Lấy mã 6 tháng.\n";
                        $content .= "/k_n_7 - Lấy mã 7 tháng.\n";
                        $content .= "/k_n_8 - Lấy mã 8 tháng.\n";
                        $content .= "/k_n_9 - Lấy mã 9 tháng.\n";
                        $content .= "/k_n_10 - Lấy mã 10 tháng.\n";
                        $content .= "/k_n_11 - Lấy mã 11 tháng.\n";
                        $content .= "/k_n_12 - Lấy mã 12 tháng.\n";
                        $telegram->sendMessage($content);
                        break;
                }
                break;
            default:
                $telegram->sendMessage("Câu lệnh không được hỗ trợ.");
                break;
        }
        break;
}