<?php
/*
 * (*) Là các trường bắt buộc phải thay đổi khi đổi mật khẩu MOMO
 * $otp                 : Lấy khi đăng nhập mới từ đầu.
 * $rkey                : Lấy trong publiv/login
 * $setupKeyEncrypted   : Lấy trong public
 *
 *
 *  private $phone              = '0966624292';
    private $password           = '241992';
    private $otp                = '761912'; // (*) mã OTP gửi về điện thoại khi login
    private $rkey               = 'hM7iCzZHMpB1JkRdZXHM'; // (*) 20 ký tự, xem trong public/login
    private $setupKeyEncrypted  = "OSuXozNZ9q42GSf1xvw9GSU/+vr6s90xV87+PdjtGlw5KmmRVj9TMEd2H0pv3g/S"; // (*): Xem trong public
    private $imei               = "53122BEC-4613-4873-95F1-90DA9638C4ED";
    private $token              = 'dfdjCewLGlE:APA91bEyR_lpb8CN6eghznFGMuPzSPpr9qb7Z8SlBJa3zeReBopzKQvsdf7QAkVBEnWKK3dX-uyFsPPy0Yrsbxq3Gh6KzqdFDnXGjNrzK5FeXwtPfhO8cfYgvjVWCxBZpIaXzBhVf7Lc';
    private $onesignalToken     = 'a12e8af7-4f94-4fbd-9983-64aa2e938ac5';

 * */
class Momo{
    private $config;
    public function __construct($phone, $password, $otp, $rkey, $setupKeyEncrypted, $imei, $token, $onesignalToken){
        $ohash = hash('sha256', $phone . $rkey . $otp);
        $this->config = [
            'phone'                 => $phone,
            'otp'                   => $otp,
            'password'              => $password,
            'rkey'                  => $rkey,
            'setupKeyEncrypted'     => $setupKeyEncrypted,
            'imei'                  => $imei,
            'token'                 => $token,
            'onesignalToken'        => $onesignalToken,
            'aaid'                  => '',
            'idfa'                  => '',
            'csp'                   => 'Viettel',
            'icc'                   => '',
            'mcc'                   => '452',
            'mnc'                   => '04',
            'cname'                 => 'Vietnam',
            'ccode'                 => '084',
            'channel'               => 'APP',
            'lang'                  => 'vi',
            'device'                => 'iPhone',
            'firmware'              => '13.5.1',
            'manufacture'           => 'Apple',
            'hardware'              => 'iPhone',
            'simulator'             => false,
            'appVer'                => '21481',
            'appCode'               => "2.1.48",
            'deviceOS'              => "IOS",
            'setupKeyDecrypted'     => $this->encryptDecrypt($setupKeyEncrypted, $ohash, 'DECRYPT')
        ];
    }

    private function encryptDecrypt($data, $key, $mode = 'ENCRYPT'){
        if (strlen($key) < 32) {
            $key = str_pad($key, 32, 'x');
        }
        $key = substr($key, 0, 32);
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        if ($mode === 'ENCRYPT') {
            return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
        }
        else {
            return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        }
    }

    private function get_microtime(){
        return floor(microtime(true) * 1000);
    }

    private function get_checksum($type){
        $config         = $this->config;
        $checkSumSyntax = $config['phone'] . $this->get_microtime() . '000000' . $type . ($this->get_microtime() / 1000000000000.0) . 'E12';
        return $this->encryptDecrypt($checkSumSyntax, $config['setupKeyDecrypted']);
    }

    private function get_pHash(){
        $config         = $this->config;
        $pHashSyntax    = $config['imei'] . '|' . $config['password'];
        return $this->encryptDecrypt($pHashSyntax, $config['setupKeyDecrypted']);
    }

