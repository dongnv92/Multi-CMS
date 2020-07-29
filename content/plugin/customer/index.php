<?php
$plugin_config = file_get_contents('config.json');
$plugin_config = json_decode($plugin_config, true);

switch ($path[2]){
    case 'detail':
        // Kiểm tra quyền truy cập
        if(!$role['customer']['manager']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Khách hàng, Đối tác', 'Chi tiết khách hàng, đối tác','Chi tiết', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng, Đối tác']);
            echo admin_error('Chi tiết khách hàng, đối tác', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $customer_data = new Customer($database);
        $customer = $customer_data->get_customer(['customer_id' => $path[3]]);

        if(!$customer || !$path[3]){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Khách hàng, Đối tác', 'Chi tiết khách hàng, đối tác','Chi tiết', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng, Đối tác']);
            echo admin_error('Chi tiết Khách hàng, Đối tác', 'Khách hàng, đối tác không tồn tại, vui lòng xem lại.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $customer   = $customer['data'];
        $type       = $customer['customer_type'] == 'customer' ? 'Khách hàng' : 'Đối tác';
        $customer_user = new user($database);
        $customer_user = $customer_user->get_user(['user_id' => $customer['customer_user']]);

        $header['title'] = $type.' '.$customer['customer_name'];
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs($type, $header['title'],'Chi tiết', [URL_ADMIN . "/{$path[1]}/" => $type]);
        ?>
        <div class="row clearfix">
            <div class="col-xl-4 col-lg-5 col-md-12">
                <div class="card member-card">
                    <div class="header l-blue">
                        <h4 class="m-t-0"><?=$customer['customer_name']?></h4>
                        <p><?=$customer['customer_code']?></p>
                    </div>
                    <div class="member-img">
                        <a href="">
                            <img class="rounded-circle" src="http://sms.topcongty.vn/administrator/assets/images/avatar/12.png"  alt="Nguyễn Đông">
                        </a>
                    </div>
                    <div class="body">
                        <div class="col-12">
                            <p class="text-muted">
                                <span class="font-weight-bold">Địa chỉ</span>: <?=$customer['customer_address'] ? $customer['customer_address'] : '---'?><br>
                                <span class="font-weight-bold">Điện thoại</span>: <?=$customer['customer_phone'] ? $customer['customer_phone'] : '---'?><br>
                                <span class="font-weight-bold">Email</span>: <?=$customer['customer_email'] ? $customer['customer_email'] : '---'?><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Chi tiết <?=$type?> <?=$customer['customer_name']?></h2>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="<?=URL_ADMIN."/{$path[1]}"?>" class="btn btn-raised bg-blue waves-effect">Danh sách</a>
                                <a href="<?=URL_ADMIN."/{$path[1]}/update/{$path[3]}?type={$customer['customer_type']}"?>" class="btn btn-raised bg-blue waves-effect">Cập nhật</a>
                                <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-raised bg-blue waves-effect">Thêm mới</a>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive">
                        <table class="table table hover">
                            <tbody>
                            <tr>
                                <td style="width: 25%" class="text-right">Họ Tên</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer['customer_name']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Mã <?=$type?></td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer['customer_code']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Khách hàng / Đối tác</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$type?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Địa chỉ</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer['customer_address'] ? $customer['customer_address'] : '---'?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Điện thoại</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer['customer_phone'] ? $customer['customer_phone'] : '---'?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Email</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer['customer_email'] ? $customer['customer_email'] : '---'?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Người thêm</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer_user['user_name']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Trạng thái</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer_data->get_status($customer['customer_status'])?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Ngày tạo</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=view_date_time($customer['customer_time'])?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Lần sửa đổi gần nhất</td>
                                <td style="width: 75%" class="font-bold text-danger"><?=$customer['customer_last_update'] ? view_date_time($customer['customer_last_update']) : '---'?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
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
            echo admin_error('Quản lý Khách hàng, Đối tác', 'Bạn không có quyền truy cập hoặc đường dẫn sai, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        // Lấy dữ liệu
        $customer   = new Customer($database, (in_array($_REQUEST['customer_type'], ['customer', 'partner']) ? $_REQUEST['customer_type'] : 'customer'));
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
                        <div class="col-lg-3 col-md-5 col-9 text-center d-flex justify-content-center align-items-center">
                            <?=formInputSelect('customer_type', ['customer' => 'Khách hàng', 'partner' => 'Đối tác'], ['data-live-search' => 'true', 'selected' => $_REQUEST['customer_type']])?>
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
                                <th style="width: 15%" class="text-center align-middle">Mã</th>
                                <th style="width: 15%" class="text-center align-middle">Họ tên</th>
                                <th style="width: 20%" class="text-center align-middle">Địa chỉ</th>
                                <th style="width: 15%" class="text-center align-middle">Điện thoại</th>
                                <th style="width: 15%" class="text-center align-middle">Email</th>
                                <th style="width: 10%" class="text-center align-middle">Thời gian</th>
                                <th style="width: 10%" class="text-center align-middle">Quản lý</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($data['paging']['count_data'] == 0){?>
                                <tr>
                                    <td colspan="7" class="text-center">Dữ liệu trống</td>
                                </tr>
                            <?php }?>
                            <?php
                            foreach ($data['data'] AS $row){
                                ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <a title="Xem chi tiết" class="font-weight-bold" href="<?=URL_ADMIN . "/{$path[1]}/detail/{$row['customer_id']}"?>"><?=$row['customer_code']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['customer_name']?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=text_truncate($row['customer_address'] ? $row['customer_address'] : '---', 5)?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=text_truncate($row['customer_phone'] ? $row['customer_phone'] : '---', 1)?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=text_truncate($row['customer_email'] ? $row['customer_email'] : '---', 1)?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['customer_last_update'] ? "Sửa lần cuối <p>". view_date_time($row['customer_last_update']) ."</p>" : 'Đăng lúc <p>'. view_date_time($row['customer_time']) .'</p>'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['customer_id']}?type={$row['customer_type']}"?>" title="Cập nhật <?=$row['customer_name']?>"><i class="material-icons text-info">mode_edit</i></a>
                                        <a href="javascript:;" data-type="delete" data-id="<?=$row['customer_id']?>" title="Xóa <?=$row['customer_name']?>"><i class="material-icons text-danger">delete_forever</i></a>
                                    </td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="7" class="text-left">
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