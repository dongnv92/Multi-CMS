<?php
switch ($path[2]){
    case 'add':
        $user = new user($database);
        $user_dieuphoi = $user->get_all_user_by_role(2);
        $option_dieuphoi = [];
        foreach ($user_dieuphoi AS $_user_dieuphoi){
            $option_dieuphoi[$_user_dieuphoi['user_id']] = $_user_dieuphoi['user_name'];
        }
        $header['js']       = [
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title'] = 'Thêm dữ liệu';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Thêm dữ liệu bốc xếp', 'Test','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'excel']);
        ?>
        <div class="nk-block nk-block-lg">
            <div class="card card-bordered">
                <div class="card-header border-bottom">Thêm dữ liệu bốc xếp hằng ngày</div>
                <div class="card-inner">
                    <?=formOpen('POST', ['id' => 'form_add_pickup'])?>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <?=formInputText('pickup_date_move', [
                                'label' => 'Ngày tháng (VD: 31/12/2021) <code>*</code>',
                                'value' => date('d/m/Y', time()),
                                'icon'  => '<em class="icon ni ni-calendar-alt"></em>',
                                'class' => 'form-control form-control-outlined date-picker',
                                'data-date-format' => 'dd/mm/yyyy'
                            ])?>
                        </div>
                        <div class="col-lg-4">
                            <?=formInputText('pickup_big_car', [
                                'label' => 'Biển số xe lớn (VD: 29H12345) <code>*</code>',
                                'value' => '',
                                'icon'  => '<em class="icon ni ni-list-thumb-alt"></em>'
                            ])?>
                        </div>
                        <div class="col-lg-4">
                            <?=formInputText('pickup_weight', [
                                'label' => 'Trọng lượng hàng (tấn. VD 12.5) <code>*</code>',
                                'value' => '',
                                'icon'  => '<em class="icon ni ni-shrink"></em>'
                            ])?>
                        </div>
                        <div class="col-lg-4">
                            <?=formInputSelect('pickup_user_receive', $option_dieuphoi, [
                                'label' => ''
                            ])?>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="form-group">
                                <ul class="custom-control-group g-3 align-center">
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="yes" class="custom-control-input" id="com-email-1" name="pickup_down">
                                            <label class="custom-control-label" for="com-email-1">Xuống Hàng</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="yes" class="custom-control-input" id="com-sms-1" name="pickup_up">
                                            <label class="custom-control-label" for="com-sms-1">Lên Hàng</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <?=formInputText('pickup_note', [
                                'label' => 'Ghi chú',
                                'value' => '',
                                'icon'  => '<em class="icon ni ni-edit-alt"></em>'
                            ])?>
                        </div>
                        <div class="col-lg-12 text-right">
                            <div class="form-group">
                                <?=formButton('THÊM MỚI', [
                                    'id'    => 'button_add_pickup',
                                    'class' => 'btn btn-secondary'
                                ])?>
                            </div>
                        </div>
                        <?=formClose()?>
                    </div>
                </div>
                </div>
            </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        $header['js']       = [
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title'] = 'Thêm dữ liệu';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Excel', 'Test','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'excel']);
        ?>
        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner position-relative card-tools-toggle">
                        <div class="card-title-group">
                            <div class="card-tools">
                                <div class="form-inline flex-nowrap gx-3">
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
                        </div><!-- .card-title-group -->
                        <div class="card-search search-wrap" data-search="search">
                            <div class="card-body">
                                <div class="search-content">
                                    <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                    <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search by user or email">
                                    <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                </div>
                            </div>
                        </div><!-- .card-search -->
                    </div><!-- .card-inner -->
                    <div class="card-inner p-0">
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">User</span></div>
                                <div class="nk-tb-col tb-col-mb"><span class="sub-text">Balance</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Phone</span></div>
                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">Verified</span></div>
                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col nk-tb-col-tools text-right">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                        <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                            <ul class="link-tidy sm no-bdr">
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked="" id="bl">
                                                        <label class="custom-control-label" for="bl">Balance</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked="" id="ph">
                                                        <label class="custom-control-label" for="ph">Phone</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="vri">
                                                        <label class="custom-control-label" for="vri">Verified</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="st">
                                                        <label class="custom-control-label" for="st">Status</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-tb-item -->
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <a href="html/user-details-regular.html">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary">
                                                <span>AB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead">Abu Bin Ishtiyak <span class="dot dot-success d-md-none ml-1"></span></span>
                                                <span>info@softnio.com</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-tb-col tb-col-mb">
                                    <span class="tb-amount">35,040.34 <span class="currency">USD</span></span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span>+811 847-4958</span>
                                </div>
                                <div class="nk-tb-col tb-col-lg">
                                    <ul class="list-status">
                                        <li><em class="icon text-success ni ni-check-circle"></em> <span>Email</span></li>
                                        <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li>
                                    </ul>
                                </div>
                                <div class="nk-tb-col tb-col-lg">
                                    <span>10 Feb 2020</span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-status text-success">Active</span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li class="nk-tb-action-hidden">
                                            <a href="#" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Wallet">
                                                <em class="icon ni ni-wallet-fill"></em>
                                            </a>
                                        </li>
                                        <li class="nk-tb-action-hidden">
                                            <a href="#" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Send Email">
                                                <em class="icon ni ni-mail-fill"></em>
                                            </a>
                                        </li>
                                        <li class="nk-tb-action-hidden">
                                            <a href="#" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Suspend">
                                                <em class="icon ni ni-user-cross-fill"></em>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-repeat"></em><span>Transaction</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- .nk-tb-item -->
                        </div><!-- .nk-tb-list -->
                    </div><!-- .card-inner -->
                    <div class="card-inner">
                        <div class="nk-block-between-md g-3">
                            <div class="g">
                                <ul class="pagination justify-content-center justify-content-md-start">
                                    <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul><!-- .pagination -->
                            </div>
                            <div class="g">
                                <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                    <div>Page</div>
                                    <div>
                                        <select class="form-select form-select-sm" data-search="on" data-dropdown="xs center">
                                            <option value="page-1">1</option>
                                            <option value="page-2">2</option>
                                            <option value="page-4">4</option>
                                            <option value="page-5">5</option>
                                            <option value="page-6">6</option>
                                            <option value="page-7">7</option>
                                            <option value="page-8">8</option>
                                            <option value="page-9">9</option>
                                            <option value="page-10">10</option>
                                            <option value="page-11">11</option>
                                            <option value="page-12">12</option>
                                            <option value="page-13">13</option>
                                            <option value="page-14">14</option>
                                            <option value="page-15">15</option>
                                            <option value="page-16">16</option>
                                            <option value="page-17">17</option>
                                            <option value="page-18">18</option>
                                            <option value="page-19">19</option>
                                            <option value="page-20">20</option>
                                        </select>
                                    </div>
                                    <div>OF 102</div>
                                </div>
                            </div><!-- .pagination-goto -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .card-inner -->
                </div><!-- .card-inner-group -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}