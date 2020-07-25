<?php
switch($_GET['act']){
    case 'login':
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $postfields = '{
            "user":"0966624292",
            "msgType":"USER_LOGIN_MSG",
            "cmdId":"1595640141092000000",
            "lang":"vi",
            "channel":"APP",
            "time":1595640141092,
            "appVer":"21481",
            "appCode":"2.1.48",
            "deviceOS":"IOS",
            "result":true,
            "errorCode":0,
            "errorDesc":"",
            "extra":{
                "checkSum":"CjkvFGhlnDAMsXZzvZkxpWHvbo9QnCP1o8bMuJlcdOY1rQ0Re2jcGER6G2dnQSbR7iwOFHD0Wy6Vnuq8fQXv0A==",
                "pHash":"xHe2CdLKgPI4VIJ6A08MI1DVVpb54/oxTOybDn/2pnXvp7JXBibUBZuNRwUZIZbT",
                "AAID":"",
                "IDFA":"082EFF0A-76CD-43D5-8CDF-CFD2E96E463D",
                "TOKEN":"dfdjCewLGlE:APA91bEyR_lpb8CN6eghznFGMuPzSPpr9qb7Z8SlBJa3zeReBopzKQvsdf7QAkVBEnWKK3dX-uyFsPPy0Yrsbxq3Gh6KzqdFDnXGjNrzK5FeXwtPfhO8cfYgvjVWCxBZpIaXzBhVf7Lc",
                "ONESIGNAL_TOKEN":"a12e8af7-4f94-4fbd-9983-64aa2e938ac5",
                "SIMULATOR":"false"
            },
            "pass":"241992",
            "momoMsg":{
                "_class":"mservice.backend.entity.msg.LoginMsg",
                "isSetup":false
            }
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://owa.momo.vn/public/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Host: owa.momo.vn:443';
        $headers[] = 'Msgtype: USER_LOGIN_MSG';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer';
        $headers[] = 'Accept-Language: vi-vn';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Userhash: null';
        $headers[] = 'User-Agent: MoMoApp-Release/21481 CFNetwork/1126 Darwin/19.5.0';
        $headers[] = 'Cookie: _ga=GA1.2.1034455276.1589351584';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($result, true);
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        break;
    default:
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $postfields = '{
            "user":"0966624292",
            "msgType":"QUERY_TRAN_HIS_MSG",
            "cmdId":"1595648707024000000",
            "lang":"vi",
            "channel":"APP",
            "time":1595643968789,
            "appVer":"21481",
            "appCode":"2.1.48",
            "deviceOS":"IOS",
            "result":true,
            "errorCode":0,
            "errorDesc":"",
            "extra":{
                "checkSum":"CjkvFGhlnDAMsXZzvZkxpWHvbo9QnCP1o8bMuJlcdOY1rQ0Re2jcGER6G2dnQSbR7iwOFHD0Wy6Vnuq8fQXv0A=="
            },
            "momoMsg":{
                "_class":"mservice.backend.entity.msg.QueryTranhisMsg",
                "begin":1595403200585,
                "end":1595648707024
            }
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://owa.momo.vn/api/sync/QUERY_TRAN_HIS_MSG');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Host: owa.momo.vn:443';
        $headers[] = 'Msgtype: QUERY_TRAN_HIS_MSG';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiMDk2NjYyNDI5MiIsImltZWkiOiI1MzEyMkJFQy00NjEzLTQ4NzMtOTVGMS05MERBOTYzOEM0RUQiLCJCQU5LX0NPREUiOiIxMjM0NSIsIkJBTktfTkFNRSI6IlRNQ1AgTmdv4bqhaSBUaMawxqFuZyBWaeG7h3QgTmFtIiwiVkFMSURfV0FMTEVUX0NPTkZJUk0iOjMsIk1BUF9TQUNPTV9DQVJEIjowLCJOQU1FIjoiTkdVWUVOIFZBTiBET05HIiwiSURFTlRJRlkiOiJDT05GSVJNIiwicGluIjoiR0QxODJqbzBpMnc9IiwicGluX2VuY3J5cHQiOnRydWUsImlhdCI6MTU5NTY0ODc0OCwiZXhwIjoxNTk1NjU0MTQ4fQ.wQ32m98gQjlEvOeqmDqocVvDDNiwAGxgoyuuCpVgOcc';
        $headers[] = 'Accept-Language: vi-vn';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Userhash: b9e4ebb1e42de83f2a6589bf0b255540';
        $headers[] = 'User-Agent: MoMoApp-Release/21481 CFNetwork/1126 Darwin/19.5.0';
        $headers[] = 'Cookie: _ga=GA1.2.1034455276.1589351584';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($result, true);
        echo "<pre>";
        print_r($result);
        echo "</pre>";

        break;
}
