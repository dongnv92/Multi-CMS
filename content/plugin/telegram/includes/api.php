<?php
header('Content-Type: application/json');

switch ($path[2]){
    case 'bot':
        $simthue_apikey     = 'GSp5Du68ELUTTWe9_d0Fw579j';
        $simthue_service    = 28; // 258: Kplus, Dịch vụ khác: 2
        $update             = json_decode(file_get_contents("php://input"), TRUE);
        $chatId             = $update["message"]["chat"]["id"];
        $message_chat       = $update["message"]["text"];
        $message            = explode('_', $update["message"]["text"]);
        $message_key        = $message[0];
        $message_value      = str_replace("{$message_key}_", '', $message_chat);
        $telegram           = new Telegram('rentcode');
        $list_user = [
            '823657709'         // Me
        ];
        $telegram->set_chatid($chatId);
        switch ($message_key){
            // KPLUS CHECK
            case '/kc':
                $kplus  = new Kplus($database);
                $month  = $kplus->getMonthUnPaid($chatId);
                $telegram->sendMessage("Số tháng bạn chưa thanh toán là: ". ($month > 0 ? $month : '0') ." tháng.");
                break;
            case '/kr':
            case '/ku':
            case '/ke':
                // Check quyền truy cập
                if(!in_array($chatId, ['823657709', '1150103183'])){
                    $telegram->sendMessage("Bạn không có quyền truy cập tính năng này.");
                    exit();
                }
                $kplus_code     = $message_value;
                $kplus_status   = substr($message_key, 2, 1);
                if($kplus_status == 'r'){
                    $status = 'registered';
                }else if($kplus_status == 'u'){
                    $status = 'unregistered';
                }else{
                    $status = 'error';
                }
                $kplus  = new Kplus($database);
                $update = $kplus->updateStatusBot($kplus_code, $chatId, $status);
                if($update['response'] != 200){
                    $telegram->sendMessage("{$update['message']}.");
                    break;
                }
                $telegram->sendMessage($update['message']);
                break;
            // Kplus New
            case '/k3':
            case '/k4':
            case '/k5':
            case '/k6':
            case '/k7':
            case '/k8':
            case '/k9':
            case '/k10':
            case '/k11':
            case '/k12':
                // Check quyền truy cập
                if(!in_array($chatId, ['823657709', '1150103183'])){
                    $telegram->sendMessage("Xin lỗi, bạn không có quyền truy cập tính năng này.");
                    exit();
                }
                // Lấy số tháng cần lấy
                $month = substr($message_key, 2, (strlen($message_key) == 4 ? 2 : 1));
                $kplus  = new Kplus($database);
                // Nếu 1 giao dịch chưa hoàn thành thì thông báo lỗi
                if(!$kplus->checkChatId($chatId)){
                    $telegram->sendMessage("Cập nhật trạng thái mã thẻ cuối trước trước khi lấy mã mới!");
                    exit();
                }
                // Tìm số tháng gần đúng nhất
                $search = $kplus->searchCode($month);
                if(!$search){
                    $telegram->sendMessage("Tài khoản ứng với số tháng hiện không còn. Vui lòng chọn số tháng khác.");
                    exit();
                }

                $update = $kplus->updateSearchCode($search['kplus_code'], $chatId);
                if(!$update){
                    $telegram->sendMessage("Có sự cố khi cập nhật mã thẻ.");
                    exit();
                }
                $kplus->updateRegisterMonth($search['kplus_code'], $month);
                $content = "{$search['kplus_code']}\nNgày Hết Hạn: ". (date('d/m/Y', strtotime($search['kplus_expired'])))." (".$kplus->caculatorDate($search['kplus_expired']).")";
                $telegram->sendMessage($content);
                $content = "/kr_{$search['kplus_code']} - Thành công.\n/ku_{$search['kplus_code']} - Không dùng.\n/ke_{$search['kplus_code']} - Mã lỗi.";
                $telegram->sendMessage($content);
                if($chatId != '823657709'){
                    $telegram->set_chatid('823657709');
                    $content = 'Thông báo: '.$kplus->getNameByChatId($chatId)." vừa lấy 1 mã thẻ $month tháng.";
                    $telegram->sendMessage($content);
                }
                break;
            // CHAT ID
            case '/ci':
                $telegram->sendMessage("Mã chát ID của bạn là: $chatId");
                break;
            // SMS NEW
            case '/sn':
                // Check quyền truy cập
                if(!in_array($chatId, ['823657709'])){
                    $telegram->sendMessage("Bạn không có quyền truy cập tính năng này.");
                    exit();
                }
                $url_fetch  = 'http://api.simthue.com/request/create';
                $fetch      = curl($url_fetch, ['key' => $simthue_apikey, 'service_id' => $simthue_service], 'GET');
                $fetch      = json_decode($fetch, true);
                if($fetch['id']){
                    $telegram->sendMessage("/sc_{$fetch['id']}\nSố dư: {$fetch['balance']}");
                }else{
                    $telegram->sendMessage("Lỗi: {$fetch['message']}\nTạo vận đơn khác.\n/sn");
                }
                break;
            // SMS CHECK
            case '/sc':
                if(!$message_value){
                    $telegram->sendMessage("Thiếu mã đơn SMS.");
                    break;
                }
                $url_fetch  = "http://api.simthue.com/request/check";
                $fetch  = curl($url_fetch, ['key' => $simthue_apikey, 'id' => $message_value], 'GET');
                $fetch  = json_decode($fetch, true);
                if(!$fetch['number']){
                    $telegram->sendMessage("Chưa tìm được số điện thoại.\n/sc_{$message_value}");
                    break;
                }
                $number = $fetch['number'];
                $number = substr($number, 2, 9);
                $number = "0$number";
                if(!$fetch['sms'][0]){
                    $telegram->sendMessage("$number\nCheck lại: /sc_{$message_value}\n-> Thời gian còn lại: {$fetch['timeleft']} giây");
                    break;
                }
                $code = explode('|', $fetch['sms'][0]);
                $code = $code[2];
                $code = explode(' ', $code);
                $code = $code[0];
                $telegram->sendMessage($code);
                break;
            default:
                $telegram->sendMessage("Tôi không hiểu bạn đang nói gì?");
                break;
        }
        break;
}