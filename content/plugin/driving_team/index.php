<?php
switch ($path[2]){
    case 'plan':
        switch ($path[3]){
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['plan']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Thêm kế hoạch xe', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế hoạch xe'],'Thêm kế hoạch xe');
                    echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $header['title']    = 'Thêm kế hoạch xe';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Thêm kế hoạch xe', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế hoạch xe'],'Thêm kế hoạch');
                echo formOpen('', ['method' => 'GET'])
                ?>
                <div class="row">

                </div>
                <?php
                echo formClose();
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            default:

                break;
        }
        break;
}