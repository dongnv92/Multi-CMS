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
            ?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}