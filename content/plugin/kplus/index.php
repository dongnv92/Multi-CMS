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
                        <?=formOpen('POST', ['id' => 'add'])?>
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
                        <?=formInputText('kplus_name', [
                            'layout'        => 'horizonta',
                            'label'         => 'Tên chủ thẻ',
                            'autofocus'     => 'true',
                            'placeholder'   => 'Tên chủ thẻ. Có thể để trống'
                        ])?>
                        <div class="text-center">
                            <?=formButton('THÊM MỚI', [
                                'id' => 'button_add'
                            ])?>
                        </div>
                        <?=formClose()?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="second">
                        <?=formOpen('POST', ['id' => 'adds'])?>
                        <?=formInputText('kplus_expired', [
                            'label'         => '<code>*</code> Hết hạn',
                            'placeholder'   => 'Nhập ngày hết hạn định dạng dd/mm/yyyy (VD: 24/02/1992)'
                        ])?>
                        <?=formInputTextarea('content', [
                            'placeholder'   => 'Mỗi mã thẻ phân cách bằng dấu xuống dòng. (VD: 135298654521/ - 24/02/1992)',
                            'rows'          =>  10
                        ])?>
                        <div class="text-center">
                            <?=formButton('THÊM MỚI', [
                                'id' => 'button_adds'
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
            echo admin_breadcrumbs('Kplus', 'Danh sách tài khoản','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
            echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        // Lấy dữ liệu
        $kplus  = new Kplus($database);
        $data   = $kplus->get_all();
        $param  = get_param_defaul();

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
            URL_JS . "{$path[1]}",
        ];

        $header['title'] = 'Danh sách mã thẻ';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', 'Danh sách mã thẻ','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'Kplus']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <a href="<?=URL_ADMIN . "/{$path[1]}"?>" class="text-small">Chưa đăng ký</a> |
                <a href="<?=URL_ADMIN . "/{$path[1]}/?kplus_status=wait"?>" class="text-small text-success">Đang chờ đăng ký</a> |
                <a href="<?=URL_ADMIN . "/{$path[1]}/?kplus_status=registered"?>" class="text-small text-danger">Đã đăng ký</a>
            </div>
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
                        <div class="col-lg-6 col-md-5 col-9 text-right d-flex justify-content-end align-items-center">
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
                                <th style="width: 20%" class="text-left align-middle">Mã thẻ</th>
                                <th style="width: 20%" class="text-left align-middle">
                                    <?=!$_REQUEST['sort'] ? '<a href="'. URL_ADMIN .'/'. $path[1] .'?sort=kplus_expired.desc">Ngày hết hạn</a>' : '<a href="'. URL_ADMIN .'/'. $path[1] .'">Ngày hết hạn</a>'?>
                                </th>
                                <th style="width: 15%" class="text-left align-middle">Đếm ngày</th>
                                <th style="width: 15%" class="text-center align-middle">Trạng thái</th>
                                <th style="width: 10%" class="text-center align-middle">Ngày thêm</th>
                                <th style="width: 20%" class="text-center align-middle">Quản lý</th>
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
                                        <?=$row['kplus_code']?>
                                    </td>
                                    <td class="text-left align-middle">
                                        <?=date('d/m/Y', strtotime($row['kplus_expired']))?>
                                    </td>
                                    <td class="text-left align-middle">
                                        <?=$kplus->caculatorDate($row['kplus_expired'])?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['kplus_status'] == 'unregistered' ? '<span class="text-success">Chưa đăng ký</span>' : '<span class="text-danger">Đã đăng ký</span>'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=view_date_time($row['kplus_time'])?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['kplus_code']}"?>" title="Sửa mã thẻ này"><i class="material-icons">mode_edit</i></a>
                                        <a href="javascript:;" title="Xóa mã thẻ này" class="text-danger" data-type="delete" data-id="<?=$row['kplus_code']?>"><i class="material-icons">delete</i></a>
                                        <a href="javascript:;" title="Cập nhật trạng thái" class="text-info" data-type="update_status" data-status="<?=in_array($row['kplus_status'], ['unregistered', 'wait']) ? 'registered' : 'unregistered'?>" data-id="<?=$row['kplus_code']?>"><i class="material-icons">flash_on</i></a>
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
                <div class="text-center clearfix">
                    <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/".build_query($_REQUEST, ['page' => '{page}']))?>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}