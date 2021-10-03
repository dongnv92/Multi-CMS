<?php
function admin_alert($type = 'success', $content = ''){
    $text = '';
    switch ($type) {
        case 'success':
            $text = '<div class="alert alert-custom alert-outline-2x alert-outline-success fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
                <div class="alert-text">'. $content .'</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>';
            break;
        case 'error':
            $text = '<div class="alert alert-custom alert-outline-2x alert-outline-danger fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">'. $content .'</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>';
            break;
    }
    return $text;
}

function admin_error($title, $content){
    $text = '<div class="card card-custom gutter-b">
         <div class="card-header">
            <div class="card-title"><h3 class="card-label">'. $title .'</h3></div>
         </div>
         <div class="card-body text-center">
          '. $content .'
         </div>
         <div class="card-footer text-center">
             <a href="'. URL_ADMIN .'" class="btn btn-square btn-dark">Trang chủ</a>
        </div>
    </div>';
    return $text;
}

function admin_breadcrumbs($title, $list_url = [], $title_active = '', $content = ''){
    $li = '<li class="breadcrumb-item text-muted"><a href="'. URL_ADMIN .'" class="text-muted text-hover-primary">Trang chủ</a></li>';
    if(is_array($list_url)){
        foreach ($list_url AS $key => $value){
            $li .= '<li class="breadcrumb-item text-muted"><a href="'. $key .'" class="text-muted text-hover-primary">'. $value .'</a></li>';
        }
    }
    $text = '
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">'. $title .'</h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    '. $li .'
                    <li class="breadcrumb-item text-dark">'. $title_active .'</li>
                </ul>
                <!--end::Actions-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
              '. $content .'
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->';
    return $text;
}

function admin_menu(){
    $menu = get_menu_header_structure();
    $text = '<!--begin::Menu--><ul class="menu-nav">';
    $text .= get_menu_header($menu);
    $text .= '</ul>';
    return $text;
}

function get_menu_header($menu){
    global $path, $role;
    $result = '';
    foreach ($menu AS $_menu){
        // Kiểm tra xem menu con
        if(is_array($_menu['child']) && count($_menu['child']) > 0){
            $permission = false;
            $li_active  = false;
            foreach ($_menu['child'] AS $_child){
                if(count($_child['roles']) == 0 || $role[$_child['roles'][0]][$_child['roles'][1]]){
                    $permission = true;
                }
                if(check_menu_active($path, $_child['active'])){
                    $li_active = true;
                }
            }
            if($permission){
                $result .= '<li class="menu-item menu-item-submenu '. ($li_active ? 'menu-item-open menu-item-here' : '') .'" aria-haspopup="true" data-menu-toggle="hover">';
                $result .= '<a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">'. $_menu['icon'] .'</span>
                        <span class="menu-text">'. $_menu['text'] .'</span>
                        <i class="menu-arrow"></i>
                        </a>
						<div class="menu-submenu">
						    <i class="menu-arrow"></i>
							<ul class="menu-subnav">';
                                foreach ($_menu['child'] AS $_child){
                                    if(count($_child['roles']) == 0 || $role[$_child['roles'][0]][$_child['roles'][1]]){
                                        $result .= view_menu_header_li([
                                                'text'  => $_child['text'],
                                                'url'   => $_child['url'],
                                                'class' => (check_menu_active($path, $_child['active'])  ? 'menu-item menu-item-active' : 'menu-item')
                                            ])."\n";
                                        //active current-page
                                    }
                                }
                            $result .= '</ul>';
                        $result .= '</div>';
                    $result .= '</li>';
            }
        }else{
            if(count($_menu['roles']) == 0 || $role[$_menu['roles'][0]][$_menu['roles'][1]]){
                $result .= view_menu_header_li([
                        'text'  => $_menu['text'],
                        'icon'  => $_menu['icon'],
                        'url'   => $_menu['url'],
                        'class' => (check_menu_active($path, $_menu['active'])  ? 'menu-item menu-item-active' : 'menu-item')
                    ]);
            }
        }
    }
    return $result;
}

