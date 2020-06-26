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
                if($meta['response'] != 200){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Vai trò thành viên', 'Cập nhật vai trò thành viên','Cập nhật', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                    echo admin_error('Cập nhật vai trò thành viên', 'Vai trò thành viên không tồn tại.');
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
                $meta               = new meta($database, 'role');
                $data               = $meta->get_all();

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
                                        <td colspan="4" class="text-left">Tổng số <strong class="text-primary"><?=$data['paging']['count_data']?></strong> bản ghi</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                require_once 'admin-footer.php';
                break;
        }
        break;
    case 'add':
        $header['title'] = 'Thêm thành viên';
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Thêm thành viên', 'Thêm mới thành viên','Thêm thành viên', [URL_ADMIN . '/user/' => 'Thành viên']);

        require_once 'admin-footer.php';
        break;
    default:
        $header['title'] = 'Quản lý thành viên';
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Quản lý thành viên', '','Quản lý thành viên', [URL_ADMIN . '/user/' => 'Thành viên']);

        require_once 'admin-footer.php';
        break;
}