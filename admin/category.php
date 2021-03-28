<?php
switch ($path[2]){
    case 'code':
    case 'blog':
        switch ($path[2]){
            case 'code':
                // Check Role
                if(!$role['code']['category']){
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Chuyên mục mã nguồn', [URL_ADMIN . '/code' => 'Mã nguồn'],'Chuyên mục');
                    echo admin_error('Chuyên mục mã nguồn', 'Bạn không có quyền truy cập trang này. Vui lòng liên hệ BQT nếu đây là 1 lỗi.');
                    require_once 'admin-footer.php';
                }
                break;
        }
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Chuyên mục mã nguồn', [URL_ADMIN . '/code' => 'Mã nguồn'],'Chuyên mục');
        ?>

        <?php
        require_once 'admin-footer.php';
        break;
    default:
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
        echo admin_error('Chuyên mục', 'Nội dung trống.');
        require_once 'admin-footer.php';
        break;
}