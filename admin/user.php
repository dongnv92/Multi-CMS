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
                $header['title'] = 'Thêm vai trò';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Vai trò thành viên', 'Quản lý vai trò thành viên','Vai trò thành viên', [URL_ADMIN . '/user/' => 'Thành viên', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Vai trò']);
                ?>
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2>Tiêu đề <small>Mô tả tiêu đề</small></h2>
                                <ul class="header-dropdown m-r--5">
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="#">Action Link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                Nội dung Card
                            </div>
                        </div>
                    </div>
                </div>
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