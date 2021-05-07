<?php
function admin_error($title, $content, $title_sub = ''){
    $text = '<div class="card card-bordered">
        <div class="card-inner border-bottom">
            <!-- Title -->
            <div class="card-title-group"><div class="card-title"><h6 class="title">'. $title .'</h6></div></div>
            <!-- Title -->
        </div>
        <!-- Content -->
        <div class="card-inner text-center">
            '. $content .'
        </div>
        <!-- End Content -->
    </div>';
    return $text;
}

function admin_breadcrumbs($title, $list_url = '', $title_active = ''){
    $li = '';
    if(is_array($list_url)){
        foreach ($list_url AS $key => $value){
            $li .= '<li class="breadcrumb-item"><a href="'. $key .'">'. $value .'</a></li>';
        }
    }
    $text = "<div class=\"nk-block-head nk-block-head-sm\">
    <div class=\"nk-block-between\">
        <div class=\"nk-block-head-content\">
            <h3 class=\"nk-block-title page-title\">$title</h3>
        </div><!-- .nk-block-head-content -->
        <div class=\"nk-block-head-content\">
            <div class=\"nk-block-des text-soft\">
                <nav>
                    <ul class=\"breadcrumb\">
                        <li class=\"breadcrumb-item\"><a href=\"". URL_HOME ."\">Trang chủ</a></li>
                        $li
                        <li class=\"breadcrumb-item active\">$title_active</li>
                    </ul>
                </nav>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->";
    return $text;
}


// Hiển thị thanh Topbar
function admin_main_header(){
    global $me;
    return '<!-- main header @s -->
    <div class="nk-header nk-header-fixed is-light">
        <div class="container-fluid">
            <div class="nk-header-wrap">
                <div class="nk-menu-trigger d-xl-none ml-n1">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                </div>
                <div class="nk-header-brand d-xl-none">
                    <a href="'. URL_ADMIN .'" class="logo-link">
                        <img class="logo-light logo-img" src="'. get_config('logo') .'" srcset="'. get_config('logo') .' 2x" alt="logo">
                        <img class="logo-dark logo-img" src="'. get_config('logo') .'" srcset="'. get_config('logo') .' 2x" alt="logo-dark">
                    </a>
                </div><!-- .nk-header-brand -->
                <div class="nk-header-news d-none d-xl-block">
                    <div class="nk-news-list">
                        <a class="nk-news-item" href="#">
                            <div class="nk-news-icon">
                                <em class="icon ni ni-card-view"></em>
                            </div>
                            <div class="nk-news-text">
                                <p>Bản tin nhanh <span> Website đang trong thời gian xây dựng</span></p>
                                <em class="icon ni ni-external"></em>
                            </div>
                        </a>
                    </div>
                </div><!-- .nk-header-news -->
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="user-toggle">
                                    <div class="user-avatar sm">
                                        '. ($me['user_avatar'] ? '<img src="'. URL_HOME .'/'. $me['user_avatar'] .'" />' : get_config('avatar_default')) .'
                                    </div>
                                    <div class="user-info d-none d-md-block">
                                        <div class="user-status">'. $me['meta_name'] .'</div>
                                        <div class="user-name dropdown-indicator">'. $me['user_name'] .'</div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                    <div class="user-card">
                                        <div class="user-avatar">
                                            <span>ĐN</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text">'. $me['user_name'] .'</span>
                                            <span class="sub-text">'. ($me['user_phone'] ? $me['user_phone'] : '---') .'</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>Xem hồ sơ</span></a></li>
                                        <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Cài đặt tài khoản</span></a></li>
                                        <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Nhật ký hoạt động</span></a></li>
                                    </ul>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="#"><em class="icon ni ni-signout"></em><span>Đăng xuất</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                        <li class="dropdown notification-dropdown mr-n1">
                            <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                                <div class="dropdown-head">
                                    <span class="sub-title nk-dropdown-title">Thông báo</span>
                                    <a href="#">Đánh dấu đã đọc tất cả</a>
                                </div>
                                <div class="dropdown-body">
                                    <div class="nk-notification">
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">Đây là thông báo mẫu</div>
                                                <div class="nk-notification-time">Không xác định thời gian gửi</div>
                                            </div>
                                        </div>
                                    </div><!-- .nk-notification -->
                                </div><!-- .nk-dropdown-body -->
                                <div class="dropdown-foot center">
                                    <a href="#">Xem tất cả</a>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                    </ul><!-- .nk-quick-nav -->
                </div><!-- .nk-header-tools -->
            </div><!-- .nk-header-wrap -->
        </div><!-- .container-fliud -->
    </div>
    <!-- main header @e -->';
}

