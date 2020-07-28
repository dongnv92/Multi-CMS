<?php
$plugin_config = file_get_contents('config.json');
$plugin_config = json_decode($plugin_config, true);

switch ($path[2]){
    case 'update':
        // Kiểm tra quyền truy cập
        if(!$role['customer']['update']){
            $header['title'] = 'Cập nhật khách hàng, đối tác';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Khách hàng', 'Cập nhật','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng, Đối tác', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Cập nhật']);
                echo admin_error('Cập nhật Khách hàng, Đối tác', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $customer = new Customer($database, $_REQUEST['type']);
        $customer = $customer->get_customer(['customer_id' => $path[3]]);
        if(!$customer || !$_REQUEST['type'] || !$path[3]){
            $header['title'] = 'Cập nhật khách hàng, đối tác';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Khách hàng', 'Cập nhật','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng, Đối tác', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Cập nhật']);
                echo admin_error('Cập nhật Khách hàng, Đối tác', 'Khách hàng, đối tác không tồn tại, vui lòng xem lại.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $customer = $customer['data'];

        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
        ];

        $header['title']    = 'Cập nhật khác hàng, đối tác';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Khách hàng, Đối tác', 'Cập nhật','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng, Đối tác', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Cập nhật']);
        echo formOpen();
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Khách hàng, Khách hàng <small>Cập nhật dữ liệu</small></h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputText('customer_name', [
                                    'label'         => 'Nhập tên khách hàng, tối tác <small class="text-danger">*</small>',
                                    'placeholder'   => 'Nhập tên',
                                    'value'         => $customer['customer_name'],
                                    'autofocus'     => ''
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('customer_code', [
                                    'label'         => 'Mã khách hàng. đối tác <small class="text-danger">Để trống thì hệ thống sẽ tự tạo mã</small>',
                                    'value'         => $customer['customer_code'],
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
                                    'label'             => 'Kiểu khách hàng / đối tác <small class="text-danger">*</small>',
                                    'selected'          => $customer['customer_type']
                                ]
                                )?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputText('customer_address', [
                                    'label'         => 'Địa chỉ khách hàng, đối tác',
                                    'value'         => $customer['customer_address'],
                                    'placeholder'   => 'Nhập địa chỉ'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('customer_phone', [
                                    'label'         => 'Điện thoại khách hàng, đối tác',
                                    'value'         => $customer['customer_phone'],
                                    'placeholder'   => 'Nhập số điện thoại'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('customer_email', [
                                    'label'         => 'Email khách hàng, đối tác',
                                    'value'         => $customer['customer_email'],
                                    'placeholder'   => 'Nhập địa chỉ Email'
                                ])?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 text-left">
                                <?=formInputSelect('customer_status', [
                                    'active'        => 'Hoạt Động',
                                    'not_active'    => 'Tạm Khóa'
                                ],
                                [
                                    'data-live-search'  => 'true',
                                    'selected'          => $customer['customer_status']
                                ]
                                )?>
                                <input type="hidden" name="type" value="<?=$_REQUEST['type']?>">
                            </div>
                            <div class="col-lg-6 text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update',
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
    default:
        // Kiểm tra quyền truy cập
        if(!$role['customer']['manager']){
            $header['title'] = 'Quản lý khách hàng, đối tác';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Khách hàng, đối tác', 'Quản lý','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng, Đối tác', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Quản lý']);
            echo admin_error('Quản lý Khách hàng, Đối tác', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        // Lấy dữ liệu
        $customer   = new Customer($database, $_REQUEST['customer_type']);
        $data       = $customer->get_all();
        $param      = get_param_defaul();

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
            URL_JS . "{$path[1]}",
        ];
        $header['title'] = 'Quản lý khách hàng, đối tác';
        require_once ABSPATH . PATH_ADMIN . '/admin-header.php';
        echo admin_breadcrumbs('Khách hàng, đối tác', 'Quản lý khách hàng, đối tác','Quản lý', [URL_ADMIN . "/{$path[1]}" => 'Khách hàng, đối tác']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card action_bar m-t-15">
                    <?=formOpen('', ['method' => 'GET'])?>
                    <div class="row" style="margin-left : 5px; margin-right : 5px">
                        <div class="col-lg-4 col-md-6 hidden-sm-down">
                            <div class="input-group m-t-10">
                                <span class="input-group-addon"><i class="zmdi zmdi-search"></i></span>
                                <div class="form-line">
                                    <input type="text" autofocus name="search" value="<?=$_REQUEST['search']?>" class="form-control" placeholder="Tìm kiếm ...">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 col-9 text-center d-flex justify-content-center align-items-center">
                            <?=formButton('<i class="material-icons">search</i> Tìm kiếm', ['type' => 'submit', 'class' => 'btn btn-raised btn-outline-info waves-effect'])?>
                        </div>
                        <div class="col-lg-3 col-md-5 col-9 text-right d-flex justify-content-end align-items-center">
                            <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-raised bg-blue waves-effect">Thêm mới</a>
                        </div>
                    </div>
                    <?=formClose()?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="content table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th style="width: 30%" class="text-left align-middle">Tiêu đề</th>
                                <th style="width: 15%" class="text-center align-middle">Tác giả</th>
                                <th style="width: 15%" class="text-center align-middle">Chuyên mục</th>
                                <th style="width: 15%" class="text-center align-middle">Nổi bật</th>
                                <th style="width: 15%" class="text-center align-middle">Thời gian</th>
                                <th style="width: 10%" class="text-center align-middle">Quản lý</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($data['paging']['count_data'] == 0){?>
                                <tr>
                                    <td colspan="6" class="text-center">Dữ liệu trống</td>
                                </tr>
                            <?php }?>
                            <?php
                            foreach ($data['data'] AS $row){
                                ?>
                                <tr>
                                    <td class="text-left align-middle font-weight-bold">
                                        <a title="Xem chi tiết bài viết" class="font-weight-bold" href="<?=URL_ADMIN . "/{$path[1]}/detail/{$row['post_id']}"?>"><?=text_truncate($row['post_title'], 10)?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/". build_query(['post_user' => $row['post_user']])?>"><?=$post_user['user_name']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/". build_query(['post_category' => $row['post_category']])?>"><?=$post_category['data']['meta_name']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=formInputSwitch('post_feature', [
                                            'checked'   => $row['post_feature'] == 'true' ? 'true' : '',
                                            'value'     => 'true',
                                            'label'     => ' '
                                        ])?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['post_last_update'] ? "Sửa lần cuối <p>". view_date_time($row['post_last_update']) ."</p>" : 'Đăng lúc <p>'. view_date_time($row['post_time']) .'</p>'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['post_id']}"?>" title="Cập nhật <?=$row['post_title']?>"><i class="material-icons text-info">mode_edit</i></a>
                                        <a href="javascript:;" data-type="delete" data-id="<?=$row['post_id']?>" title="Xóa <?=$row['post_title']?>"><i class="material-icons text-danger">delete_forever</i></a>
                                    </td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="6" class="text-left">
                                    Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                    Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center clearfix">
                    <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/".build_query($_REQUEST, ['page' => '{page}']))?>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . '/admin-footer.php';
        break;
}