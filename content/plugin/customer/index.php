<?php
$plugin_config = file_get_contents('config.json');
$plugin_config = json_decode($plugin_config, true);

switch ($path[2]){
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['customer']['add']){
            $header['title'] = 'Thêm khách hàng mới';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Khách hàng', 'Thêm mới khách hàng','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Thêm mới']);
            echo admin_error('Cập nhật vai trò thành viên', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $header['title'] = 'Thêm khách hàng mới';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Khách hàng', 'Thêm mới khách hàng','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Khách hàng', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Thêm mới']);


        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}