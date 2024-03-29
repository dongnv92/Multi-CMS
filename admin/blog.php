<?php
switch ($path[2]){
    case 'detail':
        $post = new Post($database, 'blog');
        $post = $post->get_post(['post_id' => $path[3]]);
        if($post['response'] != 200){
            $header['title'] = 'Xem bài viết';
            require_once 'admin-header.php';
                echo admin_breadcrumbs('Bài viết', 'Xem bài viết','Xem bài viết', [URL_ADMIN . '/blog/' => 'Bài viết']);
                echo admin_error('Xem bài viết', 'Bài viết không tồn tại hoặc đã bị xóa khỏi hệ thống.');
            require_once 'admin-footer.php';
            exit();
        }

        $_REQUEST['limit']          = 5;
        $_REQUEST['post_category']  = $post['data']['post_category'];
        $_REQUEST['fields']         = 'post_id, post_title, post_images, post_time';
        $post_related               = new Post($database, 'blog');
        $post_related               = $post_related->get_all();

        $category   = new meta($database, 'blog_category');
        $category   = $category->get_meta($post['data']['post_category']);
        $post_user  = new user($database);
        $post_user  = $post_user->get_user(['user_id' => $post['data']['post_user']]);

        $header['css']  = [
            URL_ADMIN_ASSETS . "css/blog.css"
        ];
        $header['title'] = $post['data']['post_title'];
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Bài viết', $post['data']['post_title'],'Chi tiết bài viết', [URL_ADMIN . '/blog/' => 'Bài viết']);
        ?>
        <div class="row">
            <div class="col-lg-8 col-md-12 left-box">
                <div class="card single-blog-post">
                    <div class="body">
                        <h3 class="m-t-20"><?=$post['data']['post_title']?></h3>
                        <?=$post['data']['post_content']?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 right-box">
                <div class="card">
                    <div class="body">
                        <form method="get" action="<?=URL_ADMIN."/{$path[1]}/"?>">
                            <div class="widget search">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="search" class="form-control" placeholder="Tìm bài viết ...">
                                    </div>
                                    <button class="btn btn-raised btn-primary m-t-10" type="submit">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Thông tin chi tiết</h2>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="<?=URL_ADMIN."/{$path[1]}/update/{$path[3]}"?>" class="btn btn-raised bg-blue waves-effect">Chỉnh sửa</a>
                                <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-raised bg-blue waves-effect">Thêm mới</a>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive">
                        <table class="table table hover">
                            <tbody>
                            <tr>
                                <td style="width: 25%" class="text-right">Tiêu đề</td>
                                <td style="width: 75%" class="font-bold"><?=$post['data']['post_title']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Chuyên mục</td>
                                <td style="width: 75%" class="font-bold"><?=$category['data']['meta_name']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Tác giả</td>
                                <td style="width: 75%" class="font-bold"><?=$post_user['user_name']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Trạng thái</td>
                                <td style="width: 75%" class="font-bold"><?=get_status('blog', $post['data']['post_status'])?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Nổi bật?</td>
                                <td style="width: 75%" class="font-bold"><?=$post['data']['post_feature'] == 'true' ? 'Có' : 'Không'?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Lượt xem</td>
                                <td style="width: 75%" class="font-bold"><?=$post['data']['post_view']?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Ngày đăng</td>
                                <td style="width: 75%" class="font-bold"><?=view_date_time($post['data']['post_time'])?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-right">Sửa lần cuối</td>
                                <td style="width: 75%" class="font-bold"><?=$post['data']['post_last_update'] ? view_date_time($post['data']['post_last_update']) : '---'?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>Bài viết liên quan</h2>
                    </div>
                    <div class="body">
                        <ul class="inbox-widget list-unstyled clearfix">
                        <?php foreach ($post_related['data'] AS $_post_related){?>
                            <li class="inbox-inner"><a href="javascript:void(0);">
                                <div class="inbox-item">
                                    <div class="inbox-img"> <img src="<?=URL_HOME . '/' .$_post_related['post_images']?>"> </div>
                                    <div class="inbox-item-info">
                                        <p class="author"><a href="<?=URL_ADMIN . "/{$path[1]}/detail/{$_post_related['post_id']}"?>"><?=$_post_related['post_title']?></a></p>
                                        <p class="inbox-date"><?=view_date_time($_post_related['post_time'])?></p>
                                    </div>
                                </div>
                                </a>
                            </li>
                        <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
    case 'category':
        // Kiểm tra quyền truy cập
        if(!$role['blog']['category']){
            $header['title']    = 'Quản lý chuyên mục bài viết';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Chuyên mục bài viết', 'Quản lý chuyên mục bài viết','Quản lý', [URL_ADMIN . '/blog/' => 'Bài viết', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Chuyên mục']);
            echo admin_error('Quản lý chuyên mục bài viết', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }
        switch ($path[3]){
            case 'update':
                $meta = new meta($database, 'blog_category');
                $meta = $meta->get_meta($path[4]);
                // Kiểm tra tồn tại của meta
                if($meta['response'] != 200){
                    $header['title']    = 'Cập nhật chuyên mục bài viết';
                    require_once 'admin-header.php';
                    echo admin_breadcrumbs('Chuyên mục bài viết', 'Cập nhật chuyên mục bài viết','Cập nhật chuyên mục', [URL_ADMIN . '/blog/' => 'Bài viết', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Chuyên mục']);
                    echo admin_error('Chuyên mục bài viết', 'Chuyên mục bài viết không tồn tại.');
                    require_once 'admin-footer.php';
                    exit();
                }

                $list_cate_option   = new meta($database, 'blog_category');
                $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Chuyên mục cha']);
                $list_cate          = new meta($database, 'blog_category');
                $list_cate          = $list_cate->get_data_showall();

                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"
                ];
                $header['title']    = 'Thêm chuyên mục bài viết';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Chuyên mục bài viết', 'Cập nhật chuyên mục bài viết','Cập nhật chuyên mục', [URL_ADMIN . '/blog/' => 'Bài viết', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Chuyên mục']);
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Thông tin <small>Thông tin về chuyên mục bài viết</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên chuyên mục. <code>*</code>',
                                    'placeholder'   => 'Nhập tên chuyên mục',
                                    'autofocus'     => '',
                                    'value'         => $meta['data']['meta_name']
                                ])?>
                                <?=formInputText('meta_url', [
                                    'label'         => 'URL <code>Có thể để trống</code>',
                                    'placeholder'   => 'Nhập URL chuyên mục',
                                    'value'         => $meta['data']['meta_url']
                                ])?>
                                <?=formInputSelect('meta_parent', $list_cate_option, [
                                    'label'             => 'Chuyên mục cha.',
                                    'data-live-search'  => 'true',
                                    'selected'          => $meta['data']['meta_parent']]
                                )?><br><br>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả chuyên mục',
                                    'rows'          => '5',
                                    'value'         => $meta['data']['meta_des']
                                ])?>
                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('CẬP NHẬT', [
                                            'id'    => 'button_update_cate',
                                            'class' => 'btn btn-raised bg-blue waves-effect'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--End Col-lg-4-->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="header">
                                <div class="row">
                                    <div class="col-lg-6 text-left"><h2>Danh sách chuyên mục</h2></div>
                                </div>
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%" class="text-left align-middle">Tên chuyên mục</th>
                                        <th style="width: 30%" class="text-center align-middle">Nội dung</th>
                                        <th style="width: 20%" class="text-center align-middle">Ngày Thêm</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($list_cate AS $_list_cate){?>
                                        <tr>
                                            <td class="text-left align-middle">
                                                <a href="<?=URL_ADMIN . "/{$path[1]}/{$path[2]}/update/{$_list_cate['meta_id']}"?>" class="font-weight-bold"><?=($_list_cate['level'] > 0 ? str_repeat(' → ', $_list_cate['level']) : '') . $_list_cate['meta_name']?></a>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=$_list_cate['meta_content'] ? $_list_cate['meta_content'] : 'Trống'?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=view_date_time($_list_cate['meta_time'])?>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?=formClose()?>
                <?php
                require_once 'admin-footer.php';
                break;
            default:
                $list_cate_option   = new meta($database, 'blog_category');
                $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Chuyên mục cha']);
                $list_cate          = new meta($database, 'blog_category');
                $list_cate          = $list_cate->get_data_showall();

                $header['css']      = [
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
                ];
                $header['js']       = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
                    URL_JS . "{$path[1]}/{$path[2]}",
                ];
                $header['title']    = 'Thêm chuyên mục bài viết';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Cập nhật chuyên mục blog', 'Cập nhật chuyên mục blog','Cập nhật', [URL_ADMIN . '/blog/' => 'Bài viết', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Chuyên mục']);
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Thông tin <small>Thông tin về chuyên mục bài viết</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên chuyên mục. <code>*</code>',
                                    'placeholder'   => 'Nhập tên chuyên mục',
                                    'autofocus'     => ''
                                ])?>
                                <?=formInputText('meta_url', [
                                    'label'         => 'URL <code>Có thể để trống</code>',
                                    'placeholder'   => 'Nhập URL chuyên mục'
                                ])?>
                                <?=formInputSelect('meta_parent', $list_cate_option, [
                                    'label'             => 'Chuyên mục cha.',
                                    'data-live-search'  => 'true']
                                )?><br><br>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả chuyên mục',
                                    'rows'          => '5'
                                ])?>
                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('THÊM', [
                                            'id'    => 'button_add_category',
                                            'class' => 'btn btn-raised bg-blue waves-effect'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--End Col-lg-4-->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="header">
                                <div class="row">
                                    <div class="col-lg-6 text-left"><h2>Danh sách chuyên mục</h2></div>
                                </div>
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%" class="text-left align-middle">Tên chuyên mục</th>
                                        <th style="width: 30%" class="text-center align-middle">Nội dung</th>
                                        <th style="width: 20%" class="text-center align-middle">Ngày Thêm</th>
                                        <th style="width: 20%" class="text-center align-middle">Xóa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($list_cate AS $_list_cate){?>
                                        <tr>
                                            <td class="text-left align-middle">
                                                <a href="<?=URL_ADMIN . "/{$path[1]}/{$path[2]}/update/{$_list_cate['meta_id']}"?>" class="font-weight-bold"><?=($_list_cate['level'] > 0 ? str_repeat(' → ', $_list_cate['level']) : '') . $_list_cate['meta_name']?></a>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=$_list_cate['meta_content'] ? $_list_cate['meta_content'] : 'Trống'?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?=view_date_time($_list_cate['meta_time'])?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="javascript:;" data-type="delete" data-id="<?=$_list_cate['meta_id']?>" title="Xóa <?=$_list_cate['meta_name']?>">
                                                    <i class="material-icons text-danger">delete_forever</i>
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
                <?=formClose()?>
                <?php
                require_once 'admin-footer.php';
                break;
        }
        break;
    case 'add':
        $header['title']    = 'Thêm bài viết';
        // Kiểm tra quyền truy cập
        if(!$role['blog']['add']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Bài viết', 'Thêm bài viết','Thêm bài viết', [URL_ADMIN . '/blog/' => 'Bài viết']);
            echo admin_error('Thêm bài viết', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        if($_REQUEST['submit']){
            $post   = new Post($database, 'blog');
            $result = $post->add();
            if($result['response'] == 200){
                require_once ABSPATH . "includes/class/class.uploader.php";
                if($_FILES['post_images']){
                    $path_upload        = 'content/uploads/post/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time()).'/';
                    $uploader           = new Uploader();
                    $data_upload        = $uploader->upload($_FILES['post_images'], array(
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
                    if($data_upload['isComplete']){
                        $data_images    =  $path_upload . $data_upload['data']['metas'][0]['name'];
                        $post->update_post_images($result['data'], $data_images);
                    }
                }
            }else{
                $error = '<div class="col-lg-12"><div class="alert alert-danger">'. $result['message'] .'</div></div>';
            }
        }

        $category           = new meta($database, 'blog_category');
        $category           = $category->get_data_select();

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.css',
            URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];

        require_once 'admin-header.php';
        echo admin_breadcrumbs('Bài viết', 'Thêm bài viết','Thêm bài viết', [URL_ADMIN . '/blog/' => 'Bài viết']);
        echo formOpen('', ['method' => 'POST', 'id' => 'form_add_post', 'enctype' => true]);
        ?>
        <div class="row">
            <?=$error ? $error : ''?>
            <div class="col-lg-8">
                <div class="card">
                    <div class="body">
                        <?=formInputText('post_title', [
                            'label'         => 'Tiêu đề. <code>*</code>',
                            'placeholder'   => 'Nhập tiêu đề',
                            'value'         => $_REQUEST['post_title'] ? $_REQUEST['post_title'] : '',
                            'autofocus'     => ''
                        ])?>
                        <?=formInputTextarea('post_content', [
                            'value' => $_REQUEST['post_content'] ? $_REQUEST['post_content'] : '',
                            'id'    => 'summernote'
                        ])?>
                    </div>
                </div>
                <div class="card">
                    <div class="header">Tuỳ chọn khác</div>
                    <div class="body">
                        <?=formInputText('post_url', [
                            'label'         => 'URL. <code>có thể để trống</code>',
                            'value'         => $_REQUEST['post_url'] ? $_REQUEST['post_url'] : '',
                            'placeholder'   => 'URL bài viết'
                        ])?>
                        <?=formInputText('post_keyword', [
                            'label'         => 'Từ khoá.',
                            'value'         => $_REQUEST['post_keyword'] ? $_REQUEST['post_keyword'] : '',
                            'placeholder'   => 'Từ khoá tìm kiếm'
                        ])?>
                        <?=formInputTextarea('post_short_content', [
                            'value' => $_REQUEST['post_short_content'] ? $_REQUEST['post_short_content'] : '',
                            'label' => 'Mô tả ngắn'
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="header">
                        <h2>Xuất bản</h2>
                    </div>
                    <div class="body">
                        <div class="text-left">
                            <?=formInputSwitch('post_feature', [
                                'checked'   => $_REQUEST['post_feature'] ? 'true' : '',
                                'value'     => 'true',
                                'label'     => 'Nổi bật?'
                            ])?>
                        </div>
                        <div class="text-right">
                            <?=formButton('ĐĂNG BÀI', [
                                'id'    => 'add_post',
                                'type'  => 'submit',
                                'name'  => 'submit',
                                'value' => 'submit',
                                'class' => 'btn btn-raised bg-blue waves-effect'
                            ])?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>Trạng thái</h2>
                    </div>
                    <div class="body">
                        <?=formInputSelect('post_status', ['public' => 'Đăng luôn', 'pending' => 'Chờ duyệt'], [
                            'data-live-search'  => 'true',
                            'selected'          => $_REQUEST['post_status']
                        ])?>
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <?=formInputSelect('post_category', $category, [
                            'label'             => 'Chọn chuyên mục',
                            'data-live-search'  => 'true',
                            'selected'          => $_REQUEST['post_category']
                        ]
                        )?>
                    </div>
                </div>
                <div class="card">
                    <div class="header"><h2>Ảnh bài viết</h2></div>
                    <div class="body">
                        <div class="form-group">
                            <input type="file" name="post_images" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
    case 'update':
        $header['title']    = 'Cập nhập bài viết';
        // Kiểm tra quyền truy cập
        if(!$role['blog']['update']){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Bài viết', 'Cập nhật bài viết','Cập nhật', [URL_ADMIN . '/blog/' => 'Bài viết']);
            echo admin_error('Cập nhật bài viết', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once 'admin-footer.php';
            exit();
        }

        $post = new Post($database, 'blog');
        $post = $post->get_post(['post_id' => $path[3]]);

        if($post['response'] != 200){
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Bài viết', 'Cập nhật bài viết','Cập nhật', [URL_ADMIN . '/blog/' => 'Bài viết']);
            echo admin_error('Cập nhật bài viết', 'Bài viết không tồn tại hoặc đã bị xóa khỏi hệ thống.');
            require_once 'admin-footer.php';
            exit();
        }

        $_REQUEST['post_title']         = $_REQUEST['post_title']           ? $_REQUEST['post_title']           : $post['data']['post_title'];
        $_REQUEST['post_content']       = $_REQUEST['post_content']         ? $_REQUEST['post_content']         : $post['data']['post_content'];
        $_REQUEST['post_url']           = $_REQUEST['post_url']             ? $_REQUEST['post_url']             : $post['data']['post_url'];
        $_REQUEST['post_keyword']       = $_REQUEST['post_keyword']         ? $_REQUEST['post_keyword']         : $post['data']['post_keyword'];
        $_REQUEST['post_short_content'] = $_REQUEST['post_short_content']   ? $_REQUEST['post_short_content']   : $post['data']['post_short_content'];
        $_REQUEST['post_category']      = $_REQUEST['post_category']        ? $_REQUEST['post_category']        : $post['data']['post_category'];

        if($_REQUEST['submit']){
            $post   = new Post($database, 'blog');
            $result = $post->update($path[3]);
            if($result['response'] == 200){
                require_once ABSPATH . "includes/class/class.uploader.php";
                if($_FILES['post_images']){
                    $path_upload        = 'content/uploads/post/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time()).'/';
                    $uploader           = new Uploader();
                    $data_upload        = $uploader->upload($_FILES['post_images'], array(
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
                    if($data_upload['isComplete']){
                        $data_images    =  $path_upload . $data_upload['data']['metas'][0]['name'];
                        $post->update_post_images($path[3], $data_images);
                    }
                }
                $success = '<div class="col-lg-12"><div class="alert alert-info">Cập nhật bài viết thành công</div></div>';
            }else{
                $error = '<div class="col-lg-12"><div class="alert alert-danger">'. $result['message'] .'</div></div>';
            }

            $post = new Post($database, 'blog');
            $post = $post->get_post(['post_id' => $path[3]]);
        }

        $category           = new meta($database, 'blog_category');
        $category           = $category->get_data_select();

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.css',
            URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];

        require_once 'admin-header.php';
        echo admin_breadcrumbs('Bài viết', 'Cập nhật bài viết','Cập nhật', [URL_ADMIN . '/blog/' => 'Bài viết']);
        echo formOpen('', ['method' => 'POST', 'id' => 'form_add_post', 'enctype' => true]);
        ?>
        <div class="row">
            <?=$error ? $error : ''?>
            <?=$success ? $success : ''?>
            <div class="col-lg-8">
                <div class="card">
                    <div class="body">
                        <?=formInputText('post_title', [
                            'label'         => 'Tiêu đề. <code>*</code>',
                            'placeholder'   => 'Nhập tiêu đề',
                            'value'         => $_REQUEST['post_title'] ? $_REQUEST['post_title'] : '',
                            'autofocus'     => ''
                        ])?>
                        <?=formInputTextarea('post_content', [
                            'value' => $_REQUEST['post_content'] ? $_REQUEST['post_content'] : '',
                            'id'    => 'summernote'
                        ])?>
                    </div>
                </div>
                <div class="card">
                    <div class="header">Tuỳ chọn khác</div>
                    <div class="body">
                        <?=formInputText('post_url', [
                            'label'         => 'URL. <code>có thể để trống</code>',
                            'value'         => $_REQUEST['post_url'] ? $_REQUEST['post_url'] : '',
                            'placeholder'   => 'URL bài viết'
                        ])?>
                        <?=formInputText('post_keyword', [
                            'label'         => 'Từ khoá.',
                            'value'         => $_REQUEST['post_keyword'] ? $_REQUEST['post_keyword'] : '',
                            'placeholder'   => 'Từ khoá tìm kiếm'
                        ])?>
                        <?=formInputTextarea('post_short_content', [
                            'value' => $_REQUEST['post_short_content'] ? $_REQUEST['post_short_content'] : '',
                            'label' => 'Mô tả ngắn'
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="header">
                        <h2>Xuất bản</h2>
                    </div>
                    <div class="body">
                        <div class="text-left">
                            <?=formInputSwitch('post_feature', [
                                'checked'   => $post['data']['post_feature'] == 'true' ? 'true' : '',
                                'value'     => 'true',
                                'label'     => 'Nổi bật?'
                            ])?>
                        </div>
                        <div class="text-right">
                            <?=formButton('ĐĂNG BÀI', [
                                'id'    => 'add_post',
                                'type'  => 'submit',
                                'name'  => 'submit',
                                'value' => 'submit',
                                'class' => 'btn btn-raised bg-blue waves-effect'
                            ])?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>Trạng thái</h2>
                    </div>
                    <div class="body">
                        <?=formInputSelect('post_status', ['public' => 'Đăng luôn', 'pending' => 'Chờ duyệt'], [
                            'data-live-search'  => 'true',
                            'selected'          => $_REQUEST['post_status']
                        ])?>
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <?=formInputSelect('post_category', $category, [
                            'label'             => 'Chọn chuyên mục',
                            'data-live-search'  => 'true',
                            'selected'          => $_REQUEST['post_category']
                        ]
                        )?>
                    </div>
                </div>
                <div class="card">
                    <div class="header"><h2>Ảnh bài viết</h2></div>
                    <div class="body">
                        <div class="form-group">
                            <input type="file" name="post_images" id="input-file-now" data-default-file="<?=$post['data']['post_images'] ? URL_HOME . '/' . $post['data']['post_images'] : ''?>" class="dropify" data-allowed-file-extensions="jpg png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once 'admin-footer.php';
        break;
    default:
        // Lấy dữ liệu
        $post       = new Post($database, 'blog');
        $data       = $post->get_all();
        $param      = get_param_defaul();
        $category   = new meta($database, 'blog_category');
        $category   = $category->get_data_select(['0' => 'Chuyên mục']);

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
            URL_JS . "{$path[1]}",
        ];
        $header['title'] = 'Quản lý bài viết';
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Bài viết', 'Quản lý bài viết','Quản lý bài viết', [URL_ADMIN . '/blog/' => 'Bài viết']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card action_bar m-t-15">
                    <?=formOpen('', ['method' => 'GET'])?>
                    <div class="row" style="margin-left : 5px; margin-right : 5px">
                        <div class="col-lg-4 col-md-6 hidden-sm-down">
                            <div class="input-group m-t-10">
                                <span class="input-group-addon"><i class="zmdi zmdi-search"></i></span>
                                <div class="form-line">
                                    <input type="text" autofocus name="search" value="<?=$_REQUEST['search']?>" class="form-control" placeholder="Tìm kiếm ...">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 col-9 text-center d-flex justify-content-center align-items-center">
                            <?=formInputSelect('post_category', $category, ['data-live-search' => 'true', 'selected' => $_REQUEST['post_category']])?>
                        </div>
                        <div class="col-lg-2 col-md-5 col-9 text-center d-flex justify-content-center align-items-center">
                            <?=formButton('<i class="material-icons">search</i> Tìm kiếm', ['type' => 'submit', 'class' => 'btn btn-raised btn-outline-info waves-effect'])?>
                        </div>
                        <div class="col-lg-3 col-md-5 col-9 text-right d-flex justify-content-end align-items-center">
                            <a href="<?=URL_ADMIN."/{$path[1]}/add"?>" class="btn btn-raised bg-blue waves-effect">Thêm mới</a>
                        </div>
                    </div>
                    <?=formClose()?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="content table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th style="width: 30%" class="text-left align-middle">Tiêu đề</th>
                                <th style="width: 15%" class="text-center align-middle">Tác giả</th>
                                <th style="width: 15%" class="text-center align-middle">Chuyên mục</th>
                                <th style="width: 15%" class="text-center align-middle">Nổi bật</th>
                                <th style="width: 15%" class="text-center align-middle">Thời gian</th>
                                <th style="width: 10%" class="text-center align-middle">Quản lý</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($data['paging']['count_data'] == 0){?>
                                <tr>
                                    <td colspan="6" class="text-center">Dữ liệu trống</td>
                                </tr>
                            <?php }?>
                            <?php
                            foreach ($data['data'] AS $row){
                                $post_user = new user($database);
                                $post_user = $post_user->get_user(['user_id' => $row['post_user']], 'user_name');

                                $post_category = new meta($database, 'blog_category');
                                $post_category = $post_category->get_meta($row['post_category'], 'meta_name');
                                ?>
                                <tr>
                                    <td class="text-left align-middle font-weight-bold">
                                        <a title="Xem chi tiết bài viết" class="font-weight-bold" href="<?=URL_ADMIN . "/{$path[1]}/detail/{$row['post_id']}"?>"><?=text_truncate($row['post_title'], 10)?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/". build_query(['post_user' => $row['post_user']])?>"><?=$post_user['user_name']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/". build_query(['post_category' => $row['post_category']])?>"><?=$post_category['data']['meta_name']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=formInputSwitch('post_feature', [
                                            'checked'   => $row['post_feature'] == 'true' ? 'true' : '',
                                            'value'     => 'true',
                                            'label'     => ' '
                                        ])?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['post_last_update'] ? "Sửa lần cuối <p>". view_date_time($row['post_last_update']) ."</p>" : 'Đăng lúc <p>'. view_date_time($row['post_time']) .'</p>'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['post_id']}"?>" title="Cập nhật <?=$row['post_title']?>"><i class="material-icons text-info">mode_edit</i></a>
                                        <a href="javascript:;" data-type="delete" data-id="<?=$row['post_id']?>" title="Xóa <?=$row['post_title']?>"><i class="material-icons text-danger">delete_forever</i></a>
                                    </td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="6" class="text-left">
                                    Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                    Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center clearfix">
                    <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/".build_query($_REQUEST, ['page' => '{page}']))?>
                </div>
            </div>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}