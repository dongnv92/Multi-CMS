<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';
require_once ABSPATH . PATH_ADMIN .'/includes/function.php';

if(!$me){
    redirect(URL_LOGIN);
}

switch ($path[1]){
    case 'blog':
    case 'user':
    case 'profile':
    case 'elements':
    case 'plugin':
    case 'category':
    case 'test':
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
            $header['title'] = 'Trang quản trị';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Trang Chủ', [URL_ADMIN => 'Quản trị'], 'Nội dung trang chính');
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <?php
                    if(class_exists(pDriving)){
                        $driving = new pDriving();
                        echo $driving->widget_index('oil_last');
                    }
                    ?>
                </div><!-- .col -->
            </div>
            <?php
            require_once 'admin-footer.php';
        }
        break;
}