<?php

class MOMO

{

    //Đưa dữ liệu vào
    private $config = array();
    //Kết nối Database
    private $connect;

    private $BankId = array(
        'BIDV' => array(
            'partnerCode' => '110',
        ),
        'VTB'  => array(
            'partnerCode' => '102',
        ),
        'MB'   => array(
            'partnerCode' => '301',
        ),
        'ACB'  => array(
            'partnerCode' => '115',
        ),
        'VCB'  => array(
            'partnerCode' => '12345',
        ),
        'ACB'  => array(
            'partnerCode' => '111',
        ),
        'VPB'  => array(
            'partnerCode' => '103',
        ),
        'VIB'  => array(
            'partnerCode' => '113',
        ),
        'EXB'  => array(
            'partnerCode' => '107',
        ),
        'OCB'  => array(
            'partnerCode' => '104',
        ),
        'SCB'  => array(
            'partnerCode' => '111',
        ),

    );

    private $servicer = '["evn_quangtri","evn_phuyen","evn_daknong","evn_khanhhoa","evn_danang","evn_daklak","evn_quangbinh","evn_kontum","evnspc_cantho","evn_quangnam","EVN_HANOI_V2","evn_hcm_bk","EVN_HANOI","evnspc_travinh","evnspc_soctrang","evnspc_lamdong","evn_mien_nam","evn_mien_trung","evnspc_longan","evnspc_miennam","evnspc_dongthap","evnspc_tiengiang","EVN_HANOI_NEW","evnspc_tayninh","evn_npc","evnspc_ninhthuan","evn_gialai","evn_quangngai","evnspc_binhthuan","evnspc_angiang","evn_hcm","evnspc_kiengiang","angiang_electric","evn_binhdinh","evnspc_vinhlong","evnspc_haugiang","evnspc_bentre","evn_hue","evnspc_baclieu","evnspc_binhphuoc","evn_npc_v2","evnspc_dongnai","evnspc_binhduong","evnspc_camau","evnspc_vungtau","thuducwaco","NUOCBENTHANH","THWATER","HUE_WATER","dongthapwater","nuocdanang","NUOCCHOLON","WATER_HCM","cantho_water","HUE_WATER_BK","viwaco","NUOCNB_BK","PHTWATER","TAWATER","hawacom_water","tayhanoi_water","sonla_water","binhphuoc_water","haiphong_water","nshn3","gialai_water","dongnai_water","sontay_water","nshn2","hoabinh_water","lamdong_water","bienhoa_water","biwase_water","kiengiang_water","bentre_water","NUOCNB","nong_thon_water","hungyen_water","bacninh_water","dongtienthanh_water","hungyen_water_v2","vinhphuc_water","travinh_water","bwaco","khanhhoa_water","angiang_water","tiengiang_water","dienbien_water","caobang_water","namdinh_water","daklak_water","binhthuan_water","quangninh_water","TDWATER","baclieu_water","duytien_water","vanninh_water","thanhoai_water","baria_water","giadinhwater","yenkhanh_water","haiduong_water","tiengiang_water_v2","TAWATER_V2","bacgiang_water","cantho2_water","danphuong_water","tanviet_water","quangngai_water","mtdt_hue","chaugiang_water","hagiang_water","haugiang_water","huyphat_water","quangnam_water","tayninh_water","hanam_water","vinhlong_water","haiphongv2_water","longan_water","nghean_water","langson_water","quangbinh_water","quangtri_water","haugiang2_water","laichau_water","cuchi_water","phumy_water","hadong_water","hadong_water_v2","CAT_21","evn","evn_thainguyen","evnldg_dalat","CAT_22","MOMOD5B120180926","nuocsachvts","folder_nuoc_mien_bac","huds_water","tht_water","khaservice_apartment","anvien","SCTVCAB","VTV_EXTENSION","VTVCAB","my_tv","htvc","kplus_v2","SCTVCAB_V2","CDHCM","CDHN","IFPT","napas_stc_paybill","vnnfiber","vnpt_daklak","vnpt_danang","vnpt_hue","vnpt_quangbinh","vnpt_quangnam","vnpt_quangngai","vnpt_toan_quoc","napas_sstadsl_paybill","IFPT_bk","chungcu584_cc","savista","savista_4slinhdong","ttc_land","ttc_land_belleza","ttc_land_carillon3","ttc_land_carillon5","ttc_land_jamonacity","ttc_land_jamonagoldensilk","ttc_land_jamonaheight","ttc_land_jamonaresort","ttc_land_lapointe","ttc_land_sunview","himlam_apartment","phuc_yen1_apartment","pdpremier_apartment","lucky_palace_apartment","everrich_infinity_apartment","grand_riverside_apartment","calla_garden_apartment","an_gia_riverside_apartment","garden_plaza1&2_apartment","green_view_apartment","la_casa_apartment","my_khang_apartment","sggw_apartment","hung_vuong2_apartment","galaxy9_apartment","bee_home_apartment","thu_ho_MOMOSP1120190723","ttc_land_carillon7","conn_topup_trasau_viettel","mobifonetrasau","mobitrasau","napas_mobifone_paybill","VINAHCM","VINAHCM_v2","caothang_school_fees","hcc_danang","ssc_school_fees","edulink_school","vtvcab_on","thu_ho_MOMOPUND20200203"]';

