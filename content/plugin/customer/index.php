<?php
$plugin_config = file_get_contents('config.json');
$plugin_config = json_decode($plugin_config, true);

switch ($path[2]){
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['customer']['add']){
            $header['title'] = 'Thêm khách hàng mới';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Khách hàng', 'Thêm mới khách hàng','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Thêm mới']);
            echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title']    = 'Thêm khách hàng mới';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Khách hàng', 'Thêm mới khách hàng','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Thêm mới']);
        echo formOpen();
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Khách hàng <small>Thêm khách hàng mới</small></h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputText('customer_name', [
                                    'label'         => 'Nhập tên khách hàng, tối tác <small class="text-danger">*</small>',
                                    'placeholder'   => 'Nhập tên',
                                    'autofocus'     => ''
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('customer_code', [
                                    'label'         => 'Mã khách hàng. đối tác <small class="text-danger">Để trống thì hệ thống sẽ tự tạo mã</small>',
                                    'placeholder'   => 'Nhập mã khách hàng / đối tác'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('customer_type', [
                                    'customer'  => 'Khách hàng',
                                    'partner'   => 'Đối tác'
                                ],
                                [
                                    'data-live-search'  => 'true',
                                    'label'             => 'Kiểu khách hàng / đối tác <small class="text-danger">*</small>'
                                ])?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputText('customer_address', [
                                    'label'         => 'Địa chỉ khách hàng, đối tác',
                                    'placeholder'   => 'Nhập địa chỉ'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('customer_phone', [
                                    'label'         => 'Điện thoại khách hàng, đối tác',
                                    'placeholder'   => 'Nhập số điện thoại'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('customer_email', [
                                    'label'         => 'Email khách hàng, đối tác',
                                    'placeholder'   => 'Nhập địa chỉ Email'
                                ])?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <?=formButton('THÊM', [
                                    'id'    => 'button_add',
                                    'class' => 'btn btn-raised bg-blue waves-effect'
                                ])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}