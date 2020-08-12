<?php
switch ($path[2]){
    default:
        $header['title'] = 'Lịch sử giao dịch';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('MOMO', 'Lịch sử giao dịch','Lịch sử', [URL_ADMIN . "/{$path[1]}/" => 'MOMO']);
        
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}