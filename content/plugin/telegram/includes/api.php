<?php
header('Content-Type: application/json');

switch ($path[2]){
    case 'bot':
        $simthue_apikey     = 'GSp5Du68ELUTTWe9_d0Fw579j';
        $simthue_service    = 256; // 256: Kplus, Dịch vụ khác: 28
        $update             = json_decode(file_get_contents("php://input"), TRUE);
        $chatId             = $update["message"]["chat"]["id"];
        $message_chat       = $update["message"]["text"];
        $message            = explode('_', $message_chat);
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
                $kplus  = new Kplus($database);

                if($kplus_status == 'r'){
                    $status         = 'registered';
                    $text_notify_ad = 'Thông báo: '. $kplus->getNameByChatId($chatId) .' cập nhật trạng thái mã thẻ "'. $kplus_code .'" thành đã đăng ký thành công.';
                    $text_notify    = 'Cập nhật trạng thái mã thẻ "'. $kplus_code .'" thành đã đăng ký thành công.'."\n#update_registed";
                }else if($kplus_status == 'u'){
                    $status         = 'unregistered';
                    $text_notify_ad = 'Thông báo: '. $kplus->getNameByChatId($chatId) .' cập nhật trạng thái mã thẻ "'. $kplus_code .'" thành không đăng ký nữa.';
                    $text_notify    = 'Cập nhật trạng thái mã thẻ "'. $kplus_code .'" thành không đăng ký nữa.'."\n#update_unregisted";
                }else{
                    $status         = 'error';
                    $text_notify_ad = 'Thông báo: '. $kplus->getNameByChatId($chatId) .' cập nhật trạng thái mã thẻ "'. $kplus_code .'" thành mã thẻ bị lỗi.';
                    $text_notify    = 'Cập nhật trạng thái mã thẻ "'. $kplus_code .'" thành mã thẻ bị lỗi.'."\n#update_error";
                }

                $update = $kplus->updateStatusBot($kplus_code, $chatId, $status);
                if($update['response'] != 200){
                    $telegram->sendMessage("{$update['message']}.");
                    break;
                }
                $telegram->sendMessage($text_notify);

                // Nếu không phải admin thì thông báo cho admin khi có người update thẻ
                if($chatId != '823657709'){
                    $telegram->set_chatid('823657709');
                    $telegram->sendMessage($text_notify_ad."\n#notify_{$chatId}_update_code");
                }
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
                $month  = substr($message_key, 2, (strlen($message_key) == 4 ? 2 : 1));
                $kplus  = new Kplus($database);

                // Nếu 1 giao dịch chưa hoàn thành thì thông báo lỗi
                if(!$kplus->checkChatId($chatId)){
                    $telegram->sendMessage("Cập nhật trạng thái mã thẻ cuối trước trước khi lấy mã mới!");
                    exit();
                }

                // Lấy nhiều mã thẻ 1 lúc
                if(count($message) > 1){
                    $data = $kplus->get_multi_month($month, $message_value, $chatId);
                    $telegram->sendMessage($data['message']."\n#get_multiple_code");

                    // Nếu không phải admin thì thông báo cho admin khi có người lấy thẻ
                    if($chatId != '823657709'){
                        $telegram->set_chatid('823657709');
                        $content = 'Thông báo: '.$kplus->getNameByChatId($chatId)." vừa lấy $message_value mã thẻ $month tháng.\n#notify_{$chatId}_get_multiple_code";
                        $telegram->sendMessage($content);
                    }
                    break;
                }

                // Tìm số tháng gần đúng nhất
                $search = $kplus->searchCode($month);
                if(!$search){
                    $telegram->sendMessage("Tài khoản ứng với số tháng hiện không còn. Vui lòng chọn số tháng khác.");
                    exit();
                }

                // Update trạng thái mã thẻ thành wait và unpaid
                $update = $kplus->updateSearchCode($search['kplus_code'], $chatId);
                if(!$update){
                    $telegram->sendMessage("Có sự cố khi cập nhật mã thẻ.");
                    exit();
                }

                // Update trạng thái mã thẻ thành số tháng tính từ lúc lấy mã
                $kplus->updateRegisterMonth($search['kplus_code'], $month);

                // Gửi thông tin thẻ và ngày hết hạn
                $content = "{$search['kplus_code']}\nNgày Hết Hạn: ". (date('d/m/Y', strtotime($search['kplus_expired'])))." (".$kplus->caculatorDate($search['kplus_expired']).")".($search['kplus_verify'] == 'verify' ? "\n✅ mã đã được xác thực." : '');
                $telegram->sendMessage($content);

                // Gửi mã lệnh update trạng thái thẻ khi đăng ký xong
                $content = "/kr_{$search['kplus_code']} - Thành công.\n/ku_{$search['kplus_code']} - Không dùng.\n/ke_{$search['kplus_code']} - Mã lỗi.";
                $telegram->sendMessage($content."\n#get_code");

                // Nếu không phải admin thì thông báo cho admin khi có người lấy thẻ
                if($chatId != '823657709'){
                    $telegram->set_chatid('823657709');
                    $content = 'Thông báo: '.$kplus->getNameByChatId($chatId)." vừa lấy 1 mã thẻ $month tháng.\n#notify_{$chatId}_get_code";
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
                if(!in_array($chatId, ['823657709', '1150103183'])){
                    $telegram->sendMessage("Bạn không có quyền truy cập tính năng này.");
                    exit();
                }
                $url_fetch  = 'http://api.simthue.com/request/create';
                $fetch      = curl($url_fetch, ['key' => $simthue_apikey, 'service_id' => $simthue_service], 'GET');
                $fetch      = json_decode($fetch, true);
                if($fetch['id']){
                    function convert_number_to_money($number){
                        return number_format($number, 0, '', '.');
                    }
                    $telegram->sendMessage("/sc_{$fetch['id']}\nSố dư: ". convert_number_to_money($fetch['balance']) ."₫\n#get_sms");
                    // Nếu không phải admin thì thông báo cho admin khi có thêm đơn SMS mới
                    $kplus  = new Kplus($database);
                    if($chatId != '823657709'){
                        $telegram->set_chatid('823657709');
                        $telegram->sendMessage('Thông báo: '.$kplus->getNameByChatId($chatId)." vừa thêm 1 đơn SMS mới.\n/sc_{$fetch['id']}\n#notify_{$chatId}_get_sms");
                    }
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
                $telegram->sendMessage($number);
                break;
            case '/t':
                echo $telegram->sendMessage("Đây là tin nhắn phản hồi lại từ Server.");
                break;
            // CHECK NAME
            case '/cn':
                  $kplus = new Kplus($database);
                  $check = $kplus->checkName($message_value);
                  if(!$check){
                      $telegram->sendMessage("Hiện chưa có thuê bao nào trong danh sách có tên: \"$message_value\".");
                      break;
                  }
                $telegram->sendMessage("Tên: \"$message_value\" đã có trong danh sách.");
                break;
            default: // Thêm mã thẻ
                $message = explode("\n", $message_chat);
                if(!in_array(count($message), [2, 3])){
                    break;
                }
                $kplus                      = new Kplus($database);
                $_REQUEST['kplus_code']     = trim($message[0]);
                $_REQUEST['kplus_expired']  = trim($message[1]);
                $_REQUEST['kplus_name']     = $message[2] ? trim($message[2]) : trim($kplus->getLastNameAdd());
                $add = $kplus->add();
                if($add['response'] != 200){
                    $telegram->sendMessage("Lỗi khi thêm mã thẻ: {$add['message']}.");
                    break;
                }
                $telegram->sendMessage("Thêm mã thẻ mới thành công.\nMã thẻ: {$add['meta']['kplus_code']}\nNgày hết hạn: {$add['meta']['kplus_expired']}\nTên chủ thuê bao: {$add['meta']['kplus_name']}.\nSố thuê bao chưa đăng ký: {$add['statics']['unregistered']}\n#add_code");
                break;
        }
        break;
}