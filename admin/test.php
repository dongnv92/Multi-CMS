<?php

$config = [
    'name'              => 'Quản lý khách hàng',
    'unique_identifier' => 'customer',
    'version'           => '0.1',
    'banner'            => 'banner.png',
    'status'            => 'active',
    'menu'              => [
        [
            'text'  => 'Quản lý khách hàng',
            'icon'  => '<i class="zmdi zmdi-accounts-alt"></i>',
            'child' => [
                [
                    'text'      => 'Danh sách khách hàng',
                    'url'       => "URL_ADMIN/customer/",
                    'roles'     => ['customer', 'manager'],
                    'active'    => [[PATH_ADMIN, 'customer', ''], [PATH_ADMIN, 'customer', 'update']]
                ],
                [
                    'text'      => 'Thêm khách hàng',
                    'url'       => "URL_ADMIN/customer/add",
                    'roles'     => ['customer', 'add'],
                    'active'    => [[PATH_ADMIN, 'customer', 'add']]
                ]
            ]
        ]
    ],
    'role_structure'    => [
        'customer' => [
            'manager'   => false,
            'add'       => false
        ]
    ],
    'role_text'         => [
        ''          => 'Plugin Quản lý khách hàng',
        'manager'   => 'Quản lý khách hàng',
        'add'       => 'Thêm khách hàng',
        'update'    => 'Cập nhật khách hàng',
        'delete'    => 'Xoá khách hàng'
    ]
];

function curl($url, $data){
    $curl = curl_init();
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

$data = 'curl -H \'Host: owa.momo.vn:443\' -H \'msgtype: NEXT_PAGE_MSG\' -H \'Accept: application/json\' -H \'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiMDk2NjYyNDI5MiIsImltZWkiOiI1MzEyMkJFQy00NjEzLTQ4NzMtOTVGMS05MERBOTYzOEM0RUQiLCJCQU5LX0NPREUiOiIxMjM0NSIsIkJBTktfTkFNRSI6IlRNQ1AgTmdv4bqhaSBUaMawxqFuZyBWaeG7h3QgTmFtIiwiVkFMSURfV0FMTEVUX0NPTkZJUk0iOjMsIk1BUF9TQUNPTV9DQVJEIjowLCJOQU1FIjoiTkdVWUVOIFZBTiBET05HIiwiSURFTlRJRlkiOiJDT05GSVJNIiwicGluIjoiR0QxODJqbzBpMnc9IiwicGluX2VuY3J5cHQiOnRydWUsImlhdCI6MTU5NTM4NjYxMiwiZXhwIjoxNTk1MzkyMDEyfQ.jjjNOtRC68dSR2uqSHOtqxnmZh8uhrjVYGVs9Gdac6Q\' -H \'Accept-Language: vi-vn\' -H \'Content-Type: application/json\' -H \'userhash: b9e4ebb1e42de83f2a6589bf0b255540\' -H \'User-Agent: MoMoApp-Release/21481 CFNetwork/1126 Darwin/19.5.0\' -H \'Cookie: _ga=GA1.2.1034455276.1589351584; _gid=GA1.2.1968117970.1595328102\' --data-binary \'{"user":"0966624292","msgType":"NEXT_PAGE_MSG","cmdId":"1595386653118000000","lang":"vi","channel":"APP","time":1595386653118,"appVer":"21481","appCode":"2.1.48","deviceOS":"IOS","result":true,"errorCode":0,"errorDesc":"","extra":{"checkSum":"Ucn+PNK+G0yReOTc61CZwgS1eAaFedSGzgTh5+g7XQjV3IGzrr+xI/imSjVZxH46r2cCKDEfvf+HInMGCZf2Iw=="},"momoMsg":{"ID":"b553dc89-ed62-4cda-a246-bae7805348b3","user":"0966624292","commandInd":"1595386620284000000","tranId":1595386620480,"clientTime":1595386620480,"ackTime":1595386620602,"tranType":7,"io":-1,"category":5,"partnerId":"0966624292","partnerCode":"momo","partnerName":"NGUYEN VAN DONG","amount":20000,"status":4,"ownerNumber":"0966624292","ownerName":"20","parentTranType":3,"moneySource":1,"partnerExtra1":"NGUYEN VAN DONG","desc":"ThÃ nh cÃ´ng","serviceName":"Viettel","originalAmount":20000,"serviceId":"EPAY_VIETTEL","quantity":1,"step":2,"lastUpdate":1595386620602,"share":"0.0","receiverType":1,"pageNumber":2,"extras":"{\"vpc_CardType\":\"SML\",\"vpc_TicketNo\":\"171.224.181.135\",\"app_version\":21481,\"request_id_backend\":\"1595386620480_0966624292\",\"business_trans_id\":\"1595386620480_0966624292\",\"ispayment\":1,\"money_source\":1,\"FEE_BANK\":0.0,\"FEE_MOMO\":0.0}","channel":"END_USER","otpType":"NA","_class":"mservice.backend.entity.msg.TranHisMsg"},"pass":"241992"}\' --compressed \'https://owa.momo.vn/api/NEXT_PAGE_MSG/7/EPAY_VIETTEL\'';
$mes = curl('https://owa.momo.vn/public/login', $data);
$mes = json_decode($mes, true);
echo '<pre>';
print_r($mes);
echo '</pre>';