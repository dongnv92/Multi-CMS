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

function admin_left_side_bar(){
    global $me;
    $menu = get_menu_header_structure();
    $text = '<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image"><img src="'. URL_ADMIN . '/assets/images/avatar/1.png" width="48" height="48" alt="User" /></div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown">'. $me['user_name'] .'</div>
            '. ($me['user_phone'] ? $me['user_phone'] : 'No Info') .'
        </div>
    </div>';
    $text .= get_menu_header($menu);
    $text .= '</aside>';
    return $text;
}

function view_menu_header_li($data = []){
    return '<li '. ($data['class'] ? 'class="'. $data['class'] .'"' : '') .'><a href="'. $data['url'] .'">'. $data['icon'] .' <span>'. $data['text'] .'</span></a></li>';
}

function get_menu_header($menu){
    global $path;
    $role   = role_structure();
    $result = '<div class="menu"><ul class="list">'."\n";
    foreach ($menu AS $_menu){
        if(count($_menu['child']) > 0){
            // Kiểm tra xem menu con
            $permission = false;
            $li_active  = false;
            foreach ($_menu['child'] AS $_child){
                if(count($_child['roles']) == 0 || $role[$_child['roles'][0]][$_child['roles'][1]]){
                    $permission = true;
                }
                if($path == $_child['active']){
                    $li_active = true;
                }
            }
            if($permission){
                $result .= '<li '. ($li_active ? 'class="active open"' : '') .'>'."\n";
                $result .= '<a href="javascript:void(0);" class="menu-toggle">'. $_menu['icon'] .' <span>'. $_menu['text'] .'</span></a><ul class="ml-menu">';
                foreach ($_menu['child'] AS $_child){
                    if(count($_child['roles']) == 0 || $role[$_child['roles'][0]][$_child['roles'][1]]){
                        $result .= view_menu_header_li(['text'=>$_child['text'], 'icon' => $_child['icon'], 'url' => $_child['url'], 'class' => ($_child['active'] == $path ? 'active' : '')])."\n";
                    }
                }
                $result .= '</ul></li>'."\n";
            }
        }else{
            if(count($_menu['roles']) == 0 || $role[$_menu['roles'][0]][$_menu['roles'][1]]){
                $result .= view_menu_header_li(['text'=>$_menu['text'], 'icon' => $_menu['icon'], 'url' => $_menu['url'], 'class' => ($_menu['active'] == $path ? 'active' : '')])."\n";
            }
        }
    }
    $result .= '</ul></div>';
    return $result;
}

function get_menu_header_structure(){
    $menu = [
        [
            'roles'     => [],
            'text'      => 'Trang quản trị',
            'icon'      => '<i class="zmdi zmdi-home"></i>',
            'url'       => URL_ADMIN,
            'active'    => [PATH_ADMIN]
        ],
        [
            'text'  => 'Quản lý thành viên',
            'icon'  => '<i class="zmdi zmdi-home"></i>',
            'child' => [
                [
                    'text'      => 'Danh sách thành viên',
                    'url'       => 'http://google.com.vn',
                    'roles'     => ['user', 'manager'],
                    'active'    => [PATH_ADMIN, 'user']
                ],
                [
                    'text'  => 'Thêm thành viên',
                    'url'   => 'http://google.com.vn',
                    'roles' => ['user', 'add'],
                    'active'    => [PATH_ADMIN, 'user', 'add']
                ]
            ]
        ],
        [
            'text'  => 'Quản lý chuyên mục',
            'icon'  => '<i class="zmdi zmdi-home"></i>',
            'child' => [
                [
                    'text'      => 'Danh sách chuyên mục',
                    'url'       => 'http://google.com.vn',
                    'roles'     => ['category', 'manager'],
                    'active'    => [PATH_ADMIN, 'category'],
                ],
                [
                    'text'      => 'Thêm chuyên mục',
                    'url'       => 'http://google.com.vn',
                    'roles'     => ['category', 'add'],
                    'active'    => [PATH_ADMIN, 'category', 'add']
                ]
            ]
        ]
    ];
    return $menu;
}