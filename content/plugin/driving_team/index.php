<?php
switch ($path[2]){
    case 'plan':
        switch ($path[3]){
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['driving_team']['plan']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Thêm kế hoạch xe', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế hoạch xe'],'Thêm kế hoạch xe');
                    echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $list_car   = new Category('driving_team');
                $list_car   = $list_car->getOptionSelect();
                $list_user  = new user($database);
                $list_user  = $list_user->get_all_user_option();

                $header['js']       = [URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"];
                $header['title']    = 'Thêm kế hoạch xe';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Thêm kế hoạch xe', [URL_ADMIN . "/{$path[1]}/" => 'Tổ lái xe', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Kế hoạch xe'],'Thêm kế hoạch');
                echo formOpen('', ['method' => 'GET'])
                ?>
                <div class="row justify-content-center">
                    <div class="col-9">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <!-- Title -->
                                <div class="card-title-group">
                                    <div class="card-title"><h6 class="title">Thêm kế hoạch xe</h6></div>
                                    <div class="card-tools">
                                        <a href="#" class="link">Danh sách</a>
                                    </div>
                                </div>
                                <!-- Title -->
                            </div>
                            <!-- Content -->
                            <div class="card-inner">
                                <?=formInputText('plan_date', [
                                    'label'         => 'Tiêu đề kế hoạch',
                                    'placeholder'   => 'Chọn ngày phát hàng',
                                    'layout'        => 'date'
                                ])?>
                                <?=formInputSelect('plan_car', $list_car, [
                                    'label'         => 'Biển Số Xe',
                                    'data-search'   => 'on'
                                ])?>
                                <?=formInputSelect('plan_lx', $list_user, [
                                    'data-search'   => 'on',
                                    'multiple'      => 'multiple',
                                    'data-placeholder' => 'Chọn lái xe phát'
                                ])?>
                                <?=formInputText('plan_area', [
                                    'label' => 'Khu vực phát'
                                ])?>
                                <?=formInputTextarea('plan_note', [
                                    'label' => 'Ghi chú'
                                ])?>
                                <div class="text-center">
                                    <?=formButton('THÊM MỚI', [
                                        'id'    => 'button_plan_add',
                                        'class' => 'btn btn-secondary',
                                        'type'  => 'submit',
                                        'name'  => 'submit',
                                        'value' => 'submit'
                                    ])?>
                                </div>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                </div>
                <?php
                echo formClose();
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
            default:

                break;
        }
        break;
}