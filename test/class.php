<?php
class facebook{
    const access_token  = 'EAAAAZAw4FxQIBAGjLGd8y4xDyDKPfuYTojKQiJha7P3kE8xSAmNWLRu6xHQJcgeHHnFEKePqskIea9zEoqQsVwGOk2VrRmFkXFzTNQhvZAyS2gLiKaaOLPJzKBAP7M6GGngagx38TOgRpehLkIAAIEC7rHIxpen7AzjiU7I4JZBUUMbcADj';
    const url_graph     = 'https://graph.facebook.com/v3.3/';
    public function __construct(){
    }

    // ID Fanpage, Group
    public function getListFeed($id, $limit = 100){
        $data = $this->curl(self::url_graph."/$id/feed/", ['access_token' => self::access_token, 'limit' => $limit]);
        return $data;
    }

    // Gọi CURL để lấy data
    function curl($url, $data = '', $method = 'GET'){
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