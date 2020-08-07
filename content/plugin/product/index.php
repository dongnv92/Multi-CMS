<?php
require_once ABSPATH . PATH_PLUGIN . "product/includes/function-nomal.php";
switch ($path[2]){
    case 'brand':
        // Kiểm tra quyền truy cập
        if(!$role['product']['brand']){
            $header['title']    = 'Truy cập không hợp lệ';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Sản phẩm', 'Brand','Brand', [URL_ADMIN . '/product/' => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Brand']);
                echo admin_error('Truy cập không hợp lệ', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        switch ($path[3]){
            case 'update':
                $meta = new meta($database, 'product_brand');
                $meta = $meta->get_meta($path[4]);
                // Kiểm tra tồn tại của meta
                if($meta['response'] != 200){
                    $header['title']    = 'Cập nhật Brand';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                        echo admin_breadcrumbs('Sản phẩm', 'Cập nhật Brand','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Brand']);
                        echo admin_error('Brand', 'Brand không tồn tại.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $list_cate          = new meta($database, 'product_brand');
                $list_cate          = $list_cate->get_data_showall();

                $header['css']  = [
                    URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css'
                ];
                $header['js']   = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"
                ];
                $header['title']    = 'Thêm Brand';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Brand', 'Cập nhật Brand','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Brand']);
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Brand <small>Thêm Brand mới</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên Brand. <code>*</code>',
                                    'placeholder'   => 'Nhập tên Brand',
                                    'autofocus'     => '',
                                    'value'         => $meta['data']['meta_name']
                                ])?>
                                <?=formInputText('meta_url', [
                                    'label'         => 'URL <code>Có thể để trống</code>',
                                    'placeholder'   => 'Nhập URL chuyên mục',
                                    'value'         => $meta['data']['meta_url']
                                ])?>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả Brand',
                                    'rows'          => '5',
                                    'value'         => $meta['data']['meta_des']
                                ])?>

                                <br />
                                <label>Ảnh Brand <code>(Định dạng jpg, png)</code></label>
                                <div class="form-group">
                                    <input type="file" data-default-file="<?=URL_HOME . '/' . $meta['data']['meta_image']?>" name="meta_image" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png" />
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-raised bg-blue waves-effect">THÊM MỚI</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('CẬP NHẬT', [
                                            'id'    => 'button_update',
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
                                    <div class="col-lg-6 text-left"><h2>Danh sách Brand</h2></div>
                                </div>
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%" class="text-left align-middle">Tên Brand</th>
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
                                                <?=$_list_cate['meta_des'] ? $_list_cate['meta_des'] : '---'?>
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
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            default:
                $list_cate          = new meta($database, 'product_brand');
                $list_cate          = $list_cate->get_data_showall();
                $header['css']      = [
                    URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css',
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
                ];
                $header['js']       = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
                    URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
                    URL_JS . "{$path[1]}/{$path[2]}",
                ];
                $header['title']    = 'Brand';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Brand', 'Brand sản phẩm','Danh sách', [URL_ADMIN . "/{$path['1']}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Brand']);
                ?>
                <?=formOpen('', ["method" => "POST", 'enctype' => true])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Brand <small>Thêm Brand</small></h2>
                            </div>
                            <div class="body">
                                <?=formInputText('meta_name', [
                                    'label'         => 'Tên Brand. <code>*</code>',
                                    'placeholder'   => 'Nhập tên Brand',
                                    'autofocus'     => ''
                                ])?>
                                <?=formInputText('meta_url', [
                                    'label'         => 'URL <code>Có thể để trống</code>',
                                    'placeholder'   => 'Nhập URL danh mục'
                                ])?>
                                <?=formInputTextarea('meta_des', [
                                    'label'         => 'Mô tả',
                                    'placeholder'   => 'Nhập mô tả Brand',
                                    'rows'          => '5'
                                ])?>
                                <br />
                                <label>Ảnh Brand <code>(Định dạng jpg, png)</code></label>
                                <div class="form-group">
                                    <input type="file" name="meta_image" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png" />
                                </div>

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
                                    <div class="col-lg-6 text-left"><h2>Danh sách Brand</h2></div>
                                </div>
                            </div>
                            <div class="content table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%" class="text-left align-middle">Tên Brand</th>
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
                                                <?=$_list_cate['meta_des'] ? $_list_cate['meta_des'] : '---'?>
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
    case 'category':
        // Kiểm tra quyền truy cập
        if(!$role['product']['category']){
            $header['title']    = 'Truy cập không hợp lệ';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Danh mục sản phẩm', '','Quản lý', [URL_ADMIN . '/product/' => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Danh mục']);
            echo admin_error('Truy cập không hợp lệ', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        switch ($path[3]){
            case 'update':
                $meta = new meta($database, 'product_category');
                $meta = $meta->get_meta($path[4]);
                // Kiểm tra tồn tại của meta
                if($meta['response'] != 200){
                    $header['title']    = 'Cập nhật danh mục bài sản phẩm';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                        echo admin_breadcrumbs('Sản phẩm', 'Cập nhật danh mục sản phẩm','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Danh mục']);
                        echo admin_error('Danh mục sản phẩm', 'Danh mục sản phẩm không tồn tại.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $list_cate_option   = new meta($database, 'product_category');
                $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Danh mục cha']);
                $list_cate          = new meta($database, 'product_category');
                $list_cate          = $list_cate->get_data_showall();

                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"
                ];
                $header['title']    = 'Danh mục sản phẩm';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Sản phẩm', 'Cập nhật danh mục sản phẩm','Cập nhật danh mục', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Danh mục']);
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
                                        <a href="<?=URL_ADMIN."/{$path[1]}/{$path[2]}"?>" class="btn btn-raised bg-blue waves-effect">THÊM MỚI</a>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?=formButton('CẬP NHẬT', [
                                            'id'    => 'button_update',
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
                                                <?=$_list_cate['meta_des'] ? $_list_cate['meta_des'] : '---'?>
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
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            default:
                $list_cate_option   = new meta($database, 'product_category');
                $list_cate_option   = $list_cate_option->get_data_select(['0' => 'Danh mục cha']);
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
                $header['title']    = 'Danh mục sản phẩm';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Danh mục', 'Danh mục sản phẩm','Quản lý', [URL_ADMIN . "/{$path['1']}/" => 'Sản phẩm', URL_ADMIN . '/'. $path[1] .'/' . $path[2] => 'Danh mục']);
                ?>
                <?=formOpen('', ["method" => "POST"])?>
                <div class="row clearfix">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="header">
                                <h2>Danh mục <small>Thêm danh mục sản phẩm</small></h2>
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
                                                <?=$_list_cate['meta_des'] ? $_list_cate['meta_des'] : '---'?>
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
    case 'update':
        // Kiểm tra quyền truy cập
        if(!$role['product']['update']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Sản phẩm', 'Cập nhật sản phẩm','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
            echo admin_error('Cập nhật sản phẩm', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $product    = new Product($database);
        $data       = $product->get_product(['product_id' => $path[3]]);

        $unit_product_option = $product->get_unit();

        if(!$data){
            $header['title'] = 'Sản phẩm không tồn tại.';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Sản phẩm', 'Cập nhật sản phẩm','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
            echo admin_error('Cập nhật sản phẩm', 'Sản phẩm không tồn tại hoặc bị xóa.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        // Get Category Option
        $option_category = new meta($database, 'product_category');
        $option_category = $option_category->get_data_select([0 => 'Chọn Danh Mục']);

        // Get Brand Option
        $option_brand = new meta($database, 'product_brand');
        $option_brand = $option_brand->get_data_select([0 => 'Chọn Brand']);

        // Get List Images
        $images = new Media($database);
        $images = $images->get_list_data('product', $path[3]);

        $header['title']    = 'Cập nhật sản phẩm';
        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.css',
            URL_ADMIN_ASSETS . 'plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
            URL_ADMIN_ASSETS . 'plugins/light-gallery/css/lightgallery.css',
            URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
            URL_ADMIN_ASSETS . 'plugins/light-gallery/js/lightgallery-all.js',
            URL_ADMIN_ASSETS . 'plugins/bootstrap-tagsinput/bootstrap-tagsinput.js',
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.js',
            URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
        ];
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Sản phẩm', 'Cập nhật sản phẩm','Cập nhật', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
        echo formOpen();
        ?>
        <div class="row">
            <div class="col-lg-8">
                <!--Thông tin cơ bản-->
                <div class="card">
                    <div class="body">
                        <?=formInputText('product_name', [
                            'placeholder'   => 'Nhập tên sản phẩm',
                            'value'         => $data['product_name'],
                            'autofocus'     => true
                        ])?>
                        <?=formInputTextarea('product_content', [
                            'value'     => $data['product_content'],
                            'class'     => 'summernote'
                        ])?>
                    </div>
                </div>

                <!--Thông tin khác-->
                <div class="card">
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#first">Chung</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#second">Kiểm kê kho</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#images">Danh sách ảnh</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#upload_images">Tải thêm ảnh</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="first">
                                <?=formInputText('product_price', [
                                    'layout'    => 'horizonta',
                                    'value'     => $data['product_price'],
                                    'label'     => '<code>*</code> Giá bán thường (₫)'
                                ])?>
                                <?=formInputText('product_price_sale', [
                                    'layout'    => 'horizonta',
                                    'value'     => $data['product_price_sale'],
                                    'label'     => 'Giá khuyến mãi (₫)'
                                ])?>
                                <?=formInputText('product_price_buy', [
                                    'layout'    => 'horizonta',
                                    'value'     => $data['product_price_buy'],
                                    'label'     => 'Giá nhập (₫)'
                                ])?>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        Đơn vị tính
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <?=formInputSelect('product_unit', $unit_product_option, [
                                            'data-live-search'  => 'true',
                                            'selected'          => $data['product_unit']
                                        ])?>
                                    </div>
                                </div><br />
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        Giá đã gồm thuế?
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <?=formInputSwitch('product_price_vat', [
                                            'checked'   => $data['product_price_vat'] == 'true' ? 'true' : '',
                                            'value'     => 'true',
                                            'label'     => ' '
                                        ])?>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="second">
                                <?=formInputText('product_barcode', [
                                    'layout'    => 'horizonta',
                                    'label'     => 'Mã sản phẩm',
                                    'value'     => $data['product_barcode']
                                ])?>
                                <?=formInputText('product_sku', [
                                    'layout'    => 'horizonta',
                                    'value'     => $data['product_sku'],
                                    'label'     => 'Mã SKU'
                                ])?>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        Trạng thái kho hàng?
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <?=formInputSelect('product_instock', ['instock' => 'Còn hàng', 'outofstock' => 'Hết hàng'], [
                                            'data-live-search'  => 'true',
                                            'selected'          => $data['product_instock']
                                        ])?>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="images">
                                <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                    <?php if($images){?>
                                    <?php foreach ($images AS $_images){?>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 m-b-20">
                                        <a href="<?=URL_HOME . '/' . $_images['file_path']?>" data-sub-html="Ảnh sản phẩm <?=$data['product_name']?>">
                                            <img class="img-fluid img-thumbnail" src="<?=URL_HOME . '/' . $_images['file_path']?>" alt="">
                                        </a>
                                        <div class="text-danger text-center"><small>Xóa ảnh</small></div>
                                    </div>
                                    <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="upload_images">
                                <div class="form-group">
                                    <input type="file" name="product_images[]" id="product_images" class="dropify" data-allowed-file-extensions="jpg png" multiple />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Nội dung ngắn-->
                <div class="card">
                    <div class="header">
                        <h2>Nội dung ngắn</h2>
                    </div>
                    <div class="body">
                        <?=formInputTextarea('product_short_content', [
                            'class'     => 'summernote',
                            'value'     => $data['product_short_content']
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="body">
                        <?=formInputCheckbox('product_featured', ['1' => 'Đây là sản phẩm nổi bật?'], ['layout' => 'inline', 'checked' => ($data['product_featured'] == 'true' ? 'checked' : '')])?>
                        <?=formInputCheckbox('product_status', ['show' => 'Ẩn / Hiện'], ['layout' => 'inline', 'checked' => ($data['product_status'] == 'public' ? 'checked' : '')])?>
                        <hr style="border-top: 1px dashed #0f74a8" />
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="<?=URL_ADMIN."/{$path[1]}/"?>" class="btn btn-outline-info waves-effect">DANH SÁCH</a>
                            </div>
                            <div class="col-lg-6 text-right">
                                <?=formButton('CẬP NHẬT', [
                                    'id' => 'button_submit'
                                ])?>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Danh Mục Sản Phẩm-->
                <div class="card">
                    <div class="body">
                        <?=formInputSelect('product_category', $option_category, [
                            'label'     => 'Danh mục sản phẩm <code>*</code>',
                            'selected'  => $data['product_category'],
                            'data-live-search'  => 'true'
                        ])?>
                    </div>
                </div>

                <!--Brand-->
                <div class="card">
                    <div class="body">
                        <?=formInputSelect('product_brand', $option_brand, [
                            'label'     => 'Brand Name',
                            'selected'  => $data['product_brand'],
                            'data-live-search'  => 'true',
                        ])?>
                    </div>
                </div>

                <!--Brand-->
                <div class="card">
                    <div class="body">
                        <?=formInputText('product_url', [
                            'placeholder'   => 'Nhập URL sản phẩm',
                            'value'         => $data['product_url'],
                            'label'         => 'URL sản phẩm <code>(Có thể để trống)</code>'
                        ])?>
                    </div>
                </div>

                <!--Hastag-->
                <div class="card">
                    <div class="body">
                        <?=formInputText('product_hashtag', [
                            'label'         => '# Hashtag <code>(Phân cách bằng dấu phẩy hoặc phím enter)</code>',
                            'data-role'     => 'tagsinput',
                            'value'         => $data['product_hashtag']
                        ])?>
                    </div>
                </div>

                <!-- Ảnh -->
                <div class="card">
                    <div class="header">
                        <h2>Ảnh sản phẩm</h2>
                    </div>
                    <div class="body">
                        <div class="form-group">
                            <input type="file" name="product_image" data-default-file="<?=URL_HOME . '/' . $data['product_image']?>" id="product_image" class="dropify" data-allowed-file-extensions="jpg png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
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

        $product = new Product($database);
        $unit_product_option = $product->get_unit();

        // Get Category Option
        $option_category = new meta($database, 'product_category');
        $option_category = $option_category->get_data_select([0 => 'Chọn Danh Mục']);
        // Get Brand Opyin
        $option_brand = new meta($database, 'product_brand');
        $option_brand = $option_brand->get_data_select([0 => 'Chọn Brand']);

        $header['title']    = 'Thêm sản phẩm';
        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.css',
            URL_ADMIN_ASSETS . 'plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
            URL_ADMIN_ASSETS . 'plugins/dropify/css/dropify.min.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_ADMIN_ASSETS . 'plugins/dropify/js/dropify.min.js',
            URL_ADMIN_ASSETS . 'plugins/bootstrap-tagsinput/bootstrap-tagsinput.js',
            URL_ADMIN_ASSETS . 'plugins/summernote/summernote.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Sản phẩm', 'Thêm mới sản phẩm','Thêm mới', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
        echo formOpen();
        ?>
        <div class="row">
            <div class="col-lg-8">
                <!--Thông tin cơ bản-->
                <div class="card">
                    <div class="body">
                        <?=formInputText('product_name', [
                            'placeholder'   => 'Nhập tên sản phẩm',
                            'autofocus'     => true,
                        ])?>
                        <?=formInputTextarea('product_content', [
                            'class'    => 'summernote'
                        ])?>
                    </div>
                </div>

                <!--Thông tin khác-->
                <div class="card">
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#first">Chung</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#second">Kiểm kê kho</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#images">Danh sách ảnh</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="first">
                                <?=formInputText('product_price', [
                                    'layout'    => 'horizonta',
                                    'label'     => '<code>*</code> Giá bán thường (₫)'
                                ])?>
                                <?=formInputText('product_price_sale', [
                                    'layout'    => 'horizonta',
                                    'label'     => 'Giá khuyến mãi (₫)'
                                ])?>
                                <?=formInputText('product_price_buy', [
                                    'layout'    => 'horizonta',
                                    'label'     => 'Giá nhập (₫)'
                                ])?>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        Đơn vị tính
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <?=formInputSelect('product_unit', $unit_product_option, [
                                            'data-live-search'  => 'true',
                                        ])?>
                                    </div>
                                </div><br />
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        Giá đã gồm thuế?
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <?=formInputSwitch('product_price_vat', [
                                            'value'     => 'true',
                                            'label'     => ' '
                                        ])?>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="second">
                                <?=formInputText('product_barcode', [
                                    'layout'    => 'horizonta',
                                    'label'     => 'Mã sản phẩm',
                                    'value'     => $product->create_barcode()
                                ])?>
                                <?=formInputText('product_sku', [
                                    'layout'    => 'horizonta',
                                    'label'     => 'Mã SKU'
                                ])?>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        Trạng thái kho hàng?
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <?=formInputSelect('product_instock', ['instock' => 'Còn hàng', 'outofstock' => 'Hết hàng'], [
                                            'data-live-search'  => 'true',
                                        ])?>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="images">
                                <div class="form-group">
                                    <input type="file" name="product_images[]" id="product_images" class="dropify" data-allowed-file-extensions="jpg png" multiple />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Nội dung ngắn-->
                <div class="card">
                    <div class="header">
                        <h2>Nội dung ngắn</h2>
                    </div>
                    <div class="body">
                        <?=formInputTextarea('product_short_content', [
                            'class'    => 'summernote'
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="body">
                        <?=formInputCheckbox('product_featured', ['1' => 'Đây là sản phẩm nổi bật?'], ['layout' => 'inline'])?>
                        <?=formInputCheckbox('product_status', ['show' => 'Ẩn / Hiện'], ['layout' => 'inline', 'checked' => 'checked'])?>
                        <hr style="border-top: 1px dashed #0f74a8" />
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="<?=URL_ADMIN."/{$path[1]}/"?>" class="btn btn-outline-info waves-effect">DANH SÁCH</a>
                            </div>
                            <div class="col-lg-6 text-right">
                                <?=formButton('THÊM MỚI', [
                                    'id' => 'button_add'
                                ])?>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Danh Mục Sản Phẩm-->
                <div class="card">
                    <div class="body">
                        <?=formInputSelect('product_category', $option_category, [
                            'label' => 'Danh mục sản phẩm <code>*</code>',
                            'data-live-search'  => 'true',
                        ])?>
                    </div>
                </div>

                <!--Brand-->
                <div class="card">
                    <div class="body">
                        <?=formInputSelect('product_brand', $option_brand, [
                            'label' => 'Brand Name',
                            'data-live-search'  => 'true',
                        ])?>
                    </div>
                </div>

                <!--Brand-->
                <div class="card">
                    <div class="body">
                        <?=formInputText('product_url', [
                            'placeholder'   => 'Nhập URL sản phẩm',
                            'label'         => 'URL sản phẩm <code>(Có thể để trống)</code>',
                        ])?>
                    </div>
                </div>

                <!--Hastag-->
                <div class="card">
                    <div class="body">
                        <?=formInputText('product_hashtag', [
                            'label'         => '# Hashtag <code>(Phân cách bằng dấu phẩy hoặc phím enter)</code>',
                            'data-role'     => 'tagsinput'
                        ])?>
                    </div>
                </div>

                <!-- Ảnh -->
                <div class="card">
                    <div class="header">
                        <h2>Ảnh sản phẩm</h2>
                    </div>
                    <div class="body">
                        <div class="form-group">
                            <input type="file" name="product_image" data-default-file="<?=URL_HOME . '/' . get_config('no_image')?>" id="product_image" class="dropify" data-allowed-file-extensions="jpg png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        // Kiểm tra quyền truy cập
        if(!$role['product']['manager']){
            $header['title']    = 'Truy cập không hợp lệ';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Sản phẩm', 'Quản lý sản phẩm','quản lý', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
            echo admin_error('Truy cập không hợp lệ', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        // Lấy dữ liệu
        $product    = new Product($database);
        $data       = $product->get_all();
        $param      = get_param_defaul();
        $category   = new meta($database, 'product_category');
        $category   = $category->get_data_select(['0' => 'Chuyên mục']);

        $header['css']      = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.css'
        ];
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/sweetalert/sweetalert.min.js',
            URL_JS . "{$path[1]}",
        ];
        $header['title'] = 'Quản lý sản phẩm';
        require_once ABSPATH . PATH_ADMIN . '/admin-header.php';
        echo admin_breadcrumbs('Sản phẩm', 'Quản lý sản phẩm','Quản lý sản phẩm', [URL_ADMIN . "/{$path[1]}/" => 'Sản phẩm']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <a href="<?=URL_ADMIN . "/{$path[1]}/"?>" class="text-small">Tất cả</a> | <a href="<?=URL_ADMIN . "/{$path[1]}/?product_status=public"?>" class="text-small">Đã xuất bản</a> | <a href="<?=URL_ADMIN . "/{$path[1]}/?product_status=hide"?>" class="text-small text-danger">Thùng rác</a>
            </div>
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
                            <?=formInputSelect('product_category', $category, ['data-live-search' => 'true', 'selected' => $_REQUEST['product_category']])?>
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
                                <th style="width: 7%" class="text-center align-middle">Ảnh</th>
                                <th style="width: 27%" class="text-left align-middle">Tên sản phẩm</th>
                                <th style="width: 8%" class="text-center align-middle">Mã SP</th>
                                <th style="width: 13%" class="text-center align-middle">Giá</th>
                                <th style="width: 7%" class="text-center align-middle">Nổi bật</th>
                                <th style="width: 10%" class="text-center align-middle">Kho</th>
                                <th style="width: 8%" class="text-center align-middle">Danh Mục</th>
                                <th style="width: 10%" class="text-center align-middle">Brand</th>
                                <th style="width: 10%" class="text-center align-middle">Thời gian</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($data['paging']['count_data'] == 0){?>
                                <tr>
                                    <td colspan="9" class="text-center">Dữ liệu trống</td>
                                </tr>
                            <?php }?>
                            <?php
                            foreach ($data['data'] AS $row){
                                $product_user       = new user($database);
                                $product_user       = $product_user->get_user(['user_id' => $row['category_user']], 'user_name');
                                $product_category   = new meta($database, 'product_category');
                                $product_category   = $product_category->get_meta($row['product_category'], 'meta_name');
                                if($row['product_brand']){
                                    $product_brand   = new meta($database, 'product_brand');
                                    $product_brand   = $product_brand->get_meta($row['product_brand'], 'meta_name');
                                }
                                ?>
                                <tr data-label="manager" data-id="<?=$row['product_id']?>">
                                    <td class="text-center align-middle">
                                        <img src="<?=URL_HOME . "/" . $row['product_image']?>" class="rounded" height="60px">
                                    </td>
                                    <td class="text-left align-middle font-weight-bold">
                                        <?=$row['product_name']?><br />
                                        <p id="hide_<?=$row['product_id']?>" style="display: none">
                                            <small>ID: <?=$row['product_id']?> | <a href="<?=URL_ADMIN . "/{$path[1]}/update/{$row['product_id']}"?>">Chỉnh sửa</a> | <a href="#" class="text-danger">Xoá</a></small>
                                        </p>
                                        <p id="show_<?=$row['product_id']?>"><br /></p>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['product_barcode']?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['product_price_sale'] ? "<del>". convert_number_to_money($row['product_price']) ." ". CURRENCY ."</del><br />". convert_number_to_money($row['product_price_sale']) ." ".CURRENCY : convert_number_to_money($row['product_price']). ' '.CURRENCY?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['product_featured'] ? '<i class="material-icons text-secondary">star</i>' : '<i class="material-icons text-secondary">star_border</i>'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['product_instock'] == 'instock' ? '<span class="text-success font-weight-bold">Còn hàng</span> ('. $row['product_quantity'] .')' : '<span class="text-danger font-weight-bold">Hết hàng</span>'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=URL_ADMIN . "/{$path[1]}/?product_category={$row['product_category']}"?>"><?=$product_category['data']['meta_name']?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['product_brand'] ? '<a href="'. URL_ADMIN .'/'. $path[1] .'/?product_brand='. $row['product_brand'] .'">'. $product_brand['data']['meta_name'] .'</a>' : '---'?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?=$row['product_last_update'] ? "Sửa lần cuối <p>". view_date_time($row['product_last_update']) ."</p>" : 'Đăng lúc <p>'. view_date_time($row['product_time']) .'</p>'?>
                                    </td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="9" class="text-left">
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
        require_once ABSPATH . PATH_ADMIN . '/admin-footer.php';
        break;
}