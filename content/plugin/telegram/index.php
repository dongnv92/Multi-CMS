<?php
header('Content-Type: text/html; charset=utf-8');
switch ($path[2]){
    case 'test':
        $string = 'BƯU CỤC H&#192; NỘI Đ&#227; lấy h&#224;ng (HN Kiểm So&#225;t Hafele - 1241654564)';
        echo html_entity_decode($string);
        break;
    default:
        $header['title'] = 'Telegram';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Cấu Hình');
        $token = $_REQUEST['token'];
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Tiêu đề</h6></div>
                            <div class="card-tools">
                                <a href="#" class="link">Xem tất cả</a>
                            </div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                    <?php
                    if($token){
                        $telegram = new Telegram($token);
                        echo "<pre>";
                        print_r(json_decode($telegram->getUpdates(), true));
                        echo "</pre>";
                    }
                    ?>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}