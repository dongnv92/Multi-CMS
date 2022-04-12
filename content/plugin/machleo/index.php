<?php
switch ($path[2]) {
    case 'add':
        $header['title'] = 'Thêm Mách Lẻo';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Mách Lẻo', [URL_ADMIN . "/{$path[1]}/" => 'Mách Lẻo'],'Thêm Mới Mách Lẻo');
        ?>

        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        echo 'default';
        break;
}