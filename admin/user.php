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
                    $header['toolbar']  =  admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò thành viên'],'Cập nhật');
                    require_once 'admin-header.php';
                    echo admin_error('Cập nhật vai trò thành viên', 'Vai trò thành viên không tồn tại.');
                    require_once 'admin-footer.php';
                    exit();
                }

                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    $header['toolbar']  =  admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò thành viên'],'Cập nhật');
                    require_once 'admin-header.php';
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $role_info = unserialize($meta['data']['meta_info']);
                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"];
                $header['title']    = 'Cập nhật vai trò thành viên';
                $header['toolbar']  =  admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò thành viên'],'Cập nhật', '<a href="'. URL_ADMIN .'/'. $path[1] .'/'. $path[2] .'" class="btn btn-success font-weight-bold btn-square btn-sm mr-2">DANH SÁCH</a> <a href="'. URL_ADMIN .'/'. $path[1] .'/'. $path[2] .'/add" class="btn btn-success font-weight-bold btn-square btn-sm">THÊM MỚI</a>');
                require_once 'admin-header.php';
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title"><h3 class="card-label">Cập nhật vai trò thành viên</h3></div>
                            </div>
                            <!-- Content -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?=formInputText('meta_name', [
                                            'label'         => 'Tên vai trò thành viên. <span class="text-danger">*</span>',
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
                        <?php
                        $list_role = role_structure();
                        foreach ($list_role AS $key => $value){
                        ?>
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Clipboard-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                                <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                        <?=role_structure('des', [$key])?>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="checkbox-list">
                                        <?php foreach ($value AS $_key => $_value){?>
                                            <label class="checkbox checkbox-square">
                                                <input type="checkbox" name="<?=$key.'_'.$_key?>" class="custom-control-input" value="1" id="<?=$key.'_'.$_key?>" <?=$role_info[$key][$_key] ? 'checked' : ''?>>
                                                <span></span>
                                                <?=role_structure('des', [$key, $_key])?>
                                            </label>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <?=formClose()?>
                <?php
                require_once 'admin-footer.php';
                break;
            case 'update_user':
                $meta       = new meta($database, 'role');
                $user_info  = $user->get_user(['user_id' => $path[4]]);
                $role_info  = $user_info['user_roleplus'];
                $role_info  = unserialize($role_info);

                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    $header['toolbar']  =  admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò thành viên'],'Cập nhật');
                    require_once 'admin-header.php';
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                // Kiểm tra thành viên có tồn tại không
                if(!$user_info){
                    $header['title']    = 'Cập nhật vai trò thành viên';
                    $header['toolbar']  =  admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò thành viên'],'Cập nhật');
                    require_once 'admin-header.php';
                    echo admin_error('Cập nhật vai trò thành viên', 'Thành viên không tồn tại, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"];
                $header['title']    = 'Cập nhật vai trò thành viên';
                $header['toolbar']  =  admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò thành viên'],'Cập nhật', '<a href="'. URL_ADMIN .'/'. $path[1] .'/'. $path[2] .'" class="btn btn-success font-weight-bold btn-square btn-sm mr-2">DANH SÁCH</a> <a href="'. URL_ADMIN .'/'. $path[1] .'/'. $path[2] .'/add" class="btn btn-success font-weight-bold btn-square btn-sm">THÊM MỚI</a>');
                require_once 'admin-header.php';
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title"><h3 class="card-label">Cập nhật vai trò thành viên</h3></div>
                            </div>
                            <!-- Content -->
                            <div class="card-body">
                                Bổ sung thêm quyền riêng cho thành viên
                            </div>
                            <div class="card-footer">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update_role',
                                    'class' => 'btn btn-secondary'
                                ])?>
                            </div>
                        </div> <!--End Col-lg-4-->
                    </div>
                    <div class="col-lg-8">
                        <?php
                        $list_role = role_structure();
                        foreach ($list_role AS $key => $value){
                        ?>
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Clipboard-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                                <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                        <?=role_structure('des', [$key])?>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="checkbox-list">
                                        <?php foreach ($value AS $_key => $_value){?>
                                            <label class="checkbox checkbox-square">
                                                <input type="checkbox" name="<?=$key.'_'.$_key?>" class="custom-control-input" value="1" id="<?=$key.'_'.$_key?>" <?=$role_info[$key][$_key] ? 'checked' : ''?>>
                                                <span></span>
                                                <?=role_structure('des', [$key, $_key])?>
                                            </label>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
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
                    $header['toolbar']  = admin_breadcrumbs('Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Thêm mới');
                    require_once 'admin-header.php';
                    echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"];
                $header['title']    = 'Thêm vai trò thành viên';
                $header['toolbar']  = admin_breadcrumbs('Thêm vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Thêm mới', '<a href="'. URL_ADMIN .'/'. $path[1] .'/'. $path[2] .'" class="btn btn-success font-weight-bold btn-square btn-sm">DANH SÁCH</a>');
                require_once 'admin-header.php';
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title"><h6 class="card-label">Thông tin cơ bản</h6></div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?=formInputText('meta_name', [
                                            'label' => 'Tên vai trò thành viên. <span class="text-danger">*</span>'
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
                        <?php
                        $list_role = role_structure();
                        foreach ($list_role AS $key => $value){
                        ?>
                        <!--begin::Content-->
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Clipboard-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                            <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                        </g>
                                    </svg><!--end::Svg Icon--></span>
                                        <?=role_structure('des', [$key])?>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="checkbox-list">
                                        <?php foreach ($value AS $_key => $_value){?>
                                            <label class="checkbox checkbox-square">
                                                <input type="checkbox" name="<?=$key.'_'.$_key?>" class="custom-control-input" value="1" id="<?=$key.'_'.$_key?>" />
                                                <span></span>
                                                <?=role_structure('des', [$key, $_key])?>
                                            </label>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Content-->
                        <?php }?>
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
                    $header['toolbar']  = admin_breadcrumbs('Quản lý vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Quản lý vai trò thành viên');
                    require_once 'admin-header.php';
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
                $header['toolbar']  = admin_breadcrumbs('Quản lý vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò'],'Quản lý vai trò thành viên', '<a href="'. URL_ADMIN .'/'. $path[1] .'/'. $path[2] .'/add" class="btn btn-success font-weight-bold btn-square btn-sm">THÊM MỚI</a>');
                require_once 'admin-header.php';
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Danh sách vai trò thành viên</h3>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-body p-0">
                                <table class="table table-hover table-head-custom table-row-dashed">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%" class="text-center align-middle">ID</th>
                                        <th style="width: 25%" class="text-left align-middle">Tên vai trò</th>
                                        <th style="width: 30%" class="text-left align-middle">Mô tả</th>
                                        <th style="width: 20%" class="text-center align-middle">Ngày tạo</th>
                                        <th style="width: 20%" class="text-center align-middle">Quản trị</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($data['paging']['count_data'] == 0){?>
                                        <tr>
                                            <td colspan="5" class="text-center">Dữ liệu trống</td>
                                        </tr>
                                    <?php }?>
                                    <?php foreach ($data['data'] AS $row){?>
                                        <tr>
                                            <td class="text-center">
                                                <?=$row['meta_id']?>
                                            </td>
                                            <td class="text-left align-middle font-weight-bold">
                                                <a title="Click để chỉnh sửa" href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}/update/{$row['meta_id']}"?>"><?=$row['meta_name']?></a>
                                                <?=get_config('role_special') == $row['meta_id'] ? '<span class="svg-icon svg-icon-danger svg-icon-1x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Shield-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                                        <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"/>
                                                    </g>
                                                </svg><!--end::Svg Icon--></span>' : ''?>
                                                <?=get_config('role_default') == $row['meta_id'] ? '<span class="svg-icon svg-icon-warning svg-icon-1x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Heart.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg><!--end::Svg Icon--></span>' : ''?>
                                            </td>
                                            <td class="text-left align-middle">
                                                <?=($row['meta_des'] ? text_truncate($row['meta_des'], '7') : '---')?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=view_date_time($row['meta_time'])?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <!--<ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <a href="<?/*=URL_ADMIN."/{$path[1]}/{$path[2]}/update/{$row['meta_id']}"*/?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Cập Nhật">
                                                            <em class="icon ni ni-edit"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-type="delete" data-id="<?/*=$row['meta_id']*/?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                            <em class="icon ni ni-trash text-danger"></em>
                                                        </a>
                                                    </li>
                                                </ul>-->
                                                <a href="javascript:;" data-type="delete" data-id="<?=$row['meta_id']?>" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                    <span class="svg-icon svg-icon-md svg-icon-danger">
                                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Trash.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="5" class="text-left">
                                            Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                            Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div>
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
        $header['toolbar']  = admin_breadcrumbs('Cập nhật thành viên', [URL_ADMIN . '/user' => 'Thành viên'],'Cập nhật', '<a href="'. URL_ADMIN .'/'. $path[1] .'" class="btn btn-success font-weight-bold btn-square btn-sm mr-2">DANH SÁCH</a> <a href="'. URL_ADMIN .'/'. $path[1] .'/add" class="btn btn-success font-weight-bold btn-square btn-sm">THÊM MỚI</a>');
        $user = new user($database);
        $user = $user->get_user(['user_id' => $path[3]]);

        if(!$role['user']['update']){
            require_once 'admin-header.php';
            echo admin_error('Cập nhật thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        if(!$path[3] || !$user){
            require_once 'admin-header.php';
            echo admin_error('Cập nhật thành viên.', 'Thành viên không tồn tại hoặc đã bị xóa khỏi hệ thống. Vui lòng kiểm tra lại.');
            require_once 'admin-footer.php';
            exit();
        }


        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title"><h3 class="card-label">Cập nhật thành viên <?=$user['user_name']?></h3></div>
                    </div>
                    <!-- Content -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputText('user_login', [
                                    'label'         => 'Tên đăng nhập. <span class="text-danger">*</span>',
                                    'autofocus'     => '',
                                    'value'         => $user['user_login']
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <span class="text-danger">*</span>',
                                    'value'         => $user['user_name']
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu.',
                                    'autocomplete'  => 'new-password'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_repass', [
                                    'label'         => 'Nhập lại mật khẩu.'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_phone', [
                                    'label'         => 'Điện thoại.',
                                    'value'         => $user['user_phone']
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_email', [
                                    'label'         => 'Email.',
                                    'value'         => $user['user_email']
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputSelect('user_role', $user_role, [
                                        'label'         => 'Phân quyền',
                                        'data-live-search'  => 'true',
                                        'selected'      => $user['user_role']]
                                )?>
                            </div>
                            <div class="col-lg-6">
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
                    </div>
                    <div class="card-footer text-center">
                        <?=formButton('CẬP NHẬT', [
                            'id'    => 'button_update_user',
                            'class' => 'btn btn-secondary'
                        ])?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
    case 'add':
        $header['js']       = [
            URL_JS . "{$path[1]}/{$path[2]}",
            URL_ADMIN_ASSETS."js/pages/crud/forms/widgets/select2.js?v=7.2.8"
        ];
        $header['title']    = 'Thêm thành viên';
        $header['toolbar']  = admin_breadcrumbs(
            'Thêm thành viên',
            [URL_ADMIN . '/user/' => 'Thành viên'],
            'Thêm thành viên',
            '<a href="'. URL_ADMIN .'/'. $path[1] .'" class="btn btn-light-primary font-weight-bolder btn-sm">Danh sách thành viên</a>');
        // Kiểm tra quyền truy cập
        if(!$role['user']['add']){
            require_once 'admin-header.php';
            echo admin_error('Thêm thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title"><h3 class="card-label">Thêm thành viên</h3></div>
                    </div>
                    <!-- Content -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputText('user_login', [
                                    'label'         => 'Tên đăng nhập. <span class="text-danger">*</span>',
                                    'autofocus'     => ''
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <span class="text-danger">*</span>'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu. <span class="text-danger">*</span>',
                                    'autocomplete'  => 'new-password'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputPassword('user_repass', [
                                    'label'         => 'Nhập lại mật khẩu. <span class="text-danger">*</span>'
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
                                    'id'    => 'kt_select2_1',
                                    'label' => 'Vài trò']
                                )?>
                            </div>
                            <div class="col-lg-12 text-center">
                                <?=formButton('THÊM THÀNH VIÊN', [
                                    'id'    => 'button_add_user',
                                    'class' => 'btn btn-dark font-weight-bold btn-square'
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
        $header['toolbar'] = admin_breadcrumbs('Quản lý thành viên', [URL_ADMIN . '/user/' => 'Thành viên'],'Quản lý thành viên', '<a href="'. URL_ADMIN .'/'. $path[1] .'/add" class="btn btn-light-primary font-weight-bolder btn-sm">Thêm thành viên</a>');
        // Kiểm tra quyền truy cập
        if(!$role['user']['manager']){
            require_once 'admin-header.php';
            echo admin_error('Quản lý thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }
        // Lấy dữ liệu
        $user   = new user($database);
        $data   = $user->get_all();
        $param  = get_param_defaul();
        $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}",];

        // Lấy danh sách vai trò thành viên
        $my_role    = new meta($database, 'role');
        $list_role  = $my_role->get_data_select();
        require_once 'admin-header.php';
        ?>
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Search Form-->
                <div class="mb-7">
                    <form action="" method="get">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" value="<?=($_REQUEST['search'] ? $_REQUEST['search'] : '')?>" name="search" class="form-control" placeholder="Tìm kiếm ..." id="kt_datatable_search_query" />
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Trạng thái:</label>
                                            <select name="user_status" class="form-control selectpicker">
                                                <option value="">Tất cả</option>
                                                <option value="active" <?=($_REQUEST['user_status'] == 'active' ? 'selected' : '')?>>Hoạt động</option>
                                                <option value="not_active" <?=($_REQUEST['user_status'] == 'not_active' ? 'selected' : '')?>>Chưa Active</option>
                                                <option value="block" <?=($_REQUEST['user_status'] == 'block' ? 'selected' : '')?>>Tạm Khóa</option>
                                                <option value="block_forever" <?=($_REQUEST['user_status'] == 'block_forever' ? 'selected' : '')?>>Đã Khóa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Vai trò:</label>
                                            <select name="user_role" class="form-control selectpicker">
                                                <option value="">Tất cả</option>
                                                <?php
                                                foreach ($list_role AS $key => $value){
                                                    echo '<option value="'. $key .'" '. ($_REQUEST['user_role'] == $key ? 'selected' : '') .'>'. $value .'</option>';
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
                                <th style="width: 5%" class="text-center align-middle">
                                    <a href="<?=URL_ADMIN."/{$path[1]}".((!$_REQUEST['sort'] || $_REQUEST['sort'] == 'user_id.asc') ? '/?sort=user_id.desc' : '')?>">#
                                        <?php
                                        if(!$_REQUEST['sort'] || $_REQUEST['sort'] == 'user_id.asc'){
                                            echo '<span class="svg-icon svg-icon-primary svg-icon-1x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Up-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
                                                    <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg><!--end::Svg Icon--></span>';
                                        }else{
                                            echo '<span class="svg-icon svg-icon-primary svg-icon-1x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Arrow-down.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"/>
                                                    <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999) "/>
                                                </g>
                                            </svg><!--end::Svg Icon--></span';
                                        }
                                        ?>
                                    </a>
                                </th>
                                <th style="width: 25%" class="text-left align-middle">Tên</th>
                                <th style="width: 15%" class="text-left align-middle">Điện thoại</th>
                                <th style="width: 10%" class="text-left align-middle">Vai trò</th>
                                <th style="width: 15%" class="text-center align-middle">Trạng thái</th>
                                <th style="width: 15%" class="text-center align-middle">Ngày tạo</th>
                                <th style="width: 15%" class="text-center align-middle">Quản trị</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($data['data'] AS $row){
                                $user_role = new meta($database, 'role');
                                $user_role = $user_role->get_meta($row['user_role'], 'meta_name');
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?=$row['user_id']?></td>
                                    <td class="datatable-cell">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40 symbol-sm flex-shrink-0">
                                                <div class="symbol symbol-20 symbol-lg-30 symbol-circle mr-3">
                                                    <img alt="<?=$row['user_name']?>" src="<?=($row['user_avatar'] ? URL_HOME .'/'. $row['user_avatar'] : URL_HOME.'/'.get_config('avatar_default'))?>" />
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <?=($row['user_id'] == get_config('user_special') ? '<div class="text-danger font-weight-bolder font-size-lg mb-0">'. $row['user_name'] .' <span class="svg-icon svg-icon-primary svg-icon-1x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/Done-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                        <path d="M16.7689447,7.81768175 C17.1457787,7.41393107 17.7785676,7.39211077 18.1823183,7.76894473 C18.5860689,8.1457787 18.6078892,8.77856757 18.2310553,9.18231825 L11.2310553,16.6823183 C10.8654446,17.0740439 10.2560456,17.107974 9.84920863,16.7592566 L6.34920863,13.7592566 C5.92988278,13.3998345 5.88132125,12.7685345 6.2407434,12.3492086 C6.60016555,11.9298828 7.23146553,11.8813212 7.65079137,12.2407434 L10.4229928,14.616916 L16.7689447,7.81768175 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg><!--end::Svg Icon--></span></div>' : '<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'. $row['user_name'] .'</div>')?>

                                                <span class="text-muted text-hover-primary font-size-lg"><?=$row['user_login']?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left align-middle font-size-lg">
                                        <?=$row['user_phone'] ? $row['user_phone'] : '---'?>
                                    </td>
                                    <td class="text-left align-middle font-size-lg"><?=$user_role['data']['meta_name']?></td>
                                    <td class="text-center align-middle"><?=get_status('user', $row['user_status'])?></td>
                                    <td class="text-center align-middle text-primary mb-0 font-size-lg"><?=view_date_time($row['user_time'])?></td>
                                    <td class="pr-0 text-center">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/role/update_user/{$row['user_id']}"?>">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/Settings4.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                                                </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                        </a>
                                        <a href="<?=URL_ADMIN."/{$path[1]}/update/{$row['user_id']}"?>" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                                            <span class="svg-icon svg-icon-md svg-icon-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </a>
                                        <a href="javascript:;" data-type="delete" data-id="<?=$row['user_id']?>" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                            <span class="svg-icon svg-icon-md svg-icon-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            // end::foreach
                            if($data['paging']['count_data'] == 0){
                                echo '<tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>';
                            }
                            ?>
                            <tr>
                                <td colspan="7" class="text-left">
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
                </div><!-- .card -->
            </div>
        </div><!-- .nk-block -->
        <?php
        require_once 'admin-footer.php';
        break;
}