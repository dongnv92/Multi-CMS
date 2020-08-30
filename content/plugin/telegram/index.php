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
                $telegram = new Telegram('rentcode');
                echo $telegram->getUpdates();
            ?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}