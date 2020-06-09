<?php
// Khởi động các giá trị ban đầu
session_start();
error_reporting(0);
set_time_limit(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Khởi động các giá trị ban đầu
/** Cài đặt các hằng số cố định */
define( 'ABSPATH'       , dirname( __FILE__ ) . '/' );
define( 'PATH_ADMIN'    , 'admin');
define( 'URL_HOME'      , 'http://localhost/dong/multicms');
define( 'URL_ADMIN'     , URL_HOME . '/' . PATH_ADMIN);
define( 'DB_HOST'       , 'localhost');
define( 'DB_USERNAME'   , 'root');
define( 'DB_PASSWORD'   , '');
define( 'DB_DATABASE'   , 'multicms');

/* Kết nối file database */
require_once ABSPATH . 'includes/class/class.mysqli.db.php';
$database = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

/* Nhúng các file function */
require_once ABSPATH.'includes/function.php';
require_once ABSPATH.'includes/function-admin.php';
require_once ABSPATH.'includes/formatting.php';
require_once ABSPATH.'includes/function-form.php';

// Mã hóa các ký tự đặc biệt
cms_magic_quotes();

// kiểm tra user
