<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';

$data = [
    'name'          => 'Quản lý khách Hàng, Đối Tác',
    'version'       => '0.1',
    'background'    => 'images/images.png',
    'status'        => 'active'
];

echo encode_json($data);