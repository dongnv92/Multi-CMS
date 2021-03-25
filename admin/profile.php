<?php
switch ($path[2]){
    case 'change-avatar':
        require_once ABSPATH . 'includes/class/class.uploader.php';
        if($_REQUEST['submit']){
            if($_FILES['user_avatar']){
                $path_upload        = 'content/uploads/avatar/'. $me['user_id'] .'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time()).'/';
                $uploader           = new Uploader();
                $data_upload        = $uploader->upload($_FILES['user_avatar'], array(
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

/*                echo '<pre>';
                print_r($data_upload);
                echo '</pre>';
                break;*/

                if($data_upload['isSuccess']){
                    $data_images    =  $path_upload . $data_upload['data']['metas'][0]['name'];
                    $update_avatar  = new user($database);
                    $update_avatar  = $update_avatar->update_avatar($data_images);
                    if($update_avatar['response'] == 200){
                        $success = '<div class="alert alert-success">Đổi ảnh đại diện thành công.</div>';
                    }
                }
                if($data_upload['hasErrors']){
                    $error = '<div class="alert alert-danger">'. $data_upload['errors'][0][0] .'</div>';
                }
            }
        }
        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title']    = 'Đổi ảnh đại diện';
        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Hồ sơ', [URL_ADMIN . '/profile/' => 'Hồ sơ'],'Cập nhật ảnh đại diện');
        echo formOpen('', ['method' => 'POST', 'enctype' => true]);
        ?>
        <div class="row justify-content-lg-center">
            <div class="col-lg-8">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Cập nhật Avatar</h6></div>
                            <div class="card-tools">
                                <a href="#" class="link">Xem tất cả</a>
                            </div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                        <div class="row g-4">
                            <?=$success ? '<div class="col-lg-12">'. $success .'</div>' : ''?>
                            <?=$error ? '<div class="col-lg-12">'. $error .'</div>' : ''?>
                            <div class="col-lg-2">
                                <div class="user-avatar">
                                    <?=($me['user_avatar'] ? '<img src="'. URL_HOME .'/'. $me['user_avatar'] .'" />' : get_config('avatar_default'))?>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="custom-file">
                                            <input type="file" name="user_avatar" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Chọn File</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 align-bottom">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update_avatar',
                                    'class' => 'btn btn-secondary',
                                    'type'  => 'submit',
                                    'name'  => 'submit',
                                    'value' => 'submit'
                                ])?>
                            </div>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
                <br /><p class="font-italic">Chú ý: chỉ chấp nhận các tập tin định dạng <span class="text-danger">Jpg, Jpeg, Png</span> và nhỏ hơn <span class="text-danger">2Mb</span></p>
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
    default:
        $header['js']      = [
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title']    = 'Cập nhật hồ sơ';
        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Cập nhật hồ sơ', 'Cập nhật hồ sơ','Cập nhật hồ sơ', [URL_ADMIN . '/profile/' => 'Hồ sơ']);
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-preview">
                    <div class="card-inner">
                        <div class="preview-block">
                            <div class="row gy-4">
                                <div class="col-lg-6">
                                    <?=formInputText('', [
                                        'label'         => 'Tên đăng nhập',
                                        'value'         => $me['user_login'],
                                        'disabled'      => 'disabled'
                                    ])?>
                                </div>
                                <div class="col-lg-6">
                                    <?=formInputText('user_name', [
                                        'label'         => 'Tên hiển thị',
                                        'value'         => $me['user_name']
                                    ])?>
                                </div>
                                <div class="col-lg-6">
                                    <?=formInputPassword('user_password', [
                                        'label'         => 'Mật khẩu. (Nếu không đổi mật khẩu thì để trống)',
                                        'autocomplete'  => 'new-password'
                                    ])?>
                                </div>
                                <div class="col-lg-6">
                                    <?=formInputPassword('user_repass', [
                                        'label'         => 'Nhập lại mật khẩu.'
                                    ])?>
                                </div>
                                <div class="col-lg-6">
                                    <?=formInputText('user_email', [
                                        'label'         => 'Email.',
                                        'placeholder'   => 'Nhập Email',
                                        'value'         => $me['user_email']
                                    ])?>
                                </div>
                                <div class="col-lg-6">
                                    <?=formInputText('user_phone', [
                                        'label'         => 'Điện thoại.',
                                        'placeholder'   => 'Nhập số điện thoại',
                                        'value'         => $me['user_phone']
                                    ])?>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <?=formButton('CẬP NHẬT', [
                                        'id'    => 'button_update_me',
                                        'class' => 'btn btn-secondary'
                                    ])?>
                                </div>
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
}