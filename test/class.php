<?php
class facebook{
    const url_graph     = 'https://graph.facebook.com/v3.3/';
    private $access_token;
    public function __construct(){
        $this->access_token = [
            'EAAAAZAw4FxQIBAO3nsbiGmhTy8NsDNIIzqL4I3QZBTJnWP5jtJEhbsnomYwnUQlrzh0QXHNzZCHqNAYQIMBEfTKslEpeXXCrFdVbCetkZC49e25boX4aMPM33kiV9LuvX3AlFrGjlcZC1qf0pQiZCSGjLqTEZA8ua7GlXEODRaXrrzKdWuL6uTM',
            'EAAAAZAw4FxQIBAKzBRXOEOkHFGTNLZBMsULxxZAADyByZBmy8U8ozWLUPY01cXt0HBoIapN9ctb4K9EtmDwLj5L4vkgUQAUuzOnah67B3ZAqoYKjcmbpqgrBtLu4o9LmW4ceCkqmHkE8rbeZBSgKtZCjJtjGnafmBmrr8qw7kDbYzZC07ZC9ntr4ZB',
            'EAAAAZAw4FxQIBACOtSykNP2iDpkZCT61amQVWVZBzPhAV1KNXZATwQaJJiNPKaj5zCHFA0cD5I2fT3ZChdXrZCRCag7ZAZCxhGSELCGXxshpp1o8LIZA7TK33v1pHNtXQqaXrZAvk1DhUl1pnHEZBOMZB9TlZCDsUsCuok4wF1Jm1Qmf7addWcXHsGMBc',
            'EAAAAZAw4FxQIBADzdz8VBMTqbceckNHXFl913rblOCMFn1p0n1G0rp164MApXAze8pv6L36MVR05jPSoY0U01Tsv2s2NQqYAe51TQjIj2ZBhzcWRuODYbsDNDZBht0tnZBPuo2tGEWBr6nb78zi6VLmiTvRZCVCLkjz0l3Tt5rgZDZD',
            'EAAAAZAw4FxQIBAPoCocIrLTZCixqQHAlYMU2tPMriWzvrXksH2QkElg1cbpOYRgedxyfzCKVyTvMPVV2feHeKNsCTUSg9zUFoBjjgPEMaKq8K2Q1p6o601Wq1coxD8sQlIr42ZBLH9ZApyfopwbZCNOVMPOAT6MBbpRKmXelElAZDZD',
            'EAAAAZAw4FxQIBAIjf5n6yLUragFjY8ux064xNOEkCfkccqFqHKZBtHr6oBJtZCwqM9qRwGp7PsmXGpMTz3xnVDxNDjyqz5vc3TX70PtJFRC08vZAkvoNTgLe0daZAwrXu1XfJzZBKCUKdnVAEJeZAArseuUuRJAXs557KHdqDX3SQZDZD'
        ];
    }

    //
    private function get_access_token(){
        $access_token   = $this->access_token;
        $count          = count($access_token);
        return $access_token[rand(0, ($count - 1))];
    }

    // ID Fanpage, Group
    public function getListFeed($id, $limit = 100){
        $data = $this->curl(self::url_graph."/$id/feed/", ['access_token' => $this->get_access_token(), 'limit' => $limit, 'fields' => 'message,id,permalink_url']);
        return $data;
    }


    // Get Comments
    public function getListComments($id, $limit = 1000){
        $data = $this->curl(self::url_graph."/$id/comments/", ['access_token' => $this->get_access_token(), 'limit' => $limit, 'fields' => 'message']);
        return $data;
    }

    // Cắt chuỗi ký tự hoặc văn bản
    function text_truncate($text, $limit, $type = 'words', $ellipsis = ' ...'){
        switch ($type) {
            case 'words':
                $words = preg_split("/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE);
                if (count($words) > $limit) {
                    end($words); //ignore last element since it contains the rest of the string
                    $last_word = prev($words);

                    $text = substr($text, 0, $last_word[1] + strlen($last_word[0])) . $ellipsis;
                }
                return $text;
                break;
            case 'text':
                if (strlen($text) > $limit) {
                    $endpos = strpos(str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $text), ' ', $limit);
                    if ($endpos !== FALSE)
                        $text = trim(substr($text, 0, $endpos)) . $ellipsis;
                }
                return $text;
                break;
        }
    }

    // Check Comment xem có số điện thoại không?
    function checkPhone($text){
        preg_match_all('/0[0-9]{9}/', $text, $match);
        if(count($match[0]) == 0){
            return false;
        }
        return implode(',', $match[0]);
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