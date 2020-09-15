<?php
switch ($path[2]){
    case 'add':
        $header['title'] = 'Thêm dữ liệu';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
        ?>
        <div class="card">
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#first">Thêm một mã</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#second">Thêm nhiều mã 1 lúc</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active" id="first">
                        <?=formInputText('kplus_code', [
                            'layout'        => 'horizonta',
                            'label'         => '<code>*</code> Mã thẻ',
                            'autofocus'     => 'true',
                            'placeholder'   => 'Mã thẻ gồm 12 chữ số'
                        ])?>
                        <?=formInputText('kplus_expired', [
                            'layout'        => 'horizonta',
                            'label'         => '<code>*</code> Hết hạn',
                            'placeholder'   => 'Nhập ngày hết hạn định dạng dd/mm/yyyy (VD: 24/02/1992)'
                        ])?>
                        <div class="text-center">
                            <?=formButton('THÊM MỚI', [
                                'id' => 'button_add'
                            ])?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="second">
                        <?=formInputTextarea('content', [
                            'placeholder'   => 'Mỗi mã thẻ phân cách bằng dấu xuống dòng. (VD: 135298654521/ - 24/02/1992)',
                            'rows'          =>  10
                        ])?>
                    </div>
                </div>
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