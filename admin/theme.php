<?php
switch ($path[2]){
    case 'slides':
        switch ($path[3]){
            case 'update':
                // Kiểm tra quyền truy cập
                if(!$role['theme']['slides']){
                    $header['title']    = 'Lỗi quyền truy cập';
                    $header['toolbar']  = admin_breadcrumbs('Quản lý Slide', [URL_ADMIN . "/{$path[1]}/" => 'Slide'],'Quản lý Slides');
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_error('Quản lý Slide', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }
                $theme  = new Theme();
                $slides = $theme->get_slides($path[4]);
                if(!$slides){
                    $header['title']    = 'Cập nhật Slides';
                    $header['toolbar']  = admin_breadcrumbs('Cập nhật lý Slide', [URL_ADMIN . "/{$path[1]}/" => 'Theme', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Slides'],'Cập nhật lý Slide');
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_error('Quản lý Slide', 'Slides không tồn tại, vui lòng kiểm tra lại.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                if($_REQUEST['submit']){
                    // Upload Image
                    if($_FILES['slides_image']){
                        require_once ABSPATH . 'includes/class/class.uploader.php';
                        $path_upload        = 'content/assets/images/slides/';
                        $uploader           = new Uploader();
                        $data_upload        = $uploader->upload($_FILES['slides_image'], array(
                            'limit'         => 10, //Maximum Limit of files. {null, Number}
                            'maxSize'       => 1, //Maximum Size of files {null, Number(in MB's)}
                            'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                            'required'      => true, //Minimum one file is required for upload {Boolean}
                            'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                            'title'         => array('auto', 8), //New file name {null, String, Array} *please read documentation in README.md
                            'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                            'replace'       => false, //Replace the file if it already exists {Boolean}
                            'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                        ));
                        if($data_upload['isSuccess']){
                            $_REQUEST['slides_image'] = $path_upload . $data_upload['data']['metas'][0]['name'];
                        }
                        if($data_upload['hasErrors']){
                            $notice   = admin_alert('error', $data_upload['errors'][0][0]);
                        }
                    }
                    // Upload Image
                    $update    = $theme->update_slides($path[4]);
                    if($update['response'] == 200){
                        $notice = admin_alert('success', $update['message']);
                        $slides = $theme->get_slides($path[4]);
                    }else{
                        $notice   = admin_alert('error', $update['message']);
                    }
                }

                $header['js']       = [
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}",
                    URL_ADMIN_ASSETS . "plugins/custom/dropify/js/dropify.js",
                ];
                $header['css']      = [
                    URL_ADMIN_ASSETS . "plugins/custom/dropify/css/dropify.css"
                ];
                $header['title']    = 'Cập nhật Slides';
                $header['toolbar']  = admin_breadcrumbs('Cập nhật lý Slide', [URL_ADMIN . "/{$path[1]}/" => 'Theme', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Slides'],'Cập nhật lý Slide');
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                ?>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <?=($notice ? $notice : '')?>
                        <?=formOpen('', ['method' => 'post', 'enctype' => 'true'])?>
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title"><h3 class="card-label">Thêm Slides</h3></div>
                            </div>
                            <div class="card-body">
                                <?=formInputText('slides_caption', [
                                    'label'         => 'Tiêu đề <small class="text-danger">(*)</small>',
                                    'placeholder'   => 'Nhập tiêu đề chính Slides',
                                    'value'         => $slides['slides_caption']
                                ])?>
                                <?=formInputText('slides_content', [
                                    'label'         => 'Nội dung <small class="text-danger">(*)</small>',
                                    'placeholder'   => 'Nhập nội dung Slides',
                                    'value'         => $slides['slides_content']
                                ])?>
                                <?=formInputText('slides_link', [
                                    'label'         => 'Button Link <small class="text-danger">(*)</small>',
                                    'placeholder'   => 'Nhập nội dung link button',
                                    'value'         => htmlspecialchars($slides['slides_link'], ENT_QUOTES)
                                ])?>
                                <label>Chọn ảnh Slide</label>
                                <input data-default-file="<?=URL_HOME . "/{$slides['slides_image']}"?>" type="file" name="slides_image" class="dropify" data-max-file-size="1M" data-allowed-file-extensions="jpg png JPG PNG" />
                            </div>
                            <div class="card-footer text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'class' => 'btn btn-dark btn-square',
                                    'type'  => 'submit',
                                    'name'  => 'submit',
                                    'value' => 'submit'
                                ])?>
                            </div>
                        </div>
                        <?=formClose()?>
                    </div>
                </div>
                <?php
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
                /* End Case update */
            default:
                // Kiểm tra quyền truy cập
                if(!$role['theme']['slides']){
                    $header['title']    = 'Lỗi quyền truy cập';
                    $header['toolbar']  = admin_breadcrumbs('Quản lý Slide', [URL_ADMIN . "/{$path[1]}/" => 'Slide'],'Quản lý Slides');
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_error('Quản lý Slide', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }
                $theme  = new Theme();
                if($_REQUEST['submit']){
                    // Upload Image
                    if($_FILES['slides_image']){
                        require_once ABSPATH . 'includes/class/class.uploader.php';
                        $path_upload        = 'content/assets/images/slides/';
                        $uploader           = new Uploader();
                        $data_upload        = $uploader->upload($_FILES['slides_image'], array(
                            'limit'         => 10, //Maximum Limit of files. {null, Number}
                            'maxSize'       => 1, //Maximum Size of files {null, Number(in MB's)}
                            'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                            'required'      => true, //Minimum one file is required for upload {Boolean}
                            'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                            'title'         => array('auto', 8), //New file name {null, String, Array} *please read documentation in README.md
                            'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                            'replace'       => false, //Replace the file if it already exists {Boolean}
                            'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                        ));
                        if($data_upload['isSuccess']){
                            $_REQUEST['slides_image'] = $path_upload . $data_upload['data']['metas'][0]['name'];
                            $add    = $theme->add_slides();
                            if($add['response'] == 200){
                                $notice   = admin_alert('success', $add['message']);
                            }else{
                                $notice   = admin_alert('error', $add['message']);
                            }
                        }
                        if($data_upload['hasErrors']){
                            $notice   = admin_alert('error', $data_upload['errors'][0][0]);
                        }
                    }
                    // Upload Image
                }

                $header['js']       = [
                    URL_JS . "{$path[1]}/{$path[2]}",
                    URL_ADMIN_ASSETS . "plugins/custom/dropify/js/dropify.js",
                ];
                $header['css']      = [
                    URL_ADMIN_ASSETS . "plugins/custom/dropify/css/dropify.css"
                ];
                $header['title']    = 'Quản lý Slide';
                $header['toolbar']  = admin_breadcrumbs('Quản lý Slide', [URL_ADMIN . "/{$path[1]}/" => 'Theme', URL_ADMIN . "/{$path[1]}/{$path[2]}/" => 'Slides'],'Quản lý Slide');
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                ?>
                <div class="row">
                    <div class="col-lg-4">
                        <?=($notice ? $notice : '')?>
                        <?=formOpen('', ['method' => 'post', 'enctype' => 'true'])?>
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title"><h3 class="card-label">Thêm Slides</h3></div>
                            </div>
                            <div class="card-body">
                                <?=formInputText('slides_caption', [
                                    'label'         => 'Tiêu đề <small class="text-danger">(*)</small>',
                                    'placeholder'   => 'Nhập tiêu đề chính Slides'
                                ])?>
                                <?=formInputText('slides_content', [
                                    'label'         => 'Nội dung <small class="text-danger">(*)</small>',
                                    'placeholder'   => 'Nhập nội dung Slides'
                                ])?>
                                <?=formInputText('slides_link', [
                                    'label'         => 'Button Link <small class="text-danger">(*)</small>',
                                    'placeholder'   => 'Nhập nội dung link button'
                                ])?>
                                <label>Chọn ảnh Slide</label>
                                <input type="file" name="slides_image" class="dropify" data-max-file-size="1M" data-allowed-file-extensions="jpg png jpeg JPEG JPG PNG" />
                            </div>
                            <div class="card-footer text-right">
                                <?=formButton('THÊM MỚI', [
                                    'class' => 'btn btn-dark btn-square',
                                    'type'  => 'submit',
                                    'name'  => 'submit',
                                    'value' => 'submit'
                                ])?>
                            </div>
                        </div>
                        <?=formClose()?>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title"><h3 class="card-label">Danh sách Slides</h3></div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover table-head-custom table-row-dashed">
                                    <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-center">Ảnh</th>
                                        <th class="text-left">Tiêu đề</th>
                                        <th class="text-left">Nội dung</th>
                                        <th class="text-left">Trạng thái</th>
                                        <th class="text-center">Quản lý</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $all = $theme->get_all();
                                    foreach ($all AS $row){
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                                                    <div class="symbol-label" style="background-image: url('<?=URL_HOME . "/" . $row['slides_image']?>')"></div>
                                                </div>
                                            </td>
                                            <td class="font-size-lg align-middle"><?=$row['slides_caption']?></td>
                                            <td class="font-size-lg align-middle"><?=$row['slides_content']?></td>
                                            <td class="font-size-lg align-middle text-center">
                                                <span class="switch switch-outline switch-sm switch-icon switch-success">
                                                    <label>
                                                         <input type="checkbox" data-action="switch" data-id="<?=$row['slides_id']?>" <?=$row['slides_status'] == 'show' ? 'checked="checked"' : ''?> name="select"/>
                                                         <span></span>
                                                    </label>
                                               </span>
                                            </td>
                                            <td class="text-center font-size-lg align-middle">
                                                <a href="<?=URL_ADMIN . "/{$path[1]}/{$path[2]}/update/{$row['slides_id']}"?>">
                                                    <i class="far fa-edit text-success"></i>
                                                </a>
                                                <a href="javascript:;" data-action="delete" data-id="<?=$row['slides_id']?>">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
        }
        break;
}