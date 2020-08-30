<?php

class Telegram{
    private $token;
    private $chat_id;
    private $url_api;

    public function __construct($token){
        switch ($token){
            case 'rentcode':
                $this->token = '1377461891:AAEDxvY8dVOTTYXZE5k20X8HjIfv7I_Eeqg';
                break;
            default:
                $this->token    = $token;
                break;
        }
        $this->url_api = 'https://api.telegram.org/bot'. $this->token .'/';
    }

    public function set_chatid($chat_id){
        $this->chat_id = $chat_id;
    }

    public function setWebhook($url_webhook){
        if(!validate_url($url_webhook)){
            return false;
        }
        $request = $this->get_data($this->url_api . 'setWebhook', ['url' => $url_webhook]);
        if(!$request){
            return false;
        }
        return $request;
    }

    public function deleteWebhook(){
        $request = $this->get_data($this->url_api . 'deleteWebhook');
        if(!$request){
            return false;
        }
        return $request;
    }

    public function getWebhookInfo(){
        $request = $this->get_data($this->url_api . 'getWebhookInfo');
        if(!$request){
            return false;
        }
        return $request;
    }

    public function sendMessage($content){
        if(!$this->chat_id){
            return false;
        }
        $request = $this->get_data($this->url_api . 'sendMessage', ['chat_id' => $this->chat_id, 'text' => $content]);
        if(!$request){
            return false;
        }
        return $request;
    }

    // Lấy danh sách chatid
    public function getUpdates(){
        $request = $this->get_data($this->url_api . 'getUpdates');
        if(!$request){
            return false;
        }
        return $request;
    }

    // Gọi CURL để lấy data
    private function get_data($url, $data = '', $method = 'GET'){
        if ($method == 'GET') {
            $ch = curl_init($url.($data ? '?'.http_build_query($data) : ''));
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: *']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            if ($result === FALSE) {
                return false;
            } else {
                return $result;
            }
        }else if($method == 'POST'){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER  => 1,
                CURLOPT_URL             => $url,
                CURLOPT_USERAGENT       => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
                CURLOPT_POST            => 1,
                CURLOPT_SSL_VERIFYPEER  => false, //Bỏ kiểm SSL
                CURLOPT_POSTFIELDS      => http_build_query($data)
            ));
            $result = curl_exec($curl);
            curl_close($curl);
            if ($result === FALSE) {
                return false;
            } else {
                return $result;
            }
        } else {
            $curl = curl_init();
            $data = json_encode($data);
            $options = array(
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_URL             => $url,
                CURLOPT_POST            => true,
                CURLOPT_SSL_VERIFYPEER  => false,
                CURLOPT_USERAGENT       => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
                CURLOPT_POSTFIELDS      => $data,
                CURLOPT_HTTPHEADER      => ['Content-Type: application/json', 'Content-Length: ' . strlen($data)]
            );
            curl_setopt_array($curl, $options);
            $result = curl_exec($curl);
            if ($result === FALSE) {
                return false;
            } else {
                return $result;
            }
        }
    }
}