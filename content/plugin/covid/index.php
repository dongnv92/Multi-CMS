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

                    <!--Line 5-->
                    <div class="col-4">
                        <?=formInputText('covid_moiquanhe', [
                            'label' => 'Mối quan hệ với ca bệnh tiếp xúc',
                            'note'  => 'Mối quan hệ với ca bệnh đã tiếp xúc'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_phanloaitx', [
                            'label' => 'Phân loại tiếp xúc',
                            'note'  => 'Phân loại tiếp xúc'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_ngaytxcuoicung', [
                            'placeholder' => 'Ngày tiếp xúc cuối cùng',
                            'layout'    => 'date'
                        ])?>
                    </div>

                    <!--Line 5-->
                    <div class="col-12">
                        <?=formInputTextarea('covid_motahoancanhtx', [
                            'label' => 'Mô tả hoàn cảnh tiếp xúc'
                        ])?>
                    </div>

                    <!--Line 6-->
                    <div class="col-4">
                        <?=formInputText('covid_ngaykhoiphat', [
                            'placeholder' => 'Ngày khởi phát',
                            'layout'    => 'date'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_ngayvaovien', [
                            'placeholder' => 'Ngày vào viện',
                            'layout'    => 'date'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_ngayravien', [
                            'placeholder' => 'Ngày ra viện',
                            'layout'    => 'date'
                        ])?>
                    </div>

                    <!--Line 7-->
                    <div class="col-4">
                        <?=formInputText('covid_loaicanhly', [
                            'label' => 'Loại cách ly'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_ngaycachly', [
                            'placeholder' => 'Ngày bắt đầu cách ly',
                            'layout'    => 'date'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_noicachly', [
                            'label' => 'Địa điểm cách ly'
                        ])?>
                    </div>

                    <!--Line 8-->
                    <div class="col-4">
                        <?=formInputText('covid_ngaychamdutcachly', [
                            'placeholder' => 'Ngày chấm dứt cách ly',
                            'layout'    => 'date'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputSelect('covid_xetnghiemchua', [
                            ' ' => 'Đã xét nghiệm chưa',
                            '1' => 'Chưa',
                            '2' => 'Rồi'
                        ], [
                            'data-search' => 'on'
                        ])?>
                    </div>
                    <div class="col-4">
                        <?=formInputText('covid_solanxetnghiem', [
                            'placeholder' => 'Số lần xét nghiệm'
                        ])?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="text-center">
                            <?=formButton('THÊM MỚI', [
                                'id'    => 'button_covid_add',
                                'class' => 'btn btn-secondary',
                                'type'  => 'submit',
                                'name'  => 'submit',
                                'value' => 'submit'
                            ])?>
                        </div>
                    </div>
                </div>
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">Thông tin người nhập</h6></div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                        <?=formInputText('covid_user_name', [
                            'label' => 'Họ và tên'
                        ])?>
                    </div>
                    <!-- End Content -->
                </div>
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <!-- Title -->
                        <div class="card-title-group">
                            <div class="card-title"><h6 class="title">File dữ liệu</h6></div>
                        </div>
                        <!-- Title -->
                    </div>
                    <!-- Content -->
                    <div class="card-inner">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="meta_image" id="meta_image_add">
                                    <label class="custom-file-label" for="meta_image_add">Chọn File</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}