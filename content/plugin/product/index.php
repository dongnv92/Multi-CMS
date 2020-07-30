<?php
switch ($path[2]){
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
                $list_cate_option   = new meta($database, 'product_category');
                $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Chuyên mục cha']);
                $list_cate          = new meta($database, 'product_category');
                $list_cate          = $list_cate->get_data_showall();

                $header['css']      = [
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
                ];
                $header['js']       = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
                    URL_JS . "{$path[1]}/{$path[2]}",
                ];
                $header['title']    = 'Danh mục bài viết';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Danh mục', 'Danh mục bài viết','Quản lý', [URL_ADMIN . "/{$path['1']}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Danh mục']);
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Danh mục <small>Thêm danh mục bài viết</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên danh mục. <code>*</code>',
                                    'placeholder'   => 'Nhập tên danh mục',
                                    'autofocus'     => ''
                                ])?>
                                <?=formInputText('meta_url', [
                                    'label'         => 'URL <code>Có thể để trống</code>',
                                    'placeholder'   => 'Nhập URL danh mục'
                                ])?>
                                <?=formInputSelect('meta_parent', $list_cate_option, [
                                        'label'             => 'Danh mục cha.',
                                        'data-live-search'  => 'true']
                                )?><br><br>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả danh mục',
                                    'rows'          => '5'
                                ])?>
                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('THÊM', [
                                            'id'    => 'button_add',
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
                                    <div class="col-lg-6 text-left"><h2>Danh sách danh mục sản phẩm</h2></div>
                                </div>
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%" class="text-left align-middle">Tên danh mục</th>
                                        <th style="width: 30%" class="text-center align-middle">Nội dung</th>
                                        <th style="width: 20%" class="text-center align-middle">Ngày Thêm</th>
                                        <th style="width: 20%" class="text-center align-middle">Xóa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?=!count($list_cate) ? '<tr><td colspan="4" class="text-center">Chưa có dữ liệu</td></tr>' : ''?>
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
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
        }
        break;
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['product']['add']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Sản phẩm', 'Thêm mới sản phẩm','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
            echo admin_error('Thêm mới sản phẩm', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $header['title']    = 'Thêm sản phẩm';
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
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Sản phẩm', 'Thêm mới sản phẩm','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
        echo formOpen();
        ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2>Sản phẩm <small>Thêm sản phẩm</small></h2>
                    </div>
                    <div class="body">
                        <?=formInputText('product_name', [
                            'placeholder'   => 'Nhập tên sản phẩm',
                            'autofocus'     => ''
                        ])?>
                        <?=formInputTextarea('post_content', [
                            'value' => $_REQUEST['post_content'] ? $_REQUEST['post_content'] : '',
                            'id'    => 'summernote'
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>
        <?php
        echo formClose();
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}