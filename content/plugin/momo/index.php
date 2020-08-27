<?php
switch ($path[2]){
    default:
        $momo_phone              = '0966624292';
        $momo_password           = '241992';
        $momo_otp                = '761912'; // (*) mã OTP gửi về điện thoại khi login
        $momo_rkey               = 'hM7iCzZHMpB1JkRdZXHM'; // (*) 20 ký tự, xem trong public/login
        $momo_setupKeyEncrypted  = "OSuXozNZ9q42GSf1xvw9GSU/+vr6s90xV87+PdjtGlw5KmmRVj9TMEd2H0pv3g/S"; // (*): Xem trong public
        $momo_imei               = "53122BEC-4613-4873-95F1-90DA9638C4ED";
        $momo_token              = 'dfdjCewLGlE:APA91bEyR_lpb8CN6eghznFGMuPzSPpr9qb7Z8SlBJa3zeReBopzKQvsdf7QAkVBEnWKK3dX-uyFsPPy0Yrsbxq3Gh6KzqdFDnXGjNrzK5FeXwtPfhO8cfYgvjVWCxBZpIaXzBhVf7Lc';
        $momo_onesignalToken     = 'a12e8af7-4f94-4fbd-9983-64aa2e938ac5';

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
                $momo = new Momo($momo_phone, $momo_password, $momo_otp, $momo_rkey, $momo_setupKeyEncrypted, $momo_imei, $momo_token, $momo_onesignalToken);
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