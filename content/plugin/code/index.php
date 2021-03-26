<?php
switch ($path[2]){
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['code']['add']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Upload Code', [URL_ADMIN . "/{$path[1]}/" => 'Mã nguồn'],'Upload Code');
            echo admin_error('Upload Code', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $header['css']  = [URL_ADMIN_ASSETS.'assets/css/editors/summernote.css?ver=2.2.0'];
        $header['js']   = [
            URL_ADMIN_ASSETS.'assets/js/libs/editors/summernote.js?ver=2.2.0',
            URL_ADMIN_ASSETS.'assets/js/editors.js?ver=2.2.0',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title'] = 'Upload Code';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Upload Code', [URL_ADMIN . "/{$path[1]}/" => 'Mã nguồn'],'Upload Code');
        ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Upload Code và kiếm tiền</h6></div>
                            <div class="card-tools"><a href="<?=URL_ADMIN . "/{$path[1]}/"?>" class="link">Danh sách</a></div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                        <?=formOpen()?>
                        <?=formInputText('code_title', [
                            'label' => 'Tiêu đề Code <code>*</code>'
                        ])?>
                        <?=formInputTextarea('code_conetnt', [
                            'class' => 'summernote-basic',
                            ''
                        ])?>
                        <?=formClose()?>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-bordered">
                    <!-- Content -->
                    <div class="card-inner bg-teal-dim">
                        <p class="text-center"><em class="icon ni ni-shield-check h1 text-success"></em></p>
                        <p class="text-center font-weight-bold h6 mt-0 header-title text-secondary">QUY ĐỊNH DUYỆT CODE</p><hr style="border-top: 1px dashed">
                        <p class="blockquote-footer text-secondary fs-15px"><strong>KHÔNG</strong> viết in hoa hoặc không dấu toàn bộ nội dung tiêu đề.</p>
                        <p class="blockquote-footer text-secondary fs-15px"><strong>KHÔNG</strong> viết in hoa hoặc không dấu toàn bộ nội dung tiêu đề.</p>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        echo "Hello";
        break;
}