<?php
switch ($path[2]){
    case 'test':
        $string = 'Bưu Cục Hà Nội';
        echo 'Uppercase: '.mb_convert_case($string, MB_CASE_UPPER, "UTF-8").'<br>';
        echo 'Lowercase: '.mb_convert_case($string, MB_CASE_LOWER, "UTF-8").'<br>';
        echo 'Original: '.$string.'<br>';
        break;
    case 'fill':
        $kplus = new Kplus($database);
        $where  = ['kplus_status' => 'unregistered', 'kplus_verify' => 'unchecked'];
        $database->select()->from('dong_kplus')->where($where);
        $database->limit(20);
        $database->order_by('kplus_id', 'DESC');
        $data   = $database->fetch();
        foreach ($data AS $_data){
            $check = $kplus->Register($_data['kplus_code']);
            if($check['msg_card']){
                $data_update = ['kplus_status' => 'registered'];
                $database->where(['kplus_code' => $_data['kplus_code']])->update('dong_kplus', $data_update);
                echo "Check mã thẻ <b>{$_data['kplus_code']}</b>: Đã đăng ký Myk+, đã update thành mã hỏng.<br>";
            }else{
                $data_update = ['kplus_verify' => 'verify'];
                $database->where(['kplus_code' => $_data['kplus_code']])->update('dong_kplus', $data_update);
                echo "Check mã thẻ <b>{$_data['kplus_code']}</b>: Chưa đăng ký Myk+, đã update thành mã đã kiểm định.<br>";
            }
            sleep(1);
        }
        Break;
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
            echo admin_breadcrumbs('Kplus', [URL_ADMIN . "/{$path[1]}/" => 'Kplus'],'Cập nhật');
            echo admin_error('Cập nhật', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $data_option_status = [
            'unregistered'  => 'Chưa đăng ký',
            'registered'    => 'Đã đăng ký',
            'wait'          => 'Đang chờ xác nhận',
            'error'         => 'Mã lỗi'
        ];
        $data_option_verify = [
            'verify'    => 'Đã xác thực',
            'unchecked' => 'Chưa kiểm tra'
        ];

        $kplus  = new Kplus($database);
        $row    = $kplus->getData($path[3]);

        $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"];
        $header['title']    = 'Cập nhật';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Kplus', [URL_ADMIN . "/{$path[1]}/" => 'Kplus'],'Cập nhật');
        ?>
        <div class="row">
            <div class="col-9">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Cập nhật thông tin thẻ</h6></div>
                            <div class="card-tools">
                                <a href="<?=URL_ADMIN."/{$path[1]}"?>" class="link">Danh sách</a>
                            </div>
                        </div>
                        <!-- Title -->
                    </div>
                    <div class="card-inner">
                        <?=formOpen('POST', ['id' => 'add'])?>
                        <div class="row g-4">
                            <div class="col-4">
                                <?=formInputText('kplus_code', [
                                    'label'         => '<code>*</code> Mã thẻ',
                                    'value'         => $row['kplus_code']
                                ])?>
                            </div>
                            <div class="col-4">
                                <?=formInputText('kplus_expired', [
                                    'label'         => '<code>*</code> Ngày hết hạn',
                                    'placeholder'   => 'Nhập ngày hết hạn định dạng dd/mm/yyyy (VD: 24/02/1992)',
                                    'value'         => date('d/m/Y', strtotime($row['kplus_expired']))
                                ])?>
                            </div>
                            <div class="col-4">
                                <?=formInputText('kplus_name', [
                                    'label'         => 'Tên chủ thẻ',
                                    'placeholder'   => 'Tên chủ thẻ. Có thể để trống',
                                    'value'         => $row['kplus_name']
                                ])?>
                            </div>
                            <div class="col-6">
                                <?=formInputSelect('kplus_status', $data_option_status, [
                                    'label'     => 'Trạng thái mã thẻ',
                                    'selected'  => $row['kplus_status']
                                ])?>
                            </div>
                            <div class="col-6">
                                <?=formInputSelect('kplus_verify', $data_option_verify, [
                                    'label'     => 'Xác thực mã thẻ',
                                    'selected'  => $row['kplus_verify']
                                ])?>
                            </div>
                            <div class="col-12 text-center">
                                <?=formButton('CẬP NHẬT', [
                                    'id' => 'button_update'
                                ])?>
                            </div>
                        </div>
                        <?=formClose()?>
                    </div>
                </div>
            </div> <!-- End Col-9 -->
            <div class="col-3">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Update tài khoản</h6></div>
                            <div class="card-tools">
                                <a href="<?=URL_ADMIN."/{$path[1]}"?>" class="link">Danh sách</a>
                            </div>
                        </div>
                        <!-- Title -->
                    </div>
                    <div class="card-inner">
                        <?=formOpen('POST', ['id' => 'add'])?>
                        <div class="row g-4">

                            <div class="col-12 text-center">
                                <?=formButton('Cập Nhật Tải Khoản', [
                                    'id' => 'button_update'
                                ])?>
                            </div>
                        </div>
                        <?=formClose()?>
                    </div>
                </div>
            </div> <!--End Col-3-->
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        // Kiểm tra quyền truy cập
        if(!$role['kplus']['manager']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('Kplus', [URL_ADMIN . "/{$path[1]}/" => 'Kplus'],'Danh sách tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
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
        $select_chatid  = [];

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

        $header['title']    = 'Danh sách mã thẻ';
        $header['toolbar']  = admin_breadcrumbs('Kplus', [URL_ADMIN . "/{$path[1]}/" => 'Kplus'],'Danh sách tài khoản');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
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
                <!--begin::Search Form-->
                <div class="mb-7">
                    <form action="" method="get">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" value="<?=($_REQUEST['search'] ? $_REQUEST['search'] : '')?>" name="search" class="form-control" placeholder="Tìm kiếm ..." />
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Trạng thái:</label>
                                            <select name="kplus_status" class="form-control selectpicker">
                                                <option value="">Tất cả</option>
                                                <?php
                                                foreach ($select_status AS $key => $value){
                                                    echo '<option value="'. $key .'" '. ($_REQUEST['kplus_status'] == $key ? 'selected' : '') .'>'. $value .'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Người Đki:</label>
                                            <select name="kplus_register_by" class="form-control selectpicker">
                                                <option value="">Tất cả</option>
                                                <?php
                                                foreach ($select_chatid AS $key => $value){
                                                    echo '<option value="'. $key .'" '. ($_REQUEST['kplus_register_by'] == $key ? 'selected' : '') .'>'. $value .'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                <button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Search Form-->
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <table class="table table-hover table-head-custom table-row-dashed">
                            <thead>
                            <tr class="text-uppercase">
                                <th style="width: 5%" class="text-center align-middle">ID</th>
                                <th style="width: 15%" class="text-center align-middle">Mã thẻ</th>
                                <th style="width: 15%" class="text-left align-middle">
                                    <?=!$_REQUEST['sort'] ? '<a href="'. URL_ADMIN .'/'. $path[1] . build_query($_REQUEST, ['sort' => 'kplus_expired.desc']) .'">Ngày hết hạn</a>' : '<a href="'. URL_ADMIN .'/'. $path[1] . build_query($_REQUEST, ['sort' => '']) .'">Ngày hết hạn</a>'?>
                                </th>
                                <th style="width: 15%" class="text-center align-middle">Đếm ngày</th>
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
                                    <td class="font-size-lg text-center"><?=$row['kplus_id']?></td>
                                    <td class="text-center align-middle font-size-lg">
                                        <?=$row['kplus_code']?> <?=$row['kplus_verify'] == 'verify' ? '<em class="icon ni ni-check-circle-cut text-primary"></em>' : ''?>
                                    </td>
                                    <td class="text-left align-middle font-size-lg">
                                        <?=date('d/m/Y', strtotime($row['kplus_expired']))?>
                                    </td>
                                    <td class="text-center align-middle font-size-lg">
                                        <?=$kplus->caculatorDate($row['kplus_expired'])?>
                                    </td>
                                    <td class="text-center align-middle font-size-lg">
                                        <?=$kplus->getNameByChatId($row['kplus_register_by']).($row['kplus_register_month'] ? '<br />'.$row['kplus_register_month'].' tháng' : '')?>
                                    </td>
                                    <td class="text-center align-middle font-size-lg">
                                        <?=$kplus->getStatus($row['kplus_status']).($row['kplus_status'] == 'registered' ? '<br />'.($row['kplus_register_payment'] == 'paid' ? '<span class="text-success">Đã thanh toán</span>' : '<span class="text-danger">Chưa thanh toán</span>') : '')?>
                                    </td>
                                    <td class="text-center align-middle font-size-lg">
                                        <?=view_date_time($row['kplus_time']).($row['kplus_register_at'] ? '<br />'.date('d/m/Y', strtotime($row['kplus_register_at'])) : '')?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['kplus_code']}"?>" title="Sửa mã thẻ này"><i class="text-dark-50 flaticon-edit"></i></a>
                                        <a href="javascript:;" title="Xóa mã thẻ này" class="text-danger" data-type="delete" data-id="<?=$row['kplus_code']?>"><i class="text-danger flaticon-delete"></i></a>
                                        <a href="javascript:;" title="Cập nhật trạng thái" class="text-info" data-type="update_status" data-status="<?=in_array($row['kplus_status'], ['unregistered', 'wait']) ? 'registered' : 'unregistered'?>" data-id="<?=$row['kplus_code']?>"><i class="flaticon2-refresh text-info"></i></a>
                                        <a href="javascript:;" title="Cập nhật xác nhận" class="text-warning text-small" data-type="update_verify" data-id="<?=$row['kplus_code']?>"><i class="flaticon2-protected text-success"></i></a>
                                    </td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="9" class="text-left font-size-lg">
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
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}