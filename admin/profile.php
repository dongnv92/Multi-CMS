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
                if($data_upload['isComplete']){
                    $data_images    =  $path_upload . $data_upload['data']['metas'][0]['name'];
                    $update_avatar  = new user($database);
                    $update_avatar  = $update_avatar->update_avatar($data_images);
                    if($update_avatar['response'] == 200){
                        $success = '<div class="alert alert-success">Đổi ảnh đại diện thành công.</div>';
                    }
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
        echo admin_breadcrumbs('Hồ sơ', 'Cập nhật ảnh đại diện','Cập nhật ảnh đại diện', [URL_ADMIN . '/profile/' => 'Hồ sơ']);
        echo formOpen('', ['method' => 'POST', 'enctype' => true, 'id' => 'form_change_avatar']);
        ?>
        <div class="row justify-content-lg-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="header">
                        <h2>Cập nhật ảnh đại diện</h2>
                    </div>
                    <div class="body">
                        <?=($success ? $success : '')?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="file" name="user_avatar" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update_avatar',
                                    'class' => 'btn btn-raised bg-blue waves-effect',
                                    'type'  => 'submit',
                                    'name'  => 'submit',
                                    'value' => 'submit'
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
        $header['js']      = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title']    = 'Cập nhật hồ sơ';
        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Hồ sơ', 'Cập nhật hồ sơ','Cập nhật hồ sơ', [URL_ADMIN . '/profile/' => 'Hồ sơ']);
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Cập nhật hồ sơ</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputText('', [
                                    'label'         => 'Tên đăng nhập. <code>(Không thể thay đổi)</code>',
                                    'placeholder'   => 'Nhập tên đăng nhập',
                                    'value'         => $me['user_login'],
                                    'disabled'      => 'disabled'
                                ])?>
                            </div>
                            <div class="col-lg-6">
                                <?=formInputText('user_name', [
                                    'label'         => 'Tên hiển thị. <code>*</code>',
                                    'placeholder'   => 'Nhập tên hiển thị',
                                    'value'         => $me['user_name']
                                ])?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?=formInputPassword('user_password', [
                                    'label'         => 'Mật khẩu. <code>(Nếu không đổi mật khẩu thì để trống)</code>',
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
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'id'    => 'button_update_me',
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
}