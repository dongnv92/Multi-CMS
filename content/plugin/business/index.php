<?php
switch ($path[2]){
    case 'report':
        switch ($path[3]){
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['business']['report']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Thêm báo cáo KD', [URL_ADMIN . "/{$path[1]}/" => 'Phòng Kinh Doanh', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Báo cáo'],'Thêm báo cáo');
                    echo admin_error('Thêm mới', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $business = new pBusiness();
                $header['js']       = [URL_JS."{$path[1]}/{$path[2]}/{$path[3]}"];
                $header['title']    = 'Thêm báo cáo KD';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Thêm báo cáo KD', [URL_ADMIN . "/{$path[1]}/" => 'Phòng Kinh Doanh', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Báo cáo'],'Thêm báo cáo');
                echo formOpen('', ['method' => 'GET'])
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-bordered">
                            <div class="card-inner border-bottom">
                                <!-- Title -->
                                <div class="card-title-group">
                                    <div class="card-title"><h6 class="title">Thêm báo cáo</h6></div>
                                </div>
                                <!-- Title -->
                            </div>
                            <!-- Content -->
                            <div class="card-inner">
                                <div class="row gy-4">
                                    <div class="col-lg-6">
                                        <?=formInputText('report_company_name', [
                                            'label' => 'Tên công ty <code>*</code>'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('report_company_address', [
                                            'label' => 'Địa chỉ công ty'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('report_contact_phone', [
                                            'label' => 'Số điện thoại khách hàng <code>*</code>'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('report_company_email', [
                                            'label' => 'Email khách hàng'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('report_contact_name', [
                                            'label' => 'Tên người liên hệ'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('report_shipping_needs', [
                                            'label' => 'Loại hàng, Số lượng của KH'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('report_using_company', [
                                            'label' => 'Đơn vị VC Khách hàng đang dùng'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputSelect('report_customer_need', $business->listCustomerNeedOption([0 => 'Nhu cầu của Khách Hàng']), [
                                            'data-search'       => 'on'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputSelect('report_approach', $business->listApproachOption([0 => 'Cách tiếp cận Khách Hàng']), [
                                            'data-search'       => 'on'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputSelect('report_customer_type', $business->listCustomerTypeOption([0 => 'Loại khách hàng liên hệ']), [
                                            'data-search'       => 'on'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputTextarea('report_feedback', [
                                            'placeholder'   => 'Phản hồi của Khách hàng',
                                            'rows'          => '5',
                                            'note'          => 'Phản hồi, ý kiến của khách hàng.'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputTextarea('report_note', [
                                            'placeholder'   => 'Ghi chú báo cáo',
                                            'rows'          => '5',
                                            'note'          => 'Ghi chú báo cáo.'
                                        ])?>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-right">
                                            <?=formButton('THÊM BÁO CÁO', [
                                                'id'    => 'report_add',
                                                'class' => 'btn btn-secondary'
                                            ]);?>
                                        </div>
                                    </div>
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
                // Kiểm tra quyền truy cập
                if(!$role['business']['report']){
                    $header['title'] = 'Lỗi quyền truy cập';
                    require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                    echo admin_breadcrumbs('Báo cáo KD', [URL_ADMIN . "/{$path[1]}/" => 'Phòng Kinh Doanh', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Báo cáo'],'Báo cáo');
                    echo admin_error('Báo cáo KD', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
                    require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                    exit();
                }

                $report = new pBusiness();
                $data   = $report->getMyReport();
                $param  = get_param_defaul();

                $header['title']    = 'Báo cáo KD';
                require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
                echo admin_breadcrumbs('Báo cáo KD', [URL_ADMIN . "/{$path[1]}/" => 'Phòng Kinh Doanh', URL_ADMIN . "/{$path[1]}/{$path[2]}" => 'Báo cáo'],'Báo cáo');
                ?>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        <div class="form-inline flex-nowrap gx-3">
                                            <?=formInputText('search', ['label' => 'Tìm kiếm', 'value' => 'Hihiii'])?>
                                            <div class="form-wrap w-150px">
                                                <select class="form-select form-select-sm" data-search="off" data-placeholder="Bulk Action">
                                                    <option value="">Bulk Action</option>
                                                    <option value="email">Send Email</option>
                                                    <option value="group">Change Group</option>
                                                    <option value="suspend">Suspend User</option>
                                                    <option value="delete">Delete User</option>
                                                </select>
                                            </div>
                                            <div class="btn-wrap">
                                                <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Apply</button></span>
                                                <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                            </div>
                                        </div><!-- .form-inline -->
                                    </div><!-- .card-tools -->
                                    <div class="card-tools mr-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li class="btn-toolbar-sep"></li><!-- li -->
                                            <li>
                                                <div class="toggle-wrap">
                                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                    <div class="toggle-content" data-content="cardTools">
                                                        <ul class="btn-toolbar gx-1">
                                                            <li class="toggle-close">
                                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                            </li><!-- li -->
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                        <em class="icon ni ni-setting"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                        <ul class="link-check">
                                                                            <li><span>Show</span></li>
                                                                            <li class="active"><a href="#">10</a></li>
                                                                            <li><a href="#">20</a></li>
                                                                            <li><a href="#">50</a></li>
                                                                        </ul>
                                                                        <ul class="link-check">
                                                                            <li><span>Order</span></li>
                                                                            <li class="active"><a href="#">DESC</a></li>
                                                                            <li><a href="#">ASC</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div><!-- .dropdown -->
                                                            </li><!-- li -->
                                                        </ul><!-- .btn-toolbar -->
                                                    </div><!-- .toggle-content -->
                                                </div><!-- .toggle-wrap -->
                                            </li><!-- li -->
                                        </ul><!-- .btn-toolbar -->
                                    </div><!-- .card-tools -->
                                </div><!-- .card-title-group -->
                            </div><!-- .card-inner -->
                            <div class="card-inner p-0">
                                <table class="table table-tranx table-hover">
                                    <thead>
                                    <tr class="tb-tnx-head">
                                        <th width="5%">STT</th>
                                        <th width="10%">Tên Cty</th>
                                        <th width="10%">Địa chỉ</th>
                                        <th width="10%">Liên hệ</th>
                                        <th width="5%">Nhu cầu VC</th>
                                        <th width="10%">DVKH Đang Dùng</th>
                                        <th>Nhu cầu KH</th>
                                        <th>Cách tiếp cận</th>
                                        <th>Loại KH</th>
                                        <th>Ghi chú</th>
                                        <th>Thời gian</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0; foreach ($data['data'] AS $_data){ $i++;?>
                                        <tr class="tb-tnx-item">
                                            <td><?=$i?></td>
                                            <td><?=$_data['report_company_name']?></td>
                                            <td><?=$_data['report_company_address']?></td>
                                            <td>
                                                <p><?=$_data['report_contact_name'] . ' ('. $_data['report_contact_phone'] .')'?></p>
                                                <?=$_data['report_company_email']?$_data['report_company_email']:'---'?>
                                            </td>
                                            <td><?=$report->listCustomerNeedOption('', $_data['report_customer_need'])?></td>
                                            <td><?=$_data['report_using_company']?$_data['report_using_company']:'---'?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
                <?php
                require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
                break;
        }
        break;
}