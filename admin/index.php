<?php
require_once '../init.php';
require_once ABSPATH . PATH_ADMIN . '/includes/function-admin.php';
require_once ABSPATH . PATH_ADMIN .'/includes/function.php';
require_once ABSPATH . PATH_ADMIN .'/includes/function-form.php';

if(!$me){
    redirect(URL_LOGIN."?ref=".URL_HOME . $_SERVER['REQUEST_URI']);
}

switch ($path[1]){
    case 'test':
    case 'blog':
    case 'user':
    case 'profile':
    case 'elements':
    case 'plugin':
    case 'theme':
    case 'category':
    case 'settings':
        require_once "{$path[1]}.php";
        break;
    default:
        if(in_array($path[1], get_list_plugin())){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . $path[1] . '/config.json');
            $config = json_decode($config, true);
            if($config['status'] != 'active'){
                $header['title'] = "Plugin {$config['name']} chưa được kích hoạt";
                require_once 'admin-header.php';
                    echo admin_breadcrumbs('PLUGIN', [URL_ADMIN . '/plugin/' => 'Plugin'] ,$config['name']);
                    echo admin_error($config['name'], "Plugin <strong>{$config['name']}</strong> chưa được kích hoạt hoặc không có trên hệ thống.");
                require_once 'admin-footer.php';
            }
            require_once (ABSPATH . PATH_PLUGIN . $path[1] . '/index.php');
        }else{
            $header['title']    = 'Trang quản trị';
            $header['toolbar']  = admin_breadcrumbs('Trang chủ', [URL_ADMIN => 'Trang chủ'], 'Trang đầu');
            require_once 'admin-header.php';
            require ABSPATH . PATH_ADMIN . '/includes/widget.php';
            $list_lugin = get_list_plugin();
            foreach ($list_lugin AS $plugin){
                $config     = file_get_contents(ABSPATH . PATH_PLUGIN . $plugin . '/config.json');
                $config     = json_decode($config, true);
                $file_name  = ABSPATH . PATH_PLUGIN . $plugin . "/{$config['source']['widget']}";
                if($config['source']['widget'] && file_exists($file_name)){
                    require_once $file_name;
                }
            }
            require_once 'admin-footer.php';
        }
        break;
}