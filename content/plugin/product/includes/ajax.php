<?php
switch ($path[2]){
    case 'delete_image':
        // Kiểm tra đăng nhập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }
        if(!$role['product']['update']){
            echo encode_json(get_response_array(403));
            break;
        }
        $media = new Media($database);
        $media = $media->delete_file('product', $path[3]);
        echo encode_json($media);
        break;
    case 'add_images':
        // Kiểm tra đăng nhập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }
        if(!$role['product']['add']){
            echo encode_json(get_response_array(403));
            break;
        }
        require_once ABSPATH . "/includes/class/class.uploader.php";
        if(!empty($_FILES['product_images'])) {
            $path_upload    = 'content/uploads/product/';
            $uploader       = new Uploader();
            $data_upload    = $uploader->upload($_FILES['product_images'], array(
                'limit'         => 15, //Maximum Limit of files. {null, Number}
                'maxSize'       => 2, //Maximum Size of files {null, Number(in MB's)}
                'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                'required'      => true, //Minimum one file is required for upload {Boolean}
                'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                'title'         => array('auto', 15), //New file name {null, String, Array} *please read documentation in README.md
                'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                'replace'       => false, //Replace the file if it already exists {Boolean}
                'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
            ));
            if ($data_upload['isComplete']) {
                $media = new Media($database);
                foreach ($data_upload['data']['metas'] AS $metas){
                    $_REQUEST['file_path']      = $path_upload . $metas['name'];
                    $_REQUEST['file_name']      = $metas['name'];
                    $_REQUEST['file_extension'] = $metas['extension'];
                    $_REQUEST['file_size']      = $metas['size'];
                    $media->add('product', $_REQUEST['product_id']);
                }
                echo encode_json(['response' => 200, 'message' => 'Upload ảnh thành công']);
            } else {
                echo encode_json($data_upload);
            }
        }else{
            echo encode_json(['response' => 203, 'message' => 'Không có File nào được chọn']);
        }
        break;
    case 'update_product_image':
        // Kiểm tra đăng nhập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }
        if(!$role['product']['add']){
            echo encode_json(get_response_array(403));
            break;
        }

        require_once ABSPATH . "/includes/class/class.uploader.php";
        if(!empty($_FILES['product_image'])){
            $path_upload        = 'content/uploads/product/';
            $uploader           = new Uploader();
            $data_upload        = $uploader->upload($_FILES['product_image'], array(
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
                $update_image   = new Product($database);
                $update_image   = $update_image->update_image($_REQUEST['product_id'], $data_images);
                echo encode_json($update_image);
            }else{
                echo encode_json(['response' => 203, 'message' => 'Upload File Lỗi']);
            }
        }else{
            echo encode_json(['response' => 203, 'message' => 'Không có file nào được chọn']);
        }
        break;
    case 'create_url':
        // Kiểm tra quyền truy cập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }

        // Kiểm tra quyền truy cập
        if(!$role['product']['add']){
            echo encode_json(get_response_array(403));
            break;
        }
        $title = sanitize_title($_REQUEST['product_name']);
        echo $title;
        break;
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }

        // Kiểm tra quyền truy cập
        if(!$role['product']['add']){
            echo encode_json(get_response_array(403));
            break;
        }

        $product    = new Product($database);
        $add        = $product->add();
        echo encode_json($add);
        break;
    case 'category':
        // Kiểm tra quyền truy cập
        if(!$role['product']['category']){
            echo "Forbidden";
            exit();
        }
        switch ($path[3]){
            case 'update':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }

                $cate   = new meta($database, 'product_category');
                $update = $cate->update($path[4]);
                echo encode_json($update);
                break;
            case 'delete':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }

                $role   = new meta($database, 'product_category');
                $delete = $role->delete($path[4]);
                echo encode_json($delete);
                break;
            default:
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                $category   = new meta($database, 'product_category');
                $add        = $category->add();
                echo encode_json($add);
                break;
        }
        break;
    case 'brand':
        // Kiểm tra quyền truy cập
        if(!$role['product']['brand']){
            echo "Forbidden";
            exit();
        }
        switch ($path[3]){
            case 'update':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }

                $cate   = new meta($database, 'product_brand');
                $update = $cate->update($path[4]);
                echo encode_json($update);
                break;
            case 'delete':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }

                $role   = new meta($database, 'product_brand');
                $delete = $role->delete($path[4]);
                echo encode_json($delete);
                break;
            case 'update_image':
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                require_once ABSPATH . "/includes/class/class.uploader.php";
                if(!empty($_FILES['file'])){
                    $path_upload        = 'content/uploads/brand/';
                    $uploader           = new Uploader();
                    $data_upload        = $uploader->upload($_FILES['file'], array(
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
                        $update_image   = new meta($database, 'product_brand');
                        $update_image   = $update_image->update_image($path[4], $data_images);
                        echo encode_json($update_image);
                    }else{
                        echo encode_json(['response' => 203, 'message' => 'Upload File Lỗi']);
                    }
                }else{
                    echo encode_json(['response' => 203, 'message' => 'Upload File Lỗi']);
                }
                break;
            default:
                // Kiểm tra đăng nhập
                if(!$me) {
                    echo encode_json(get_response_array(403));
                    break;
                }
                $category   = new meta($database, 'product_brand');
                $add        = $category->add();
                echo encode_json($add);
                break;
        }
        break;
    case 'update':
        // Kiểm tra quyền truy cập
        if(!$me) {
            echo encode_json(get_response_array(403));
            break;
        }

        // Kiểm tra quyền truy cập
        if(!$role['product']['update']){
            echo encode_json(get_response_array(403));
            break;
        }

        $product    = new Product($database);
        $action     = $product->update($path[3]);
        echo encode_json($action);
        break;
}