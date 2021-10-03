<?php
#- Thêm 1 trường cú pháp trong bảng account transaction.
#- Khi đồng bộ dữ liệu giữa Momo và Database thì check theo nội dung cú pháp và số tiền trong các transaction
require_once 'init.php';

$account    = new MomoAccount();
$data       = $account->getHistoryByPayment('2021-09-25 23:40:00', '2021-09-25 23:50:00', 'Hello', '3000');
print_r($data);
