<?php

class Momo
{
    private $phone;
    private $config = [];
    private $keys, $rsa;
    private $table_account = 'dong_momo_account';
    private $table_account_rows = [
        'account_id' => 'account_id',
        'account_user' => 'account_user',
        'account_phone' => 'account_phone',
        'account_password' => 'account_password',
        'account_name' => 'account_name',
        'account_imei' => 'account_imei',
        'account_aaid' => 'account_aaid',
        'account_token' => 'account_token',
        'account_ohash' => 'account_ohash',
        'account_secureid' => 'account_secureid',
        'account_rkey' => 'account_rkey',
        'account_rowcardId' => 'account_rowcardId',
        'account_authorization' => 'account_authorization',
        'account_agent_id' => 'account_agent_id',
        'account_setupkey_decrypt' => 'account_setupkey_decrypt',
        'account_setupkey' => 'account_setupkey',
        'account_sessionkey' => 'account_sessionkey',
        'account_rsa_public_key' => 'account_rsa_public_key',
        'account_balance' => 'account_balance',
        'account_last_update' => 'account_last_update',
        'account_status' => 'account_status',
        'account_device' => 'account_device',
        'account_hardware' => 'account_hardware',
        'account_facture' => 'account_facture',
        'account_model_id' => 'account_model_id',
        'account_create' => 'account_create'
    ];
    private $url_action = array(
        "CHECK_USER_BE_MSG" => "https://api.momo.vn/backend/auth-app/public/CHECK_USER_BE_MSG",//Check người dùng
        "SEND_OTP_MSG"      => "https://api.momo.vn/backend/otp-app/public/SEND_OTP_MSG",//Gửi OTP
        "REG_DEVICE_MSG"    => "https://api.momo.vn/backend/otp-app/public/REG_DEVICE_MSG",// Xác minh OTP
        "QUERY_TRAN_HIS_MSG" => "https://owa.momo.vn/api/QUERY_TRAN_HIS_MSG", // Check ls giao dịch
        "USER_LOGIN_MSG"     => "https://owa.momo.vn/public/login",// Đăng Nhập
        "QUERY_TRAN_HIS_MSG_NEW" => "https://m.mservice.io/hydra/v1/user/noti",// check ls giao dịch
        "M2MU_INIT"         => "https://owa.momo.vn/api/M2MU_INIT",// Chuyển tiền
        "M2MU_CONFIRM"      => "https://owa.momo.vn/api/M2MU_CONFIRM",// Chuyển tiền
        "LOAN_MSG"          => "https://owa.momo.vn/api/LOAN_MSG",// yêu cầu chuyển tiền
        'M2M_VALIDATE_MSG'  => 'https://owa.momo.vn/api/M2M_VALIDATE_MSG',// Ko rõ chức năng
        'CHECK_USER_PRIVATE'=> 'https://owa.momo.vn/api/CHECK_USER_PRIVATE', // Check người dùng ẩn
        'TRAN_HIS_INIT_MSG' => 'https://owa.momo.vn/api/TRAN_HIS_INIT_MSG', // Rút tiền, chuyển tiền
        'TRAN_HIS_CONFIRM_MSG' => 'https://owa.momo.vn/api/TRAN_HIS_CONFIRM_MSG',// rút tiền chuyển tiền
        'GET_CORE_PREPAID_CARD' => 'https://owa.momo.vn/api/sync/GET_CORE_PREPAID_CARD',
        'ins_qoala_phone'   => 'https://owa.momo.vn/proxy/ins_qoala_phone',
        'GET_DETAIL_LOAN'   => 'https://owa.momo.vn/api/GET_DETAIL_LOAN',// Get danh sách yêu cầu chuyển
        'LOAN_UPDATE_STATUS'=> 'https://owa.momo.vn/api/LOAN_UPDATE_STATUS',// Từ chỗi chuyển tiền
        'CANCEL_LOAN_REQUEST'=> 'https://owa.momo.vn/api/CANCEL_LOAN_REQUEST',// Huỷe chuyển tiền
        'LOAN_SUGGEST'      => 'https://owa.momo.vn/api/LOAN_SUGGEST',
        'STANDARD_LOAN_REQUEST'  => 'https://owa.momo.vn/api/STANDARD_LOAN_REQUEST',
        'SAY_THANKS'        => 'https://owa.momo.vn/api/SAY_THANKS',// Gửi lời nhắn khi nhận tiền
        'HEARTED_TRANSACTIONS'=> 'https://owa.momo.vn/api/HEARTED_TRANSACTIONS',
        'VERIFY_MAP'        => 'https://owa.momo.vn/api/VERIFY_MAP',// Liên kết ngân hàng
        'service'           => "https://owa.momo.vn/service",   // Check ngân hàng qua stk
        'NEXT_PAGE_MSG'     => 'https://owa.momo.vn/api/NEXT_PAGE_MSG', // mua thẻ điện thoại
        'dev_backend_gift-recommend' => 'https://owa.momo.vn/proxy/dev_backend_gift-recommend', // check gift
        'ekyc_init'         => 'https://owa.momo.vn/proxy/ekyc_init',  // Xác minh cmnd
        'ekyc_ocr'          => 'https://owa.momo.vn/proxy/ekyc_ocr', // xác minh cmnd
        'GetDataStoreMsg'   => 'https://owa.momo.vn/api/GetDataStoreMsg', // Get danh sách ngân hàng đã chuyển
        'VOUCHER_GET'       => 'https://owa.momo.vn/api/sync/VOUVHER_GET',// get voucher
        'END_USER_QUICK_REGISTER' => 'https://api.momo.vn/backend/auth-app/public/END_USER_QUICK_REGISTER',// đăng kí
        'AGENT_MODIFY'      => 'https://api.momo.vn/backend/auth-app/api/AGENT_MODIFY',// Cập nhật tên email
        'ekyc_ocr_result'   => 'https://owa.momo.vn/proxy/ekyc_ocr_result',// xác minh cmnd
        'CHECK_INFO'        => 'https://owa.momo.vn/api/CHECK_INFO',// Check hóa đơn
        'BANK_OTP'          => 'https://owa.momo.vn/api/BANK_OTP',// Rút tiền
        'SERVICE_UNAVAILABLE'=> 'https://owa.momo.vn/api/SERVICE_UNAVAILABLE',// Bên bảo mật
        'ekyc_ocr_confirm'  => 'https://owa.momo.vn/proxy/ekyc_ocr_confirm',//Xác minh cmnd
        'sync'              => 'https://owa.momo.vn/api/sync',// Lấy biến động số dư
        'MANAGE_CREDIT_CARD'=> 'https://owa.momo.vn/api/MANAGE_CREDIT_CARD',//Thêm visa marter card
        'UN_MAP'            => 'https://owa.momo.vn/api/UN_MAP',// Hủy liên kết thẻ
        'WALLET_MAPPING'    => 'https://owa.momo.vn/api/WALLET_MAPPING',// Liên kết thẻ
        'NAPAS_CASHIN_INIT_MSG' => 'https://owa.momo.vn/api/NAPAS_CASHIN_INIT_MSG', // Liên kết napas
        "CARD_GET" => "https://owa.momo.vn/api/sync/CARD_GET",// Get thẻ
        'NAPAS_CASHIN_DELETE_TOKEN_MSG' => 'https://owa.momo.vn/api/NAPAS_CASHIN_DELETE_TOKEN_MSG',// Hủy thẻ
        'API_DEFAULT_SOURCE'=> 'https://owa.momo.vn/api/API_DEFAULT_SOURCE',
        'GET_WIDGET'        => 'https://owa.momo.vn/api/GET_WIDGET',
        'QUERY_POINT_HIS_MSG'=> 'https://owa.momo.vn/api/QUERY_POINT_HIS_MSG',
        'GENERATE_TOKEN_AUTH_MSG'   => 'https://api.momo.vn/backend/auth-app/public/GENERATE_TOKEN_AUTH_MSG',
        'GET_TRANS_BY_TID'          => 'https://owa.momo.vn/api/GET_TRANS_BY_TID'
    );
    private $device_config = [
        'samsung' => [
            'device' => 'SM-G532F',
            'hardware' => 'mt6735',
            'facture' => 'samsung',
            'modelid' => 'samsung sm-g532gmt6735r58j8671gsw'
        ]
    ];