    private $ohash;

    private $TimeSetUp = 600; // seconds

    private $amount = 100000;

    private $day = 200;

    private $keys;

    private $send = array();

    private $rsa;

    private $URLAction = array(
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
    protected $proxy = null;


    public function LoadData($phone)
    {
        $select = $this->connect->query("SELECT * FROM `table_momo` WHERE `phone` = '".$phone."' LIMIT 1 ");
        if($select->num_rows == 0){
            $this->CheckUser($phone);
            return $this;
        }
        $this->config = $select->fetch_assoc();
        return $this;
    }

    public function __construct($database_name, $username, $password, $host = 'localhost', $proxy = '')
    {
        $this->connect = mysqli_connect($host, $username, $password, $database_name);
        if(!empty($proxy)) $this->proxy = trim($proxy);
        return $this;
    }

    public function CheckUser($phone)
    {
        try {
            $select = $this->connect->query("SELECT * FROM `table_momo` WHERE `phone` = '".$phone."' ");
        }
        catch (\Throwable $e) {
            echo JsonStringFy(array(
                'status' => 'error',
                'message'=> 'Vui lòng thêm bảng table_momo để gửi giữ liệu lên'
            ));
            die();
        }


        if($select->num_rows >= 1){
            $this->connect->query("UPDATE `table_momo` SET `agent_id` = 'underfined',
                                                          `sessionkey` = '',
                                                          `authorization` = 'underfined' WHERE `phone` = '$phone' ");
        }else if($select->num_rows == 0){
            try{
                $device = $this->connect->query("SELECT * FROM `device` ORDER BY RAND() LIMIT 1 ")->fetch_assoc();
            }
            catch (\Throwable $e) {
                echo JsonStringFy(array(
                    'status' => 'error',
                    'message'=> 'Vui lòng thêm bảng device để lấy thông tin thiết bị'
                ));
                die();
            }

            $device_info = sprintf($device["MODELID"], $this->generateRandom(20));
            $this->connect->query("INSERT INTO `table_momo` SET `phone` = '".$phone."',
                                                               `imei` = '".$this->generateImei()."',
                                                               `SECUREID` = '".$this->get_SECUREID()."',
                                                               `rkey` = '".$this->generateRandom(20)."',
                                                               `AAID` = '".$this->generateImei()."',
                                                               `TOKEN` = '".$this->get_TOKEN()."',
                                                               `device` = '".$device["device"]."',
                                                               `hardware` = '".$device["hardware"]."',
                                                               `facture` = '".$device["facture"]."',
                                                               `MODELID` = '".$device_info."' ");

        }
        $this->config = $this->connect->query("SELECT * FROM `table_momo` WHERE `phone` = '".$phone."' LIMIT 1 ")->fetch_assoc();
        return $this;
    }

    public function ImportProxy($proxy)
    {
        $this->proxy = trim($proxy);
        return $this;
    }

    public function CheckBeUser()
    {
        $result = $this->CHECK_USER_BE_MSG();
        if(empty($result)){
            return array(
                'status' => 'error',
                'message'=> 'Đã xảy ra lỗi máy chủ xin vui lòng thử lại'
            );
        }
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }
        return array(
            "status"  => "success",
            "message" => "Thành công"
        );

    }

    public function SendOTP()
    {
        $result = $this->SEND_OTP_MSG();
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }
        else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        return array(
            "status"  => "success",
            "message" => "Thành công"
        );

    }

    public function ImportOTP($code)
    {
        $this->config['ohash'] = hash('sha256',$this->config["phone"].$this->config["rkey"].$code);
        $this->connect->query("UPDATE `table_momo` SET `ohash` = '".$this->config['ohash']."' WHERE `phone` = '".$this->config["phone"]."' ");
        $result = $this->REG_DEVICE_MSG();
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        $setupKeyDecrypt = $this->get_setupKey($result["extra"]["setupKey"]);
        $this->connect->query("UPDATE `table_momo` SET `setupKey` = '".$result["extra"]["setupKey"]."',
                                                     `setupKeyDecrypt` = '".$setupKeyDecrypt."' WHERE `phone` =  '".$this->config["phone"]."' ");
        return array(
            "status" => "success",
            "message"=> "Thành công"
        );
    }

    public function LoginUser($password = "", $tranfer = TRUE)
    {
        if($password == ""){
            $result = $this->USER_LOGIN_MSG();
        }else{
            $this->config["password"] = $password;
            $result = $this->USER_LOGIN_MSG();
        }
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }else if(is_null($result)){
            return array(
                "status"  => "error",
                "code"    => -5,
                "message" => "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        $extra = $result["extra"];
        $BankVerify = empty($result['momoMsg']['bankVerifyPersonalid']) ? '1' : '2';
        $this->connect->query("UPDATE `table_momo` SET `password` = '".$this->config["password"]."',
                                                      `Name`     = '".$result['momoMsg']['name']."',
                                                      `identify` = '".$result["momoMsg"]["identify"]."',
                                                      `authorization` = '".$extra["AUTH_TOKEN"]."',
                                                      `refreshToken`  = '".$extra['REFRESH_TOKEN']."',
                                                      `BankVerify`    = '".$BankVerify."',
                                                      `agent_id` = '".$result["momoMsg"]["agentId"]."',
                                                      `RSA_PUBLIC_KEY` = '".$extra["REQUEST_ENCRYPT_KEY"]."',
                                                      `BALANCE` = '".$extra["BALANCE"]."',
                                                      `bankCode` = '".$result['momoMsg']['bankCode']."',
                                                      `walletStatus` = '".$result['momoMsg']['walletStatus']."',
                                                      `sessionkey` = '".$extra["SESSION_KEY"]."',
                                                      `success`    = 'true',
                                                      `TimeLogin`  = '".time()."' WHERE `phone` = '".$this->config["phone"]."' ");
        if($tranfer == FALSE) return $result;
        return array(
            "status" => "success",
            "Số dư"  => (int)$extra["BALANCE"],
            "message"=> "Thành công"
        );
    }

    public function SendMoney($receiver,$amount = 100,$comment = "")
    {
        $result = $this->CHECK_USER_PRIVATE($receiver);
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message" => $result["errorDesc"]
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        $results = $this->M2M_VALIDATE_MSG($receiver, $comment);
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
            );
        }
        $message = $results['momoMsg']['message'];
        $this->send = array(
            "amount" => (int)$amount,
            "comment"=> $message,
            "receiver"=> $receiver,
            "partnerName"=> $result["extra"]["NAME"]
        );
        $result = $this->M2MU_INIT();
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
            );
        }else{
            $ID = $result["momoMsg"]["replyMsgs"]["0"]["ID"];
            $result = $this->M2MU_CONFIRM($ID);
            $tranHisMsg = $result["momoMsg"]["replyMsgs"]["0"]["tranHisMsg"];
            if($tranHisMsg["status"] != 999){
                return array(
                    "status"   => "error",
                    "message"  => $tranHisMsg["desc"],
                    "tranDList"=> array(
                        "ID"   => $tranHisMsg["ID"],
                        "tranId"=> $tranHisMsg["tranId"],
                        "partnerId"=> $tranHisMsg["partnerId"],
                        "partnerName"=> $tranHisMsg["partnerName"],
                        "amount"   => $tranHisMsg["amount"],
                        "comment"  => (empty($tranHisMsg["comment"])) ? "" : $tranHisMsg["comment"],
                        "status"   => $tranHisMsg["status"],
                        "desc"     => $tranHisMsg["desc"],
                        "ownerNumber" => $tranHisMsg["ownerNumber"],
                        "ownerName"=> $tranHisMsg["ownerName"],
                        "millisecond" => $tranHisMsg["finishTime"]
                    )
                );
            }else{
                return array(
                    "status" => "success",
                    "message"=> $tranHisMsg["desc"],
                    "tranDList" => array(
                        "ID"    => $tranHisMsg["ID"],
                        "tranId"=> $tranHisMsg["tranId"],
                        "partnerId"=> $tranHisMsg["partnerId"],
                        "partnerName"=> $tranHisMsg["partnerName"],
                        "amount"     => $tranHisMsg["amount"],
                        "comment"    => (empty($tranHisMsg["comment"])) ? "" : $tranHisMsg["comment"],
                        "status"     => $tranHisMsg["status"],
                        "desc"       => $tranHisMsg["desc"],
                        "ownerNumber"=> $tranHisMsg["ownerNumber"],
                        "ownerName"  => $tranHisMsg["ownerName"],
                        "millisecond"=> $tranHisMsg["finishTime"]
                    )
                );
            }

        }
    }

