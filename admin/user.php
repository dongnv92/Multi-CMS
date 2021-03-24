<?php
switch ($path[2]){
    case 'role':
        switch ($path[3]){
            case 'update':
                $meta = new meta($database, 'role');
                $meta = $meta->get_meta($path[4]);
                // Kiểm tra tồn tại của meta
                if($meta['response'] != 200){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Cập nhật');
                    echo admin_error('Cập nhật vai trò thành viên', 'Vai trò thành viên không tồn tại.');
                    require_once 'admin-footer.php';
                    exit();
                }

                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Cập nhật');
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $role_info = unserialize($meta['data']['meta_info']);
                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"];
                $header['title']    = 'Cập nhật vai trò thành viên';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Cập nhật vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Cập nhật');
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title"><h6 class="title">Thông tin cơ bản</h6></div>
                                    <div class="card-tools">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/add"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Thêm vai trò thành viên"><em class="icon ni ni-plus"></em></a>
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Danh sách vai trò thành viên"><em class="icon ni ni-list-thumb"></em></a>
                                    </div>
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="card-inner">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <?=formInputText('meta_name', [
                                            'label'         => 'Tên vai trò thành viên. <code>*</code>',
                                            'value'         => $meta['data']['meta_name']
                                        ])?>
                                    </div>
                                    <div class="col-lg-12">
                                        <?=formInputTextarea('meta_des', [
                                            'label'         => 'Mô tả',
                                            'rows'          => '5',
                                            'value'         => $meta['data']['meta_des']
                                        ])?>
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <?=formButton('CẬP NHẬT', [
                                            'id'    => 'button_update_role',
                                            'class' => 'btn btn-secondary'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div> <!--End Col-lg-4-->
                    </div>
                    <div class="col-lg-8">
                        <div class="nk-block">
                            <?php
                            $list_role = role_structure();
                            foreach ($list_role AS $key => $value){
                            ?>
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">
                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-ulist is-compact">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col">
                                                        <p class="text-danger font-weight-bold"><em class="icon ni ni-curve-down-right"></em> <?=role_structure('des', [$key])?></p>
                                                    </div>
                                                </div>
                                                <?php foreach ($value AS $_key => $_value){?>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" name="<?=$key.'_'.$_key?>" class="custom-control-input" value="1" id="<?=$key.'_'.$_key?>" <?=$role_info[$key][$_key] ? 'checked' : ''?>>
                                                                <label class="custom-control-label" for="<?=$key.'_'.$_key?>"><?=role_structure('des', [$key, $_key])?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <?=formClose()?>
                <?php
                require_once 'admin-footer.php';
                break;
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Thêm mới');
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"];
                $header['title']    = 'Thêm vai trò thành viên';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Thêm vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Thêm mới');
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title"><h6 class="title">Thông tin cơ bản</h6></div>
                                    <div class="card-tools"><a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="link"><em class="icon ni ni-list-thumb"></em></a></div>
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="card-inner">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <?=formInputText('meta_name', [
                                            'label'         => 'Tên vai trò thành viên. <code>*</code>'
                                        ])?>
                                    </div>
                                    <div class="col-lg-12">
                                        <?=formInputTextarea('meta_des', [
                                            'label'         => 'Mô tả',
                                            'rows'          => '5'
                                        ])?>
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <?=formButton('THÊM', [
                                            'id'    => 'button_add_role',
                                            'class' => 'btn btn-secondary'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div> <!--End Col-lg-4-->
                    </div>
                    <div class="col-lg-8">
                        <div class="nk-block">
                            <?php
                            $list_role = role_structure();
                            foreach ($list_role AS $key => $value){
                            ?>
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">
                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-ulist is-compact">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col">
                                                        <p class="text-danger font-weight-bold"><em class="icon ni ni-curve-down-right"></em> <?=role_structure('des', [$key])?></p>
                                                    </div>
                                                </div>
                                                <?php foreach ($value AS $_key => $_value){?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" name="<?=$key.'_'.$_key?>" class="custom-control-input" value="1" id="<?=$key.'_'.$_key?>">
                                                            <label class="custom-control-label" for="<?=$key.'_'.$_key?>"><?=role_structure('des', [$key, $_key])?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <?=formClose()?>
                <?php
                require_once 'admin-footer.php';
                break;
            default:
                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Quản lý vai trò thành viên';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Quản lý vai trò', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Quản lý');
                    echo admin_error('Quản lý vai trò', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                // Lấy dữ liệu
                $meta   = new meta($database, 'role');
                $data   = $meta->get_all();
                $param  = get_param_defaul();

                $header['js']       = [
                    URL_JS . "{$path[1]}/{$path[2]}",
                ];
                $header['title']    = 'Quản lý vai trò thành viên';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Quản lý vai trò', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Quản lý');
                ?>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        <?=formOpen('', ['method' => 'GET'])?>
                                        <div class="form-inline flex-nowrap gx-3">
                                            <?=formInputText('search', ['label' => 'Tìm kiếm', 'value' => $_GET['search'] ? $_GET['search'] : ''])?>
                                            <div class="btn-wrap">
                                                <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">LỌC</button></span>
                                                <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div><!-- .form-inline -->
                                        <?=formClose()?>
                                    </div><!-- .card-tools -->
                                    <div class="card-tools mr-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li>
                                                <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/add"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Thêm vai trò thành viên">
                                                    <em class="icon ni ni-plus"></em>
                                                </a>
                                            </li>
                                        </ul><!-- .btn-toolbar -->
                                    </div><!-- .card-tools -->
                                </div><!-- .card-title-group -->
                            </div><!-- .card-inner -->
                            <div class="card-inner p-0">
                                <table class="table table-tranx table-hover">
                                    <thead>
                                    <tr class="tb-tnx-head">
                                        <th style="width: 25%" class="text-left align-middle">Tên vai trò</th>
                                        <th style="width: 35%" class="text-center align-middle">Mô tả</th>
                                        <th style="width: 20%" class="text-center align-middle">Ngày tạo</th>
                                        <th style="width: 20%" class="text-right align-middle">Quản trị</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($data['paging']['count_data'] == 0){?>
                                        <tr>
                                            <td colspan="4" class="text-center">Dữ liệu trống</td>
                                        </tr>
                                    <?php }?>
                                    <?php foreach ($data['data'] AS $row){?>
                                        <tr>
                                            <td class="text-left align-middle font-weight-bold">
                                                <a title="Click để chỉnh sửa" href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/update/{$row['meta_id']}"?>"><?=$row['meta_name']?></a>
                                                <?=get_config('role_special') == $row['meta_id'] ? '<em class="icon ni ni-shield-check-fill text-success"></em></em>' : ''?>
                                                <?=get_config('role_default') == $row['meta_id'] ? '<em class="icon ni ni-na text-danger"></em>' : ''?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=text_truncate($row['meta_des'], '7')?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=view_date_time($row['meta_time'])?>
                                            </td>
                                            <td class="text-right align-middle">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/update/{$row['meta_id']}"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Cập Nhật">
                                                            <em class="icon ni ni-edit"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-type="delete" data-id="<?=$row['meta_id']?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                            <em class="icon ni ni-trash text-danger"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="4" class="text-left">
                                            Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                            Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
                <?php
                require_once 'admin-footer.php';
                break;
        }
        break;
    case 'update':
        // Kiểm tra quyền truy cập
        $header['js']      = [
            URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
        ];
        $header['title']    = 'Cập nhật thành viên';
        $user = new user($database);
        $user = $user->get_user(['user_id' => $path[3]]);

        if(!$role['user']['update']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Cập nhật thành viên', [URL_ADMIN . '/user' => 'Thành viên'],'Cập nhật');
            echo admin_error('Cập nhật thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        if(!$path[3] || !$user){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Cập nhật thành viên', [URL_ADMIN . '/user' => 'Thành viên'],'Cập nhật');
            echo admin_error('Cập nhật thành viên.', 'Thành viên không tồn tại hoặc đã bị xóa khỏi hệ thống. Vui lòng kiểm tra lại.');
            require_once 'admin-footer.php';
            exit();
        }


        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Cập nhật thành viên', [URL_ADMIN . '/user' => 'Thành viên'],'Cập nhật');
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Cập nhật thành viên <?=$user['user_name']?></h6></div>
                            <div class="card-tools">
                                <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Thêm thành viên mới">
                                    <em class="icon ni ni-user-add"></em>
                                </a>
                                <a href="<?=URL_ADMIN."/{$path[1]}"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Danh sách thành viên">
                                    <em class="icon ni ni-users"></em>
                                </a>
                            </div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <?=formInputText('user_login', [
                                    'label'         => 'Tên đăng nhập. <code>*</code>',
                                    'autofocus'     => '',
                                    'value'         => $user['user_login']
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <code>*</code>',
                                    'value'         => $user['user_name']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu. <code>*</code>',
                                    'autocomplete'  => 'new-password'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputPassword('user_repass', [
                                    'label'         => 'Nhập lại mật khẩu. <code>*</code>'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('user_status', [
                                    'active'        => 'Hoạt động',
                                    'not_active'    => 'Chưa kích hoạt',
                                    'block'         => 'Tạm khóa',
                                    'block_forever' => 'Đã khóa'
                                ], [
                                    'data-live-search'  => 'true',
                                    'selected'          => $user['user_status']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('user_email', [
                                    'label'         => 'Email.',
                                    'value'         => $user['user_email']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('user_phone', [
                                    'label'         => 'Điện thoại.',
                                    'value'         => $user['user_phone']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('user_role', $user_role, [
                                    'data-search'  => 'on',
                                    'selected'     => $user['user_role']]
                                )?>
                            </div>
                            <div class="col-lg-12 text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update_user',
                                    'class' => 'btn btn-secondary'
                                ])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
    case 'add':
        $header['js']      = [URL_JS . "{$path[1]}/{$path[2]}"];
        $header['title']    = 'Thêm thành viên';
        // Kiểm tra quyền truy cập
        if(!$role['user']['add']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Thành viên', [URL_ADMIN . '/user/' => 'Thành viên'], 'Thêm thành viên');
            echo admin_error('Thêm thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Thành viên', [URL_ADMIN . '/user/' => 'Thành viên'], 'Thêm thành viên');
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Thêm thành viên</h6></div>
                            <div class="card-tools">
                                <a href="<?=URL_ADMIN."/{$path[1]}"?>" class="link">Xem tất cả</a>
                            </div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <?=formInputText('user_login', [
                                    'label'         => 'Tên đăng nhập. <code>*</code>',
                                    'autofocus'     => ''
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <code>*</code>'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu. <code>*</code>',
                                    'autocomplete'  => 'new-password'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_repass', [
                                    'label'         => 'Nhập lại mật khẩu. <code>*</code>'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('user_email', [
                                    'label'         => 'Email.'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('user_phone', [
                                    'label'         => 'Nhập số điện thoại.'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('user_role', $user_role, [
                                    'data-live-search'  => 'true']
                                )?>
                            </div>
                            <div class="col-lg-12 text-right">
                                <?=formButton('THÊM THÀNH VIÊN', [
                                    'id'    => 'button_add_user',
                                    'class' => 'btn btn-secondary'
                                ])?>
                            </div>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
    default:
        $header['title'] = 'Quản lý thành viên';
        // Kiểm tra quyền truy cập
        if(!$role['user']['manager']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Quản lý thành viên', [URL_ADMIN . '/user/' => 'Thành viên'],'Quản lý thành viên');
            echo admin_error('Quản lý thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }
        // Lấy dữ liệu
        $user   = new user($database);
        $data   = $user->get_all();
        $param  = get_param_defaul();

        $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}",];
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Quản lý thành viên', [URL_ADMIN . '/user/' => 'Thành viên'],'Quản lý thành viên');
        ?>
        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner position-relative card-tools-toggle">
                        <div class="card-title-group">
                            <div class="card-tools">
                                <?=formOpen('', ['method' => 'GET'])?>
                                <div class="form-inline flex-nowrap gx-3">
                                    <?=formInputText('search', ['label' => 'Tìm kiếm', 'value' => $_GET['search'] ? $_GET['search'] : ''])?>
                                    <div class="form-wrap w-150px">
                                        <select class="form-select form-select-sm" data-search="on" data-placeholder="Trạng thái" name="user_status">
                                            <option value="">Tất cả</option>
                                            <option value="active" <?=$_REQUEST['user_status'] == 'active' ? 'selected' : ''?>>Hoạt Động</option>
                                            <option value="not_active" <?=$_REQUEST['user_status'] == 'not_active' ? 'selected' : ''?>>Chưa Kích Hoạt</option>
                                            <option value="block" <?=$_REQUEST['user_status'] == 'block' ? 'selected' : ''?>>Tạm Khoá</option>
                                            <option value="block_forever" <?=$_REQUEST['user_status'] == 'block_forever' ? 'selected' : ''?>>Khoá Vĩnh Viễn</option>
                                        </select>
                                    </div>
                                    <div class="btn-wrap">
                                        <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">LỌC</button></span>
                                        <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                    </div>
                                </div><!-- .form-inline -->
                                <?=formClose()?>
                            </div><!-- .card-tools -->
                            <div class="card-tools mr-n1">
                                <ul class="btn-toolbar gx-1">
                                    <li>
                                        <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Thêm thành viên mới">
                                            <em class="icon ni ni-user-add"></em>
                                        </a>
                                    </li>
                                    <li class="btn-toolbar-sep"></li><!-- li -->
                                    <li>
                                        <div class="toggle-wrap">
                                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                            <div class="toggle-content" data-content="cardTools">
                                                <ul class="btn-toolbar gx-1">
                                                    <li class="toggle-close">
                                                        <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                    </li><!-- li -->
                                                    <li>
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                <em class="icon ni ni-setting"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                <ul class="link-check">
                                                                    <li><span>Show</span></li>
                                                                    <li class="active"><a href="#">10</a></li>
                                                                    <li><a href="#">20</a></li>
                                                                    <li><a href="#">50</a></li>
                                                                </ul>
                                                                <ul class="link-check">
                                                                    <li><span>Order</span></li>
                                                                    <li class="active"><a href="#">DESC</a></li>
                                                                    <li><a href="#">ASC</a></li>
                                                                </ul>
                                                            </div>
                                                        </div><!-- .dropdown -->
                                                    </li><!-- li -->
                                                </ul><!-- .btn-toolbar -->
                                            </div><!-- .toggle-content -->
                                        </div><!-- .toggle-wrap -->
                                    </li><!-- li -->
                                </ul><!-- .btn-toolbar -->
                            </div><!-- .card-tools -->
                        </div><!-- .card-title-group -->
                    </div><!-- .card-inner -->
                    <div class="card-inner p-0">
                        <table class="table table-tranx table-hover">
                            <thead>
                            <tr class="tb-tnx-head">
                                <th style="width: 15%" class="text-left align-middle">Thông tin</th>
                                <th style="width: 10%" class="text-center align-middle">Tên đăng nhập</th>
                                <th style="width: 10%" class="text-center align-middle">Điện Thoại</th>
                                <th style="width: 15%" class="text-center align-middle">Vai trò</th>
                                <th style="width: 10%" class="text-center align-middle">Trạng thái</th>
                                <th style="width: 10%" class="text-center align-middle">Ngày tạo</th>
                                <th style="width: 15%" class="text-right align-middle">Quản trị</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($data['data'] AS $row){
                                $user_role = new meta($database, 'role');
                                $user_role = $user_role->get_meta($row['user_role'], 'meta_name');
                                ?>
                                <tr class="tb-tnx-item">
                                    <td class="text-left align-middle">
                                        <div class="user-card">
                                            <div class="user-avatar">
                                                <?=strtoupper(substr($row['user_name'], 0, 2))?>
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead font-weight-bold"><?=$row['user_name']?> <?=get_config('user_special') == $row['user_id'] ? '<em class="icon ni ni-shield-check-fill text-success"></em>' : ''?></span>
                                                <span><?=$row['user_email'] ? $row['user_email'] : ''?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle"><?=$row['user_login']?></td>
                                    <td class="text-center align-middle"><?=$row['user_phone'] ? $row['user_phone'] : '---'?></td>
                                    <td class="text-center align-middle"><?=$user_role['data']['meta_name']?></td>
                                    <td class="text-center align-middle"><?=get_status('user', $row['user_status'])?></td>
                                    <td class="text-center align-middle"><?=view_date_time($row['user_time'])?></td>
                                    <td class="text-center align-middle">
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <a href="<?=URL_ADMIN."/{$path[1]}/update/{$row['user_id']}"?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Cập Nhật">
                                                    <em class="icon ni ni-account-setting-fill"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="delete" data-id="<?=$row['user_id']?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                    <em class="icon ni ni-user-cross-fill text-danger"></em>
                                                </a>
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
        require_once 'admin-footer.php';
        break;
}