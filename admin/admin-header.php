<?php
$header = $header ? $header : ['title' => 'Trang quản trị'];
?>
<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="SMS OTP.">
    <title><?=$header['title']?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?=URL_ADMIN?>/assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=URL_ADMIN?>/assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?=URL_ADMIN?>/assets/css/main.css">
    <link rel="stylesheet" href="<?=URL_ADMIN?>/assets/css/color_skins.css">
    <?php foreach ($header['css'] AS $css){echo '<link rel="stylesheet" href="'. $css .'">'."\n";}?>
</head>
<body class="theme-blush">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <p>Vui lòng chờ ...</p>
        <div class="m-t-30"><img src="<?=URL_ADMIN?>/assets/images/logo.png" width="48" height="48" alt="Logo"></div>
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay"></div><!-- Search  -->
<div class="search-bar">
    <div class="search-icon"> <i class="material-icons">search</i> </div>
    <input type="text" placeholder="Tìm kiếm ...">
    <div class="close-search"> <i class="material-icons">close</i> </div>
</div>
<!-- Top Bar -->
<nav class="navbar">
    <div class="col-12">
        <div class="navbar-header text-center">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?=URL_ADMIN?>">..:: MULTICMS ::..</a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>
            <li><a href="<?=URL_ADMIN."/settings/"?>" class="inbox-btn hidden-sm-down" data-close="true"><i class="material-icons">settings</i></a></li>
            <li><a href="<?=URL_ADMIN."/sms/?act=add"?>" class="inbox-btn hidden-sm-down" data-close="true"><i class="zmdi zmdi-mail-send"></i></a></li>
            <li><a href="<?=URL_ADMIN."/?act=statics"?>" class="inbox-btn hidden-sm-down" data-close="true"><i class="zmdi zmdi-trending-up"></i></a></li>
            <li class="dropdown menu-app hidden-sm-down"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"> <i class="zmdi zmdi-apps"></i> </a>
                <ul class="dropdown-menu slideDown">
                    <li class="body">
                        <ul class="menu">
                            <li><a href="<?=$router['transaction']?>"><i class="zmdi zmdi-receipt"></i><span>Giao dịch</span></a></li>
                            <li><a href="<?=$router['contacts']?>"><i class="zmdi zmdi-accounts-list"></i><span>Danh bạ</span></a></li>
                            <li><a href="<?=$router['sms']?>"><i class="zmdi zmdi-comment-outline"></i><span>Tin Nhắn</span></a></li>
                            <li><a href="<?=URL_ADMIN."/?act=statics"?>"><i class="zmdi zmdi-trending-up"></i><span>Thống Kê</span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>Tài Khoản <span class="font-bold text-danger">N-A</span></li>
            <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="zmdi zmdi-search"></i></a></li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                    <i class="zmdi zmdi-notifications"></i><div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                </a>
                <ul class="dropdown-menu slideDown">
                    <li class="header">THÔNG BÁO</li>
                    <li class="body">
                        <ul class="menu list-unstyled">
                            <li>
                                <a href="#">
                                    <div class="icon-circle l-blue"> <i class="material-icons">search</i> </div>
                                    <div class="menu-info">
                                        <h4 class="font-bold">Nội dung thông báo</h4>
                                        <p> <i class="material-icons">access_time</i> Thời gian </p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"> <a href="#">Xem tất cả thông báo</a> </li>
                </ul>
            </li>
            <li><a href="#" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
        </ul>
    </div>
