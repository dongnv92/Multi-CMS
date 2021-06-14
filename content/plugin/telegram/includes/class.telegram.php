<?php

class Telegram{
    private $token;
    private $chat_id;
    private $url_api;

    public function __construct($token){
        switch ($token){
            case 'citypost_notice':
                $this->token = '1709795286:AAEyN3xSVPti3RtHKZitBpYfwl0qCcOplhc';
                break;
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
        $request = curl($this->url_api . 'setWebhook', ['url' => $url_webhook]);
        if(!$request){
            return false;
        }
        return $request;
    }

    public function deleteWebhook(){
        $request = curl($this->url_api . 'deleteWebhook');
        if(!$request){
            return false;
        }
        return $request;
    }

    public function getWebhookInfo(){
        $request = curl($this->url_api . 'getWebhookInfo');
        if(!$request){
            return false;
        }
        return $request;
    }

    public function sendMessage($content){
        if(!$this->chat_id){
            return false;
        }
        $request = curl($this->url_api . 'sendMessage', ['chat_id' => $this->chat_id, 'text' => $content]);
        if(!$request){
            return false;
        }
        return $request;
    }

    // Lấy danh sách chatid
    public function getUpdates(){
        $request = curl($this->url_api . 'getUpdates');
        if(!$request){
            return false;
        }
        return $request;
    }

}