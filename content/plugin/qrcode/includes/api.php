<?php
switch ($path[2]){
    case 'citypost':
        $content        = json_decode(file_get_contents("php://input"), TRUE);
        $chatId         = $content["message"]["chat"]["id"];
        $message_chat   = $content["message"]["text"];
        $telegram       = new Telegram('citypostarbot');
        $key_message    = explode(' ', $message_chat);
        $key_message    = strtolower($key_message[0]);
        $count_message_key  = mb_strlen($key_message, 'utf-8');
        $count_message      = mb_strlen($message_chat, 'utf-8');
        $new_message        = trim(mb_substr($message_chat, $count_message_key, $count_message));
        switch ($key_message){
            case 'bill':
                if(!$new_message){
                    $telegram->set_chatid($chatId);
                    $telegram->sendMessage('Bạn cần nhập mã Bill để kiểm tra.');
                    break;
                }
                require_once ABSPATH."includes/class/simple_html_dom.php";
                $data_api   = curl('https://system.citypost.com.vn/api/Search/SearchLading', ['code' => $new_message], 'JSON');
                $data_api   = json_decode($data_api, true);
                if($data_api['Message'] == 'An error has occurred.'){
                    $telegram->set_chatid($chatId);
                    $telegram->sendMessage("Mã $new_message không tồn tại trên hệ thống.");
                    break;
                }
                $html       = file_get_html("http://citypost.com.vn/tra-cuu-van-don.html?code=$new_message");
                $data_web   = array();
                foreach($html->find('table tbody tr') as $row) {
                    $rowData = array();
                    foreach($row->find('td') as $cell) {
                        $rowData[] = html_entity_decode(trim($cell->innertext));
                    }
                    $data_web[] = $rowData;
                }
                $reply  = "Thông tin mã Bill $new_message:\n\n";
                $reply .= "Trạng thái: {$data_api[0]['StatusName']}.\n";
                $reply .= "Thời gian tạo: ". (str_replace('T', ' ', $data_api[0]['CreateDate'])) .".\n";
                $reply .= "Cân nặng: {$data_api[0]['Weight']}g.\n";
                $reply .= "Số kiện: {$data_api[0]['Weight']}g.\n";
                if($data_api[0]['StatusName'] == 'Phát thành công'){
                    $reply .= "Thời gian hoàn thành: ". (str_replace('T', ' ', $data_api[0]['FinishDate'])) .".\n";
                }
                $reply .= "\n- THÔNG TIN NGƯỜI GỬI.\n";
                $reply .= "Người gửi: {$data_api[0]['SenderCompany']}.\n";
                $reply .= "SĐT người gửi: {$data_api[0]['SenderPhone']}.\n";
                $reply .= "\n- THÔNG TIN NGƯỜI NHẬN.\n";
                $reply .= "Tên người nhận: {$data_api[0]['RecipeName']}.\n";
                $reply .= "Công ty nhận: {$data_api[0]['RecipeCompany']}.\n";
                $reply .= "SĐT người nhận: {$data_api[0]['RecipePhone']}.\n";
                $reply .= "Địa chỉ người nhận: {$data_api[0]['RecipeAddress']}.\n";
                $reply .= "\n- LỊCH TRÌNH.\n";
                foreach ($data_web AS $lichtrinh){
                    $reply .= "- [{$lichtrinh[0]}] {$lichtrinh[3]} {$lichtrinh[4]} ({$lichtrinh[2]} - {$lichtrinh[1]}).\n";
                }
                $telegram->set_chatid($chatId);
                $telegram->sendMessage($reply);
                break;
            case '/id':
                $telegram->set_chatid($chatId);
                $telegram->sendMessage("Mã ID của bạn là: $chatId");
                break;
            case 'ketqua':
                $result = json_decode($new_message, true);
                if(count($result) == 0){
                    $telegram->set_chatid($chatId);
                    $telegram->sendMessage("Sai cú pháp hoặc nguồn đáp án. Vui lòng thử lại.");
                    break;
                }
                $i      = 0;
                $text   = "";
                foreach ($result AS $kq){
                    $i++;
                    $j = 0;
                    foreach ($kq['ListAnswer'] AS $dapan){
                        $j++;
                        if($dapan['CorrectAnswerName'] == 'Đúng'){
                            switch ($j){
                                case 1:
                                    $dapso = 'A';
                                    break;
                                case 2:
                                    $dapso = 'B';
                                    break;
                                case 3:
                                    $dapso = 'C';
                                    break;
                                case 4:
                                    $dapso = 'D';
                                    break;
                            }
                            $text .= "Câu $i: $dapso\n";
                            break;
                        }
                    }
                }
                $telegram->set_chatid($chatId);
                $telegram->sendMessage($text);
                break;
            default:
                $telegram->set_chatid($chatId);
                $telegram->sendMessage('Bot không hiểu bạn đang nói gì. Vui lòng kiểm tra lại hoặc liên hệ @dongnv.');
                break;
        }
        break;
    case 'bot':
        $otpsim_apikey      = 'c0de81ffe776dc041b0efeabdbdc7d07';
        $otpsim_service     = 103; // 256: Kplus, Dịch vụ khác: 28
        $otpsim_service_vie = 239; // 256: Vie ON, Dịch vụ khác: 28
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
                if(count($message) > 1 && in_array($message_value, [2,3,4,5,6,7,8,9,10])){
                    /*if($chatId != '823657709'){
                        $content = 'Thông báo: Chúng tôi đang sửa chức năng này. Vui lòng quay lại sau';
                        $telegram->sendMessage($content);
                        break;
                    }*/

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

                // Nếu có đuôi _r, _u, _e thì update luôn
                if(count($message) > 1 && in_array($message_value, ['r', 'u', 'e'])){
                    if($message_value == 'r'){
                        $status         = 'registered';
                        $text_notify    = 'Cập nhật trạng thái mã thẻ "'. $search['kplus_code'] .'" thành đã đăng ký thành công.'."\n#update_registed";
                    }else if($message_value == 'u'){
                        $status         = 'unregistered';
                        $text_notify    = 'Cập nhật trạng thái mã thẻ "'. $search['kplus_code'] .'" thành không đăng ký nữa.'."\n#update_unregisted";
                    }else{
                        $status         = 'error';
                        $text_notify    = 'Cập nhật trạng thái mã thẻ "'. $search['kplus_code'] .'" thành mã thẻ bị lỗi.'."\n#update_error";
                    }
                    $update = $kplus->updateStatusBot($search['kplus_code'], $chatId, $status);
                    if($update['response'] != 200){
                        $telegram->sendMessage("{$update['message']}.");
                        break;
                    }
                    $telegram->sendMessage($text_notify);
                }else{
                    // Gửi mã lệnh update trạng thái thẻ khi đăng ký xong
                    $content = "/kr_{$search['kplus_code']} - Thành công.\n/ku_{$search['kplus_code']} - Không dùng.\n/ke_{$search['kplus_code']} - Mã lỗi.";
                    $telegram->sendMessage($content."\n#get_code");
                }

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
            case '/sk':
                // Check quyền truy cập
                if(!in_array($chatId, ['823657709', '1150103183', '811726046', '1585307227', '1637619949'])){
                    $telegram->sendMessage("Bạn không có quyền truy cập tính năng này.");
                    exit();
                }
                $apikey     = '3125b8a2';
                $service    = 1222; // 1222 kplus

                /*$telegram->sendMessage("Hiện tại hệ thống SMS đang bảo trì, vui lòng truy cập lại sau.");
                exit();*/

                $url_fetch  = 'https://chothuesimcode.com/api';
                $fetch      = curl($url_fetch, ['apik' => $apikey, 'appId' => $service, 'act' => 'number', 'carrier' => 'Viettel'], 'GET');
                $fetch      = json_decode($fetch, true);
                if($fetch['ResponseCode'] == 0){
                    $telegram->sendMessage("Phone: 0{$fetch['Result']['Number']}\nSố dư: ". ($chatId == '823657709' ? convert_number_to_money($fetch['Result']['Balance']) : 'You do not have permission.') ."\n/skc_{$fetch['Result']['Id']}\n#get_sms");
                    // Nếu không phải admin thì thông báo cho admin khi có thêm đơn SMS mới
                    $kplus  = new Kplus($database);
                    if($chatId != '823657709'){
                        $telegram->set_chatid('823657709');
                        $telegram->sendMessage('Thông báo: '.$kplus->getNameByChatId($chatId)." vừa thêm 1 đơn SMS mới.\n/skc_{$fetch['Result']['Id']}\n#notify_{$chatId}_get_sms");
                    }
                }else{
                    $telegram->sendMessage("Lỗi: {$fetch['message']}\nTạo vận đơn khác.\n/sk");
                }
                break;
            // SMS NEW
            case '/sn':
            case '/sv':
                // Check quyền truy cập
                if(!in_array($chatId, ['823657709', '1150103183', '811726046', '1585307227', '1637619949'])){
                    $telegram->sendMessage("Bạn không có quyền truy cập tính năng này.");
                    exit();
                }

                /*$telegram->sendMessage("Hiện tại hệ thống SMS đang bảo trì, vui lòng truy cập lại sau.");
                exit();*/

                $url_fetch  = 'http://otpsim.com/api/phones/request';
                $fetch      = curl($url_fetch, ['token' => $otpsim_apikey, 'service' => ($message_key == '/sn' ? $otpsim_service : $otpsim_service_vie), 'network' => '3'], 'GET');
                $fetch      = json_decode($fetch, true);
                if($fetch['status_code'] == 200){
                    function otpsim_get_balance(){
                        global $otpsim_apikey;
                        $url_fetch  = 'http://otpsim.com/api/users/balance';
                        $fetch      = curl($url_fetch, ['token' => $otpsim_apikey], 'GET');
                        $fetch      = json_decode($fetch, true);
                        return number_format($fetch['data']['balance'], 0, '', '.');
                    }
                    $telegram->sendMessage("Phone: 0{$fetch['data']['phone_number']}\nSố dư: ". ($chatId == '823657709' ? otpsim_get_balance() : 'You do not have permission.') ."₫\n/sc_{$fetch['data']['session']}\n#get_sms");
                    // Nếu không phải admin thì thông báo cho admin khi có thêm đơn SMS mới
                    $kplus  = new Kplus($database);
                    if($chatId != '823657709'){
                        $telegram->set_chatid('823657709');
                        $telegram->sendMessage('Thông báo: '.$kplus->getNameByChatId($chatId)." vừa thêm 1 đơn SMS mới.\n/sc_{$fetch['data']['session']}\n#notify_{$chatId}_get_sms");
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
                $url_fetch  = "http://otpsim.com/api/sessions/{$message_value}";
                $fetch  = curl($url_fetch, ['token' => $otpsim_apikey], 'GET');
                $fetch  = json_decode($fetch, true);
                if($fetch['data']['status'] == 1){
                    $telegram->sendMessage("Chưa nhận được tin nhắn OTP.\n/sc_{$message_value}");
                    break;
                }
                if($fetch['data']['status'] == 2){
                    $telegram->sendMessage("Phiên đã hết hạn.");
                    break;
                }
                if($fetch['data']['status'] == 0){
                    $telegram->sendMessage($fetch['data']['messages'][0]['otp']);
                    $telegram->sendMessage('0'.$fetch['data']['phone_number']);
                    break;
                }
                break;
            case '/skc':
                if(!$message_value){
                    $telegram->sendMessage("Thiếu mã đơn SMS.");
                    break;
                }
                $apikey     = '3125b8a2';
                $url_fetch  = "https://chothuesimcode.com/api";
                $fetch  = curl($url_fetch, ['apik' => $apikey, 'id' => $message_value, 'act' => 'code'], 'GET');
                $fetch  = json_decode($fetch, true);
                if($fetch['ResponseCode'] == 1){
                    $telegram->sendMessage("Đang chờ tin nhắn về.\n/skc_{$message_value}");
                    break;
                }
                if($fetch['ResponseCode'] == 2){
                    $telegram->sendMessage("Phiên đã hết hạn.");
                    break;
                }
                if($fetch['ResponseCode'] == 0){
                    $telegram->sendMessage($fetch['Result']['Code']);
                    break;
                }
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
                $telegram->sendMessage("Thêm mã thẻ mới thành công.\nMã thẻ: {$add['meta']['kplus_code']}\nNgày hết hạn: {$add['meta']['kplus_expired']}\nTên chủ thuê bao: {$add['meta']['kplus_name']}.\nĐếm ngày: ". ($kplus->caculatorDate($add['meta']['kplus_expired'])) ."\nSố thuê bao chưa đăng ký: {$add['statics']['unregistered']}\n#add_code");
                break;
        }
        break;
    case 'test':
        //$telegram = new Telegram('rentcode');
        //$telegram->set_chatid('823657709');
        //$telegram->sendMessage('Đây là tin nhắn test');
        echo encode_json(['response' => 200, 'message' => 'Request thành công']);
        break;
}