<?php
switch ($path[2]){
    default:
        $header['title'] = 'Telegram';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('MOMO', 'Lịch sử giao dịch','Lịch sử', [URL_ADMIN . "/{$path[1]}/" => 'MOMO']);
        ?>
        <div class="card">
            <div class="header">
                <h2>Telegram</h2>
            </div>
            <div class="body">
            <?php
            $rentcode_apikey    = 'MsxlaU40YLImmynR8ByMAGEaosizG9YOeNa9TI/RpsQ=';
            $rentcode_service   = 258; // 258: Kplus, Dịch vụ khác: 2
            $telegram = new Telegram('rentcode');
            $url_fetch  = 'https://api.rentcode.net/api/v2/order/request';
            if(isset($message[1]) && in_array($message[1], [258, 2])){
                $rentcode_service = $message[1];
            }
            $fetch  = $telegram->get_data($url_fetch, ['apiKey' => $rentcode_apikey, 'ServiceProviderId' => $rentcode_service], 'GET');
            $fetch  = json_decode($fetch, true);
            print_r($fetch);
            ?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}