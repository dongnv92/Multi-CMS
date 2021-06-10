<?php
switch ($path[2]){
    case 'oil':
        switch ($path[3]){
            case 'view':
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['oil_manager'] && !$role['driving_team']['oil_add']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Chi tiết đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Đổ dầu'],'Chi tiết đổ dầu');
                    echo admin_error('Chi tiết đổ dầu', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }
                $oil  = new pDriving();
                $data = $oil->get_caroil($path[4]);

                $car        = new meta($database, 'listcar_category');
                $get_car    = $car->get_meta($data['caroil_bsx']);

                $tx         = new user($database);
                $get_tx     = $tx->get_user(['user_id' => $data['caroil_tx']]);
                $get_user   = $tx->get_user(['user_id' => $data['caroil_user']]);

                // Kiểm tra tồn tại của path 4
                if(!$data){
                    $header['title'] = 'Lỗi không tồn tại';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Chi tiết đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Đổ dầu'],'Chi tiết đổ dầu');
                    echo admin_error('Chi tiết đổ dầu', 'Lỗi không tồn tại, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $header['title'] = 'Chi tiết đổ dầu';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Chi tiết đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Đổ dầu'],'Chi tiết đổ dầu');
                ?>
                <div class="nk-block">
                    <div class="invoice">
                        <div class="invoice-wrap">
                            <div class="invoice-brand text-center">
                                <img src="<?=get_config('logo')?>" alt="">
                            </div>
                            <div class="invoice-head">
                                <div class="invoice-contact">
                                    <span class="overline-title">Hoá Đơn Của</span>
                                    <div class="invoice-contact-info">
                                        <h4 class="title"><?=$get_tx['user_name']?></h4>
                                        <ul class="list-plain">
                                            <li><em class="icon ni ni-map-pin-fill"></em><span>Cửa hàng xăng dầu số 8 - 190, Đại Mỗ, P. Đại Mỗ, Q. Nam Từ Liêm, Tp. Hà Nội</span></li>
                                            <li><em class="icon ni ni-call-fill"></em><span><?=$get_tx['user_phone']?></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-desc">
                                    <h3 class="title">HOÁ ĐƠN</h3>
                                    <ul class="list-plain">
                                        <li class="invoice-id"><span>Số Phiếu</span>:<span><?=$data['caroil_code']?></span></li>
                                        <li class="invoice-date"><span>Ngày Đổ</span>:<span><?=date('d/m/Y', strtotime($data['caroil_date']))?></span></li>
                                        <li class="invoice-date"><span>Người Nhập</span>:<span><?=$get_user['user_name']?></span></li>
                                    </ul>
                                </div>
                            </div><!-- .invoice-head -->
                            <div class="invoice-bills">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="w-150px">ID Phiếu</th>
                                            <th class="w-60">Mô Tả</th>
                                            <th>Giá/Lít</th>
                                            <th>Số Lượng (Lít)</th>
                                            <th>Thành Tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tfoot>
                                        <tr>
                                            <td><?=$data['caroil_id']?></td>
                                            <td>Xe <strong class="text-pink"><?=$get_car['data']['meta_name']?></strong> đổ dầu ngày <strong class="text-pink"><?=date('d/m/Y', strtotime($data['caroil_date']))?></strong></td>
                                            <td><?=convert_number_to_money($data['caroil_price'])?></td>
                                            <td><?=$data['caroil_lit']?></td>
                                            <td><?=convert_number_to_money($data['caroil_price']*$data['caroil_lit'])?></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <div class="nk-notes ff-italic fs-12px text-soft"> Ghi chú: <?=$data['caroil_note']?$data['caroil_note']:'Không có ghi chú cho đơn này.'?>. </div>
                                    <hr />
                                    <div>
                                        <p>Hình Ảnh</p>
                                        <p class="text-center">
                                            <?php
                                            if($data['cariol_image']){
                                                echo '<img src="'. URL_HOME .'/'. $data['cariol_image'] .'" />';
                                            }else{
                                                echo "Không có hình ảnh";
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- .invoice-bills -->
                        </div><!-- .invoice-wrap -->
                    </div><!-- .invoice -->
                </div><!-- .nk-block -->
                <?php
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['oil_add']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Thêm đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế đổ dầu'],'Thêm đổ dầu');
                    echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $list_car   = new Category('driving_team');
                $list_car   = $list_car->getOptionSelect();

                $list_user  = new user($database);
                $list_user  = $list_user->get_all_user_option();

                if($_REQUEST['submit']){
                    $error = $success = '';
                    $oil = new pDriving();
                    $add = $oil->add_oil();
                    if($add['response'] == 200){
                        require_once ABSPATH . 'includes/class/class.uploader.php';
                        if($_FILES['meta_image']){
                            $path_upload        = 'content/plugin/driving_team/upload/';
                            $uploader           = new Uploader();
                            $data_upload        = $uploader->upload($_FILES['meta_image'], array(
                                'limit'         => 1, //Maximum Limit of files. {null, Number}
                                'maxSize'       => 2, //Maximum Size of files {null, Number(in MB's)}
                                'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                                'required'      => true, //Minimum one file is required for upload {Boolean}
                                'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                                'title'         => array('auto', 15), //New file name {null, String, Array} *please read documentation in README.md
                                'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                                'replace'       => false, //Replace the file if it already exists {Boolean}
                                'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                            ));

                            if($data_upload['isSuccess']){
                                $data_images    = $path_upload . $data_upload['data']['metas'][0]['name'];
                                $update_image   = $oil->update_image_oil($add['data'], $data_images);
                            }
                        }
                        $success = alert('success', $add['message']);
                    }else{
                        $error = alert('error', $add['message']);
                    }
                }

                $header['title']    = 'Thêm phiếu đổ dầu';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Thêm đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế đổ dầu'],'Thêm đổ dầu');
                echo formOpen('', ['method' => 'POST', 'enctype' => 'true'])
                ?>
                <div class="row justify-content-center">
                    <div class="col-9">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <!-- Title -->
                                <div class="card-title-group">
                                    <div class="card-title"><h6 class="title">Thêm phiếu đổ dầu</h6></div>
                                    <div class="card-tools">
                                        <a href="#" class="link">Danh sách</a>
                                    </div>
                                </div>
                                <!-- Title -->
                            </div>
                            <!-- Content -->
                            <div class="card-inner g-4">
                                <?=$error?$error:''?>
                                <?=$success?$success:''?>
                                <div class="row">
                                    <div class="col-6">
                                        <?=formInputText('caroil_date', [
                                            'placeholder'   => 'Chọn ngày đổ dầu',
                                            'layout'        => 'date',
                                            'value'         => $_REQUEST['caroil_date']
                                        ])?>
                                    </div>
                                    <div class="col-6">
                                        <?=formInputText('caroil_code', [
                                            'label' => 'Mã phiếu',
                                            'value' => $_REQUEST['caroil_code']
                                        ])?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <?=formInputSelect('caroil_bsx', $list_car, [
                                            'label'         => 'Biển Số Xe',
                                            'data-search'   => 'on',
                                            'selected'      => $_REQUEST['caroil_bsx']
                                        ])?>
                                    </div>
                                    <div class="col-6">
                                        <?=formInputSelect('caroil_tx', $list_user, [
                                            'label'             => 'Lái xe đổ dầu',
                                            'data-search'       => 'on',
                                            'data-placeholder'  => 'Chọn lái xe đổ dầu',
                                            'selected'          => $_REQUEST['caroil_tx']
                                        ])?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <?=formInputText('caroil_lit', [
                                            'label' => 'Số lượng dầu (Lít)',
                                            'value' => $_REQUEST['caroil_lit']
                                        ])?>
                                    </div>
                                    <div class="col-6">
                                        <?=formInputText('caroil_price', [
                                            'label' => 'Đơn giá/lít',
                                            'value' => $_REQUEST['caroil_price']
                                        ])?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="customFileLabel">Ảnh</label>
                                    <div class="form-control-wrap">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="meta_image" id="meta_image_add">
                                            <label class="custom-file-label" for="meta_image_add">Chọn File</label>
                                        </div>
                                    </div>
                                </div>
                                <?=formInputTextarea('caroil_note', [
                                    'placeholder' => 'Ghi chú'
                                ])?>
                                <div class="text-center">
                                    <?=formButton('THÊM MỚI', [
                                        'id'    => 'button_oil_add',
                                        'class' => 'btn btn-secondary',
                                        'type'  => 'submit',
                                        'name'  => 'submit',
                                        'value' => 'submit'
                                    ])?>
                                </div>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                </div>
                <?php
                echo formClose();
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            default:
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['oil_manager']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Danh sách đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Đổ dầu'],'Danh sách');
                    echo admin_error('Danh sách đổ dầu', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $car   = new Category('driving_team');
                $list_car   = $car->getOptionSelect(['0' => ' Chọn Xe Ô Tô ']);

                $data_user  = new user($database);
                $list_tx    = $data_user->get_all_user_option([], ['0' => ' Chọn Lái Xe Đổ Dầu ']);
                $list_user  = $data_user->get_all_user_option([], ['0' => ' Chọn Người Nhập ']);

                $oil    = new pDriving();
                $data   = $oil->get_all();
                $param  = get_param_defaul();

                $header['js']    = [
                    URL_JS."{$path[1]}/{$path[2]}/{$path[3]}"
                ];
                $header['title']    = 'Danh sách đổ dầu';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Danh sách đổ dầu', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Đổ dầu'],'Danh sách đổ dầu');
                ?>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">

                                        <?=formOpen('', ['method' => 'GET'])?>
                                        <div class="form-inline flex-nowrap gx-4">
                                            <?=formInputText('search', ['label' => 'Tìm kiếm', 'value' => $_GET['search'] ? $_GET['search'] : ''])?>
                                            <div class="form-wrap w-150px">
                                                <?=formInputSelect('caroil_bsx', $list_car, [
                                                    'data-search'   => 'on',
                                                    'selected'      => $_REQUEST['caroil_bsx']
                                                ])?>
                                            </div>
                                            <div class="form-wrap w-150px">
                                                <?=formInputSelect('caroil_tx', $list_tx, [
                                                    'data-search'   => 'on',
                                                    'selected'      => $_REQUEST['caroil_tx']
                                                ])?>
                                            </div>
                                            <div class="form-wrap w-150px">
                                                <?=formInputSelect('caroil_user', $list_user, [
                                                    'data-search'   => 'on',
                                                    'selected'      => $_REQUEST['caroil_user']
                                                ])?>
                                            </div>
                                            <div class="btn-wrap w-150px">
                                                <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">LỌC</button></span>
                                                <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div><!-- .form-inline -->
                                        <?=formClose()?>
                                </div><!-- .card-title-group -->
                            </div><!-- .card-inner -->
                            <div class="card-inner p-0">
                                <table class="table table-tranx table-hover">
                                    <thead>
                                    <tr class="tb-tnx-head">
                                        <th style="width: 10%" class="text-left align-middle">Số Phiếu</th>
                                        <th style="width: 30%" class="text-left align-middle">Tiêu đề</th>
                                        <th style="width: 10%" class="text-center align-middle">Tài xế</th>
                                        <th style="width: 10%" class="text-center align-middle">Số Lít</th>
                                        <th style="width: 10%" class="text-center align-middle">Đơn giá/Lít</th>
                                        <th style="width: 10%" class="text-center align-middle">Người thêm</th>
                                        <th style="width: 10%" class="text-center align-middle">Ngày Thêm</th>
                                        <th style="width: 10%" class="text-center align-middle">Quản lý</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($data['data'] AS $row){
                                        $car        = new meta($database, 'listcar_category');
                                        $get_car    = $car->get_meta($row['caroil_bsx']);
                                        $tx         = new user($database);
                                        $get_tx     = $tx->get_user(['user_id' => $row['caroil_tx']]);
                                        $get_user   = $tx->get_user(['user_id' => $row['caroil_user']]);
                                        ?>
                                        <tr class="tb-tnx-item">
                                            <td class="text-left align-middle">#<?=$row['caroil_code']?></td>
                                            <td class="text-left align-middle">
                                                <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/view/{$row['caroil_id']}"?>">Xe <strong class="text-pink"><?=$get_car['data']['meta_name']?></strong> đổ dầu ngày <strong class="text-pink"><?=date('d/m/Y', strtotime($row['caroil_date']))?></strong></a>
                                            </td>
                                            <td class="text-center align-middle"><?=$get_tx['user_name']?></td>
                                            <td class="text-center align-middle"><?=$row['caroil_lit'] ? $row['caroil_lit'] : '---'?></td>
                                            <td class="text-center align-middle"><?=$row['caroil_price'] ? convert_number_to_money($row['caroil_price']) : '---'?></td>
                                            <td class="text-center align-middle"><?=$get_user['user_name']?></td>
                                            <td class="text-center align-middle"><?=view_date_time($row['caroil_create'])?></td>
                                            <td class="text-center align-middle">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <?php
                                                        if($role['driving_team']['oil_add']){
                                                            ?>
                                                            <a href="#" data-type="delete" data-id="<?=$row['caroil_id']?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                                <em class="icon ni ni-trash text-danger"></em>
                                                            </a>
                                                            <?php
                                                        }else{
                                                            echo '---';
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    <tr class="tb-tnx-item">
                                        <td colspan="8" class="text-left">
                                            <div class="row">
                                                <div class="col-lg-6 text-left">
                                                    Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                                    Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                                </div>
                                                <div class="col-lg-6 text-right">
                                                    <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/".buildQuery($_REQUEST, ['page' => '{page}']))?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
                <?php
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
        }
        break;
    case 'plan':
        switch ($path[3]){
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['plan']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Thêm kế hoạch xe', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế hoạch xe'],'Thêm kế hoạch xe');
                    echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $list_car   = new Category('driving_team');
                $list_car   = $list_car->getOptionSelect();
                $list_user  = new user($database);
                $list_user  = $list_user->get_all_user_option();

                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"];
                $header['title']    = 'Thêm kế hoạch xe';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Thêm kế hoạch xe', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế hoạch xe'],'Thêm kế hoạch');
                echo formOpen('', ['method' => 'GET'])
                ?>
                <div class="row justify-content-center">
                    <div class="col-9">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <!-- Title -->
                                <div class="card-title-group">
                                    <div class="card-title"><h6 class="title">Thêm kế hoạch xe</h6></div>
                                    <div class="card-tools">
                                        <a href="#" class="link">Danh sách</a>
                                    </div>
                                </div>
                                <!-- Title -->
                            </div>
                            <!-- Content -->
                            <div class="card-inner">
                                <?=formInputText('carplan_date', [
                                    'label'         => 'Tiêu đề kế hoạch',
                                    'placeholder'   => 'Chọn ngày phát hàng',
                                    'layout'        => 'date'
                                ])?>
                                <?=formInputSelect('plan_car', $list_car, [
                                    'label'         => 'Biển Số Xe',
                                    'data-search'   => 'on'
                                ])?>
                                <?=formInputSelect('plan_lx', $list_user, [
                                    'data-search'   => 'on',
                                    'multiple'      => 'multiple',
                                    'data-placeholder' => 'Chọn lái xe phát'
                                ])?>
                                <?=formInputText('plan_area', [
                                    'label' => 'Khu vực phát'
                                ])?>
                                <?=formInputTextarea('plan_note', [
                                    'label' => 'Ghi chú'
                                ])?>
                                <div class="text-center">
                                    <?=formButton('THÊM MỚI', [
                                        'id'    => 'button_plan_add',
                                        'class' => 'btn btn-secondary',
                                        'type'  => 'submit',
                                        'name'  => 'submit',
                                        'value' => 'submit'
                                    ])?>
                                </div>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                </div>
                <?php
                echo formClose();
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            default:

                break;
        }
        break;
}