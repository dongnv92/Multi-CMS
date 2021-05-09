<?php
switch ($path[2]){
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['covid']['add']){
            $header['title'] = 'Lỗi quyền truy cập';
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_breadcrumbs('Thêm danh sách các F', [URL_ADMIN . "/{$path[1]}/" => 'Covid Mê Linh'],'Thêm danh sách các F');
            echo admin_error('Thêm danh sách các F', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $header['title'] = 'Thêm danh sách các F huyện Mê Linh';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Thêm danh sách các F', [URL_ADMIN . "/{$path[1]}/" => 'Covid Mê Linh'],'Thêm danh sách các F');
        ?>
        <div class="row">
            <div class="col-lg-9">
                <div class="row g-4">
                    <!--Line 1-->
                    <div class="col-4">
                        <?=formInputText('covid_hovaten', [
                            'label' => 'Họ và tên <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_namsinh', [
                            'label' => 'Năm sinh <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputSelect('covid_gioitinh', [
                            ' ' => 'Chọn giới tính',
                            '1' => 'Nam',
                            '2' => 'Nữ'
                        ], [
                            'data-search' => 'on'
                        ])?>
                    </div>

                    <!--Line 2-->
                    <div class="col-3">
                        <?=formInputText('covid_xom', [
                            'label' => 'Xóm <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-3">
                        <?=formInputText('covid_thon', [
                            'label' => 'Thôn <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-3">
                        <?=formInputText('covid_xa', [
                            'label' => 'Xã <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-3">
                        <?=formInputText('covid_huyen', [
                            'label' => 'Huyện <code>*</code>'
                        ])?>
                    </div>

                    <!--Line 3-->
                    <div class="col-4">
                        <?=formInputText('covid_tinh', [
                            'label' => 'Tỉnh / Thành phố <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_sodienthoai', [
                            'label' => 'Điện thoại <code>*</code>'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_nghe', [
                            'label' => 'Nghề nghiệp <code>*</code>'
                        ])?>
                    </div>

                    <!--Line 4-->
                    <div class="col-4">
                        <?=formInputText('covid_loaigiamsat', [
                            'label' => 'Loại giám sát <code>*</code>',
                            'note'  => 'Phân loại giám sát'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_ngayphathien', [
                            'placeholder' => 'Ngày phát hiện',
                            'layout'    => 'date'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputSelect('covid_f', [
                            ' ' => 'Là F mấy?',
                            'f0' => 'F0',
                            'f1' => 'F1',
                            'f2' => 'F2',
                            'f3' => 'F3',
                            'f4' => 'F4'
                        ], [
                            'data-search' => 'on',
                            'note'        => 'Thuộc diện F mấy?'
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">

            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}