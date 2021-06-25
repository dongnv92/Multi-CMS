<?php
switch ($path[2]){
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['kplus']['add']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
            echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title'] = 'Thêm mã thẻ mới';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Thêm mã thẻ mới', [URL_ADMIN."/kplus" => 'Kplus'], 'Thêm mã mới');
        ?>
        <div class="card card-bordered">
            <div class="card-inner border-bottom">
                <!-- Title -->
                <div class="card-title-group">
                    <div class="card-title"><h6 class="title">Thêm mã thẻ mới</h6></div>
                    <div class="card-tools"><a href="<?=URL_ADMIN . "/{$path[1]}/"?>" class="link">Danh sách</a></div>
                </div>
                <!-- Title -->
            </div>
            <!-- Content -->
            <div class="card-inner">
                <?=formOpen('POST', ['id' => 'add'])?>
                <?=formInputText('kplus_code', [
                    'layout'        => 'outlined',
                    'label'         => 'Mã thẻ (12 chữ số) *'
                ])?>
                <?=formInputText('kplus_expired', [
                    'layout'        => 'outlined',
                    'label'         => 'Ngày hết hạn (VD: 31/12/2020) *'
                ])?>
                <?=formInputText('kplus_name', [
                    'layout'        => 'outlined',
                    'label'         => 'Tên chủ thuê bao'
                ])?>
                <div class="text-center">
                    <?=formButton('CHECK NAME', [
                        'id'    => 'button_checkname',
                        'class' => 'btn btn-danger'
                    ])?>
                    <?=formButton('THÊM MỚI', [
                        'id' => 'button_adds'
                    ])?>
                </div>
                <?=formClose()?>
            </div>
            <!-- End Content -->
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    case 'update':
        // Kiểm tra quyền truy cập
        if(!$role['kplus']['manager']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
            echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $kplus  = new Kplus($database);
        $row    = $kplus->getData($path[3]);

        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
        ];
        $header['title'] = 'Cập nhật';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
        ?>
        <div class="card">
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#first">Thêm một mã</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active" id="first">
                        <?=formOpen('POST', ['id' => 'add'])?>
                        <?=formInputText('kplus_code', [
                            'layout'        => 'horizonta',
                            'label'         => '<code>*</code> Mã thẻ',
                            'autofocus'     => 'true',
                            'placeholder'   => 'Mã thẻ gồm 12 chữ số',
                            'value'         => $row['kplus_code']
                        ])?>
                        <?=formInputText('kplus_expired', [
                            'layout'        => 'horizonta',
                            'label'         => '<code>*</code> Hết hạn',
                            'placeholder'   => 'Nhập ngày hết hạn định dạng dd/mm/yyyy (VD: 24/02/1992)',
                            'value'         => date('d/m/Y', strtotime($row['kplus_expired']))
                        ])?>
                        <?=formInputText('kplus_name', [
                            'layout'        => 'horizonta',
                            'label'         => 'Tên chủ thẻ',
                            'autofocus'     => 'true',
                            'placeholder'   => 'Tên chủ thẻ. Có thể để trống',
                            'value'         => $row['kplus_name']
                        ])?>
                        <div class="text-center">
                            <a href="<?=URL_ADMIN."/{$path[1]}"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                            <?=formButton('CẬP NHẬT', [
                                'id' => 'button_update'
                            ])?>
                        </div>
                        <?=formClose()?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        // Kiểm tra quyền truy cập
        if(!$role['kplus']['manager']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Kplus', [URL_ADMIN . "/{$path[1]}/" => 'Kplus'],'Danh sách tài khoản');
            echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        // Lấy dữ liệu
        $kplus  = new Kplus($database);
        $data   = $kplus->get_all();
        $param  = get_param_defaul();
        $static = $kplus->getStatics();
        $list_chatid    = $kplus->getListChatid();
        $select_chatid  = [' ' => 'Người đăng ký'];

        foreach ($list_chatid AS $_list_chatid){
            $select_chatid[$_list_chatid] = $kplus->getNameByChatId($_list_chatid);
        }

        $select_payment = [
            ' '         => 'Thanh toán',
            'paid'      => 'Đã thanh toán',
            'unpaid'    => 'Chưa thanh toán'
        ];

        $select_status = [
            '' => 'Tất cả ('. $static['all'] .')',
            'unregistered'  => 'Chưa đăng ký ('. $static['unregistered'] .')',
            'wait'          => 'Đang chờ ('. $static['wait'] .')',
            'registered'    => 'Đã đăng ký ('. $static['registered'] .')',
            'error'         => 'Thẻ lỗi ('. $static['error'] .')'
        ];

        $header['js']       = [URL_JS . "{$path[1]}",];

        $header['title'] = 'Danh sách mã thẻ';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', [URL_ADMIN . "/{$path[1]}/" => 'Kplus'],'Danh sách tài khoản');
        ?>
        <div class="row">
            <div class="col-lg-6">
                Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                <?php
                if($_REQUEST['kplus_register_by'] && $_REQUEST['kplus_register_payment']){
                    $month_unpaid = $kplus->getMonthUnPaid($_REQUEST['kplus_register_by']);
                    if($month_unpaid > 0){
                        echo "<strong>$month_unpaid</strong> tháng chưa thanh toán. <a href='javascript:;' id='confirm_paid' data-id='{$_REQUEST['kplus_register_by']}'>Xác nhận thanh toán</a>";
                    }
                }
                ?>
                <br />
                <a href="<?=URL_ADMIN."/{$path[1]}/"?>">Làm mới</a> | <a href="<?=URL_ADMIN."/{$path[1]}/add"?>">Thêm mới</a>
            </div>
            <div class="col-lg-6 text-right">
                <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/".build_query($_REQUEST, ['page' => '{page}']))?>
            </div>
            <div class="col-lg-12">
                <div class="card card-bordered card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <?=formOpen('', ['method' => 'GET'])?>
                            <div class="row">
                                <div class="col-2">
                                    <?=formInputText('search', [
                                        'label' => 'Tìm kiếm',
                                        'value' => $_REQUEST['search'] ? $_REQUEST['search'] : ''
                                    ])?>
                                </div>
                                <div class="col-2">
                                    <?=formInputSelect('kplus_status', $select_status, [
                                        'data-search'   => 'on',
                                        'selected'      => $_REQUEST['kplus_status'
                                        ]
                                    ])?>
                                </div>
                                <div class="col-2">
                                    <?=formInputSelect('kplus_register_by', $select_chatid, [
                                        'data-search'   => 'on',
                                        'selected'      => $_REQUEST['kplus_register_by']
                                    ])?>
                                </div>
                                <div class="col-2">
                                    <?=formInputSelect('kplus_register_payment', $select_payment, [
                                        'data-search'   => 'on',
                                        'selected'      => $_REQUEST['kplus_register_payment']
                                    ])?>
                                </div>
                                <div class="col-2">
                                    <?=formButton('<em class="icon ni ni-search"></em> Tìm kiếm', ['type' => 'submit', 'class' => 'btn btn-outline-primary'])?>
                                </div>
                            </div>
                            <?=formClose()?>
                        </div>
                        <div class="card-inner p-0">
                            <div class="content table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%" class="text-left align-middle">Mã thẻ</th>
                                        <th style="width: 20%" class="text-left align-middle">
                                            <?=!$_REQUEST['sort'] ? '<a href="'. URL_ADMIN .'/'. $path[1] . build_query($_REQUEST, ['sort' => 'kplus_expired.desc']) .'">Ngày hết hạn</a>' : '<a href="'. URL_ADMIN .'/'. $path[1] . build_query($_REQUEST, ['sort' => '']) .'">Ngày hết hạn</a>'?>
                                        </th>
                                        <th style="width: 10%" class="text-left align-middle">Đếm ngày</th>
                                        <th style="width: 10%" class="text-center align-middle">Người Đkí/Tháng</th>
                                        <th style="width: 15%" class="text-center align-middle">Trạng thái</th>
                                        <th style="width: 10%" class="text-center align-middle">Ngày thêm/Đkí</th>
                                        <th style="width: 15%" class="text-center align-middle">Quản lý</th>
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
                                            <td class="text-left align-middle">
                                                <?=$row['kplus_code']?> <?=$row['kplus_verify'] == 'verify' ? '<em class="icon ni ni-check-circle-cut text-primary"></em>' : ''?>
                                            </td>
                                            <td class="text-left align-middle">
                                                <?=date('d/m/Y', strtotime($row['kplus_expired']))?>
                                            </td>
                                            <td class="text-left align-middle">
                                                <?=$kplus->caculatorDate($row['kplus_expired'])?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=$kplus->getNameByChatId($row['kplus_register_by']).($row['kplus_register_month'] ? '<br />'.$row['kplus_register_month'].' tháng' : '')?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=$kplus->getStatus($row['kplus_status']).($row['kplus_status'] == 'registered' ? '<br />'.($row['kplus_register_payment'] == 'paid' ? '<span class="text-success">Đã thanh toán</span>' : '<span class="text-danger">Chưa thanh toán</span>') : '')?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=view_date_time($row['kplus_time']).($row['kplus_register_at'] ? '<br />'.date('d/m/Y', strtotime($row['kplus_register_at'])) : '')?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['kplus_code']}"?>" title="Sửa mã thẻ này"><em class="icon ni ni-edit-fill"></em></a>
                                                <a href="javascript:;" title="Xóa mã thẻ này" class="text-danger" data-type="delete" data-id="<?=$row['kplus_code']?>"><em class="icon ni ni-trash"></em></a>
                                                <a href="javascript:;" title="Cập nhật trạng thái" class="text-info" data-type="update_status" data-status="<?=in_array($row['kplus_status'], ['unregistered', 'wait']) ? 'registered' : 'unregistered'?>" data-id="<?=$row['kplus_code']?>"><em class="icon ni ni-update"></em></a>
                                                <a href="javascript:;" title="Cập nhật xác nhận" class="text-warning text-small" data-type="update_verify" data-id="<?=$row['kplus_code']?>"><em class="icon ni ni-shield-check"></em></a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="9" class="text-left">
                                            Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                            Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}