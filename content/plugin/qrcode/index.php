<?php
switch ($path[2]){
    default:
        $header['title']    = 'Tạo mã QR CODE';
        $header['toolbar']  = admin_breadcrumbs('Tạo mã QR Code', [URL_ADMIN . "/{$path[1]}/" => 'QRCODE'],'Tạo mã QR Code');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        $data   = new QRCode('http://localhost/dong/multicms/admin/qrcode/');
        $data->setConfig([
            'bgColor' => '#FFFFFF',
            'body' => 'diamond',
            'bodyColor' => '#0277bd',
            'brf1' => [],
            'brf2' => [],
            'brf3' => [],
            'erf1' => [],
            'erf2' => [],
            'erf3' => [],
            'eye' => 'frame12',
            'eye1Color' => '#000000',
            'eye2Color' => '#000000',
            'eye3Color' => '#000000',
            'eyeBall' => 'ball14',
            'eyeBall1Color' => '#000000',
            'eyeBall2Color' => '#000000',
            'eyeBall3Color' => '#000000',
            'gradientColor1' => '#0277bd',
            'gradientColor2' => '#000000',
            'gradientOnEyes' => 'true',
            'gradientType' => 'linear',
        ]);
        $data->setSize(200);
        $qr     = $data->create();
        echo '<img src="'. $qr .'" />';
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
    break;
}