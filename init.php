<?php
// Khởi động các giá trị ban đầu
session_start();
error_reporting(0);
//set_time_limit(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Khởi động các giá trị ban đầu

/** Đường dẫn tuyệt đối đến thư mục cài đặt */
define( 'ABSPATH'       , dirname( __FILE__ ) . '/' );
define( 'PATH_ADMIN'    , 'admin');
define( 'URL_HOME'      , 'http://localhost/dong/multicms');
define( 'URL_ADMIN'     , URL_HOME . '/' . PATH_ADMIN);

require_once ABSPATH.'includes/function.php';
require_once ABSPATH.'includes/function-admin.php';
require_once ABSPATH.'includes/formatting.php';
require_once ABSPATH.'includes/function-form.php';

// Mã hóa các ký tự đặc biệt
cms_magic_quotes();