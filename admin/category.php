<?php
$category_system        = ['blog'];
$check_plugin_category  = false;

if(in_array($path[2], $category_system)){
    $config_category = [
        'text' => [
            'title'         => 'Chuyên mục Blog',
            'title_card'    => 'Thông tin chuyên mục',
            'tool_card'     => '<a href="#" class="link">Xem tất cả</a>',
            'field_name'    => 'Tên chuyên mục <code>*</code>',
            'field_url'     => 'Đường dẫn URL',
            'bt_add'        => 'Thêm chuyên mục mới'
        ],
        'fields' => ['url' => true, 'cat_parent' => true, 'des' => true],
        'permission'    => ['blog', 'category'],
        'type'          => 'code_category',
        'breadcrumbs'   => [
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

        $list_cate_option   = new meta($database, $config_category['type']);
        $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Trống']);
        $list_cate          = new meta($database, $config_category['type']);
        $list_cate          = $list_cate->get_data_showall();

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
                                <?=$config_category['text']['tool_card']?>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner">
                        <?=formInputText('meta_name', [
                            'label' => $config_category['text']['field_name'],
                            'note'  => 'Tên riêng sẽ hiển thị trên trang mạng của bạn.'
                        ])?>
                        <?php
                        if($config_category['fields']['url']){
                            echo formInputText('meta_url', [
                                'label' => $config_category['text']['field_url'],
                                'note'  => 'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).',
                                'icon'  => '<em class="icon ni ni-link"></em>'
                            ]);
                        }
                        if($config_category['fields']['cat_parent']){
                            echo formInputSelect('meta_parent', $list_cate_option, [
                                'label' => 'Chuyên mục cha',
                                'note'  => 'Chỉ định một chuyên mục Cha để tạo thứ bậc. Ví dụ, bạn tạo chuyên mục Album nhạc thì có thể làm cha của chuyên mục Album nhạc Việt Nam và Album nhạc quốc tế.'
                            ]);
                        }
                        if($config_category['fields']['des']){
                            echo formInputTextarea('meta_des', [
                                'label'         => 'Mô tả',
                                'placeholder'   => 'Nhập mô tả chuyên mục',
                                'rows'          => '5',
                                'note'          => 'Thông thường mô tả này không được sử dụng trong các giao diện, tuy nhiên có vài giao diện có thể hiển thị mô tả này.'
                            ]);
                        }
                        ?>
                        <div class="text-right">
                            <?=formButton($config_category['text']['bt_add'], [
                                'id'    => 'button_add',
                                'class' => 'btn btn-secondary',
                                'type'  => 'submit',
                                'name'  => 'submit',
                                'value' => 'submit'
                            ]);?>
                        </div>
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