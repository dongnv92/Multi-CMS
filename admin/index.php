<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';

if(!$me){
    redirect(URL_LOGIN);
}

switch ($path[1]){
    case 'blog':
    case 'user':
    case 'profile':
    case 'elements':
    case 'plugin':
    case 'test':
        require_once "{$path[1]}.php";
        break;
    default:
        if(in_array($path[1], get_list_plugin())){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . $path[1] . '/config.json');
            $config = json_decode($config, true);
            if($config['status'] != 'active'){
                $header['title'] = "Plugin {$config['name']} chưa được kích hoạt";
                require_once 'admin-header.php';
                    echo admin_breadcrumbs('PLUGIN', $config['name'],$config['name'], [URL_ADMIN . '/plugin/' => 'Plugin']);
                    echo admin_error($config['name'], "Plugin <strong>{$config['name']}</strong> chưa được kích hoạt hoặc không có trên hệ thống.");
                require_once 'admin-footer.php';
            }
            require_once (ABSPATH . PATH_PLUGIN . $path[1] . '/index.php');
        }else{
            $header['title'] = 'Trang quản trị';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Trang Chủ', [URL_ADMIN => 'Trang test'], 'Đang ở đây');
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
                                    <th class="tb-tnx-id"><span class="">#</span></th>
                                    <th class="tb-tnx-info">
                                            <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                <span>Bill For</span>
                                            </span>
                                        <span class="tb-tnx-date d-md-inline-block d-none">
                                                <span class="d-md-none">Date</span>
                                                <span class="d-none d-md-block">
                                                    <span>Issue Date</span>
                                                    <span>Due Date</span>
                                                </span>
                                            </span>
                                    </th>
                                    <th class="tb-tnx-amount is-alt">
                                        <span class="tb-tnx-total">Total</span>
                                        <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                    </th>
                                    <th class="tb-tnx-action">
                                        <span>&nbsp;</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <a href="#"><span>4947</span></a>
                                    </td>
                                    <td class="tb-tnx-info">
                                        <div class="tb-tnx-desc">
                                            <span class="title">Enterprize Year Subscrition</span>
                                        </div>
                                        <div class="tb-tnx-date">
                                            <span class="date">10-05-2019</span>
                                            <span class="date">10-13-2019</span>
                                        </div>
                                    </td>
                                    <td class="tb-tnx-amount is-alt">
                                        <div class="tb-tnx-total">
                                            <span class="amount">$599.00</span>
                                        </div>
                                        <div class="tb-tnx-status">
                                            <span class="badge badge-dot badge-warning">Due</span>
                                        </div>
                                    </td>
                                    <td class="tb-tnx-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#">View</a></li>
                                                    <li><a href="#">Edit</a></li>
                                                    <li><a href="#">Remove</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
            <?php
            require_once 'admin-footer.php';
        }
        break;
}