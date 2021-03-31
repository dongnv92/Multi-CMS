<?php
$category_system        = ['blog'];
$check_plugin_category  = false;

if(in_array($path[2], $category_system)){
    $config_category = [
        'text' => [
            'title'         => 'Chuyên mục Blog',
            'title_card'    => 'Thông tin chuyên mục'
        ],
        'permission' => ['blog', 'category'],
        'breadcrumbs' => [
            'title'     => 'Chuyên mục Blog',
            'url'       => [URL_ADMIN . '/blog' => 'Blog'],
            'active'    => 'Chuyên mục'
        ]
    ];
}else{
    $check_plugin = get_config_plugin($path[2]);
    if($check_plugin){
        $check_plugin_category = true;
    }
}
switch ($path[2]){
    default:
        if(!in_array($path[2], $category_system) && !$check_plugin_category){
            $header['title'] = 'Chuyên mục';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
            echo admin_error('Chuyên mục', 'Lỗi: Nội dung không tồn tại.');
            require_once 'admin-footer.php';
            exit();
        }

        // Kiểm tra sự cho phép truy cập
        if(!$role[$config_category['permission'][0]][$config_category['permission'][1]]){
            $header['title'] = 'Chuyên mục';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
            echo admin_error('Chuyên mục', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên..');
            require_once 'admin-footer.php';
            exit();
        }

        $header['title'] = $config_category['text']['title'];
        require_once 'admin-header.php';
        echo admin_breadcrumbs($config_category['breadcrumbs']['title'], $config_category['breadcrumbs']['url'],$config_category['breadcrumbs']['active']);
        ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title"><?=$config_category['text']['title_card']?></h6></div>
                            <div class="card-tools">
                                <a href="#" class="link">Xem tất cả</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner">
                        Nội dung
                    </div>
                </div>
            </div>
            <div class="col-lg-8">

            </div>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}