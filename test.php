<?php

$cate = [
    'text' => [
        'title'         => 'Chuyên mục Blog',
        'title_update'  => 'Cập nhật chuyên mục Blog',
        'title_card'    => 'Thông tin chuyên mục',
        'tool_card'     => '<a href="#" class="link">Xem tất cả</a>',
        'field_name'    => 'Tên chuyên mục',
        'field_des'     => 'Mô tả',
        'field_url'     => 'Đường dẫn',
        'bt_add'        => 'Thêm chuyên mục mới',
        'bt_update'     => 'Cập nhật chuyên mục'
    ],
    'fields' => ['url' => true, 'cat_parent' => true, 'des' => true],
    'permission'    => ['blog', 'category'],
    'type'          => 'blog_category',
    'breadcrumbs'   => [
        'title'     => 'Chuyên mục Blog',
        'url'       => [URL_ADMIN . '/blog' => 'Blog'],
        'active'    => 'Chuyên mục'
    ]
];

echo json_encode($cate, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);