function check_menu_active($path, $list_active){
    $active = false;
    //if(is_array($list_active)){
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
    //}
    return $active;
}

function view_menu_header_li($data = []){
    $data['url'] = str_replace('URL_ADMIN', URL_ADMIN, $data['url']);
    return '<li class="'. $data['class'] .'" aria-haspopup="true">
        <a class="menu-link" href="'. $data['url'] .'">
            '. ($data['icon'] ? '<span class="svg-icon menu-icon">'. $data['icon'] .'</span>' : '<i class="menu-bullet menu-bullet-dot"><span></span></i>') .'
            <span class="menu-text">'. $data['text'] .'</span>
        </a>
    </li>';
}

function get_menu_header_structure(){
    $menu = [
        [
            'text'      => 'Trang quản trị',
            'icon'      => '<i class="fab fa-suse"></i>',
            'url'       => URL_ADMIN,
            'roles'     => [],
            'active'    => [[PATH_ADMIN, '']]
        ],
        [
            'text'  => 'Nhân sự',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24"/>
                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                </g>
            </svg>',
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
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                    <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"/>
                    <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"/>
                </g>
            </svg>',
            'url'       => URL_ADMIN . "/profile",
            'roles'     => [],
            'active'    => [[PATH_ADMIN, 'profile', '']]
        ],
        [
            'text'  => 'Cài đặt',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                </g>
            </svg>',
            'url'       => URL_ADMIN . "/settings",
            'roles'     => ['system', 'settings'],
            'active'    => [[PATH_ADMIN, 'settings', '']]
        ],
        [
            'text'  => 'Bài viết',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" fill="#000000"/>
                    <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
                </g>
            </svg><!--end::Svg Icon-->',
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
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                    <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                </g>
            </svg>',
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
        ],
        [
            'text'  => 'Giao diện',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M5.5,4 L9.5,4 C10.3284271,4 11,4.67157288 11,5.5 L11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L5.5,8 C4.67157288,8 4,7.32842712 4,6.5 L4,5.5 C4,4.67157288 4.67157288,4 5.5,4 Z M14.5,16 L18.5,16 C19.3284271,16 20,16.6715729 20,17.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,17.5 C13,16.6715729 13.6715729,16 14.5,16 Z" fill="#000000"/>
                    <path d="M5.5,10 L9.5,10 C10.3284271,10 11,10.6715729 11,11.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,12.5 C20,13.3284271 19.3284271,14 18.5,14 L14.5,14 C13.6715729,14 13,13.3284271 13,12.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z" fill="#000000" opacity="0.3"/>
                </g>
            </svg>',
            'child' => [
                [
                    'text'      => 'Quản lý Slides',
                    'url'       => URL_ADMIN . "/theme/slides",
                    'roles'     => ['theme', 'slides'],
                    'active'    => [[PATH_ADMIN, 'theme', 'slides']]
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
            'text'      => 'Đăng xuất',
            'icon'      => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M7.62302337,5.30262097 C8.08508802,5.000107 8.70490146,5.12944838 9.00741543,5.59151303 C9.3099294,6.05357769 9.18058801,6.67339112 8.71852336,6.97590509 C7.03468892,8.07831239 6,9.95030239 6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,9.99549229 17.0108275,8.15969002 15.3875704,7.04698597 C14.9320347,6.73472706 14.8158858,6.11230651 15.1281448,5.65677076 C15.4404037,5.20123501 16.0628242,5.08508618 16.51836,5.39734508 C18.6800181,6.87911023 20,9.32886071 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 C4,9.26852332 5.38056879,6.77075716 7.62302337,5.30262097 Z" fill="#000000" fill-rule="nonzero"/>
                    <rect fill="#000000" opacity="0.3" x="11" y="3" width="2" height="10" rx="1"/>
                </g>
            </svg><!--end::Svg Icon-->',
            'url'       => URL_LOGOUT,
            'roles'     => [],
            'active'    => []
        ]
    ];
    $menu = array_merge($menu, $menu_logout);
    return $menu;
}