<?php
// Khởi động các giá trị ban đầu
session_start();
error_reporting(0);
set_time_limit(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$time_start = microtime(true);
// Khởi động các giá trị ban đầu
/** Cài đặt các hằng số cố định */
define( 'ABSPATH'           , dirname( __FILE__ ) . '/' );
define( 'ROOTPATH'          , basename(__DIR__) );
define( 'PATH_ADMIN'        , 'admin');
define( 'PATH_PLUGIN'       , 'content/plugin/');
define( 'PATH_THEME'        , 'content/theme');
define( 'CONFIG_THEME'      , 'suha');
define( 'URL_HOME'          , 'https://muataikhoan.net');
define( 'URL_ADMIN'         , URL_HOME . '/' . PATH_ADMIN);
define( 'URL_ADMIN_ASSETS'  , URL_HOME . '/content/assets-admin/');
define( 'URL_BLOG'          , URL_HOME . '/blog/');
define( 'URL_JS'            , URL_HOME . '/js/');
define( 'URL_API'           , URL_HOME . '/api/');
define( 'URL_LOGIN'         , URL_HOME . '/login.html');
define( 'URL_LOGOUT'        , URL_HOME . '/logout.html');
define( 'URL_ADMIN_AJAX'    , URL_HOME . '/admin-ajax/');
define( 'URL_REFERER'       , isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : URL_ADMIN);

/*define( 'DB_HOST'           , 'localhost');
define( 'DB_USERNAME'       , 'root');
define( 'DB_PASSWORD'       , '');
define( 'DB_DATABASE'       , 'multicms'); */

define( 'DB_HOST'           , 'localhost');
define( 'DB_USERNAME'       , 'topcongt');
define( 'DB_PASSWORD'       , 'Anhdong2442');
define( 'DB_DATABASE'       , 'topcongt_cms');

/* Kết nối file database */
require_once ABSPATH . 'includes/class/class.mysqli.db.php';
$database = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

/* Nhúng các file function */
require_once ABSPATH . 'includes/function.php';

// Mã hóa các ký tự đặc biệt
cms_magic_quotes();

require_once ABSPATH . 'includes/formatting.php';
require_once ABSPATH . 'includes/function-validate.php';
require_once ABSPATH . 'includes/class/class.user.php';
require_once ABSPATH . 'includes/class/class.meta.php';
require_once ABSPATH . 'includes/class/class.post.php';
require_once ABSPATH . 'includes/class/class.media.php';
require_once ABSPATH . 'includes/class/class.category.php';
require_once ABSPATH . 'includes/class/class.theme.php';

// Kiểm tra user
$user   = new user($database);
$me     = $user->init_get_me();

// Nhúng các file trong Plugin vào
foreach (get_list_plugin() AS $_init_plugin){
    $_init_plugin_path      = ABSPATH . PATH_PLUGIN . $_init_plugin;
    $_init_plugin_config    = file_get_contents($_init_plugin_path . "/config.json");
    $_init_plugin_config    = json_decode($_init_plugin_config, true);
    if(is_array($_init_plugin_config['public_class']) && count($_init_plugin_config['public_class']) && $_init_plugin_config['status'] == 'active'){
        foreach ($_init_plugin_config['public_class'] AS $_init_plugin_class){
            if(validate_isset($_init_plugin_class)){
                $plugin_file = "$_init_plugin_path/$_init_plugin_class";
                if(file_exists($plugin_file)){
                    require_once $plugin_file;
                }
            }
        }
    }
}

// Lấy thông tin phân quyền vai trò
$role = new meta($database, 'role');
$role = $role->get_meta($me['user_role'], 'meta_info');
$role = unserialize($role['data']['meta_info']);

// Lấy đường đẫn hiện tại (domain|local)
$path = get_path_uri('domain');