<?php

$config = [
    'name'              => 'Quản lý khách hàng',
    'unique_identifier' => 'customer',
    'version'           => '0.1',
    'banner'            => 'banner.png',
    'status'            => 'active',
    'menu'              => [
        [
            'text'  => 'Quản lý khách hàng',
            'icon'  => '<i class="zmdi zmdi-accounts-alt"></i>',
            'child' => [
                [
                    'text'      => 'Danh sách khách hàng',
                    'url'       => "URL_ADMIN/customer/",
                    'roles'     => ['customer', 'manager'],
                    'active'    => [[PATH_ADMIN, 'customer', ''], [PATH_ADMIN, 'customer', 'update']]
                ],
                [
                    'text'      => 'Thêm khách hàng',
                    'url'       => "URL_ADMIN/customer/add",
                    'roles'     => ['customer', 'add'],
                    'active'    => [[PATH_ADMIN, 'customer', 'add']]
                ]
            ]
        ]
    ],
    'role_structure'    => [
        'customer' => [
            'manager'   => false,
            'add'       => false
        ]
    ],
    'role_text'         => [
        ''          => 'Plugin Quản lý khách hàng',
        'manager'   => 'Quản lý khách hàng',
        'add'       => 'Thêm khách hàng',
        'update'    => 'Cập nhật khách hàng',
        'delete'    => 'Xoá khách hàng'
    ]
];

echo encode_json($config);