function admin_left_side_bar(){
    $menu = get_menu_header_structure();
    $text = '<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">';
    $text .= '
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="'. URL_ADMIN .'" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="'. get_config('logo') .'" srcset="'. get_config('logo') .' 2x" alt="logo">
                <img class="logo-dark logo-img" src="'. get_config('logo') .'" srcset="'. get_config('logo') .' 2x" alt="logo-dark">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->';
    $text .= get_menu_header($menu);
    $text .= '</div>';
    return $text;
}

//
function check_menu_active($path, $list_active){
    $active = false;
    foreach ($list_active AS $_list_active){
        $count_path = count($_list_active) - 1;
        for($i = 0; $i <= $count_path; $i++){
            if($path[$i] != $_list_active[$i]){
                $active = false;
                break;
            }else{
                $active = true;
            }
        }
        if($active){
            break;
        }
    }
    return $active;
}

function view_menu_header_li($data = []){
    $data['url'] = str_replace('URL_ADMIN', URL_ADMIN, $data['url']);
    return '<li '. ($data['class'] ? 'class="'. $data['class'] .'"' : '') .'>
        <a href="'. $data['url'] .'" class="nk-menu-link">
            '. ($data['icon'] ? '<span class="nk-menu-icon">'. $data['icon'] .'</span>' : '') .'
            <span class="nk-menu-text">'. $data['text'] .'</span>
        </a>
    </li>';
}

function get_menu_header($menu){
    global $path, $role;
    //$role   = role_structure();
    $result = '<div class="nk-sidebar-element"><div class="nk-sidebar-content"><div class="nk-sidebar-menu" data-simplebar><ul class="nk-menu">'."\n";
    foreach ($menu AS $_menu){
        if(count($_menu['child']) > 0){
            // Kiểm tra xem menu con
            $permission = false;
            $li_active  = false;
            foreach ($_menu['child'] AS $_child){
                if(count($_child['roles']) == 0 || $role[$_child['roles'][0]][$_child['roles'][1]]){
                    $permission = true;
                }
                if( check_menu_active($path, $_child['active'])){
                    $li_active = true;
                }
            }
            if($permission){
                $result .= '<li '. ($li_active ? 'class="nk-menu-item has-sub active current-page"' : 'class="nk-menu-item has-sub"') .'>'."\n";
                $result .= '<a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon">'. $_menu['icon'] .' </span><span class="nk-menu-text">'. $_menu['text'] .'</span></a><ul class="nk-menu-sub">';
                foreach ($_menu['child'] AS $_child){
                    if(count($_child['roles']) == 0 || $role[$_child['roles'][0]][$_child['roles'][1]]){
                        $result .= view_menu_header_li([
                            'text'  => (check_menu_active($path, $_child['active'])  ? '<em class="icon ni ni-curve-down-right"></em> '.$_child['text'] : $_child['text']),
                            'icon'  => $_child['icon'],
                            'url'   => $_child['url'],
                            'class' => (check_menu_active($path, $_child['active'])  ? 'nk-menu-item' : 'nk-menu-item')
                        ])."\n";
                        //active current-page
                    }
                }
                $result .= '</ul></li>'."\n";
            }
        }else{
            if(count($_menu['roles']) == 0 || $role[$_menu['roles'][0]][$_menu['roles'][1]]){
                $result .= view_menu_header_li([
                    'text'  => $_menu['text'],
                    'icon'  => $_menu['icon'],
                    'url'   => $_menu['url'],
                    'class' => (check_menu_active($path, $_menu['active']) ? 'nk-menu-item' : 'nk-menu-item')
                    ])."\n";
            }
        }
    }
    $result .= '</ul><!-- .nk-menu --></div><!-- .nk-sidebar-menu --></div><!-- .nk-sidebar-content --></div><!-- .nk-sidebar-element -->';
    return $result;
}

