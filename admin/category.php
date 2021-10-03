<?php
switch ($path[2]){
    default:
        $category   = new Category($path[2], $path[3]);
        $config     = $category->getConfig();

        if(!$config){
            $header['title']    = 'Chuyên mục';
            $header['toolbar']  = admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
            require_once 'admin-header.php';
            echo admin_error('Chuyên mục', 'Lỗi: Nội dung không tồn tại.');
            require_once 'admin-footer.php';
            exit();
        }

        // Kiểm tra sự cho phép truy cập
        if(!$role[$config['permission'][0]][$config['permission'][1]]){
            $header['title']    = 'Chuyên mục';
            $header['toolbar']  = admin_breadcrumbs('Chuyên mục', [URL_ADMIN . '/category' => 'Chuyên mục'],'Chuyên mục');
            require_once 'admin-header.php';
            echo admin_error('Chuyên mục', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên..');
            require_once 'admin-footer.php';
            exit();
        }
        $meta = new meta($database, $config['type']);
        $list_cate_option   = $meta->get_data_select(['0' => 'Trống']);
        $list_cate          = $meta->get_data_showall();

        // Cập nhật
        if($path[3] && in_array($path[3], ['update']) || $path[4] && in_array($path[4], ['update'])){
            $path_id = ($path[3] == 'update' ? $path[4] : $path[5]);
            if($_REQUEST['submit']){
                $update = $meta->update($path_id);
                if($update['response'] != '200'){
                    $notice = admin_alert('error', $update['message']);
                }else{
                    $notice = admin_alert('success', $update['message']);
                    require_once ABSPATH . 'includes/class/class.uploader.php';
                    if($_FILES['meta_image']){
                        $path_upload        = 'content/uploads/category/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time()).'/';
                        $uploader           = new Uploader();
                        $data_upload        = $uploader->upload($_FILES['meta_image'], array(
                            'limit'         => 1, //Maximum Limit of files. {null, Number}
                            'maxSize'       => 2, //Maximum Size of files {null, Number(in MB's)}
                            'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                            'required'      => true, //Minimum one file is required for upload {Boolean}
                            'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                            'title'         => array('auto', 15), //New file name {null, String, Array} *please read documentation in README.md
                            'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                            'replace'       => false, //Replace the file if it already exists {Boolean}
                            'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                        ));

                        if($data_upload['isSuccess']){
                            $data_images    = $path_upload . $data_upload['data']['metas'][0]['name'];
                            $update_image   = $meta->update_image($path_id, $data_images);
                            if($update_image['response'] != 200){
                                $notice_image   = admin_alert('error', $update_image['message']);
                            }
                        }
                        if($data_upload['hasErrors']){
                            $notice_image   = admin_alert('error', $data_upload['errors'][0][0]);
                        }
                    }
                }
            }

            $category = $meta->get_meta($path_id);
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
            echo formOpen('', ['method' => 'POST', 'enctype' => true]);
            ?>
            <div class="row">
                <div class="col-lg-8">
                    <?=$notice?$notice:''?>
                    <?=$notice_image?$notice_image:''?>
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
                    if($config['fields']['image']){
                        ?>
                        <div class="image-input image-input-outline image-input-circle">
                            <div class="image-input-wrapper" style="background-image: url('<?=($category['data']['meta_image'] ? URL_HOME.'/'.$category['data']['meta_image'] : URL_HOME.'/'.get_config('no_image'))?>')"></div>
                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <input type="file" name="meta_image" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="profile_avatar_remove" />
                            </label>
                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                        </div>
                        <span class="form-text text-muted">Cho phép các định dạng File: png, jpg, jpeg và dưới 1Mb/file.</span>
                        <?php
                    }
                    ?>
                    <div class="text-right">
                        <?=formButton($config['text']['bt_update'], [
                            'id'    => 'category_update',
                            'class' => 'btn btn-dark btn-square',
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
        // Cập nhật

        if($_REQUEST['submit']){
            $add = $meta->add();
            if($add['response'] != '200'){
                $notice = admin_alert('error', $add['message']);
            }else{
                $notice = admin_alert('success', $add['message']);
                require_once ABSPATH . 'includes/class/class.uploader.php';
                if($_FILES['meta_image']){
                    $path_upload        = 'content/uploads/category/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time()).'/';
                    $uploader           = new Uploader();
                    $data_upload        = $uploader->upload($_FILES['meta_image'], array(
                        'limit'         => 1, //Maximum Limit of files. {null, Number}
                        'maxSize'       => 2, //Maximum Size of files {null, Number(in MB's)}
                        'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                        'required'      => true, //Minimum one file is required for upload {Boolean}
                        'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                        'title'         => array('auto', 15), //New file name {null, String, Array} *please read documentation in README.md
                        'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                        'replace'       => false, //Replace the file if it already exists {Boolean}
                        'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                    ));

                    if($data_upload['isSuccess']){
                        $data_images    = $path_upload . $data_upload['data']['metas'][0]['name'];
                        $update_image   = $meta->update_image($add['data'], $data_images);
                        if($update_image['response'] != 200){
                            $notice_image   = admin_alert('error', $update_image['message']);
                        }
                    }
                    if($data_upload['hasErrors']){
                        $notice_image   = admin_alert('error', $data_upload['errors'][0][0]);
                    }
                }
            }
        }
        $header['js']    = [
            URL_JS."{$path[1]}/{$path[2]}".($path[3] ? '/'.$path[3] : '')
        ];
        $header['title']    = $config['text']['title'];
        $header['toolbar']  = admin_breadcrumbs($config['breadcrumbs']['title'], $config['breadcrumbs']['url'],$config['breadcrumbs']['active']);
        require_once 'admin-header.php';
        echo formOpen('', ['method' => 'POST', 'enctype' => true]);
        ?>
        <div class="row">
            <div class="col-lg-4">
                <?=$notice?$notice:''?>
                <?=$notice_image?$notice_image:''?>

                <?=formInputText('meta_name', [
                    'label' => $config['text']['field_name'].' <span class="text-danger">*</span>',
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
                        'data-live-search'  => 'true',
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
                if($config['fields']['image']){
                    ?>
                    <div class="image-input image-input-outline image-input-circle">
                        <div class="image-input-wrapper" style="background-image: url('<?=URL_HOME.'/'.get_config('no_image')?>')"></div>
                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="meta_image" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="profile_avatar_remove" />
                        </label>
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                    </div>
                    <span class="form-text text-muted">Cho phép các định dạng File: png, jpg, jpeg và dưới 1Mb/file.</span>
                    <?php
                }
                ?>
                <div class="text-right">
                    <?=formButton($config['text']['bt_add'], [
                        'id'    => 'category_add',
                        'class' => 'btn btn-dark btn-square',
                        'type'  => 'submit',
                        'name'  => 'submit',
                        'value' => 'submit'
                    ]);?>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-custom">
                    <div class="card-body">
                        <table class="table table-hover table-head-custom table-row-dashed">
                            <thead>
                            <tr>
                                <th style="width: 15%">Ảnh</th>
                                <th style="width: 25%"><?=$config['text']['field_name']?></th>
                                <th style="width: 25%"><?=$config['text']['field_des']?></th>
                                <th style="width: 25%"><?=$config['text']['field_url']?></th>
                                <th style="width: 10%" class="text-right">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list_cate AS $_list_cate){?>
                            <tr>
                                <td class="align-middle">
                                    <div class="symbol mr-3">
                                        <img src="<?=($_list_cate['meta_image'] ? URL_HOME."/".$_list_cate['meta_image'] : URL_HOME.'/'.get_config('no_image'))?>" class="h-75 align-self-end" alt="">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="<?=URL_ADMIN . "/{$path[1]}/{$path[2]}". ($path[3] ? "/{$path[3]}" : '') ."/update/{$_list_cate['meta_id']}"?>" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa">
                                        <span class="font-weight-bolder">
                                            <?=($_list_cate['level'] > 0 ? str_repeat(' → ', $_list_cate['level']) : '<em class="icon ni ni-dot"></em> ') . $_list_cate['meta_name']?>
                                        </span>
                                    </a>
                                </td>
                                <td class="align-middle"><span><?=$_list_cate['meta_des']?$_list_cate['meta_des']:'---'?></span></td>
                                <td class="align-middle"><span><?=$_list_cate['meta_url']?$_list_cate['meta_url']:'---'?></span></td>
                                <td class="text-right align-middle">
                                    <a href="javascript:;" data-type="delete" data-id="<?=$_list_cate['meta_id']?>" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-danger">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Trash.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
}