<?php
// Khởi động các giá trị ban đầu
session_start();
error_reporting(0);
set_time_limit(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Khởi động các giá trị ban đầu
/** Cài đặt các hằng số cố định */
define( 'ABSPATH'           , dirname( __FILE__ ) . '/' );
define( 'ROOTPATH'          , basename(__DIR__) );
define( 'PATH_ADMIN'        , 'admin');

define( 'URL_HOME'          , 'http://localhost/dong/multicms');
define( 'URL_ADMIN'         , URL_HOME . '/' . PATH_ADMIN);
define( 'URL_ADMIN_ASSETS'  , URL_HOME . '/content/assets-admin/');
define( 'URL_BLOG'          , URL_HOME . '/blog/');
define( 'URL_JS'            , URL_HOME . '/js/');
define( 'URL_LOGIN'         , URL_HOME . '/login.html');
define( 'URL_LOGOUT'        , URL_HOME . '/logout.html');
define( 'URL_ADMIN_AJAX'    , URL_HOME . '/admin-ajax/');
define( 'URL_REFERER'       , isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : URL_ADMIN);

define( 'DB_HOST'           , 'localhost');
define( 'DB_USERNAME'       , 'root');
define( 'DB_PASSWORD'       , '');
define( 'DB_DATABASE'       , 'multicms');

/* Kết nối file database */
require_once ABSPATH . 'includes/class/class.mysqli.db.php';
$database = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

/* Nhúng các file function */
require_once ABSPATH . 'includes/function.php';

// Mã hóa các ký tự đặc biệt
cms_magic_quotes();

require_once ABSPATH . 'includes/function-admin.php';
require_once ABSPATH . 'includes/formatting.php';
require_once ABSPATH . 'includes/function-validate.php';
require_once ABSPATH . 'includes/function-form.php';
require_once ABSPATH . 'includes/class/class.user.php';
require_once ABSPATH . 'includes/class/class.meta.php';

// Kiểm tra user
$me = new user($database);
$me = $me->init_get_me();

// Lấy thông tin phân quyền vai trò
$role = new meta($database, 'role');
$role = $role->get_meta($me['user_role'], 'meta_info');
$role = unserialize($role['data']['meta_info']);

// Lấy đường đẫn hiện tại
$path = get_path_uri();