function get_menu_header_structure(){
    $menu = [
        [
            'roles'     => [],
            'text'      => 'Trang quản trị',
            'icon'      => '<em class="icon ni ni-home-alt"></em>',
            'url'       => URL_ADMIN,
            'active'    => [[PATH_ADMIN, '']]
        ],
        [
            'text'  => 'Nhân sự',
            'icon'  => '<em class="icon ni ni-users"></em>',
            'child' => [
                [
                    'text'      => 'Danh sách nhân sự',
                    'url'       => URL_ADMIN . "/user/",
                    'roles'     => ['user', 'manager'],
                    'active'    => [[PATH_ADMIN, 'user', ''], [PATH_ADMIN, 'user', 'update']]
                ],
                [
                    'text'      => 'Thêm mới',
                    'url'       => URL_ADMIN . "/user/add",
                    'roles'     => ['user', 'add'],
                    'active'    => [[PATH_ADMIN, 'user', 'add']]
                ],
                [
                    'text'      => 'Phân quyền',
                    'url'       => URL_ADMIN . "/user/role",
                    'roles'     => ['user', 'role'],
                    'active'    => [[PATH_ADMIN, 'user', 'role'], [PATH_ADMIN, 'user', 'role', 'add'], [PATH_ADMIN, 'user', 'role', 'update']]
                ]
            ]
        ],
        [
            'text'  => 'Thông tin cá nhân',
            'icon'  => '<em class="icon ni ni-account-setting-alt"></em>',
            'child' => [
                [
                    'text'      => 'Sửa hồ sơ',
                    'url'       => URL_ADMIN . "/profile/",
                    'roles'     => [],
                    'active'    => [[PATH_ADMIN, 'profile', '']]
                ],
                [
                    'text'      => 'Đổi Avatar',
                    'url'       => URL_ADMIN . "/profile/change-avatar",
                    'roles'     => [],
                    'active'    => [[PATH_ADMIN, 'profile', 'change-avatar']]
                ]
            ]
        ],
        [
            'text'  => 'Bài viết',
            'icon'  => '<em class="icon ni ni-article"></em>',
            'child' => [
                [
                    'text'      => 'Bài viết',
                    'url'       => URL_ADMIN . "/blog/",
                    'roles'     => ['blog', 'manager'],
                    'active'    => [[PATH_ADMIN, 'blog', ''], [PATH_ADMIN, 'blog', 'update'], [PATH_ADMIN, 'blog', 'detail']]
                ],
                [
                    'text'      => 'Thêm bài viết',
                    'url'       => URL_ADMIN . "/blog/add",
                    'roles'     => ['blog', 'add'],
                    'active'    => [[PATH_ADMIN, 'blog', 'add']]
                ],
                [
                    'text'      => 'Chuyên mục',
                    'url'       => URL_ADMIN . "/category/blog",
                    'roles'     => ['blog', 'category'],
                    'active'    => [[PATH_ADMIN, 'category', 'blog']]
                ]
            ]
        ],
        [
            'text'  => 'Plugin',
            'icon'  => '<em class="icon ni ni-grid-add-c"></em>',
            'child' => [
                [
                    'text'      => 'Tất cả Plugin',
                    'url'       => URL_ADMIN . "/plugin/",
                    'roles'     => ['plugin', 'manager'],
                    'active'    => [[PATH_ADMIN, 'plugin', '']]
                ],
                [
                    'text'      => 'Thêm mới',
                    'url'       => URL_ADMIN . "/plugin/add",
                    'roles'     => ['plugin', 'manager'],
                    'active'    => [[PATH_ADMIN, 'plugin', 'add']]
                ]
            ]
        ]
    ];

    // Lấy danh sách menu từ các plugin
    $list_plugin = get_list_plugin();
    foreach ($list_plugin AS $plugin){
        $config = file_get_contents(ABSPATH . PATH_PLUGIN . "{$plugin}/config.json");
        $config = json_decode($config, true);
        if($config['status'] == 'active'){
            $menu   = array_merge($menu, $config['menu']);
        }
    }

    $menu_logout = [
        [
            'roles'     => [],
            'text'      => 'Các phần tử',
            'icon'      => '<em class="icon ni ni-link-group"></em>',
            'url'       => URL_ADMIN.'/elements/',
            'active'    => [[PATH_ADMIN, 'elements', '']]
        ],
        [
            'roles'     => [],
            'text'      => 'Đăng xuất',
            'icon'      => '<em class="icon ni ni-arrow-from-left"></em>',
            'url'       => URL_LOGOUT,
            'active'    => []
        ]
    ];

    $menu = array_merge($menu, $menu_logout);

    return $menu;
}