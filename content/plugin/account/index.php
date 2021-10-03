<?php
switch ($path[2]){
    case 'update':
        $account = new pAccount();
        $data    = $account->get_account($path[3]);

        // Kiểm tra quyền truy cập
        if(!$role['account']['manager']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('Cập nhật tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Cập nhật tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Cập nhật tài khoản', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        // Kiểm tra tồn tại
        if(!$data || $data['account_user'] != $me['user_id']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('Cập nhật tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Cập nhật tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Cập nhật tài khoản', 'Tài khoản không tồn tại hoặc bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $media = new Media($database);
        $files = $media->get_list_data('account', $path[3]);

        if($_REQUEST['submit']){
            $update = $account->update($path[3]);
            if($update['response'] == 200){
                // Upload Images
                if($_FILES['account_image']){
                    require_once ABSPATH . 'includes/class/class.uploader.php';
                    $path_upload        = 'content/plugin/account/issets/images/';
                    $uploader           = new Uploader();
                    $data_upload        = $uploader->upload($_FILES['account_image'], array(
                        'limit'         => 10, //Maximum Limit of files. {null, Number}
                        'maxSize'       => 1, //Maximum Size of files {null, Number(in MB's)}
                        'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                        'required'      => false, //Minimum one file is required for upload {Boolean}
                        'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                        'title'         => array('auto', 8), //New file name {null, String, Array} *please read documentation in README.md
                        'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                        'replace'       => false, //Replace the file if it already exists {Boolean}
                        'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                    ));
                    if($data_upload['isSuccess']){
                        $media = new Media($database);
                        foreach ($data_upload['data']['metas'] AS $metas){
                            $_REQUEST['file_path']      = $path_upload . $metas['name'];
                            $_REQUEST['file_name']      = $metas['name'];
                            $_REQUEST['file_extension'] = $metas['extension'];
                            $_REQUEST['file_size']      = $metas['size'];
                            $add_media = $media->add('account', $path[3]);
                        }
                        $account = new pAccount();
                        $data    = $account->get_account($path[3]);
                        $notice = admin_alert('success', $update['message']);
                    }
                    if($data_upload['hasErrors']){
                        $notice   = admin_alert('error', $data_upload['errors'][0][0]);
                    }
                }
            }else{
                $notice = admin_alert('error', $add['message']);
            }
        }

        $list_service   = new Category('account', 'type');
        $list_service   = $list_service->getOptionSelect();

        $header['js']       = [
            URL_ADMIN_ASSETS . "plugins/custom/dropify/js/dropify.js",
            URL_JS . "{$path[1]}/update"
        ];
        $header['css']      = [
            URL_ADMIN_ASSETS . "plugins/custom/dropify/css/dropify.css"
        ];
        $header['title']    = 'Cập nhật tài khoản';
        $header['toolbar']  = admin_breadcrumbs('Cập nhật tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Thêm tài khoản');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo formOpen('', ['method' => 'POST', 'enctype' => 'multipart/form-data'])
        ?>
        <div class="row">
            <div class="col-lg-12">
                <?=($notice ? $notice : '')?>
            </div>
            <div class="col-lg-9">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?=formInputText('account_title', [
                                    'label'         => 'Tiêu đề. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Tiêu đề tài khoản cần bán',
                                    'autofocus'     => 'true',
                                    'value'         => $data['account_title']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_login', [
                                    'label'         => 'Tên đăng nhập. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Tên đăng nhập vào tài khoản',
                                    'value'         => $data['account_login']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_password', [
                                    'label'         => 'Mật khẩu. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Mật khẩu đăng nhập của tài khoản',
                                    'value'         => $data['account_password']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_package', [
                                    'label'         => 'Gói tài khoản.',
                                    'placeholder'   => 'VD: Premium',
                                    'value'         => $data['account_package']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_price', [
                                    'label'         => 'Giá bán. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Giá bán cố định hoặc giá/ngày',
                                    'value'         => $data['account_price']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_expired', [
                                    'label'         => 'Ngày hết hạn.',
                                    'placeholder'   => 'Nhập hoặc chọn ngày tài khoản hết hạn',
                                    'value'         => date('d-m-Y', strtotime($data['account_expired']))
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Kiểu tính giá</label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" name="account_price_type" <?=((!$data['account_price_type'] || $data['account_price_type'] == 'fixed' ? 'checked="checked"' : ''))?> value="fixed">
                                            <span></span>Cố Định
                                        </label>
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" name="account_price_type" <?=($data['account_price_type'] == 'change' ? 'checked="checked"' : '')?> value="change">
                                            <span></span>Thay đổi theo ngày
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Mô tả tài khoản</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?=formInputText('account_url', [
                                    'label'         => 'URL tài khoản <code>(Có thể để trống)</code>.',
                                    'placeholder'   => 'URL hiển thị tài khoản',
                                    'value'         => $data['account_url']
                                ])?>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="account_content" class="summernote"><?=$data['account_content']?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Ảnh tài khoản</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="symbol-list d-flex flex-wrap">
                            <?php foreach ($files AS $file){?>
                            <a href="javascript:;" data-action="delete_image" data-id="<?=$file['file_id']?>">
                                <div class="symbol symbol-100 mr-3">
                                    <img alt="Pic" src="<?=URL_HOME . "/{$file['file_path']}"?>"/>
                                </div>
                            </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title"><h3 class="card-label">Thêm tài khoản</h3></div>
                    </div>
                    <div class="card-body">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="account_featured" value="featured" <?=($data['account_featured'] == 'featured' ? 'checked="checked"' : '')?>>
                                <span></span>Nổi bật
                            </label>
                        </div>
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="account_display" value="show" <?=(($data['account_display'] == 'show' || (!$data['account_display'] && !$data['submit'])) ? 'checked="checked"' : '')?>>
                                <span></span>Ẩn / Hiện
                            </label>
                        </div>
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="account_status" value="instock" <?=(($data['account_status'] == 'instock' || (!$data['account_status'] && !$data['submit'])) ? 'checked="checked"' : '')?>>
                                <span></span>Còn Hàng
                            </label>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success btn-square" type="submit" name="submit" value="submit">CẬP NHẬT</button>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <?=formInputSelect('account_category', $list_service,
                            [
                                'label'     => 'Chọn kiểu tài khoản',
                                'selected'  => $data['account_category']
                            ]
                        )?>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <label>Chọn ảnh tài khoản</label>
                        <input type="file" name="account_image[]" class="dropify" data-max-file-size="1M" data-allowed-file-extensions="jpg png JPG PNG" multiple="multiple" />
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
        if(!$role['account']['add']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('Tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Thêm tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Thêm tài khoản', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $account    = new pAccount();
        if($_REQUEST['clone'] && validate_int($_REQUEST['clone']) && !$_REQUEST['submit']){
            $clone = $account->get_account($_REQUEST['clone']);
            if($clone){
                $_REQUEST['account_title']      = $clone['account_title'];
                $_REQUEST['account_login']      = $clone['account_login'];
                $_REQUEST['account_password']   = $clone['account_password'];
                $_REQUEST['account_package']    = $clone['account_package'];
                $_REQUEST['account_price']      = $clone['account_price'];
                $_REQUEST['account_expired']    = date('d-m-Y', strtotime($clone['account_expired']));
                $_REQUEST['account_price_type'] = $clone['account_price_type'];
                $_REQUEST['account_content']    = $clone['account_content'];
                $_REQUEST['account_featured']   = $clone['account_featured'];
                $_REQUEST['account_display']    = $clone['account_display'];
                $_REQUEST['account_status']     = $clone['account_status'];
                $_REQUEST['account_category']   = $clone['account_category'];
            }
        }

        if($_REQUEST['submit']){
            $add        = $account->add('prepare');
            if($add['response'] == 200){
                // Upload Images
                if($_FILES['account_image']){
                    require_once ABSPATH . 'includes/class/class.uploader.php';
                    $path_upload        = 'content/plugin/account/issets/images/';
                    $uploader           = new Uploader();
                    $data_upload        = $uploader->upload($_FILES['account_image'], array(
                        'limit'         => 10, //Maximum Limit of files. {null, Number}
                        'maxSize'       => 1, //Maximum Size of files {null, Number(in MB's)}
                        'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                        'required'      => true, //Minimum one file is required for upload {Boolean}
                        'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                        'title'         => array('auto', 8), //New file name {null, String, Array} *please read documentation in README.md
                        'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                        'replace'       => false, //Replace the file if it already exists {Boolean}
                        'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                    ));
                    if($data_upload['isSuccess']){
                        $add = $account->add();
                        if($add['response'] != 200){
                            $notice = admin_alert('error', $add['message']);
                        }else{
                            $media = new Media($database);
                            foreach ($data_upload['data']['metas'] AS $metas){
                                $_REQUEST['file_path']      = $path_upload . $metas['name'];
                                $_REQUEST['file_name']      = $metas['name'];
                                $_REQUEST['file_extension'] = $metas['extension'];
                                $_REQUEST['file_size']      = $metas['size'];
                                $add_media = $media->add('account', $add['id']);
                            }
                            $notice = admin_alert('success', $add['message']);
                        }
                    }
                    if($data_upload['hasErrors']){
                        $notice   = admin_alert('error', $data_upload['errors'][0][0]);
                    }
                }
            }else{
                $notice = admin_alert('error', $add['message']);
            }
        }

        $list_service   = new Category('account', 'type');
        $list_service   = $list_service->getOptionSelect();

        $header['js']       = [
            URL_ADMIN_ASSETS . "plugins/custom/dropify/js/dropify.js",
            URL_JS . "{$path[1]}/add"
        ];
        $header['css']      = [
            URL_ADMIN_ASSETS . "plugins/custom/dropify/css/dropify.css"
        ];
        $header['title']    = 'Thêm tài khoản';
        $header['toolbar']  = admin_breadcrumbs('Thêm tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Thêm tài khoản');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo formOpen('', ['method' => 'POST', 'enctype' => 'multipart/form-data'])
        ?>
        <div class="row">
            <div class="col-lg-12">
                <?=($notice ? $notice : '')?>
            </div>
            <div class="col-lg-9">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?=formInputText('account_title', [
                                    'label'         => 'Tiêu đề. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Tiêu đề tài khoản cần bán',
                                    'autofocus'     => 'true',
                                    'value'         => $_REQUEST['account_title']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_login', [
                                    'label'         => 'Tên đăng nhập. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Tên đăng nhập vào tài khoản',
                                    'value'         => $_REQUEST['account_login']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_password', [
                                    'label'         => 'Mật khẩu. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Mật khẩu đăng nhập của tài khoản',
                                    'value'         => $_REQUEST['account_password']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_package', [
                                    'label'         => 'Gói tài khoản.',
                                    'placeholder'   => 'VD: Premium',
                                    'value'         => $_REQUEST['account_package']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_price', [
                                    'label'         => 'Giá bán. <span class="text-danger">*</span>',
                                    'placeholder'   => 'Giá bán cố định hoặc giá/ngày',
                                    'value'         => $_REQUEST['account_price']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <?=formInputText('account_expired', [
                                    'label'         => 'Ngày hết hạn.',
                                    'placeholder'   => 'Nhập hoặc chọn ngày tài khoản hết hạn',
                                    'value'         => $_REQUEST['account_expired']
                                ])?>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Kiểu tính giá</label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" name="account_price_type" <?=((!$_REQUEST['account_price_type'] || $_REQUEST['account_price_type'] == 'fixed' ? 'checked="checked"' : ''))?> value="fixed">
                                            <span></span>Cố Định
                                        </label>
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" name="account_price_type" <?=($_REQUEST['account_price_type'] == 'change' ? 'checked="checked"' : '')?> value="change">
                                            <span></span>Thay đổi theo ngày
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Mô tả tài khoản</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?=formInputText('account_url', [
                                    'label'         => 'URL tài khoản <code>(Có thể để trống)</code>.',
                                    'placeholder'   => 'URL hiển thị tài khoản',
                                    'value'         => $_REQUEST['account_url']
                                ])?>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="account_content" class="summernote"><?=$_REQUEST['account_content']?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title"><h3 class="card-label">Thêm tài khoản</h3></div>
                    </div>
                    <div class="card-body">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="account_featured" value="featured" <?=($_REQUEST['account_featured'] == 'featured' ? 'checked="checked"' : '')?>>
                                <span></span>Nổi bật
                            </label>
                        </div>
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="account_display" value="show" <?=(($_REQUEST['account_display'] == 'show' || (!$_REQUEST['account_display'] && !$_REQUEST['submit'])) ? 'checked="checked"' : '')?>>
                                <span></span>Ẩn / Hiện
                            </label>
                        </div>
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="account_status" value="instock" <?=(($_REQUEST['account_status'] == 'instock' || (!$_REQUEST['account_status'] && !$_REQUEST['submit'])) ? 'checked="checked"' : '')?>>
                                <span></span>Còn Hàng
                            </label>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success btn-square" type="submit" name="submit" value="submit">THÊM TÀI KHOẢN</button>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <?=formInputSelect('account_category', $list_service,
                            [
                                'label'     => 'Chọn kiểu tài khoản',
                                'selected'  => $_REQUEST['account_category']
                            ]
                        )?>
                    </div>
                </div>
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <label>Chọn ảnh tài khoản</label>
                        <input type="file" name="account_image[]" class="dropify" data-max-file-size="1M" data-allowed-file-extensions="jpg png JPG PNG" multiple="multiple" />
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
        if(!$role['account']['manager']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('Tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Quản lý tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Quản lý tài khoản', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $account    = new pAccount();
        $data       = $account->get_all('user');
        $param      = get_param_defaul();

        $list_cates = new Category('account', 'type');
        $list_cate  = $list_cates->getOptionSelect();

        $header['js']       = [URL_JS . "{$path[1]}"];
        $header['title']    = 'Quản lý tài khoản';
        $header['toolbar']  = admin_breadcrumbs('Quản lý tài khoản', [URL_ADMIN . "/{$path[1]}/" => 'Tài khoản'],'Quản lý tài khoản');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        ?>
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Search Form-->
                <div class="mb-7">
                    <form action="" method="get">
                        <div class="row align-items-center">
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" value="<?=($_REQUEST['search'] ? $_REQUEST['search'] : '')?>" name="search" class="form-control" placeholder="Tìm kiếm ..." id="kt_datatable_search_query" />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Chuyên Mục:</label>
                                    <select name="account_category" class="form-control selectpicker">
                                        <option value="">Tất cả</option>
                                        <?php
                                        foreach ($list_cate AS $item => $value){
                                            echo '<option value="'. $item .'" '. ($_REQUEST['account_category'] == $item ? 'selected' : '') .'>'. $value .'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 my-2 my-md-0 text-right">
                                <button type="submit" class="btn btn-dark btn-square px-6 font-weight-bold">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Search Form-->
                <!--begin::Content-->
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <table class="table table-hover table-head-custom table-row-dashed">
                            <thead>
                            <tr class="text-uppercase">
                                <th class="text-center">Tiêu đề</th>
                                <th class="text-center">Tài khoản</th>
                                <th class="text-center">Hạn Ngày</th>
                                <th class="text-center">Giá tiền</th>
                                <th class="text-center">Nổi Bật</th>
                                <th class="text-center">Hiển thị</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Lượt Xem</th>
                                <th class="text-center">Ngày tạo</th>
                                <th class="text-center">Quản lý</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($data['data'] AS $row){
                            $category = $list_cates->getCategory($row['account_category']);
                            ?>
                            <tr>
                                <td class="pl-0 py-8">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50 symbol-light mr-4">
                                            <span class="symbol-label">
                                                <img src="<?=($category['meta_image'] ? URL_HOME.'/'.$category['meta_image'] : URL_HOME . '/' . get_config('no_image'))?>" class="h-75 align-self-end" alt="">
                                            </span>
                                        </div>
                                        <div>
                                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?=text_truncate($row['account_title'], 3)?></a>
                                            <span class="text-muted font-weight-bold d-block font-size-lg">
                                                Gói <?=($row['account_package'] ? $row['account_package'] : '---')?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left font-size-lg align-middle">
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?=$row['account_login']?></span>
                                    <span class="text-muted font-weight-bold"><?=$row['account_password']?></span>
                                </td>
                                <td class="text-center font-size-lg align-middle">
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                        <?=date('d/m/Y', strtotime($row['account_expired']))?>
                                    </span>
                                    <span class="text-muted font-weight-bold"><?=$account->caculatorDate($row['account_expired'])?></span>
                                </td>
                                <td class="text-right font-size-lg align-middle">
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                        <?=convert_number_to_money($row['account_price'])?>
                                    </span>
                                    <span class="text-muted font-weight-bold">
                                        Giá <?=($row['account_price_type'] == 'fixed' ? 'cố định' : 'thay đổi')?>
                                    </span>
                                </td>
                                <td class="text-center font-size-lg align-middle">
                                    <i class="<?=($row['account_featured'] == 'featured' ? 'far fa-check-circle text-success' : 'far fa-check-circle')?>"></i>
                                </td>
                                <td class="text-center font-size-lg align-middle">
                                    <i class="<?=($row['account_display'] == 'show' ? 'far fa-check-circle text-success' : 'far fa-check-circle')?>"></i>
                                </td>
                                <td class="text-center font-size-lg align-middle">
                                    <?=($row['account_status'] == 'instock' ? '<span class="label label-lg label-light-success label-inline">Còn hàng</span>' : '<span class="label label-lg label-light-danger label-inline">Hết hàng</span>')?>
                                </td>
                                <td class="text-center font-size-lg align-middle"><?=$row['account_view']?></td>
                                <td class="text-center font-size-lg align-middle"><?=view_date_time($row['account_create'])?></td>
                                <td class="text-center font-size-lg align-middle">
                                    <div class="dropdown dropdown-inline dropleft">
                                        <button type="button" class="btn btn-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['account_id']}"?>">Sửa</a>
                                            <a class="dropdown-item text-danger" data-action="delete" data-id="<?=$row['account_id']?>" href="javascript:;">Xóa</a>
                                            <a class="dropdown-item" href="<?=URL_ADMIN."/{$path[1]}/add?clone={$row['account_id']}"?>">Nhân bản</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php }if(count($data['data']) == 0){?>
                            <tr class="align-middle font-size-lg">
                                <td colspan="10" class="text-center">
                                    Chưa có tài khoản nào. <a href="<?=URL_ADMIN . "/{$path[1]}/add"?>">Click vào đây</a> để thêm tài khoản.
                                </td>
                            </tr>
                            <?php }?>
                            <tr class="align-middle font-size-lg">
                                <td colspan="10">
                                    <div class="row">
                                        <div class="col-lg-6 text-left">
                                            Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                            Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}".buildQuery($_REQUEST, ['page' => '{page}']))?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Content-->
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}