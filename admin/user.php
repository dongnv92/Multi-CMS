<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';
// Check login
if(!$me){
    redirect(URL_LOGIN.'?ref=' . get_current_url());
}

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
                    echo admin_breadcrumbs('Vai trò thành viên', 'Cập nhật vai trò thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                    echo admin_error('Cập nhật vai trò thành viên', 'Vai trò thành viên không tồn tại.');
                    require_once 'admin-footer.php';
                    exit();
                }

                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Vai trò thành viên', 'Cập nhật vai trò thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $role_info = unserialize($meta['data']['meta_info']);
                $header['css']      = [
                    ''
                ];
                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"
                ];
                $header['title']    = 'Cập nhật vai trò thành viên';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Vai trò thành viên', 'Cập nhật vai trò thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                ?>
                <?=formOpen('', ["class" => "dropzone", "id" => "frmFileUpload", "method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Thông tin <small>Thông tin về vai trò thành viên</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên vai trò thành viên. <code>*</code>',
                                    'placeholder'   => 'Nhập tên vai trò thành viên',
                                    'autofocus'     => '',
                                    'value'         => $meta['data']['meta_name']
                                ])?>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả vai trò thành viên',
                                    'rows'          => '5',
                                    'value'         => $meta['data']['meta_des']
                                ])?>
                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <a href="<?=URL_REFERER?>" class="btn btn-raised bg-blue waves-effect">QUAY LẠI</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('CẬP NHẬT', [
                                            'id'        => 'button_update_role',
                                            'class'     => 'btn btn-raised bg-blue waves-effect'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--End Col-lg-4-->
                    <div class="col-lg-8">
                        <?php
                        $list_role = role_structure();
                        foreach ($list_role AS $key => $value){
                            ?>
                            <div class="card">
                                <div class="header">
                                    <h2><?=role_structure('des', [$key])?></h2>
                                </div>
                                <div class="content table-responsive">
                                    <table class="table table-hover">
                                        <tbody>
                                        <?php foreach ($value AS $_key => $_value){?>
                                            <tr>
                                                <td width="20%" class="text-left align-middle">
                                                    <div class="switch">
                                                        <label>
                                                            <input id="<?=$key.'_'.$_key?>" name="<?=$key.'_'.$_key?>" value="1" type="checkbox" <?=$role_info[$key][$_key] ? 'checked' : ''?>>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td width="80%" class="text-left align-middle"><label class="font-weight-bold" for="<?=$key.'_'.$_key?>"><?=role_structure('des', [$key, $_key])?></label></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
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
                    echo admin_breadcrumbs('Vai trò thành viên', 'Cập nhật vai trò thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $header['css']      = [
                    ''
                ];
                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
                ];
                $header['title']    = 'Thêm vai trò thành viên';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Vai trò thành viên', 'Quản lý vai trò thành viên','Thêm mới', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                ?>
                <?=formOpen('', ["class" => "dropzone", "id" => "frmFileUpload", "method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Thông tin <small>Thông tin về vai trò thành viên</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên vai trò thành viên. <code>*</code>',
                                    'placeholder'   => 'Nhập tên vai trò thành viên',
                                    'autofocus'     => ''
                                ])?>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả vai trò thành viên',
                                    'rows'          => '5'
                                ])?>
                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('THÊM', [
                                            'id'    => 'button_add_role',
                                            'class' => 'btn btn-raised bg-blue waves-effect'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--End Col-lg-4-->
                    <div class="col-lg-8">
                        <?php
                        $list_role = role_structure();
                        foreach ($list_role AS $key => $value){
                        ?>
                        <div class="card">
                            <div class="header">
                                <h2><?=role_structure('des', [$key])?></h2>
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                    <?php foreach ($value AS $_key => $_value){?>
                                    <tr>
                                        <td width="20%" class="text-left align-middle">
                                            <div class="switch">
                                                <label>
                                                    <input id="<?=$key.'_'.$_key?>" name="<?=$key.'_'.$_key?>" value="1" type="checkbox">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td width="80%" class="text-left align-middle"><label class="font-weight-bold" for="<?=$key.'_'.$_key?>"><?=role_structure('des', [$key, $_key])?></label></td>
                                    </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?=formClose()?>
                <?php
                require_once 'admin-footer.php';
                break;
            default:
                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Quản lý vai trò';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Quản lý vai trò', 'Cập nhật vai trò thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                    echo admin_error('Quản lý vai trò', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                // Lấy dữ liệu
                $meta   = new meta($database, 'role');
                $data   = $meta->get_all();
                $param  = get_param_defaul();

                $header['css']      = [
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
                ];
                $header['js']       = [
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
                    URL_JS . "{$path[1]}/{$path[2]}",
                ];
                $header['title']    = 'Quản lý vai trò';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Vai trò thành viên', 'Quản lý vai trò thành viên','Quản lý', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
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
                                <div class="col-lg-6 col-md-5 col-9 text-right d-flex justify-content-end align-items-center">
                                    <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/add"?>" class="btn btn-raised bg-blue waves-effect">Thêm mới</a>
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
                                        <th style="width: 25%" class="text-left align-middle">Tên vai trò</th>
                                        <th style="width: 35%" class="text-center align-middle">Mô tả</th>
                                        <th style="width: 20%" class="text-center align-middle">Ngày tạo</th>
                                        <th style="width: 20%" class="text-center align-middle">Quản trị</th>
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
                                        </td>
                                        <td class="text-center align-middle">
                                            <?=text_truncate($row['meta_des'], '7')?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?=view_date_time($row['meta_time'])?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="javascript:;" data-type="delete" data-id="<?=$row['meta_id']?>" title="Xóa <?=$row['meta_name']?>"><i class="material-icons text-danger">delete_forever</i></a>
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
                        </div>
                        <div class="text-center clearfix">
                            <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/{$path[2]}/".buildQuery($_REQUEST, ['page' => '{page}']))?>
                        </div>
                    </div>
                </div>
                <?php
                require_once 'admin-footer.php';
                break;
        }
        break;
    case 'update':
        // Kiểm tra quyền truy cập
        $header['js']      = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
        ];
        $header['title']    = 'Cập nhật thành viên';

        $user = new user($database);
        $user = $user->get_user(['user_id' => $path[3]]);

        if(!$role['user']['add']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Thành viên', 'Cập nhật thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên']);
            echo admin_error('Cập nhật thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        if(!$path[3] || !$user){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Thành viên', 'Cập nhật thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên']);
            echo admin_error('Cập nhật thành viên.', 'Thành viên không tồn tại hoặc đã bị xóa khỏi hệ thống. Vui lòng kiểm tra lại.');
            require_once 'admin-footer.php';
            exit();
        }


        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Thành viên', 'Cập nhật thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên']);
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Cập nhật <span class="text-pink"><?=$user['user_name']?></span></h2>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="<?=URL_ADMIN."/{$path[1]}/"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                                <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-raised bg-blue waves-effect">THÊM MỚI</a>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputText('user_login', [
                                    'label'         => 'Tên đăng nhập. <code>*</code>',
                                    'placeholder'   => 'Nhập tên đăng nhập',
                                    'autofocus'     => '',
                                    'value'         => $user['user_login']
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <code>*</code>',
                                    'placeholder'   => 'Nhập tên hiển thị',
                                    'value'         => $user['user_name']
                                ])?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu. <code>*</code>',
                                    'placeholder'   => 'Nhập mật khẩu',
                                    'autocomplete'  => 'new-password'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputPassword('user_repass', [
                                    'label'         => 'Nhập lại mật khẩu. <code>*</code>',
                                    'placeholder'   => 'Nhập lại mật khẩu'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('user_status', [
                                    'active'        => 'Hoạt động',
                                    'not_active'    => 'Chưa kích hoạt',
                                    'block'         => 'Tạm khóa',
                                    'block_forever' => 'Đã khóa'
                                ], [
                                    'label'             => 'Trạng thái',
                                    'data-live-search'  => 'true',
                                    'selected'          => $user['user_status']
                                ])?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputText('user_email', [
                                    'label'         => 'Email.',
                                    'placeholder'   => 'Nhập Email',
                                    'value'         => $user['user_email']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('user_phone', [
                                    'label'         => 'Điện thoại.',
                                    'placeholder'   => 'Nhập số điện thoại',
                                    'value'         => $user['user_phone']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('user_role', $user_role, [
                                    'label'             => 'Vai trò <code>*</code>',
                                    'data-live-search'  => 'true',
                                    'selected'          => $user['user_role']]
                                )?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update_user',
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
        require_once 'admin-footer.php';
        break;
    case 'add':
        // Kiểm tra quyền truy cập
        $header['js']      = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title']    = 'Thêm thành viên';
        if(!$role['user']['add']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Thành viên', 'Thêm mới thành viên','Thêm thành viên', [URL_ADMIN . '/user/' => 'Thành viên']);
            echo admin_error('Thêm thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Thành viên', 'Thêm mới thành viên','Thêm thành viên', [URL_ADMIN . '/user/' => 'Thành viên']);
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Thêm thành viên</h2>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="<?=URL_ADMIN."/{$path[1]}/"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputText('user_login', [
                                    'label'         => 'Tên đăng nhập. <code>*</code>',
                                    'placeholder'   => 'Nhập tên đăng nhập',
                                    'autofocus'     => ''
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <code>*</code>',
                                    'placeholder'   => 'Nhập tên hiển thị'
                                ])?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu. <code>*</code>',
                                    'placeholder'   => 'Nhập mật khẩu',
                                    'autocomplete'  => 'new-password'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_repass', [
                                    'label'         => 'Nhập lại mật khẩu. <code>*</code>',
                                    'placeholder'   => 'Nhập lại mật khẩu'
                                ])?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <?=formInputText('user_email', [
                                    'label'         => 'Email.',
                                    'placeholder'   => 'Nhập Email'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('user_phone', [
                                    'label'         => 'Nhập số điện thoại.',
                                    'placeholder'   => 'Nhập số điện thoại'
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputSelect('user_role', $user_role, [
                                        'label'             => 'Vai trò <code>*</code>',
                                        'data-live-search'  => 'true']
                                )?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <?=formButton('THÊM THÀNH VIÊN', [
                                    'id'    => 'button_add_user',
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
        require_once 'admin-footer.php';
        break;
    default:
        $header['title'] = 'Quản lý thành viên';
        // Kiểm tra quyền truy cập
        if(!$role['user']['manager']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Quản lý thành viên', '','Quản lý thành viên', [URL_ADMIN . '/user/' => 'Thành viên']);
            echo admin_error('Quản lý thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }
        // Lấy dữ liệu
        $user   = new user($database);
        $data   = $user->get_all();
        $param  = get_param_defaul();

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
            URL_JS . "{$path[1]}/{$path[2]}",
        ];
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Quản lý thành viên', '','Quản lý thành viên', [URL_ADMIN . '/user/' => 'Thành viên']);
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
                            <?=formInputSelect('user_status', [
                                ''              => 'Trạng thái',
                                'active'        => 'Hoạt động',
                                'not_active'    => 'Chưa kích hoạt',
                                'block'         => 'Tạm khóa',
                                'block_forever' => 'Đã khóa'
                            ], ['data-live-search' => 'true', 'selected' => $_REQUEST['user_status']])?>
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
                                <th style="width: 20%" class="text-left align-middle">Tên đăng nhập</th>
                                <th style="width: 20%" class="text-center align-middle">Tên hiển thị</th>
                                <th style="width: 15%" class="text-center align-middle">Vai trò</th>
                                <th style="width: 15%" class="text-center align-middle">Trạng thái</th>
                                <th style="width: 15%" class="text-center align-middle">Ngày tạo</th>
                                <th style="width: 15%" class="text-center align-middle">Quản trị</th>
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
                                $user_role = new meta($database, 'role');
                                $user_role = $user_role->get_meta($row['user_role'], 'meta_name');
                                ?>
                                <tr>
                                    <td class="text-left align-middle font-weight-bold">
                                        <a title="Click để chỉnh sửa" href="<?=URL_ADMIN."/{$path[1]}/update/{$row['user_id']}"?>"><?=$row['user_login']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['user_name']?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$user_role['data']['meta_name']?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=get_status('user', $row['user_status'])?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=view_date_time($row['user_time'])?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="javascript:;" data-type="delete" data-id="<?=$row['user_id']?>" title="Xóa <?=$row['user_name']?>"><i class="material-icons text-danger">delete_forever</i></a>
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
                    <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/".buildQuery($_REQUEST, ['page' => '{page}']))?>
                </div>
            </div>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}