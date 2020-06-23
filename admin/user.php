<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';
// Check login
if(!$me){
    redirect(URL_LOGIN);
}

switch ($path[2]){
    case 'role':
        switch ($path[3]){
            case 'add':
                $header['css']      = [
                    URL_ADMIN_ASSETS . 'plugins/dropzone/dropzone.css'
                ];
                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/dropzone/dropzone.js'
                ];
                $header['title']    = 'Thêm vai trò thành viên';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Vai trò thành viên', 'Quản lý vai trò thành viên','Thêm vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
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
                                    'label'         => 'Tên vai trò thành viên.',
                                    'placeholder'   => 'Nhập tên vai trò thành viên',
                                    'autofocus'     => ''
                                ])?>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả vai trò thành viên',
                                    'rows'          => '5'
                                ])?>

                                <div class="dz-message">
                                    <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
                                    <h3>Drop files here or click to upload.</h3>
                                    <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em> </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?=formClose()?>
                <script>
                    $(document).ready(function () {
                        $("#frmFileUpload").dropzone({ url: "/file/post" });
                    })
                </script>
                <?php
                require_once 'admin-footer.php';
                break;
            default:
                $header['title'] = 'Quản lý vai trò';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Vai trò thành viên', 'Quản lý vai trò thành viên','Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);

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