    public function __construct($phone)
    {
        $this->phone = $phone;
        // Kiểm tra xem số điện thoại đã tồn tại chưa
        $check_phone = $this->checkIssetPhone($phone);
        if ($check_phone) {
            $this->config = $this->getAccountByPhone($phone);
        } else {
            $add = $this->createAccount($phone);
            if ($add) {
                $this->config = $this->getAccountByPhone($phone);
            }
        }
    }

    // Private Function //

    // Kiểm tra xem số điện thoại đã có trong dữ liệu chưa?
    private function checkIssetPhone($phone)
    {
        global $database;
        $data = $database->select('COUNT(*) AS count')->from($this->table_account)->where($this->table_account_rows['account_phone'], $phone)->fetch_first();
        if ($data['count'] > 0) {
            return true;
        }
        return false;
    }

    // Lấy dữ liệu tài khoản đã lưu trong cơ sở dữ liệu
    private function getAccountByPhone($phone)
    {
        global $database;
        $check_phone = $this->checkIssetPhone($phone);
        if (!$check_phone) {
            return false;
        }
        $data = $database->from($this->table_account)->where($this->table_account_rows['account_phone'], $phone)->fetch_first();
        return $data;
    }

    // Tạo mới tài khoản khi chưa có dữ liệu
    private function createAccount($phone)
    {
        global $database, $me;
        $data = [
            $this->table_account_rows['account_phone'] => $database->escape($phone),
            $this->table_account_rows['account_imei'] => $database->escape($this->generateImei()),
            $this->table_account_rows['account_secureid'] => $database->escape($this->generateSecureId()),
            $this->table_account_rows['account_rkey'] => $database->escape($this->generateRandom(20)),
            $this->table_account_rows['account_aaid'] => $database->escape($this->generateImei()),
            $this->table_account_rows['account_token'] => $database->escape($this->generateToken()),
            $this->table_account_rows['account_device'] => $database->escape($this->device_config['samsung']['device']),
            $this->table_account_rows['account_hardware'] => $database->escape($this->device_config['samsung']['hardware']),
            $this->table_account_rows['account_facture'] => $database->escape($this->device_config['samsung']['facture']),
            $this->table_account_rows['account_model_id'] => $database->escape($this->device_config['samsung']['modelid']),
            $this->table_account_rows['account_user'] => $database->escape($me['user_id']),
            $this->table_account_rows['account_create'] => $database->escape(get_date_time())
        ];
        $action = $database->insert($this->table_account, $data);
        if ($action) {
            return true;
        }
        return false;
    }

