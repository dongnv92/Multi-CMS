<?php
switch ($path[2]){
    default:
        $header['title'] = 'Telegram';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Cấu Hình');
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
                    $telegram = new Telegram('citypost_notice');
                    $telegram->set_chatid('-506790604');
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