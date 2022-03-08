<?php
switch ($path[2]){
    // Thông báo chấm công.
    case 'chamcong':
        $hour   = date('H', time());
        $minus  = date('i', time());
        $day    = date('w', time()) + 1;
        if(in_array($day, [2,3,4,5,6])){
            if($hour == 8 && $minus == 13){
                $text = 'Sắp muộn giờ làm rồi, ai đang trên đường thì đi nhanh không muộn, ai đến rồi mà quên thì chấm công nhé!';
            }else if($hour == 17 && $minus == 25){
                $text = 'Sắp đến giờ tan ca rồi, vào chấm công luôn cho chắc cốp bạn nhé.';
            }
        }else if(in_array($day, [7])){
            if($hour == 8 && $minus == 13){
                $text = 'Sắp muộn giờ làm rồi, ai đang trên đường thì đi nhanh không muộn, ai đến rồi mà quên thì chấm công nhé!';
            }else if($hour == 11 && $minus == 59){
                $text = 'Sắp đến giờ tan ca rồi, vào chấm công luôn cho chắc cốp bạn nhé.';
            }
        }
        if($text){
            $telegram = new Telegram('citypost_notice');
            $telegram->set_chatid('-592349283');
            $telegram->sendMessage($text);
            echo encode_json(['response' => 200, 'message' => 'Success!']);
        }else{
            echo encode_json(['response' => 200, 'message' => 'Nothing ...']);
        }
        break;
    // Báo cáo thống kê
    case 'static':
        $group_id = [
            'citypost_test'  => '-582736253',
            'citypost_staic' => '-799087783'
        ];
        $request    = json_decode(file_get_contents('php://input'), true);
        $telegram   = new Telegram('citypost_notice');
        $check      = new user($database);
        /*-----------------------*/
        $token      = $request['token'];    // Token
        $_REQUEST['content']        = $request['content'];   // Nội dung
        $_REQUEST['title']          = $request['title'];     // Tiêu đề
        /*-----------------------*/
        if(!$token){
            echo encode_json(['response' => '404', 'message' => 'Thiếu Mã Access Token.']);
            break;
        }
        if(!$check->check_access_token($token)){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ.']);
            break;
        }
        if(!$_REQUEST['content']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu nội dung.']);
            break;
        }
        if(!$_REQUEST['title']){
            echo encode_json(['response' => '404', 'message' => 'Thiếu tiêu đề.']);
            break;
        }

        $telegram->set_chatid($group_id['citypost_staic']);
        $content = $_REQUEST['title']."\n".$_REQUEST['content'];
        $telegram->sendMessage($content, ['parse_mode' => 'html']);
        echo json_encode(['response' => 200, 'message' => 'Send Message To Telegram Group Success.']);
        break;
    case 'checkbkp':
        $driving    = new pDriving();
        $status     = $driving->check_bill();
        if($status){
            $group_id = [
                'citypost_refusetrip_test'  => '-582736253'
            ];
            $telegram   = new Telegram('citypost_notice');
            $telegram->set_chatid($group_id['citypost_refusetrip_test']);
            $telegram->sendMessage($status);
            echo encode_json(['response' => 200, 'message' => 'Send message to Group Telegram Success!']);
            break;
        }
        echo encode_json(['response' => 200, 'message' => 'Empty']);
        break;
    case 'addbill':
        $group_id = [
            'citypost_refusetrip_test'  => '-582736253',
            'citypost_refusetrip_hn'    => '-416213766'
        ];
        $request    = json_decode(file_get_contents('php://input'), true);
        $telegram   = new Telegram('citypost_notice');
        $check      = new user($database);
        /*-----------------------*/
        $token      = $request['token'];    // Token
        $_REQUEST['officer_create']     = $request['officer_create'];   // Người tạo
        $_REQUEST['officer_receive']    = $request['officer_receive'];  // Người nhận
        $_REQUEST['bkp_code']           = $request['bkp_code'];         // Mã BKP
        $_REQUEST['bkp_location']       = $request['bkp_location'];     // Chi nhánh
        /*-----------------------*/
        if(!$token){
            echo encode_json(['response' => '404', 'message' => 'Thiếu Mã Access Token.']);
            break;
        }
        if(!$check->check_access_token($token)){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ.']);
            break;
        }
        $driving    = new pDriving();
        $add        = $driving->add_bill();
        if($add['response'] == 200){
            $message = "Tạo bảng kê phát thành công.";
            $telegram->set_chatid($group_id['citypost_refusetrip_test']);
            $telegram->sendMessage($message);
            echo encode_json($add);
            break;
        }else{
            echo encode_json($add);
            break;
        }
        break;
    case 'refusetrip':
        $group_id = [
            'citypost_refusetrip_test'  => '-582736253',
            'citypost_refusetrip_hn'    => '-416213766'
        ];
        $request    = json_decode(file_get_contents('php://input'), true);
        $telegram   = new Telegram('citypost_notice');
        $check      = new user($database);
        /*-----------------------*/
        $token          = $request['token'];    // Token
        $trip           = $request['trip']; // Mã chuyến
        $weight         = $request['weight']; // Trọng lượng, khối lượng
        $driver         = $request['driver']; // Tài xế
        $codriver       = $request['codriver']; // Tài phụ
        $manage         = $request['manage']; // Quản lý
        $refuse         = $request['refuse']; // Lý do từ chối
        $date_create    = $request['date_create']; // Ngày tạo
        $date_refuse    = $request['date_refuse']; // Ngày từ chối
        $location       = $request['location']; // Chi nhánh
        /*-----------------------*/
        if(!$token){
            echo encode_json(['response' => '404', 'message' => 'Thiếu Mã Access Token.']);
            break;
        }
        if(!$check->check_access_token($token)){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ.']);
            break;
        }
        if(!$trip){
            echo encode_json(['response' => '404', 'message' => 'Thiếu Mã TRIP.']);
            break;
        }
        if(!$weight){
            echo encode_json(['response' => '404', 'message' => 'Thiếu trọng lượng.']);
            break;
        }
        if(!$driver){
            echo encode_json(['response' => '404', 'message' => 'Thiếu tài xế.']);
            break;
        }
        if(!$manage){
            echo encode_json(['response' => '404', 'message' => 'Thiếu quản lý.']);
            break;
        }
        if(!$date_create){
            echo encode_json(['response' => '404', 'message' => 'Thiếu ngày tạo.']);
            break;
        }
        if(!$date_refuse){
            echo encode_json(['response' => '404', 'message' => 'Thiếu ngày từ chối.']);
            break;
        }
        $message  = "[THÔNG BÁO TỪ CHỐI CHUYẾN]\n";
        $message .= "Mã chuyến: <b>$trip</b>\n";
        $message .= "Trọng lượng: <b>$weight</b>\n";
        $message .= "Tài xế: <b>$driver</b>\n";
        $message .= $codriver ? "Tài phụ: <b>$codriver</b>\n" : '';
        $message .= "Quản lý: <b>$manage</b>\n";
        $message .= "Lý do từ chối: <b>$refuse</b>\n";
        $message .= "Ngày tạo: <b>$date_create</b>\n";
        $message .= "Ngày từ chối: <b>$date_refuse</b>\n";
        $message .= "Chi nhánh: <b>". ($location ? $location : '---') ."</b>\n";

        $telegram->set_chatid($group_id['citypost_refusetrip_hn']);
        $telegram->sendMessage($message, ['parse_mode' => 'html']);
        echo json_encode(['response' => 200, 'message' => 'Send Message To Telegram Group Success.']);
        break;
    case 'proposed':
        $group_id = [
            'citypost_proposed_test' => '-407900915'
        ];
        $request    = json_decode(file_get_contents('php://input'), true);
        $telegram   = new Telegram('citypost_notice');
        $check      = new user($database);
        /*-----------------------*/
        $user           = $request['user'];         // Người đề xuất.
        $approved_by    = $request['approved_by'];  // Danh sách người duyệt.
        $title          = $request['title'];        // Tiêu đề.
        $content        = $request['content'];      // Nội dung
        $money          = $request['money'];        // Số Tiền
        $token          = $request['token'];    // Token
        /*-----------------------*/
        if(!$token){
            echo encode_json(['response' => '404', 'message' => 'Thiếu Mã Access Token.']);
            break;
        }
        if(!$check->check_access_token($token)){
            echo encode_json(['response' => '503', 'message' => 'Mã Access Token không hợp lệ.']);
            break;
        }
        if(!$user){
            echo encode_json(['response' => '404', 'message' => 'Thiếu người đề xuất.']);
            break;
        }
        if(!$approved_by){
            echo encode_json(['response' => '404', 'message' => 'Thiếu danh sách người duyệt.']);
            break;
        }
        if(!$content){
            echo encode_json(['response' => '404', 'message' => 'Thiếu nội dung.']);
            break;
        }
        if(!$title){
            echo encode_json(['response' => '404', 'message' => 'Thiếu tiêu đề.']);
            break;
        }
        if(!$money){
            echo encode_json(['response' => '404', 'message' => 'Thiếu số tiền.']);
            break;
        }
        /*-----------------------*/
        $list_user = '';
        foreach ($approved_by AS $list_approved){
            $list_user .= "» $list_approved.\n";
        }
        $message  = "[THÔNG BÁO ĐỀ XUẤT].\n";
        $message .= "- Người đề xuất: $user.\n";
        $message .= "- Tiêu đề: $title.\n";
        $message .= "- Nội dung: $content.\n";
        $message .= "- Số tiền: ". convert_number_to_money($money) .".\n";
        $message .= "[DANH SÁCH NGƯỜI DUYỆT]:\n";
        $message .= "$list_user\n";
        $telegram->set_chatid($group_id['citypost_proposed_test']);
        $telegram->sendMessage($message);
        echo json_encode(['response' => 200, 'message' => 'Send Message To Telegram Group Success.']);
        break;
    case 'addoil':
        $group_id = [
            'citypost_addoil_hn' => '-589881611',
            'citypost_addoil_dn' => '-582770353',
            'citypost_addoil_sg' => '-508996637',
            'citypost_addoil_bd' => '-405325125'
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
        switch ($location){
            case 'BƯU CỤC HÀ NỘI':
                $telegram->set_chatid($group_id['citypost_addoil_hn']);
                break;
            case 'BƯU CỤC ĐÀ NẴNG':
                $telegram->set_chatid($group_id['citypost_addoil_dn']);
                break;
            case 'BƯU CỤC HỒ CHÍ MINH':
                $telegram->set_chatid($group_id['citypost_addoil_sg']);
                break;
            case 'BƯU CỤC BÌNH DƯƠNG':
                $telegram->set_chatid($group_id['citypost_addoil_bd']);
                break;
        }
        /*-----------------------*/
        $message .= "[Thông báo đổ dầu]\nLái xe {$request['user']} đổ {$request['amount']} Lít dầu xe {$request['bsx']}.\n";
        $message .= "- Số phiếu: {$request['numbill']}\n";
        $message .= "- Đơn giá: ". convert_number_to_money($request['price']) ."\n";
        $message .= "- Thời gian: ". date('H:i:s d/m/Y') ."\n";
        $message .= "- Chi nhánh: {$request['location']}\n";
        $message .= "-----------------";
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