    // Tạo mã Token
    private function generateToken()
    {
        return $this->generateRandom(22) . ':' . $this->generateRandom(9) . '-' . $this->generateRandom(20) . '-' . $this->generateRandom(12) . '-' . $this->generateRandom(7) . '-' . $this->generateRandom(7) . '-' . $this->generateRandom(53) . '-' . $this->generateRandom(9) . '_' . $this->generateRandom(11) . '-' . $this->generateRandom(4);
    }

    // Tạo mã Imei
    private function generateImei()
    {
        return $this->generateRandomString(8) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(12);
    }

    // Tạo ký tự ngẫu nhiên
    private function generateRandomString($length = 20)
    {
        $characters = '0123456789abcde';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Tạo mã Secure Id
    private function generateSecureId($length = 17)
    {
        $characters = '0123456789abcde';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Tạo các ký tự ngẫu nhiên
    private function generateRandom($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Tạo mã setupKey
    public function generateSetupKey($setUpKey)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($setUpKey), 'AES-256-CBC', $this->config["account_ohash"], OPENSSL_RAW_DATA, $iv);
    }

    // Tạo pHash
    private function generatepHash()
    {
        $data = $this->config["account_imei"] . "|" . $this->config["account_password"];
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $this->config["account_setupkey_decrypt"], OPENSSL_RAW_DATA, $iv));
    }

    // Tạo mã Checksum
    public function generateCheckSum($type, $microtime)
    {
        $Encrypt = $this->config["account_phone"] . $microtime . '000000' . $type . ($microtime / 1000000000000.0) . 'E12';
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($Encrypt, 'AES-256-CBC', $this->config["account_setupkey_decrypt"], OPENSSL_RAW_DATA, $iv));
    }

    // Lấy Microtime
    private function generateMicrotime()
    {
        return round(microtime(true) * 1000);
    }

    // Tạo mã String
    private function convertString($data)
    {
        return str_replace(array('<', "'", '>', '?', '/', "\\", '--', 'eval(', '<php', '-'), array('', '', '', '', '', '', '', '', '', ''), htmlspecialchars(addslashes(strip_tags($data))));
    }

    private function RSA_Encrypt($key, $content)
    {
        if (empty($this->rsa)) {
            $this->includeRsa($key);
        }
        return base64_encode($this->rsa->encrypt($content));
    }

    // CURL
    private function curl($action, $header, $data)
    {
        $curl = curl_init();
        $header[] = 'Content-Type: application/json';
        $header[] = 'accept: application/json';
        $opt = array(
            CURLOPT_URL => $this->url_action[$action],
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => is_array($data) ? json_encode($data) : $data,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 20
        );
        curl_setopt_array($curl, $opt);
        $body = curl_exec($curl);
        if (is_object(json_decode($body))) {
            return json_decode($body, true);
        }
        return json_decode($this->decryptData($body), true);
    }

    private function Encrypt_data($data, $key)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $this->keys = $key;
        return base64_encode(openssl_encrypt(is_array($data) ? json_encode($data) : $data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));

    }

    private function decryptData($data)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $this->keys, OPENSSL_RAW_DATA, $iv);
    }

    private function includeRsa($key)
    {
        require(dirname(__FILE__) . '/lib/RSA/Crypt/RSA.php');
        $this->rsa = new Crypt_RSA();
        $this->rsa->loadKey($key);
        $this->rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        return $this;
    }

    // Thêm 1 thiết bị mới khi nhập OTP
    private function registerDevice()
    {
        $microtime = $this->generateMicrotime();
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: REG_DEVICE_MSG",
            "Host: owa.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );
        $Data = '{
            "user": "' . $this->config["account_phone"] . '",
            "msgType": "REG_DEVICE_MSG",
            "cmdId": "' . $microtime . '000000",
            "lang": "vi",
            "time": ' . $microtime . ',
            "channel": "APP",
            "appVer": 30261,
            "appCode": "3.0.26",
            "deviceOS": "ANDROID",
            "buildNumber": 0,
            "appId": "vn.momo.platform",
            "result": true,
            "errorCode": 0,
            "errorDesc": "",
            "momoMsg": {
              "_class": "mservice.backend.entity.msg.RegDeviceMsg",
              "number": "' . $this->config["account_phone"] . '",
              "imei": "' . $this->config["account_imei"] . '",
              "cname": "Vietnam",
              "ccode": "084",
              "device": "' . $this->config["account_device"] . '",
              "firmware": "23",
              "hardware": "' . $this->config["account_hardware"] . '",
              "manufacture": "' . $this->config["account_facture"] . '",
              "csp": "",
              "icc": "",
              "mcc": "",
              "device_os": "Android",
              "secure_id": "' . $this->config["account_secureid"] . '"
            },
            "extra": {
              "ohash": "' . $this->config['account_ohash'] . '",
              "AAID": "' . $this->config["account_aaid"] . '",
              "IDFA": "",
              "TOKEN": "' . $this->config["account_token"] . '",
              "SIMULATOR": "",
              "SECUREID": "' . $this->config["account_secureid"] . '",
              "MODELID": "' . $this->config["account_model_id"] . '",
              "checkSum": ""
            }
          }';
        return $this->curl("REG_DEVICE_MSG", $header, $Data);
    }

    // Check Tài Khoản nhận tiền
    private function checkUserPrivate($phone_receiver)
    {
        $microtime = $this->generateMicrotime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["account_rsa_public_key"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["account_agent_id"],
            "user_phone: " . $this->config["account_phone"],
            "sessionkey: " . $this->config["account_sessionkey"],
            "authorization: Bearer " . $this->config["account_authorization"],
            "msgtype: CHECK_USER_PRIVATE",
            "userid: " . $this->config["account_phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = '{
            "user":"' . $this->config['account_phone'] . '",
            "msgType":"CHECK_USER_PRIVATE",
            "cmdId":"' . $microtime . '000000",
            "lang":"vi",
            "time":' . $microtime . ',
            "channel":"APP",
            "appVer":30261,
            "appCode":"3.0.26",
            "deviceOS":"ANDROID",
            "buildNumber":1916,
            "appId":"vn.momo.transfer",
            "result":true,
            "errorCode":0,
            "errorDesc":"",
            "momoMsg":
            {
                "_class":"mservice.backend.entity.msg.LoginMsg",
                "getMutualFriend":false
            },
            "extra":
            {
                "CHECK_INFO_NUMBER":"' . $phone_receiver . '",
                "checkSum":"' . $this->generateCheckSum('CHECK_USER_PRIVATE', $microtime) . '"
            }
        }';
        $data = $this->curl("CHECK_USER_PRIVATE", $header, $this->Encrypt_data($Data, $requestkeyRaw));
        return $data;
    }

    // Kiểm tra thông tin trước khi chuyển khoản
    private function m2muInit($data)
    {
        $microtime = $this->generateMicrotime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["account_rsa_public_key"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["account_agent_id"],
            "user_phone: " . $this->config["account_phone"],
            "sessionkey: " . $this->config["account_sessionkey"],
            "authorization: Bearer " . $this->config["account_authorization"],
            "msgtype: M2MU_INIT",
            "userid: " . $this->config["account_phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['account_phone'],
            'msgType' => 'M2MU_INIT',
            'cmdId' => (string)$microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => 30261,
            'appCode' => '3.0.26',
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
                array(
                    'serviceId' => 'transfer_p2p',
                    'serviceCode' => 'transfer_p2p',
                    'clientTime' => (int)($microtime - 211),
                    'tranType' => 2018,
                    'comment' => $data['comment'],
                    'ref' => '',
                    'amount' => $data['amount'],
                    'partnerId' => $data['receiver'],
                    '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                    'tranList' =>
                        array(
                            0 =>
                                array(
                                    'partnerName' => $data['partnerName'],
                                    'partnerId' => $data['receiver'],
                                    'originalAmount' => $data['amount'],
                                    '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                                    'tranType' => 2018,
                                    'comment' => $data['comment'],
                                    'moneySource' => 1,
                                    'partnerCode' => 'momo',
                                    'serviceMode' => 'transfer_p2p',
                                    'serviceId' => 'transfer_p2p',
                                    'extras' => '{"appSendChat":false,"vpc_CardType":"SML","vpc_TicketNo":"116.111.45.91","vpc_PaymentGateway":""}',
                                ),
                        ),
                    'extras' => '{"appSendChat":false,"vpc_CardType":"SML","vpc_TicketNo":"116.111.45.91","vpc_PaymentGateway":""}',
                    'moneySource' => 1,
                    'partnerCode' => 'momo',
                    'rowCardId' => '',
                    'giftId' => '',
                    'useVoucher' => 0,
                    'prepaidIds' => '',
                    'usePrepaid' => 0,
                ),
            'extra' =>
                array(
                    'checkSum' => $this->generateCheckSum('M2MU_INIT', $microtime),
                ),
        );
        $result = $this->curl("M2MU_INIT", $header, $this->Encrypt_data($Data, $requestkeyRaw));
        return $result;
    }

    // Xác nhận giao dịch
    private function m2muConfirm($id, $data_init)
    {
        $microtime = $this->generateMicrotime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["account_rsa_public_key"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["account_agent_id"],
            "user_phone: " . $this->config["account_phone"],
            "sessionkey: " . $this->config["account_sessionkey"],
            "authorization: Bearer " . $this->config["account_authorization"],
            "msgtype: M2MU_INIT",
            "userid: " . $this->config["account_phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['account_phone'],
            'pass' => $this->config['account_password'],
            'msgType' => 'M2MU_CONFIRM',
            'cmdId' => (string)$microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => 30261,
            'appCode' => '3.0.26',
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
                array(
                    'ids' =>
                        array(
                            0 => $id,
                        ),
                    'totalAmount' => $data_init['amount'],
                    'originalAmount' => $data_init['amount'],
                    'originalClass' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                    'originalPhone' => $this->config['account_phone'],
                    'totalFee' => '0.0',
                    'id' => $id,
                    'GetUserInfoTaskRequest' => $data_init['receiver'],
                    'tranList' =>
                        array(
                            0 =>
                                array(
                                    '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                                    'user' => $this->config['account_phone'],
                                    'clientTime' => (int)($microtime - 211),
                                    'tranType' => 36,
                                    'amount' => (int)$data_init['amount'],
                                    'receiverType' => 1,
                                ),
                            1 =>
                                array(
                                    '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                                    'user' => '0977371507',
                                    'clientTime' => (int)($microtime - 211),
                                    'tranType' => 36,
                                    'partnerId' => $data_init['receiver'],
                                    'amount' => 100,
                                    'comment' => '',
                                    'ownerName' => $this->config['account_name'],
                                    'receiverType' => 0,
                                    'partnerExtra1' => '{"totalAmount":' . $data_init['amount'] . '}',
                                    'partnerInvNo' => 'borrow',
                                ),
                        ),
                    'serviceId' => 'transfer_p2p',
                    'serviceCode' => 'transfer_p2p',
                    'clientTime' => (int)($microtime - 211),
                    'tranType' => 2018,
                    'comment' => '',
                    'ref' => '',
                    'amount' => $data_init['amount'],
                    'partnerId' => $data_init['receiver'],
                    'bankInId' => '',
                    'otp' => '',
                    'otpBanknet' => '',
                    '_class' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                    'extras' => '{"appSendChat":false,"vpc_CardType":"SML","vpc_TicketNo":"116.111.45.91"","vpc_PaymentGateway":""}',
                ),
            'extra' =>
                array(
                    'checkSum' => $this->generateCheckSum('M2MU_CONFIRM', $microtime),
                ),
        );
        return $this->curl("M2MU_CONFIRM", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    // LOAN
    private function LOAN_MSG($input)
    {
        $microtime = $this->generateMicrotime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["account_rsa_public_key"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["account_agent_id"],
            "user_phone: " . $this->config["account_phone"],
            "sessionkey: " . $this->config["account_sessionkey"],
            "authorization: Bearer " . $this->config["account_authorization"],
            "msgtype: M2MU_INIT",
            "userid: " . $this->config["account_phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            "user" => $this->config["account_phone"],
            "msgType" => "LOAN_MSG",
            "cmdId" => (string)$microtime . "000000",
            "lang" => "vi",
            "time" => $microtime,
            "channel" => "APP",
            "appVer" => 30261,
            "appCode" => "3.0.26",
            "deviceOS" => "ANDROID",
            "buildNumber" => 1874,
            "appId" => "vn.momo.platform",
            "result" => true,
            "errorCode" => 0,
            "errorDesc" => "",
            "momoMsg" => array(
                "_class" => "mservice.backend.entity.msg.M2MUInitMsg",
                "tranList" => [
                    array(
                        "_class" => "mservice.backend.entity.msg.TranHisMsg",
                        "user" => $this->config["account_phone"],
                        "clientTime" => ($microtime - 251),
                        "tranType" => 36,
                        "amount" => $input["amount"],
                        "receiverType" => 1
                    ),
                    array(
                        "_class" => "mservice.backend.entity.msg.TranHisMsg",
                        "user" => $this->config["account_phone"],
                        "clientTime" => ($microtime - 251),
                        "tranType" => 36,
                        "partnerId" => $input["receiver"],
                        "amount" => $input["amount"],
                        "comment" => $input["comment"],
                        "ownerName" => "",
                        "receiverType" => 0,
                        "partnerExtra1" => '{\"totalAmount\":' . $input["amount"] . '}',
                        "partnerInvNo" => "borrow"
                    )
                ]
            ),
            "extra" => array(
                "checkSum" => $this->generateCheckSum("LOAN_MSG", $microtime)
            )
        );
        return $this->curl("LOAN_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    // Public Function //

    // Tạo lệnh gửi OTP
    public function sendOtp()
    {
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: SEND_OTP_MSG",
            "Host: owa.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );
        $microtime = $this->generateMicrotime();
        $data = '{
            "user": "' . $this->config['account_phone'] . '",
            "msgType": "SEND_OTP_MSG",
            "cmdId": "' . $microtime . '000000",
            "lang": "vi",
            "time": ' . $microtime . ',
            "channel": "APP",
            "appVer": 30261,
            "appCode": "3.0.26",
            "deviceOS": "ANDROID",
            "buildNumber": 0,
            "appId": "vn.momo.platform",
            "result": true,
            "errorCode": 0,
            "errorDesc": "",
            "momoMsg": {
              "_class": "mservice.backend.entity.msg.RegDeviceMsg",
              "number": "' . $this->config["account_phone"] . '",
              "imei": "' . $this->config["account_imei"] . '",
              "cname": "Vietnam",
              "ccode": "084",
              "device": "' . $this->config["account_device"] . '",
              "firmware": "23",
              "hardware": "' . $this->config["account_hardware"] . '",
              "manufacture": "' . $this->config["account_facture"] . '",
              "csp": "",
              "icc": "",
              "mcc": "",
              "device_os": "Android",
              "secure_id": "' . $this->config["account_secureid"] . '"
            },
            "extra": {
              "action": "SEND",
              "rkey": "' . $this->config["account_rkey"] . '",
              "AAID": "' . $this->config["account_aaid"] . '",
              "IDFA": "",
              "TOKEN": "' . $this->config["account_token"] . '",
              "SIMULATOR": "",
              "SECUREID": "' . $this->config["account_secureid"] . '",
              "MODELID": "' . $this->config["account_model_id"] . '",
              "isVoice": false,
              "REQUIRE_HASH_STRING_OTP": true,
              "checkSum": ""
            }
          }';
        $data = $this->curl("SEND_OTP_MSG", $header, $data);
        if ($data['errorDesc'] == 'Thành công') {
            return true;
        }
        return false;
    }

    // Lưu mã và mật khẩu
    public function savetAccout($code, $password)
    {
        global $database;
        $this->config['account_ohash'] = hash('sha256', $this->config["account_phone"] . $this->config["account_rkey"] . $code);
        $data_update = [
            $this->table_account_rows['account_ohash'] => $this->config['account_ohash']
        ];
        $database->where([$this->table_account_rows['account_phone'] => $this->config["account_phone"]])->update($this->table_account, $data_update);
        $result = $this->registerDevice();
        if ($result['errorCode']) {
            return get_response_array($result['errorCode'], $result['errorDesc']);
        }
        if (!$result) {
            return get_response_array(404, 'Thời gian truy cập đã hết hạn, vui lòng đăng nhập lại.');
        }
        $setupKey = $result["extra"]["setupKey"];
        $setupKeyDecrypt = $this->generateSetupKey($setupKey);
        $data_update = [
            $this->table_account_rows['account_password'] => $database->escape($password),
            $this->table_account_rows['account_setupkey'] => $database->escape($setupKey),
            $this->table_account_rows['account_setupkey_decrypt'] => $database->escape($setupKeyDecrypt)
        ];
        $update = $database->where([$this->table_account_rows['account_phone'] => $this->config["account_phone"]])->update($this->table_account, $data_update);
        if (!$update) {
            return get_response_array(208, 'Lưu mã OTP không thành công.');
        }
        // Làm mới config
        $this->config = $this->getAccountByPhone($this->config["account_phone"]);
        $balance = $this->getBalance();
        return $balance;
    }

    // Lấy thông tin tài khoản
    public function getBalance()
    {
        global $database;
        $microtime = $this->generateMicrotime();
        $header = array(
            "agent_id: " . $this->config["account_agent_id"],
            "user_phone: " . $this->config["account_phone"],
            "sessionkey: " . (!empty($this->config["account_sessionkey"])) ? $this->config["account_sessionkey"] : "",
            "authorization: Bearer " . $this->config["account_authorization"],
            "msgtype: USER_LOGIN_MSG",
            "Host: owa.momo.vn",
            "user_id: " . $this->config["account_phone"],
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );
        $Data = '{
            "user": "' . $this->config["account_phone"] . '",
            "msgType": "USER_LOGIN_MSG",
            "pass": "' . $this->config["account_password"] . '",
            "cmdId": "' . $microtime . '000000",
            "lang": "vi",
            "time": ' . (int)$microtime . ',
            "channel": "APP",
            "appVer": 30261,
            "appCode": "3.0.26",
            "deviceOS": "ANDROID",
            "buildNumber": 0,
            "appId": "vn.momo.platform",
            "result": true,
            "errorCode": 0,
            "errorDesc": "",
            "momoMsg": {
              "_class": "mservice.backend.entity.msg.LoginMsg",
              "isSetup": false
            },
            "extra": {
              "pHash": "' . $this->generatepHash() . '",
              "AAID": "' . $this->config["account_aaid"] . '",
              "IDFA": "",
              "TOKEN": "' . $this->config["account_token"] . '",
              "SIMULATOR": "",
              "SECUREID": "' . $this->config["account_secureid"] . '",
              "MODELID": "' . $this->config["account_model_id"] . '",
              "checkSum": "' . $this->generateCheckSum("USER_LOGIN_MSG", $microtime) . '"
            }
          }';
        $data = $this->CURL("USER_LOGIN_MSG", $header, $Data);
        if ($data['errorCode']) {
            $data_update = [
                $this->table_account_rows['account_last_update'] => get_date_time(),
                $this->table_account_rows['account_status'] => 'inactive'
            ];
            $database->where([$this->table_account_rows['account_phone'] => $this->config["account_phone"]])->update($this->table_account, $data_update);
            return get_response_array($data['errorCode'], $data['errorDesc']);
        }
        if (!$data) {
            $data_update = [
                $this->table_account_rows['account_last_update'] => get_date_time(),
                $this->table_account_rows['account_status'] => 'inactive'
            ];
            $database->where([$this->table_account_rows['account_phone'] => $this->config["account_phone"]])->update($this->table_account, $data_update);
            return get_response_array(404, 'Thời gian truy cập đã hết hạn, vui lòng đăng nhập lại.');
        }
        $extra = $data["extra"];
        $data_update = [
            $this->table_account_rows['account_authorization'] => $database->escape($extra["AUTH_TOKEN"]),
            $this->table_account_rows['account_agent_id'] => $database->escape($data["momoMsg"]["agentId"]),
            $this->table_account_rows['account_rsa_public_key'] => $database->escape($extra["REQUEST_ENCRYPT_KEY"]),
            $this->table_account_rows['account_balance'] => $database->escape($extra["BALANCE"]),
            $this->table_account_rows['account_last_update'] => get_date_time(),
            $this->table_account_rows['account_status'] => 'active',
            $this->table_account_rows['account_sessionkey'] => $database->escape($extra["SESSION_KEY"])
        ];
        $update = $database->where([$this->table_account_rows['account_phone'] => $this->config["account_phone"]])->update($this->table_account, $data_update);
        if (!$update) {
            return get_response_array(208, 'Login không thành công.');
        }
        return ['response' => 200, 'message' => 'Lấy số dư thành công', 'balance' => $extra["BALANCE"]];
    }

    // Lấy lịch sử giao dịch
    public function getTransactionHistory($day = 5)
    {
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["account_rsa_public_key"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["account_agent_id"],
            "user_phone: " . $this->config["account_phone"],
            "sessionkey: " . $this->config["account_sessionkey"],
            "authorization: Bearer " . $this->config["account_authorization"],
            "msgtype: QUERY_TRAN_HIS_MSG",
            "userid: " . $this->config["account_phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );

        $begin = (time() - (86400 * $day)) * 1000;
        $microtime = $this->generateMicrotime();
        $Data = array(
            'user' => $this->config['account_phone'],
            'msgType' => 'QUERY_TRAN_HIS_MSG',
            'cmdId' => $microtime . '000000',
            'time' => $microtime,
            'lang' => 'vi',
            'channel' => 'APP',
            'appVer' => 30261,
            'appCode' => '3.0.26',
            'deviceOS' => 'ANDROID',
            'result' => true,
            'buildNumber' => 0,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
                array(
                    'checkSum' => $this->generateCheckSum('QUERY_TRAN_HIS_MSG', $microtime),
                ),
            'momoMsg' =>
                array(
                    '_class' => 'mservice.backend.entity.msg.QueryTranhisMsg',
                    'begin' => $begin,
                    'end' => $microtime,
                ),
        );
        $data = $this->curl("QUERY_TRAN_HIS_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));

        // Nếu lỗi thì thông báo
        if ($data['errorCode']) {
            return [
                'response' => $data['errorCode'],
                'message' => $data['errorDesc'],
                'detail' => $data
            ];
            //return get_response_array($data['errorCode'], $data['errorDesc']);
        }
        if (!$data) {
            return get_response_array(404, 'Thời gian truy cập đã hết hạn, vui lòng đăng nhập lại.');
        }
        return ['response' => '200', 'message' => 'Lấy lịch sử giao dịch thành công', 'data' => $data['momoMsg']['tranList']];
    }

    // Chuyển tiền
    public function sendMoney($receiver_phone, $amount = 100, $comment = "")
    {
        $check_user_private = $this->checkUserPrivate($receiver_phone);
        // Nếu lỗi thì thông báo
        if ($check_user_private['errorCode']) {
            return get_response_array($check_user_private['errorCode'], $check_user_private['errorDesc']);
        }
        if (!$check_user_private) {
            return get_response_array(404, 'Thời gian truy cập đã hết hạn, vui lòng đăng nhập lại.');
        }

        $data_m2mu = array(
            "amount" => (int)$amount,
            "comment" => $this->convertString($comment),
            "receiver" => $receiver_phone,
            "partnerName" => $check_user_private["extra"]["NAME"]
        );
        $m2mu_init = $this->m2muInit($data_m2mu);
        // Nếu lỗi thì thông báo
        if ($m2mu_init['errorCode']) {
            return get_response_array($m2mu_init['errorCode'], $m2mu_init['errorDesc']);
        }
        if (!$m2mu_init) {
            return get_response_array(404, 'Thời gian truy cập đã hết hạn, vui lòng đăng nhập lại.');
        }

        $id = $m2mu_init["momoMsg"]["replyMsgs"]["0"]["ID"];
        $m2mu_confirm = $this->m2muConfirm($id, $data_m2mu);
        $tranHisMsg = $m2mu_confirm["momoMsg"]["replyMsgs"]["0"]["tranHisMsg"];

        if ($tranHisMsg["status"] != 999) {
            return [
                'response'  => 208,
                'message'   => $tranHisMsg["desc"],
                "id"        => $tranHisMsg["ID"],
                "tranId"    => $tranHisMsg["tranId"],
                "amount"    => $tranHisMsg["amount"],
            ];
        }
        return [
            'response'  => 200,
            'message'   => $tranHisMsg["desc"],
            "id"        => $tranHisMsg["ID"],
            "tranId"    => $tranHisMsg["tranId"],
            "amount"    => $tranHisMsg["amount"],
        ];
    }

    // Yêu Cầu Chuyển Tiền
    public function requestMoney($receiver_phone, $amount = 100, $comment = "")
    {
        $input = array(
            "amount" => (int)$amount,
            "comment" => $this->convertString($comment),
            "receiver" => $receiver_phone,
        );
        $result = $this->LOAN_MSG($input);
        // Nếu lỗi thì thông báo
        if ($result['errorCode']) {
            return get_response_array($result['errorCode'], $result['errorDesc']);
        }
        if (!$result) {
            return get_response_array(404, 'Thời gian truy cập đã hết hạn, vui lòng đăng nhập lại.');
        }

        if ($result['errorDesc'] != 'Thành công') {
            return get_response_array(208, $result['errorDesc']);
        }
        return get_response_array(200, 'Yêu cầu chuyển tiền thành công');
    }

    // Check Lịch sử giao dịch nhận tiền
    public function getTransactionReceive($day = 5){
        $begin = (time() - (86400 * $day)) * 1000;
        $header = array(
            "authorization: Bearer " . $this->config["account_authorization"],
            "user_phone: " . $this->config["account_phone"],
            "Host: m.mservice.io"
        );
        $Data = '{
            "userId": "' . $this->config["account_phone"] . '",
            "fromTime": ' . $begin . ',
            "toTime": ' . $this->generateMicrotime() . ',
            "limit": 500,
            "cursor": ""
        }';
        $result = $this->curl("QUERY_TRAN_HIS_MSG_NEW", $header, $Data);
        if(!is_array($result)){
            return [
                'response'  => 404,
                'message'   => 'Hết thời gian truy cập vui lòng đăng nhập lại',
                'detail'    => $result
            ];
        }
        $tranHisMsg =  $result["message"]["data"]["notifications"];
        $data = [];
        foreach ($tranHisMsg AS $row){
            if($row['type'] == 77){
                $extra = json_decode($row["extra"],true);
                $data[]= [
                    'user'          => $this->config['account_phone'],
                    'tranId'        => $extra['tranId'],
                    'io'            => 1,
                    'partnerId'     => $extra["partnerId"],
                    'partnerName'   => $extra["partnerName"],
                    'amount'        => (int)str_replace('.0','',$extra["amount"]),
                    'desc'          => 'Thành công',
                    'comment'       => $extra['comment'],
                    'status'        => '999',
                    'finishTime'    => $row['time']
                ];
            }
        }
        return [
            'response'  => '200',
            'message'   => 'Success',
            'data'      => $data
        ];
    }
}