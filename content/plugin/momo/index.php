<?php
switch ($path[2]){
    default:
        $header['title'] = 'Lịch sử giao dịch';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('MOMO', 'Lịch sử giao dịch','Lịch sử', [URL_ADMIN . "/{$path[1]}/" => 'MOMO']);
        ?>
        <div class="card">
            <div class="header">
                <h2>MOMO</h2>
            </div>
            <div class="body">
            <?php
                $momo = new Momo('phone', 'pass', 'otp', 'rkey', 'setupKeyEncrypted', 'imei', 'token', 'onesignalToken');
                echo '<pre>';
                print_r(json_decode($momo->history(2), true));
                echo '</pre>';
            ?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}