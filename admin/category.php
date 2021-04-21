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
        $meta = new meta($database, $config['type']);
        $list_cate_option   = $meta->get_data_select(['0' => 'Trống']);
        $list_cate          = $meta->get_data_showall();

        // Cập nhật
        if($path[3] && in_array($path[3], ['update'])){

            if($_REQUEST['submit']){
                $add = $meta->update($path[4]);
                if($add['response'] != '200'){
                    $notice = alert('error', $add['message']);
                }else{
                    $notice = alert('success', $add['message']);
                }
            }

            $category = $meta->get_meta($path[4]);
            if($category['response'] != 200){
                $header['title'] = $config['text']['title_update'];
                require_once 'admin-header.php';
                echo admin_breadcrumbs($config['breadcrumbs']['title'], $config['breadcrumbs']['url'],$config['breadcrumbs']['active']);
                echo admin_error($config['text']['title_update'], 'Chuyên mục không tồn tại.');
                require_once 'admin-footer.php';
                exit();
            }

            $header['title'] = $config['text']['title_update'];
            require_once 'admin-header.php';
            echo admin_breadcrumbs($config['breadcrumbs']['title'], $config['breadcrumbs']['url'],$config['breadcrumbs']['active']);
            echo formOpen('', ['method' => 'POST']);
            ?>
            <div class="row">
                <div class="col-lg-8">
                    <?=$notice?$notice:''?>
                    <?=formInputText('meta_name', [
                        'label' => $config['text']['field_name'].' <code>*</code>',
                        'note'  => 'Tên riêng sẽ hiển thị trên trang mạng của bạn.',
                        'value' => $category['data']['meta_name']
                    ])?>
                    <?php
                    if($config['fields']['url']){
                        echo formInputText('meta_url', [
                            'label' => $config['text']['field_url'],
                            'note'  => 'Chuỗi cho đường dẫn tĩnh là phiên bản của tên hợp chuẩn với Đường dẫn (URL). Chuỗi này bao gồm chữ cái thường, số và dấu gạch ngang (-).',
                            'icon'  => '<em class="icon ni ni-link"></em>',
                            'value' => $category['data']['meta_url']
                        ]);
                    }
                    if($config['fields']['cat_parent']){
                        echo formInputSelect('meta_parent', $list_cate_option, [
                            'selected'      => $category['data']['meta_parent'],
                            'label'         => 'Chuyên mục cha',
                            'data-search'   => 'on',
                            'note'          => 'Chỉ định một chuyên mục Cha để tạo thứ bậc. Ví dụ, bạn tạo chuyên mục Album nhạc thì có thể làm cha của chuyên mục Album nhạc Việt Nam và Album nhạc quốc tế.'
                        ]);
                    }
                    if($config['fields']['des']){
                        echo formInputTextarea('meta_des', [
                            'placeholder'   => 'Nhập mô tả',
                            'value'         => $category['data']['meta_des'],
                            'rows'          => '5',
                            'note'          => 'Thông thường mô tả này không được sử dụng trong các giao diện, tuy nhiên có vài giao diện có thể hiển thị mô tả này.'
                        ]);
                    }
                    ?>
                    <div class="text-right">
                        <?=formButton($config['text']['bt_update'], [
                            'id'    => 'category_update',
                            'class' => 'btn btn-secondary',
                            'type'  => 'submit',
                            'name'  => 'submit',
                            'value' => 'submit'
                        ]);?>
                    </div>
                </div>
            </div>
            <?php
            echo formClose();
            require_once 'admin-footer.php';
            break;
        }

        if($_REQUEST['submit']){
            $add = $meta->add();
            if($add['response'] != '200'){
                $notice = alert('error', $add['message']);
            }else{
                $notice = alert('success', $add['message']);
            }
        }
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
                <?=$notice?$notice:''?>
                <?=formInputText('meta_name', [
                    'label' => $config['text']['field_name'].' <code>*</code>',
                    'note'  => 'Tên riêng sẽ hiển thị trên trang mạng của bạn.'
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
                        'label'         => 'Chuyên mục cha',
                        'data-search'   => 'on',
                        'note'          => 'Chỉ định một chuyên mục Cha để tạo thứ bậc. Ví dụ, bạn tạo chuyên mục Album nhạc thì có thể làm cha của chuyên mục Album nhạc Việt Nam và Album nhạc quốc tế.'
                    ]);
                }
                if($config['fields']['des']){
                    echo formInputTextarea('meta_des', [
                        'placeholder'   => 'Nhập mô tả',
                        'rows'          => '5',
                        'note'          => 'Thông thường mô tả này không được sử dụng trong các giao diện, tuy nhiên có vài giao diện có thể hiển thị mô tả này.'
                    ]);
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
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner p-0">
                                <table class="table table-tranx table-hover">
                                    <thead>
                                    <tr class="tb-tnx-head">
                                        <th>Ảnh</th>
                                        <th><?=$config['text']['field_name']?></th>
                                        <th><?=$config['text']['field_des']?></th>
                                        <th><?=$config['text']['field_url']?></th>
                                        <th class="text-right">Xóa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($list_cate AS $_list_cate){?>
                                    <tr class="tb-tnx-item">
                                        <td>
                                            <div class="user-avatar sq">
                                                <?=$_list_cate['meta_image'] ? '<img src="'. URL_HOME. '/' . $_list_cate['meta_image'] .'" />' : 'N/A'?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?=URL_ADMIN . "/{$path[1]}/{$path[2]}/update/{$_list_cate['meta_id']}"?>">
                                                <span class="font-weight-bolder">
                                                    <?=($_list_cate['level'] > 0 ? str_repeat(' → ', $_list_cate['level']) : '<em class="icon ni ni-dot"></em> ') . $_list_cate['meta_name']?>
                                                </span>
                                            </a>
                                        </td>
                                        <td><a href="#"><span><?=$_list_cate['meta_des']?$_list_cate['meta_des']:'---'?></span></a></td>
                                        <td><a href="#"><span><?=$_list_cate['meta_url']?$_list_cate['meta_url']:'---'?></span></a></td>
                                        <td class="text-right">
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <a href="#" data-type="delete" data-id="<?=$_list_cate['meta_id']?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Xóa">
                                                        <em class="icon ni ni-trash text-danger"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
}