    private function get_auth(){
        $config         = $this->config;
        $type           = 'USER_LOGIN_MSG';
        $data_body = [
            'user'      => $config['phone'],
            'pass'      => $config['password'],
            'msgType'   => $type,
            'cmdId'     => $this->get_microtime() . '000000',
            'lang'      => $config['lang'],
            'channel'   => $config['channel'],
            'time'      => $this->get_microtime(),
            'appVer'    => $config['appVer'],
            'appCode'   => $config['appCode'],
            'deviceOS'  => $config['deviceOS'],
            'result'    => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra'     => [
                'checkSum'          => $this->get_checksum($type),
                'pHash'             => $this->get_pHash(),
                'AAID'              => $config['aaid'],
                'IDFA'              => $config['idfa'],
                'TOKEN'             => $config['token'],
                'ONESIGNAL_TOKEN'   => $config['onesignalToken'],
                'SIMULATOR'         => $config['simulator']
            ],
            'momoMsg'   => [
                '_class'    => 'mservice.backend.entity.msg.LoginMsg'
                , 'isSetup' => true
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL             => "https://owa.momo.vn/public",
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => json_encode($data_body),
            CURLOPT_HTTPHEADER      => array(
                'User-Agent'    => "MoMoApp-Release/%s CFNetwork/978.0.7 Darwin/18.6.0",
                'Msgtype'       => "USER_LOGIN_MSG",
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Userhash'      => md5($config['phone'])  ,
            )
        ));
        $response = curl_exec($curl);
        if(!$response){
            return false;
        }
        return json_decode($response)->extra->AUTH_TOKEN;
    }

    public function history($day = 1){
        $config = $this->config;
        $type   = 'QUERY_TRAN_HIS_MSG';
        $data_post =  [
            'user'      => $config['phone'],
            'msgType'   => $type,
            'cmdId'     => $this->get_microtime() . '000000',
            'lang'      => $config['lang'],
            'channel'   => $config['channel'],
            'time'      => $this->get_microtime(),
            'appVer'    => $config['appVer'],
            'appCode'   => $config['appCode'],
            'deviceOS'  => $config['deviceOS'],
            'result'    => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra'     => [
                'checkSum' => $this->get_checksum($type)
            ],
            'momoMsg'   => [
                '_class'    => 'mservice.backend.entity.msg.QueryTranhisMsg',
                'begin'     => (time() - (86400 * $day)) * 1000,
                'end'       => $this->get_microtime()
            ]
        ];
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL             => "https://owa.momo.vn/api/sync/$type",
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => json_encode($data_post),
            CURLOPT_HTTPHEADER      => array(
                'User-Agent'    => "MoMoApp-Release/%s CFNetwork/978.0.7 Darwin/18.6.0",
                'Msgtype'       => $type,
                'Userhash'      => md5($config['phone']),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization: Bearer ' . trim($this->get_auth()),
            )
        ));
        $result = curl_exec($ch);
        if(!$result){
            return false;
        }
        return $result;
    }

    public function oder_cash($phone, $name, $comment, $money) {
        $config = $this->config;
        $type   = 'M2MU_INIT';
        $data_post = [
            'user'      => $config['phone'],
            'msgType'   => $type,
            'cmdId'     => $this->get_microtime() . '000000',
            'lang'      => $config['lang'],
            'channel'   => $config['channel'],
            'time'      => $this->get_microtime(),
            'appVer'    => $config['appVer'],
            'appCode'   => $config['appCode'],
            'deviceOS'  => $config['deviceOS'],
            'result'    => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' => [
                'checkSum' => $this->get_checksum($type)
            ],
            'momoMsg' => [
                '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                'ref' => '',
                'tranList' => [
                    0 => [
                        '_class'            => 'mservice.backend.entity.msg.TranHisMsg',
                        'tranType'          => 2018,
                        'partnerId'         => $phone,
                        'originalAmount'    => $money,
                        'comment'           => $comment,
                        'moneySource'       => 1,
                        'partnerCode'       => 'momo',
                        'partnerName'       => $name,
                        'rowCardId'         => NULL,
                        'serviceMode'       => 'transfer_p2p',
                        'serviceId'         => 'transfer_p2p',
                        'extras'            => '{"vpc_CardType":"SML","vpc_TicketNo":"115.79.139.158","receiverMembers":[{"receiverNumber":"'.$phone.'","receiverName":"'.$name.'","originalAmount":'.$money.'}],"loanId":0,"contact":{}}',
                    ],
                ],
            ],
        ];

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL             => "https://owa.momo.vn/api/$type",
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => json_encode($data_post),
            CURLOPT_HTTPHEADER      => array(
                'User-Agent'    => "MoMoApp-Release/%s CFNetwork/978.0.7 Darwin/18.6.0",
                'Msgtype'       => $type,
                'Userhash'      => md5($config['phone']),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization: Bearer ' . trim($this->get_auth()),
            )
        ));
        $result = curl_exec($ch);
        if(!$result){
            return false;
        }
        $id = json_decode($result, true);
        $id = $id['momoMsg']['replyMsgs'][0]['ID'];
        $send   = $this->comfirm_oderr($id);
        if(!$send){
            return false;
        }
        return $send;
    }

    private function comfirm_oderr($id) {
        $config = $this->config;
        $type   = 'M2MU_CONFIRM';

        $data_post = [
            'user'      => $config['phone'],
            'msgType'   => $type,
            'cmdId'     => $this->get_microtime() . '000000',
            'lang'      => $config['lang'],
            'channel'   => $config['channel'],
            'time'      => $this->get_microtime(),
            'appVer'    => $config['appVer'],
            'appCode'   => $config['appCode'],
            'deviceOS'  => $config['deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' => [
                'checkSum' => $this->get_checksum($type),
            ],
            'momoMsg' => [
                'ids' => [
                    0 => $id,
                ],
                'bankInId'      => '',
                '_class'        => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                'otp'           => '',
                'otpBanknet'    => '',
                'extras'        => '',
            ],
            'pass' => $config['password'],
        ];

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL             => "https://owa.momo.vn/api/$type",
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => json_encode($data_post),
            CURLOPT_HTTPHEADER      => array(
                'User-Agent'    => "MoMoApp-Release/%s CFNetwork/978.0.7 Darwin/18.6.0",
                'Msgtype'       => $type,
                'Userhash'      => md5($config['phone']),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization: Bearer ' . trim($this->get_auth()),
            )
        ));
        $result = curl_exec($ch);
        if(!$result){
            return false;
        }
        return $result;
    }
}