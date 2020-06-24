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
                    ''
                ];
                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
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
                                    'label'         => 'Tên vai trò thành viên. <code>*</code>',
                                    'placeholder'   => 'Nhập tên vai trò thành viên',
                                    'autofocus'     => ''
                                ])?>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả vai trò thành viên',
                                    'rows'          => '5'
                                ])?>
                                <div class="text-right">
                                    <?=formButton('THÊM', [
                                        'id'    => 'button_add_role',
                                        'class' => 'btn btn-raised bg-blue waves-effect'
                                    ])?>
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