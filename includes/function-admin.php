<?php

function admin_breadcrumbs($title, $title_des = '', $title_active = '', $list_url = ''){
    $li = '';
    if(is_array($list_url)){
        foreach ($list_url AS $key => $value){
            $li .= '<li class="breadcrumb-item"><a href="'. $key .'">'. $value .'</a></li>';
        }
    }
    $text = "<div class=\"block-header\">
        <div class=\"row\">
            <div class=\"col-lg-7 col-md-6 col-sm-12\">
                <h2>$title
                ". ($title_des ? '<small class="text-muted">'. $title_des .'</small>' : '') ."
                </h2>
            </div>
            <div class=\"col-lg-5 col-md-6 col-sm-12\">
                <ul class=\"breadcrumb float-md-right\">
                    <li class=\"breadcrumb-item\"><a href=\"". URL_HOME ."\"><i class=\"zmdi zmdi-home\"></i> Trang chủ</a></li>
                    $li
                    <li class=\"breadcrumb-item active\">$title_active</li>
                </ul>
            </div>
        </div>
    </div>";
    return $text;
}

// Hiển thị hiệu ứng đang tải khi đang tải trang
function admin_page_loader_start(){
    return '<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <p>Vui lòng chờ ...</p>
        <div class="m-t-30"><img src="<?=URL_ADMIN?>/assets/images/logo.png" width="48" height="48" alt="Logo"></div>
    </div>
</div>';
}

// Hiển thị thanh tìm kiếm trên Header
function admin_header_search_bar(){
    return '<!-- Overlay For Sidebars -->
<div class="overlay"></div><!-- Search  -->
<div class="search-bar">
    <div class="search-icon"> <i class="material-icons">search</i> </div>
    <input type="text" placeholder="Tìm kiếm ...">
    <div class="close-search"> <i class="material-icons">close</i> </div>
</div>';
}

// Hiển thị thanh Topbar
function admin_top_bar(){
    return '<nav class="navbar">
    <div class="col-12">
        <div class="navbar-header text-center">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="#">..:: MULTICMS ::..</a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>
            <li><a href="#" class="inbox-btn hidden-sm-down" data-close="true"><i class="material-icons">settings</i></a></li>
            <li><a href="#" class="inbox-btn hidden-sm-down" data-close="true"><i class="zmdi zmdi-mail-send"></i></a></li>
            <li><a href="#" class="inbox-btn hidden-sm-down" data-close="true"><i class="zmdi zmdi-trending-up"></i></a></li>
            <li class="dropdown menu-app hidden-sm-down"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"> <i class="zmdi zmdi-apps"></i> </a>
                <ul class="dropdown-menu slideDown">
                    <li class="body">
                        <ul class="menu">
                            <li><a href="#"><i class="zmdi zmdi-receipt"></i><span>Giao dịch</span></a></li>
                            <li><a href="#"><i class="zmdi zmdi-accounts-list"></i><span>Danh bạ</span></a></li>
                            <li><a href="#"><i class="zmdi zmdi-comment-outline"></i><span>Tin Nhắn</span></a></li>
                            <li><a href="#"?>"><i class="zmdi zmdi-trending-up"></i><span>Thống Kê</span></a></li>
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
</nav>';
}