<?php
error_reporting(0);
switch ($path[2]){
    case 'send':
        // Kiểm tra quyền truy cập
        if(!$role['momo']['manager']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Danh sách tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Danh sách tài khoản MOMO', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $header['title']    = 'Chuyển tiền';
        $header['toolbar']  = admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Danh sách tài khoản');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        $momo = new Momo('0962778307');
        print_r($momo->sendMoney('0966624292', '1111', 'Nguyễn Văn Đông'));
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    case 'history':
        // Kiểm tra quyền truy cập
        if(!$role['momo']['history']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('Lịch sử giao dịch', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Lịch sử giao dịch');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Thêm tài khoản MOMO', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $account    = new MomoAccount();
        $list_phone = $account->getListPhoneByUser();
        $data       = $account->getHistoryByUser();
        $param      = get_param_defaul();

        $header['js']       = [URL_JS . "{$path[1]}/history"];
        $header['title']    = 'Lịch sử giao dịch';
        $header['toolbar']  = admin_breadcrumbs('Lịch sử giao dịch', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Lịch sử giao dịch');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        ?>
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Search Form-->
                <div class="mb-7">
                    <form action="" method="get">
                        <div class="row align-items-center">
                            <div class="col-md-2 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" value="<?=($_REQUEST['search'] ? $_REQUEST['search'] : '')?>" name="search" class="form-control" placeholder="Tìm kiếm ..." id="kt_datatable_search_query" />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                    <input type="text" value="<?=($_REQUEST['time_start'] ? $_REQUEST['time_start'] : '')?>" placeholder="Từ Ngày" class="form-control" name="time_start" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                    </div>
                                    <input type="text" value="<?=($_REQUEST['time_end'] ? $_REQUEST['time_end'] : '')?>" placeholder="Đến ngày" class="form-control" name="time_end" />
                                </div>
                            </div>
                            <div class="col-md-2 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Tài khoản:</label>
                                    <select name="history_tran_phone" class="form-control selectpicker">
                                        <option value="">Tất cả</option>
                                        <?php
                                        foreach ($list_phone AS $_list_phone){
                                            echo '<option value="'. $_list_phone .'" '. ($_REQUEST['history_tran_phone'] == $_list_phone ? 'selected' : '') .'>'. $_list_phone .'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Giao Dịch:</label>
                                    <select name="history_tran_action" class="form-control selectpicker">
                                        <option value="">Tất cả</option>
                                        <option value="send" <?=($_REQUEST['history_tran_action'] == 'send' ? 'selected' : '')?>>Chuyển TIền</option>
                                        <option value="receive" <?=($_REQUEST['history_tran_action'] == 'receive' ? 'selected' : '')?>>Nhận Tiền</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 my-2 my-md-0 text-right">
                                <button type="submit" class="btn btn-dark btn-square px-6 font-weight-bold">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Search Form-->
                <!--begin::Content-->
                <div class="card card-custom">
                    <div class="card-body p-0">
                        <table class="table table-hover table-head-custom table-row-dashed">
                            <thead>
                            <tr class="text-uppercase">
                                <th class="text-center">STT</th>
                                <th>Tài Khoản</th>
                                <th>Mã GD</th>
                                <th>Phương thức</th>
                                <th>Mã ĐT</th>
                                <th>Tên ĐT</th>
                                <th>Số tiền</th>
                                <th>Ngày GD</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=0;
                            foreach ($data['data'] AS $row){
                            $i++;
                            ?>
                            <tr>
                                <td class="text-center font-size-lg"><?=$i?></td>
                                <td class="font-size-lg"><?=$row['history_tran_phone']?></td>
                                <td class="font-size-lg"><?=$row['history_tran_id']?></td>
                                <td class="font-size-lg text-center">
                                    <?=($row['history_tran_action'] == 'send' ? '<span class="label label-danger label-square label-inline mr-2">TRỪ TIỀN</span>' : '<span class="label label-square label-success label-inline mr-2">NHẬN TIỀN</span>')?>
                                </td>
                                <td class="font-size-lg"><?=$row['history_tran_partner_id']?></td>
                                <td class="font-size-lg"><?=$row['history_tran_partner_name']?></td>
                                <td class="font-size-lg"><?=convert_number_to_money($row['history_tran_amount'])?></td>
                                <td class="font-size-lg"><?=date('H:i - d/m/Y', strtotime($row['history_tran_time']))?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr class="align-middle font-size-lg">
                                <td colspan="8">
                                    <div class="row">
                                        <div class="col-lg-6 text-left">
                                            Tổng số <strong class="text-secondary"><?=$data['paging']['count_data']?></strong> bản ghi.
                                            Trang thứ <strong class="text-secondary"><?=$param['page']?></strong> trên tổng <strong class="text-secondary"><?=$data['paging']['page']?></strong> trang.
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <?=pagination($param['page'], $data['paging']['page'], URL_ADMIN."/{$path[1]}/{$path[2]}/".buildQuery($_REQUEST, ['page' => '{page}']))?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Content-->
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    case 'api':
        $header['js']       = [URL_JS . "{$path[1]}/api"];
        $header['title']    = 'API';
        $header['toolbar']  = admin_breadcrumbs('API', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'API');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        ?>
        <div class="alert alert-custom alert-outline-danger alert-shadow fade show gutter-b" role="alert">
            <div class="alert-icon">
                <i class="flaticon-alert text-danger"></i>
            </div>
            <div class="alert-text">
                Lưu ý, mã <code>Access Token</code> của bạn rất quan trọng, nó có thể truy cập và thay đổi dữ liệu thông tin tài khoản của bạn.<br />
                Vì vậy hãy giữ bí mật và không để lộ hoặc gửi cho bất kỳ ai mã <code>Access Token</code> của bạn. Nếu bạn nghi ngờ bị lộ, hãy <a href="#">Click vào đây</a> để đổi mã <code>Access Token</code> của bạn.<br />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <p>Mã <code>Access Token</code> của bạn là</p>
                        <div id="kt_clipboard_4" class="rounded bg-gray-100 p-5"><?=$me['user_token']?></div>
                        <div class="separator separator-dashed my-5"></div>
                        <p>
                            <a href="#" class="btn btn-primary" data-clipboard="true" data-clipboard-target="#kt_clipboard_4">
                                <i class="la la-cut"></i> Copy mã Access Token
                            </a>
                        </p>
                    </div>
                </div>

                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title"><h3 class="card-label">Các API MOMO <small>Các API Momo của bạn</small></h3></div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-secondary" role="alert">
                            <span class="label label-info label-inline mr-2">URL</span> <span class="font-italic"><?=URL_API."{$path[1]}"?></span>
                        </div>
                        <br />
                        <h4>Xem thông tin tài khoản</h4>
                        <div class="alert alert-secondary" role="alert">
                            <span class="label label-success label-inline mr-2">GET</span> <span class="font-italic">/info/<span class="font-weight-bold">{phone_number}</span></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-hover table-head-custom table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 30%">Trường thông tin</th>
                                        <th class="text-center">Mô tả</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">{phone_number} <small class="text-danger">(required)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là <code>số điện thoại MOMO</code> của bạn cần làm mới hoặc lấy số dư.<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">access_token <small class="text-danger">(required)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là mã <code>Access Token</code> của bạn. Xem trong thông tin cá nhân hoặc ở trên. <br />
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <div class="example">
                                    <div class="example-code">
                                        <span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
                                        <div class="example-highlight">
                                            <pre class=" language-html">
                                                <code class="language-html">
                                                {
                                                    "response": 200,
                                                    "message": "Success",
                                                    "data": {
                                                        "phone": "09888888888",
                                                        "balance": "9999999",
                                                        "status": "active",
                                                        "last_update": "2021-08-31 15:21:39"
                                                    }
                                                }
                                                </code>
                                            </pre>
                                        </div>
                                    </div>
                                    <p>Response <code>JSON</code> mã trạng thái và thông tin số dư tài khoản</p>
                                    <p class="font-italic">Mã <code>response</code> là <code>200</code> là tài khoản đang bình thường, các lỗi khác xem chi tiết tại trường <code>message</code></p>
                                </div>
                            </div>
                        </div><br />

                        <h4>Lấy danh sách lịch sử giao dịch</h4>
                        <div class="alert alert-secondary" role="alert">
                            <span class="label label-success label-inline mr-2">GET</span> <span class="font-italic">/history/<span class="font-weight-bold">{phone_number}</span></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-hover table-head-custom table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 30%">Trường thông tin</th>
                                        <th class="text-center">Mô tả</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">{phone_number} <small class="text-danger">(required)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là <code>số điện thoại MOMO</code> của bạn cần lấy số dư.<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">access_token <small class="text-danger">(required)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là mã <code>Access Token</code> của bạn. Xem trong thông tin cá nhân hoặc ở trên. <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">limit <small class="text-secondary">(optional)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là <code>số bản ghi</code> cần lấy lịch sử giao dịch. Nếu không có, mặc định số bản ghi là <span class="text-danger">50</span>. <br />
                                            <small class="text-danger font-italic">Số bản ghi lấy từ 1 đến 1000 bản ghi</small>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <div class="example">
                                    <p>Response <code>JSON</code> mã trạng thái và thông tin số dư tài khoản</p>
                                    <div class="example-code">
                                        <span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
                                        <div class="example-highlight">
                                            <pre class=" language-html">
                                                <code class="language-html">
                                                {
                                                    "response": 200,
                                                    "message": "Success",
                                                    "phone": "0962778307",
                                                    "limit": 50,
                                                    "count": 5,
                                                    "data": [
                                                        {
                                                        ...
                                                        }
                                                    ]
                                                }
                                                </code>
                                            </pre>
                                        </div>
                                    </div>
                                    <p class="font-italic">Mã <code>response</code> là <code>200</code> là tài khoản đang bình thường, các lỗi khác xem chi tiết tại trường <code>message</code></p>
                                </div>
                            </div>
                        </div><br />

                        <h4>Đồng bộ dữ liệu giữa MoMo và hệ thống</h4>
                        <div class="alert alert-secondary" role="alert">
                            <span class="label label-success label-inline mr-2">GET</span> <span class="font-italic">/cronjob/<span class="font-weight-bold">{phone_number}</span></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-hover table-head-custom table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 30%">Trường thông tin</th>
                                        <th class="text-center">Mô tả</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">{phone_number} <small class="text-danger">(required)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là <code>số điện thoại MOMO</code> của bạn cần đồng bộ.<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">access_token <small class="text-danger">(required)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là mã <code>Access Token</code> của bạn. Xem trong thông tin cá nhân hoặc ở trên. <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-size-lg font-italic text-center font-weight-bold">day <small class="text-secondary">(optional)</small></td>
                                        <td class="font-size-lg text-left">
                                            Là <code>ngày cần đồng bộ</code> giao dịch. Nếu không có, mặc định số ngày là <span class="text-danger">5</span>. <br />
                                            <small class="text-danger font-italic">Số ngày cần lấy từ 1 đến 5 ngày</small>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <div class="example">
                                    <p>Response <code>JSON</code> mã trạng thái và thông tin số dư tài khoản</p>
                                    <div class="example-code">
                                        <span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
                                        <div class="example-highlight">
                                            <pre class=" language-html">
                                                <code class="language-html">
                                                {
                                                    "response": 200,
                                                    "message": "Đồng bộ dữ liệu thành công"
                                                }
                                                </code>
                                            </pre>
                                        </div>
                                    </div>
                                    <p class="font-italic">Mã <code>response</code> là <code>200</code> là tài khoản đang bình thường, các lỗi khác xem chi tiết tại trường <code>message</code></p>
                                </div>
                            </div>
                        </div><br />
                    </div>
                </div>
            </div>
            <div class="col-lg-12">

            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    case 'add':
        // Kiểm tra quyền truy cập
        if(!$role['momo']['add']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Thêm tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Thêm tài khoản MOMO', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }

        $header['js']       = [URL_JS . "{$path[1]}/add"];
        $header['title']    = 'Thêm tài khoản MOMO';
        $header['toolbar']  = admin_breadcrumbs('THÊM', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Thêm tài khoản');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <?=formOpen('', ['method' => 'POST'])?>
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title"><h3 class="card-label">Thêm tài khoản</h3></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?=formInputText('account_phone', [
                                    'label' => 'Nhập số điên thoại <span class="text-danger">*</span>',
                                    'note'  => 'Nhập chính xác số điện thoại sử dụng MoMo',
                                    'autocomplete'  => 'new-password',
                                    'maxlength' => 10
                                ])?>
                            </div>
                            <div class="col-lg-12" style="display: none" id="input_otp">
                                <?=formInputText('account_otp', [
                                    'label' => 'Nhập mã OTP <span class="text-danger">*</span>',
                                    'note'  => 'Nhập chính xác mã OTP bạn vừa nhận được.',
                                    'autocomplete'  => 'new-password',
                                    'maxlength' => 4
                                ])?>
                                <?=formInputPassword('account_password', [
                                    'label' => 'Nhập mật khẩu <span class="text-danger">*</span>',
                                    'note'  => 'Nhập mật khẩu tài khoản MOMO',
                                    'autocomplete'  => 'new-password',
                                    'maxlength' => 6
                                ])?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <?=formButton('Lấy mã OTP', [
                            'id'    => 'button_get_otp',
                            'class' => 'btn btn-dark btn-square'
                        ])?>
                        <span style="display: none" id="input_button_save">
                            <?=formButton('Lưu Tài Khoản', [
                                'id'    => 'button_save_account',
                                'class' => 'btn btn-dark btn-square'
                            ])?>
                        </span>
                    </div>
                </div>
                <?=formClose()?>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        // Kiểm tra quyền truy cập
        if(!$role['momo']['manager']){
            $header['title']    = 'Lỗi quyền truy cập';
            $header['toolbar']  = admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Danh sách tài khoản');
            require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
            echo admin_error('Danh sách tài khoản MOMO', 'Bạn không có quyền truy cập, vui lòng quay lại hoặc liên hệ quản trị viên.');
            require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
            exit();
        }
        $account            = new MomoAccount();
        $list_account       = $account->getListAccount();

        $header['js']       = [URL_JS . "{$path[1]}"];
        $header['title']    = 'Danh sách tài khoản';
        $header['toolbar']  = admin_breadcrumbs('MOMO', [URL_ADMIN . "/{$path[1]}/" => 'MOMO'],'Danh sách tài khoản', '<a href="'. URL_ADMIN .'/'. $path[1] .'/add" class="btn btn-success font-weight-bold btn-square btn-sm">THÊM MỚI</a>');
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        ?>
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Search Form-->
                <div class="mb-7">
                    <form action="" method="get">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" value="<?=($_REQUEST['search'] ? $_REQUEST['search'] : '')?>" name="search" class="form-control" placeholder="Tìm kiếm ..." id="kt_datatable_search_query" />
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Trạng thái:</label>
                                            <select name="account_status" class="form-control selectpicker">
                                                <option value="">Tất cả</option>
                                                <option value="active" <?=($_REQUEST['account_status'] == 'active' ? 'selected' : '')?>>Hoạt động</option>
                                                <option value="inactive" <?=($_REQUEST['account_status'] == 'inactive' ? 'selected' : '')?>>Không hoạt động</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Tìm Kiếm</button>
                                        <a class="btn btn-light-danger px-6 font-weight-bold" href="<?=URL_ADMIN.'/'.$path[1]?>">Reset</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">

                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Search Form-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Danh sách tài khoản</h3>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php
                    if(!$list_account){
                        echo '<p class="text-center">Chưa có tài khoản liên kết nào, <a href="'. URL_ADMIN .'/'. $path[1] .'/add">Click vào đây</a> để thêm tài khoản momo mới</p>';
                    }else{
                    ?>
                        <table class="table table-hover table-head-custom table-row-dashed">
                            <thead>
                            <tr class="text-uppercase">
                                <th style="width: 5%">STT</th>
                                <th style="width: 15%" class="text-left">Điện thoại</th>
                                <th style="width: 15%" class="text-left">Tên</th>
                                <th style="width: 10%" class="text-center">Số dư</th>
                                <th style="width: 15%" class="text-center">Trạng thái</th>
                                <th style="width: 15%" class="text-center">Giờ Update</th>
                                <th style="width: 15%" class="text-center">Tạo lúc</th>
                                <th style="width: 10%" class="text-center">Quản lý</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach ($list_account AS $row){ $i++;?>
                            <tr>
                                <td class="text-center align-middle font-size-lg"><?=$i?></td>
                                <td class="text-left align-middle font-size-lg font-weight-bold"><?=$row['account_phone']?></td>
                                <td class="text-left align-middle font-size-lg"><?=$row['account_name'] ? $row['account_name'] : '---'?></td>
                                <td class="text-center align-middle font-size-lg"><?=convert_number_to_money($row['account_balance'])?></td>
                                <td class="text-center align-middle font-size-lg"><?=$account->viewStatus($row['account_status'])?></td>
                                <td class="text-center align-middle font-size-lg"><?=human_time_diff(strtotime($row['account_last_update']), time())?></td>
                                <td class="text-center align-middle font-size-lg"><?=view_date_time($row['account_create'])?></td>
                                <td class="text-center align-middle font-size-lg">
                                    <a href="javascript:;" data-type="delete" data-id="<?=$row['account_id']?>">
                                        <i class="text-danger flaticon-delete"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}