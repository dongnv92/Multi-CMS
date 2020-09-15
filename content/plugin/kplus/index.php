<?php
switch ($path[2]){
    case 'add':
        $header['title'] = 'Kplus';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
        ?>
        <div class="card">
            <div class="header">
                <h2>Danh sách</h2>
            </div>
            <div class="body">
                <?php
                ?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        $header['title'] = 'Kplus';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
        ?>
        <div class="card">
            <div class="header">
                <h2>Danh sách</h2>
            </div>
            <div class="body">
            <?php
            ?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}