</nav>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="<?=URL_ADMIN."/assets/images/avatar/1.png"?>" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown">Nguyễn Văn Đông</div>
            <?=$user['user_phone']?>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header text-center">QUẢN LÝ NỘI DUNG</li>
            <li <?=$router['path_end'] == 'administrator' && !$act ? 'class="active"' : ''?>><a href="<?=_URL_CPANEL?>"><i class="zmdi zmdi-home"></i> <span>Trang Quản Trị</span></a></li>
            <!-- Quản trị -->
            <?php if(in_array(true, [$role['controls']['controls_payment'], $role['controls']['controls_add_notice'], $role['controls']['controls_sms_manager']])){ ?>
                <li <?=$router['path_end'] == 'control' ? 'class="open active"' : ''?>>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-widgets"></i><span>Quản Trị Viên</span></a>
                    <ul class="ml-menu">
                        <!-- Quản lý SMS -->
                        <?php if($role['controls']['controls_sms_manager']){?>
                            <li <?=$router['path_end'] == 'control' && $act == 'sms_manager' ? 'class="active"' : ''?>>
                                <a href="<?=$router['controls']."?act=sms_manager"?>">Quản Lý Tin Nhắn</a>
                            </li>
                        <?php }?>
                        <!-- Quản lý thiết bị -->
                        <?php if($role['controls']['controls_device_manager']){?>
                            <li <?=$router['path_end'] == 'control' && $act == 'device_manager' ? 'class="active"' : ''?>>
                                <a href="<?=$router['controls']."?act=device_manager"?>">Quản Lý Thiết Bị</a>
                            </li>
                        <?php }?>
                        <!-- Thêm Thanh Toán -->
                        <?php if($role['controls']['controls_payment']){?>
                            <li <?=$router['path_end'] == 'control' && $act == 'payment' ? 'class="active"' : ''?>>
                                <a href="<?=$router['controls']."?act=payment"?>">Thêm Thanh Toán</a>
                            </li>
                        <?php }?>
                        <!-- Thêm thông báo -->
                        <?php if($role['controls']['controls_add_notice']){?>
                            <li <?=$router['path_end'] == 'control' && $act == 'add_notice' ? 'class="active"' : ''?>>
                                <a href="<?=$router['controls']."?act=add_notice"?>">Thêm Thông Báo</a>
                            </li>
                        <?php }?>
                    </ul>
                </li>
            <?php }?>
            <!-- Quản lý thành viên -->
            <?php if(in_array(true, [$role['user']['user_manager'], $role['user']['user_add'], $role['user']['user_update']])){ ?>
                <li <?=(($router['path_end'] == 'user' && in_array($act, ['', 'add', 'update','profile','custom_price'])) || ($router['path_end'] == 'meta' && in_array($act, ['user_role']))) ? 'class="active open"' : ''?>>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-circle"></i> <span>Thành Viên</span></a>
                    <ul class="ml-menu">
                        <!-- Quản lý thành viên -->
                        <?php if($role['user']['user_manager']){?><li <?=($router['path_end'] == 'user' && in_array($act, ['', 'update', 'profile', 'custom_price'])) ? 'class="active"' : ''?>><a href="<?=$router['user']?>">Quản Lý Thành Viên</a></li><?php }?>
                        <!-- Thêm thành viên -->
                        <?php if($role['user']['user_add']){?><li <?=($router['path_end'] == 'user' && in_array($act, ['add'])) ? 'class="active"' : ''?>><a href="<?=$router['user']."?act=add"?>">Thêm Thành Viên</a></a></li><?php }?>
                        <!-- Quản lý vai trò thành viên -->
                        <?php if($role['settings']['settings_user_role']){?><li <?=($router['path_end'] == 'meta' && in_array($act, ['user_role'])) ? 'class="active"' : ''?>><a href="<?=$router['meta']."?act=user_role"?>">Vai Trò Thành Viên</a></li><?php }?>
                    </ul>
                </li>
            <?php }?>
            <!-- Cài đặt -->
            <li <?=(($router['path_end'] == 'settings' && in_array($act, ['account', 'change_password', 'token', 'role'])) || ($router['path_end'] == 'meta' && in_array($act, ['role', 'payment_method']))) ? 'class="active open"' : ''?>>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-settings"></i><span>Cài Đặt</span></a>
                <ul class="ml-menu">
                    <!-- Đổi thông tin cá nhân -->
                    <li <?=($router['path_end'] == 'settings' && in_array($act, ['account'])) ? 'class="active"' : ''?>><a href="<?=$router['settings']."?act=account"?>">Sửa Thông Tin</a></li>
                    <!-- Đổi mật khẩu -->
                    <li <?=($router['path_end'] == 'settings' && in_array($act, ['change_password'])) ? 'class="active"' : ''?>><a href="<?=$router['settings']."?act=change_password"?>">Đổi Mật Khẩu</a></li>
                    <!-- Đổi mật khẩu -->
                    <li <?=($router['path_end'] == 'settings' && in_array($act, ['token'])) ? 'class="active"' : ''?>><a href="<?=$router['settings']."?act=token"?>">Quản lý Access Token</a></li>
                    <!-- Phân quyền vai trò -->
                    <?php if($role['settings']['settings_role']){?><li <?=($router['path_end'] == 'meta' && in_array($act, ['role'])) ? 'class="active"' : ''?>><a href="<?=$router['meta']."?act=role"?>">Mã Phân Quyền</a></li><?php }?>
                    <!-- Thay đổi phân quyền -->
                    <?php if($role['settings']['settings_change_role']){?><li <?=($router['path_end'] == 'settings' && in_array($act, ['role'])) ? 'class="active"' : ''?>><a href="<?=$router['settings']."?act=role"?>">Phân Quyền Vai Trò</a></li><?php }?>
                    <!-- Thay đổi phân quyền -->
                    <?php if($role['settings']['settings_payment_method']){?><li <?=($router['path_end'] == 'meta' && in_array($act, ['payment_method'])) ? 'class="active"' : ''?>><a href="<?=$router['meta']."?act=payment_method"?>">Phương Thức Thanh Toán</a></li><?php }?>
                </ul>
            </li>
            <?php if(in_array(true, [$role['device']['device_manager']])){ ?>
                <!-- Quản lý thiết bị -->
                <li <?=($router['path_end'] == 'device') ? 'class="active open"' : ''?>>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-devices"></i><span>Thiết bị</span></a>
                    <ul class="ml-menu">
                        <!-- Danh sách thiết bị -->
                        <li <?=($router['path_end'] == 'device' && in_array($act, [''])) ? 'class="active"' : ''?>><a href="<?=$router['device']?>">Danh Sách Thiết Bị</a></li>
                        <!-- Thêm thiết bị -->
                        <li <?=($router['path_end'] == 'device' && in_array($act, ['add'])) ? 'class="active"' : ''?>><a href="<?=$router['device']."?act=add"?>">Thêm Thiết Bị</a></li>
                    </ul>
                </li>
            <?php }?>
            <li <?=($router['path_end'] == 'sms' || ($router['path_end'] == 'meta' && in_array($act, ['phone_network', 'sms_prioritize']))) ? 'class="active open"' : ''?>>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-comment-outline"></i><span>Tin Nhắn</span></a>
                <ul class="ml-menu">
                    <!-- Lịch sử tin nhắn -->
                    <li <?=($router['path_end'] == 'sms' && in_array($act, [''])) ? 'class="active"' : ''?>>
                        <a href="<?=$router['sms']?>">Lịch sử tin nhắn</a>
                    </li>
                    <!-- Thêm Tin Nhắn -->
                    <li <?=$router['path_end'] == 'sms' && in_array($act, ['add']) ? 'class="active open"' : ''?>><a href="javascript:void(0);" class="menu-toggle"> <span>Thêm Tin Nhắn</span> </a>
                        <ul class="ml-menu">
                            <li <?=$router['path_end'] == 'sms' && in_array($act, ['add']) && !$type ? 'class="active"' : ''?>>
                                <a href="<?=$router['sms']."?act=add"?>"> <span>Gửi Tin Nhắn Thường</span> </a>
                            </li>
                            <li <?=$router['path_end'] == 'sms' && in_array($act, ['add']) && in_array($type, ['contacts']) ? 'class="active"' : ''?>>
                                <a href="<?=$router['sms']."?act=add&type=contacts"?>"> <span>Gửi Đến Danh Bạ</span> </a>
                            </li>
                            <li <?=$router['path_end'] == 'sms' && in_array($act, ['add']) && in_array($type, ['group']) ? 'class="active"' : ''?>>
                                <a href="<?=$router['sms']."?act=add&type=group"?>"> <span>Gửi Đến Nhóm</span> </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Quản lý nhà mạng -->
                    <?php if($role['settings']['settings_phone_netwrok']){?>
                        <li <?=($router['path_end'] == 'meta' && in_array($act, ['phone_network'])) ? 'class="active"' : ''?>>
                            <a href="<?=$router['meta']."?act=phone_network"?>">Quản Lý Nhà Mạng</a>
                        </li>
                    <?php }?>
                    <!-- Quản lý tin nhắn ưu tiên -->
                    <?php if($role['settings']['settings_sms_prioritize']){?>
                        <li <?=($router['path_end'] == 'meta' && in_array($act, ['sms_prioritize'])) ? 'class="active"' : ''?>>
                            <a href="<?=$router['meta']."?act=sms_prioritize"?>">Quản Lý Tin Nhắn Ưu Tiên</a>
                        </li>
                    <?php }?>
                </ul>
            </li>
            <!-- Danh bạ -->
            <li <?=($router['path_end'] == 'contacts' || ($router['path_end'] == 'meta' && in_array($act, ['contacts_group']))) ? 'class="active open"' : ''?>>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-book"></i><span>Danh Bạ</span></a>
                <ul class="ml-menu">
                    <!-- Quản lý danh bạ -->
                    <li <?=($router['path_end'] == 'contacts' && in_array($act, ['', 'update'])) ? 'class="active"' : ''?>><a href="<?=$router['contacts']?>">Quản Lý Danh Bạ</a></li>
                    <!-- Nhóm danh bạ -->
                    <li <?=($router['path_end'] == 'contacts' && in_array($act, ['add'])) ? 'class="active"' : ''?>><a href="<?=$router['contacts']."?act=add"?>">Thêm Danh Bạ</a></li>
                    <!-- Nhóm danh bạ -->
                    <li <?=($router['path_end'] == 'meta' && in_array($act, ['contacts_group'])) ? 'class="active"' : ''?>><a href="<?=$router['meta']."?act=contacts_group"?>">Nhóm Danh Bạ</a></li>
                </ul>
            </li>
            <!-- Giao dịch -->
            <li <?=$router['path_end'] == 'transaction' ? 'class="active"' : ''?>><a href="<?=$router['transaction']?>"><i class="zmdi zmdi-receipt"></i><span>Giao Dịch</span></a></li>
            <li <?=$router['path_end'] == 'administrator' && $act == 'statics' ? 'class="active"' : ''?>><a href="<?=_URL_CPANEL."/?act=statics"?>"><i class="zmdi zmdi-trending-up"></i><span>Thống Kê</span></a></li>
            <li><a href="<?=URL_ADMIN."/elements.php"?>"><i class="zmdi zmdi-power col-red"></i><span>Phần tử</span></a></li>
            <li><a href="<?=_URL_LOGOUT?>"><i class="zmdi zmdi-power col-red"></i><span>Đăng Xuất</span></a></li>
        </ul>
    </div>
    <!-- #Menu -->
</aside>
<!-- Main Content -->
<section class="content home">
    <?=$header['breadcrumbs']?$header['breadcrumbs']:''?>
    <div class="container-fluid">