    public function CheckHis($days = 5)
    {
        $this->day = $days;
        $result = $this->QUERY_TRAN_HIS_MSG();
        if(empty($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> 'Hết thời gian đăng nhập vui lòng đăng nhập lại'
            );
        }
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }
        else if(empty($result['momoMsg']['tranList'])){
            return array(
                "status" => "error",
                "code"   => -10,
                "message"=> 'Bạn chưa có giao dịch nào'
            );
        }
        $List = $result["momoMsg"]["tranList"];
        $tranList = array();
        foreach ($List as $values){
            if(empty($values['partnerId']) or empty($values['io'])) continue;
            $tranList[] = array(
                'ID'    => $values['ID'],
                "tranId"=> $values["tranId"],
                "io"    => $values["io"],
                "partnerId" => $values["partnerId"],
                "status"=> $values["status"],
                "partnerName" => empty($values["partnerName"]) ? "" : $values['partnerName'] ,
                "amount" => empty($values["amount"]) ? 0 : $values["amount"],
                "comment" => (!empty($values["comment"])) ? $values["comment"] : "",
                "desc"  => empty($values["desc"]) ? "" : $values["desc"],
                "millisecond" => empty($values["finishTime"]) ? 0 : $values['finishTime']
            );
        }
        return array(
            "status"  => "success",
            "message" => "Thành công",
            "TranList"=> $tranList
        );
    }

    public function M2M_VALIDATE_MSG($phone, $message = '')
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"],$requestkeyRaw);
        $header = array(
            "agent_id: ".$this->config["agent_id"],
            "user_phone: ".$this->config["phone"],
            "sessionkey: ".$this->config["sessionkey"],
            "authorization: Bearer ".$this->config["authorization"],
            "msgtype: M2M_VALIDATE_MSG",
            "userid: ".$this->config["phone"],
            "requestkey: ".$requestkey,
            "Host: owa.momo.vn"
        );
        $Data = '{
            "user":"'.$this->config['phone'].'",
            "msgType":"M2M_VALIDATE_MSG",
            "cmdId":"'.$microtime.'000000",
            "lang":"vi",
            "time":'.(int) $microtime.',
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
                "partnerId":"'.$phone.'",
                "_class":"mservice.backend.entity.msg.ForwardMsg",
                "message":"'.$this->get_string($message).'"
            },
            "extra":
            {
                "checkSum":"'.$this->generateCheckSum('M2M_VALIDATE_MSG',$microtime).'"
            }
        }';
        return $this->CURL("M2M_VALIDATE_MSG",$header,$this->Encrypt_data($Data,$requestkeyRaw));
    }

    private function M2MU_CONFIRM($ID)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"],$requestkeyRaw);
        $header = array(
            "agent_id: ".$this->config["agent_id"],
            "user_phone: ".$this->config["phone"],
            "sessionkey: ".$this->config["sessionkey"],
            "authorization: Bearer ".$this->config["authorization"],
            "msgtype: M2MU_INIT",
            "userid: ".$this->config["phone"],
            "requestkey: ".$requestkey,
            "Host: owa.momo.vn"
        );
        $ipaddress = $this->get_ip_address();
        $Data =  array(
            'user' => $this->config['phone'],
            'pass' => $this->config['password'],
            'msgType' => 'M2MU_CONFIRM',
            'cmdId' => (string) $microtime.'000000',
            'lang' => 'vi',
            'time' =>(int) $microtime,
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
                        array (
                            0 => $ID,
                        ),
                    'totalAmount' => $this->send['amount'],
                    'originalAmount' => $this->send['amount'],
                    'originalClass' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                    'originalPhone' => $this->config['phone'],
                    'totalFee' => '0.0',
                    'id' => $ID,
                    'GetUserInfoTaskRequest' => $this->send['receiver'],
                    'tranList' =>
                        array (
                            0 =>
                                array(
                                    '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                                    'user' => $this->config['phone'],
                                    'clientTime' => (int) ($microtime - 211),
                                    'tranType' => 36,
                                    'amount' => (int) $this->send['amount'],
                                    'receiverType' => 1,
                                ),
                            1 =>
                                array(
                                    '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                                    'user' => $this->config['phone'],
                                    'clientTime' => (int) ($microtime - 211),
                                    'tranType' => 36,
                                    'partnerId' => $this->send['receiver'],
                                    'amount' => 100,
                                    'comment' => '',
                                    'ownerName' => $this->config['Name'],
                                    'receiverType' => 0,
                                    'partnerExtra1' => '{"totalAmount":'.$this->send['amount'].'}',
                                    'partnerInvNo' => 'borrow',
                                ),
                        ),
                    'serviceId' => 'transfer_p2p',
                    'serviceCode' => 'transfer_p2p',
                    'clientTime' => (int) ($microtime - 211),
                    'tranType' => 2018,
                    'comment' => '',
                    'ref' => '',
                    'amount' => $this->send['amount'],
                    'partnerId' => $this->send['receiver'],
                    'bankInId' => '',
                    'otp' => '',
                    'otpBanknet' => '',
                    '_class' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                    'extras' => '{"appSendChat":false,"vpc_CardType":"SML","vpc_TicketNo":"'.$ipaddress.'"","vpc_PaymentGateway":""}',
                ),
            'extra' =>
                array(
                    'checkSum' => $this-> generateCheckSum('M2MU_CONFIRM',$microtime),
                ),
        );
        return $this->CURL("M2MU_CONFIRM",$header,$this->Encrypt_data($Data,$requestkeyRaw));

    }

    public function M2MU_INIT()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"],$requestkeyRaw);
        $header = array(
            "agent_id: ".$this->config["agent_id"],
            "user_phone: ".$this->config["phone"],
            "sessionkey: ".$this->config["sessionkey"],
            "authorization: Bearer ".$this->config["authorization"],
            "msgtype: M2MU_INIT",
            "userid: ".$this->config["phone"],
            "requestkey: ".$requestkey,
            "Host: owa.momo.vn"
        );
        $ipaddress = $this->get_ip_address();
        $Data = array (
            'user' => $this->config['phone'],
            'msgType' => 'M2MU_INIT',
            'cmdId' => (string) $microtime.'000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
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
                array (
                    'clientTime' => (int) $microtime - 221,
                    'tranType' => 2018,
                    'comment' => $this->send['comment'],
                    'amount' => $this->send['amount'],
                    'partnerId' => $this->send['receiver'],
                    'partnerName' => $this->send['partnerName'],
                    'ref' => '',
                    'serviceCode' => 'transfer_p2p',
                    'serviceId' => 'transfer_p2p',
                    '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                    'tranList' =>
                        array (
                            0 =>
                                array (
                                    'partnerName' => $this->send['partnerName'],
                                    'partnerId' => $this->send['receiver'],
                                    'originalAmount' => $this->send['amount'],
                                    'serviceCode' => 'transfer_p2p',
                                    'stickers' => '',
                                    'themeBackground' => '#f5fff6',
                                    'themeUrl' => 'https://cdn.mservice.com.vn/app/img/transfer/theme/Corona_750x260.png',
                                    'transferSource' => '',
                                    'socialUserId' => '',
                                    '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                                    'tranType' => 2018,
                                    'comment' => $this->send['comment'],
                                    'moneySource' => 1,
                                    'partnerCode' => 'momo',
                                    'serviceMode' => 'transfer_p2p',
                                    'serviceId' => 'transfer_p2p',
                                    'extras' => '{"loanId":0,"appSendChat":false,"loanIds":[],"stickers":"","themeUrl":"https://cdn.mservice.com.vn/app/img/transfer/theme/Corona_750x260.png","hidePhone":false,"vpc_CardType":"SML","vpc_TicketNo":"'.$ipaddress.'","vpc_PaymentGateway":""}',
                                ),
                        ),
                    'extras' => '{"loanId":0,"appSendChat":false,"loanIds":[],"stickers":"","themeUrl":"https://cdn.mservice.com.vn/app/img/transfer/theme/Corona_750x260.png","hidePhone":false,"vpc_CardType":"SML","vpc_TicketNo":"'.$ipaddress.'","vpc_PaymentGateway":""}',
                    'moneySource' => 1,
                    'partnerCode' => 'momo',
                    'rowCardId' => '',
                    'giftId' => '',
                    'useVoucher' => 0,
                    'prepaidIds' => '',
                    'usePrepaid' => 0,
                ),
            'extra' =>
                array (
                    'checkSum' => $this->generateCheckSum('M2MU_INIT', $microtime),
                ),
        );
        return $this->CURL("M2MU_INIT",$header,$this->Encrypt_data($Data,$requestkeyRaw));

    }

    public function QUERY_TRAN_HIS_MSG()
    {

        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"],$requestkeyRaw);
        $header = array(
            "agent_id: ".$this->config["agent_id"],
            "user_phone: ".$this->config["phone"],
            "sessionkey: ".$this->config["sessionkey"],
            "authorization: Bearer ".$this->config["authorization"],
            "msgtype: QUERY_TRAN_HIS_MSG",
            "userid: ".$this->config["phone"],
            "requestkey: ".$requestkey,
            "Host: owa.momo.vn"
        );

        $begin =  (time() - (86400 * $this->day)) * 1000;
        $microtime = $this->get_microtime();
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'QUERY_TRAN_HIS_MSG',
            'cmdId' => (string) $microtime.'000000',
            'time' => $microtime,
            'lang' => 'vi',
            'channel' => 'APP',
            'appVer' => 30261,
            'appCode' => '3.0.26',
            'deviceOS' => 'ANDROID',
            'appId' => 'vn.momo.platform',
            'result' => true,
            'buildNumber' => 0,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
                array(
                    'checkSum' => $this->generateCheckSum('QUERY_TRAN_HIS_MSG',$microtime),
                ),
            'momoMsg' =>
                array(
                    '_class' => 'mservice.backend.entity.msg.QueryTranhisMsg',
                    'begin' => $begin,
                    'end' => $microtime,
                ),
        );
        return $this->CURL("QUERY_TRAN_HIS_MSG",$header,$this->Encrypt_data($Data,$requestkeyRaw));

    }

    public function CHECK_USER_PRIVATE($receiver)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"],$requestkeyRaw);
        $header = array(
            "agent_id: ".$this->config["agent_id"],
            "user_phone: ".$this->config["phone"],
            "sessionkey: ".$this->config["sessionkey"],
            "authorization: Bearer ".$this->config["authorization"],
            "msgtype: CHECK_USER_PRIVATE",
            "userid: ".$this->config["phone"],
            "requestkey: ".$requestkey,
            "Host: owa.momo.vn"
        );
        $Data = '{
            "user":"'.$this->config['phone'].'",
            "msgType":"CHECK_USER_PRIVATE",
            "cmdId":"'.$microtime.'000000",
            "lang":"vi",
            "time":'.(int) $microtime.',
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
                "CHECK_INFO_NUMBER":"'.$receiver.'",
                "checkSum":"'.$this->generateCheckSum('CHECK_USER_PRIVATE',$microtime).'"
            }
        }';
        return $this->CURL("CHECK_USER_PRIVATE",$header,$this->Encrypt_data($Data,$requestkeyRaw));
    }

    public function USER_LOGIN_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: ".$this->config["agent_id"],
            "user_phone: ".$this->config["phone"],
            "sessionkey: ".(!empty($this->config["sessionkey"])) ? $this->config["sessionkey"] : "",
            "authorization: Bearer ".$this->config["authorization"],
            "msgtype: USER_LOGIN_MSG",
            "Host: owa.momo.vn",
            "user_id: ".$this->config["phone"],
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );
        $Data = array (
            'user' => $this->config['phone'],
            'msgType' => 'USER_LOGIN_MSG',
            'pass' => $this->config['password'],
            'cmdId' => (string) $microtime.'000000',
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
                array (
                    '_class' => 'mservice.backend.entity.msg.LoginMsg',
                    'isSetup' => false,
                ),
            'extra' =>
                array (
                    'pHash' => $this->get_pHash(),
                    'AAID' => $this->config['AAID'],
                    'IDFA' => '',
                    'TOKEN' => $this->config['TOKEN'],
                    'SIMULATOR' => '',
                    'SECUREID' => $this->config['SECUREID'],
                    'MODELID' => $this->config['MODELID'],
                    'checkSum' => $this->generateCheckSum('USER_LOGIN_MSG', $microtime),
                ),
        );
        return $this->CURL("USER_LOGIN_MSG",$header,$Data);
    }


    public function CHECK_USER_BE_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: CHECK_USER_BE_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );

        $Data = array (
            'user' => $this->config['phone'],
            'msgType' => 'CHECK_USER_BE_MSG',
            'cmdId' => (string) $microtime. '000000',
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
                array (
                    '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                    'number' => $this->config['phone'],
                    'imei' => $this->config["imei"],
                    'cname' => 'Vietnam',
                    'ccode' => '084',
                    'device' => $this->config["device"],
                    'firmware' => '23',
                    'hardware' => $this->config["hardware"],
                    'manufacture' => $this->config["facture"],
                    'csp' => 'Viettel',
                    'icc' => '',
                    'mcc' => '452',
                    'device_os' => 'Android',
                    'secure_id' => $this->config["SECUREID"],
                ),
            'extra' =>
                array (
                    'checkSum' => '',
                ),
        );
        return $this->CURL("CHECK_USER_BE_MSG",$header,$Data);

    }

    public function REG_DEVICE_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: REG_DEVICE_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );
        $Data = '{
            "user": "'.$this->config["phone"].'",
            "msgType": "REG_DEVICE_MSG",
            "cmdId": "'.$microtime.'000000",
            "lang": "vi",
            "time": '.$microtime.',
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
              "number": "'.$this->config["phone"].'",
              "imei": "'.$this->config["imei"].'",
              "cname": "Vietnam",
              "ccode": "084",
              "device": "'.$this->config["device"].'",
              "firmware": "23",
              "hardware": "'.$this->config["hardware"].'",
              "manufacture": "'.$this->config["facture"].'",
              "csp": "",
              "icc": "",
              "mcc": "",
              "device_os": "Android",
              "secure_id": "'.$this->config["SECUREID"].'"
            },
            "extra": {
              "ohash": "'.$this->config['ohash'].'",
              "AAID": "'.$this->config["AAID"].'",
              "IDFA": "",
              "TOKEN": "'.$this->config["TOKEN"].'",
              "SIMULATOR": "",
              "SECUREID": "'.$this->config["SECUREID"].'",
              "MODELID": "'.$this->config["MODELID"].'",
              "checkSum": ""
            }
          }';
        return $this->CURL("REG_DEVICE_MSG",$header,$Data);

    }

    public function SEND_OTP_MSG()
    {
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: SEND_OTP_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: 30261",
            "app_code: 3.0.26",
            "device_os: ANDROID"
        );
        $microtime = $this->get_microtime();
        $Data = array (
            'user' => $this->config['phone'],
            'msgType' => 'SEND_OTP_MSG',
            'cmdId' => (string) $microtime. '000000',
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
                array (
                    '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                    'number' => $this->config['phone'],
                    'imei' => $this->config["imei"],
                    'cname' => 'Vietnam',
                    'ccode' => '084',
                    'device' => $this->config["device"],
                    'firmware' => '23',
                    'hardware' => $this->config["hardware"],
                    'manufacture' => $this->config["facture"],
                    'csp' => '',
                    'icc' => '',
                    'mcc' => '452',
                    'device_os' => 'Android',
                    'secure_id' => $this->config['SECUREID'],
                ),
            'extra' =>
                array (
                    'action' => 'SEND',
                    'rkey' => $this->config["rkey"],
                    'AAID' => $this->config["AAID"],
                    'IDFA' => '',
                    'TOKEN' => $this->config["TOKEN"],
                    'SIMULATOR' => '',
                    'SECUREID' => $this->config['SECUREID'],
                    'MODELID' => $this->config["MODELID"],
                    'isVoice' => false,
                    'REQUIRE_HASH_STRING_OTP' => true,
                    'checkSum' => '',
                ),
        );
        return $this->CURL("SEND_OTP_MSG",$header,$Data);

    }

    public function get_ip_address()
    {
        $isValid = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP,FILTER_FLAG_IPV4);
        if(!empty($isValid)){
            return $_SERVER['REMOTE_ADDR'];
        }
        try {
            $curl = curl_init();
            $opt = array(
                CURLOPT_URL => 'https://api4.my-ip.io/ip.json',
                CURLOPT_RETURNTRANSFER => TRUE,
            );
            if(!empty($this->proxy)) {
                $opt[CURLOPT_PROXY] = $this->proxy;
            }
            curl_setopt_array($curl,$opt);
            $isIpv4 = json_decode(curl_exec($curl), true);
            return $isIpv4['ip'];
        } catch (\Throwable $e){
            return '116.107.187.109';
        }
    }

    private function CURL($Action,$header,$data)
    {
        $Data = is_array($data) ? json_encode($data) : $data;
        $curl = curl_init();
        // echo strlen($Data); die;
        $header[] = 'Content-Type: application/json';
        $header[] = 'accept: application/json';
        $header[] = 'Content-Length: '.strlen($Data);
        $opt = array(
            CURLOPT_URL =>$this->URLAction[$Action],
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => empty($data) ? FALSE : TRUE,
            CURLOPT_POSTFIELDS => $Data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_SSL_VERIFYHOST => FALSE
        );
        curl_setopt_array($curl,$opt);
        $body = curl_exec($curl);
        if(!empty(curl_errno($curl))){
            echo curl_error($curl);
            die();
        }
        if(is_object(json_decode($body))){
            return json_decode($body,true);
        }
        return json_decode($this->Decrypt_data($body),true);
    }

    public function RSA_Encrypt($key,$content)
    {
        if(empty($this->rsa)){
            $this->INCLUDE_RSA($key);
        }
        return base64_encode($this->rsa->encrypt($content));
    }

    private function INCLUDE_RSA($key)
    {
        require_once 'lib/RSA/Crypt/RSA.php';
        $this->rsa = new Crypt_RSA();
        $this->rsa->loadKey($key);
        $this->rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        return $this;
    }

    private function get_TOKEN()
    {
        return  $this->generateRandom(22).':'.$this->generateRandom(9).'-'.$this->generateRandom(20).'-'.$this->generateRandom(12).'-'.$this->generateRandom(7).'-'.$this->generateRandom(7).'-'.$this->generateRandom(53).'-'.$this->generateRandom(9).'_'.$this->generateRandom(11).'-'.$this->generateRandom(4);
    }

    public function Encrypt_data($data,$key)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $this->keys = $key;
        return base64_encode(openssl_encrypt(is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : $data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));

    }

    public function Decrypt_data($data)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $this->keys, OPENSSL_RAW_DATA, $iv);

    }

    public function generateCheckSum($type,$microtime)
    {
        $Encrypt =   $this->config["phone"].$microtime.'000000'.$type. ($microtime / 1000000000000.0) . 'E12';
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($Encrypt, 'AES-256-CBC',$this->config["setupKeyDecrypt"], OPENSSL_RAW_DATA, $iv));
    }

    private function get_pHash()
    {
        $data = $this->config["imei"]."|".$this->config["password"];
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($data, 'AES-256-CBC',$this->config["setupKeyDecrypt"], OPENSSL_RAW_DATA, $iv));
    }

    public function get_setupKey($setUpKey)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($setUpKey), 'AES-256-CBC',$this->config["ohash"], OPENSSL_RAW_DATA, $iv);
    }

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
    private function get_SECUREID($length = 17)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateImei()
    {
        return $this->generateRandomString(8) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(12);
    }

    private function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function get_string($data){
        return str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php','-'),array('','','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($data))));
    }

    public function get_microtime()
    {
        return round(microtime(true) * 1000);
    }
}

?><?php
