<?php
switch ($path[2]){
    case 'delete':
        if(!$role['momo']['manager']){
            exit('Forbidden');
        }
        $account    = new MomoAccount();
        $action     = $account->deleteAccount($path[3]);
        echo encode_json($action);
        break;
    case 'add':
        if(!$role['momo']['add']){
            exit('Forbidden');
        }
        switch ($path[3]){
            case 'sendotp':
                $account_phone = $_REQUEST['account_phone'];
                if(strlen($account_phone) != 10){
                    echo encode_json(['response' => 309, 'message' => 'Số điện thoại phải đúng 10 ký tự.']);
                    break;
                }
                $account = new MomoAccount();
                if(!$account->checkPhoneNumber($account_phone)){
                    echo encode_json(['response' => 309, 'message' => 'Số điện thoại không đúng định dạng.']);
                    break;
                }
                $momo       = new Momo($account_phone);
                $sendotp    = $momo->sendOtp();

                if(!$sendotp){
                    echo encode_json(['response' => 208, 'message' => 'Gửi OTP không thành công.']);
                    break;
                }
                echo encode_json(['response' => 200, 'message' => 'Gửi OTP đến số điện thoại '.$account_phone.' thành công.']);
                break;
            case 'save_account':
                $account_phone      = $_REQUEST['account_phone'];
                $account_otp        = $_REQUEST['account_otp'];
                $account_password   = $_REQUEST['account_password'];
                if(strlen($account_phone) != 10){
                    echo encode_json(['response' => 309, 'message' => 'Số điện thoại phải đúng 10 ký tự.']);
                    break;
                }
                if(strlen($account_otp) != 4){
                    echo encode_json(['response' => 309, 'message' => 'Mã OTP phải đúng 4 ký tự.']);
                    break;
                }
                if(strlen($account_password) != 6){
                    echo encode_json(['response' => 309, 'message' => 'Mật khẩu phải đúng 6 ký tự.']);
                    break;
                }
                $account = new MomoAccount();
                if(!$account->checkPhoneNumber($account_phone)){
                    echo encode_json(['response' => 309, 'message' => 'Số điện thoại không đúng định dạng.']);
                    break;
                }
                $momo       = new Momo($account_phone);
                $save_otp   = $momo->savetAccout($account_otp, $account_password);
                if($save_otp['response'] != 200){
                    echo encode_json(['response' => $save_otp['response'], 'message' => $save_otp['message']]);
                    break;
                }
                echo encode_json(['response' => 200, 'message' => 'Đăng nhập thành công. Số dư hiện tại: '.convert_number_to_money($save_otp['balance'])]);
                break;
        }
        break;
}
