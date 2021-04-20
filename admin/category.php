<?php
switch ($path[2]){
    default:
        $category   = new Category($path[2]);
        $config     = $category->getConfig();

        if(!$config){
            $header['title'] = 'Chuyên mục';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
            echo admin_error('Chuyên mục', 'Lỗi: Nội dung không tồn tại.');
            require_once 'admin-footer.php';
            exit();
        }

        // Kiểm tra sự cho phép truy cập
        if(!$role[$config['permission'][0]][$config['permission'][1]]){
            $header['title'] = 'Chuyên mục';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
            echo admin_error('Chuyên mục', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên..');
            require_once 'admin-footer.php';
            exit();
        }

        $list_cate_option   = new meta($database, $config['type']);
        $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Trống']);
        $list_cate          = new meta($database, $config['type']);
        $list_cate          = $list_cate->get_data_showall();

        $header['js']    = [
            URL_JS."{$path[1]}/{$path[2]}"
        ];
        $header['title'] = $config['text']['title'];
        require_once 'admin-header.php';
        echo admin_breadcrumbs($config['breadcrumbs']['title'], $config['breadcrumbs']['url'],$config['breadcrumbs']['active']);
        echo formOpen('', ['method' => 'POST']);
        ?>
        <div class="row">
            <div class="col-lg-4">
                <?=formInputText('meta_name', [
                    'label' => $config['text']['field_name'],
                    'note'  => 'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
                    'icon'  => '<em class="icon ni ni-slack-hash"></em>'
                ])?>
                <?php
                if($config['fields']['url']){
                    echo formInputText('meta_url', [
                        'label' => $config['text']['field_url'],
                        'note'  => 'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).',
                        'icon'  => '<em class="icon ni ni-link"></em>'
                    ]);
                }
                if($config['fields']['cat_parent']){
                    echo formInputSelect('meta_parent', $list_cate_option, [
                        'label' => 'Chuyên mục cha',
                        'note'  => 'Chỉ định một chuyên mục Cha để tạo thứ bậc. Ví dụ, bạn tạo chuyên mục Album nhạc thì có thể làm cha của chuyên mục Album nhạc Việt Nam và Album nhạc quốc tế.'
                    ]);
                }
                if($config['fields']['des']){
                    echo formInputTextarea('meta_des', [
                        'label'         => 'Mô tả',
                        'placeholder'   => 'Nhập mô tả chuyên mục',
                        'rows'          => '5',
                        'note'          => 'Thông thường mô tả này không được sử dụng trong các giao diện, tuy nhiên có vài giao diện có thể hiển thị mô tả này.'
                    ]);
                }
                if($config['fields']['image']){
                ?>
                <div class="upload-zone">
                    <div class="dz-message" data-dz-message>
                        <span class="dz-message-text">Drag and drop file</span>
                        <span class="dz-message-or">or</span>
                        <button class="btn btn-primary">SELECT</button>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="text-right">
                    <?=formButton($config['text']['bt_add'], [
                        'id'    => 'category_add',
                        'class' => 'btn btn-secondary',
                        'type'  => 'submit',
                        'name'  => 'submit',
                        'value' => 'submit'
                    ]);?>
                </div>
            </div>
            <div class="col-lg-8">

            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
}