<?php
class Momo{
    private $config;
    private $phone              = '0966624292';
    private $otp                = '636561';
    private $password           = '241992';
    private $rkey               = 'YyBkJGXO2HWt0wR7Ocgj'; // 20 characters
    private $setupKeyEncrypted  = "ozuqkHaLvPWxgWdWeNbYIWCwB8dDBnvEgwxz8g3nIo23ihZ0luUUznKxg+iZC4gY"; // (*): Xem trong public
    private $imei               = "53122BEC-4613-4873-95F1-90DA9638C4ED"; // (*): Xem trong public
    private $token              = 'dfdjCewLGlE:APA91bEyR_lpb8CN6eghznFGMuPzSPpr9qb7Z8SlBJa3zeReBopzKQvsdf7QAkVBEnWKK3dX-uyFsPPy0Yrsbxq3Gh6KzqdFDnXGjNrzK5FeXwtPfhO8cfYgvjVWCxBZpIaXzBhVf7Lc';
    private $onesignalToken     = 'a12e8af7-4f94-4fbd-9983-64aa2e938ac5';

    public function __construct(){
        $ohash = hash('sha256', $this->phone . $this->rkey . $this->otp);
        $this->config = [
            'phone'                 => $this->phone, //sdt (*)
            'otp'                   => $this->otp, //otp (*)
            'password'              => $this->password, //pass (*)
            'rkey'                  => $this->rkey, // 20 characters (*)
            'setupKeyEncrypted'     => $this->setupKeyEncrypted, // (*): Xem trong public
            'imei'                  => $this->imei, // (*)
            'token'                 => $this->token, // (*)
            'onesignalToken'        => $this->onesignalToken, // (*)
            'aaid'                  => '', //null
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
            'setupKeyDecrypted'     => $this->encryptDecrypt($this->setupKeyEncrypted, $ohash, 'DECRYPT')
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
}