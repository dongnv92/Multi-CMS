<?php
switch ($path[2]){
    default:
        $header['title'] = 'POS';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('MOMO', 'Lịch sử giao dịch','Lịch sử', [URL_ADMIN . "/{$path[1]}/" => 'MOMO']);
        ?>

        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}