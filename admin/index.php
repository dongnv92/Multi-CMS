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
            echo admin_breadcrumbs('Trang Chủ', [URL_ADMIN => 'Trang test'], 'Đang ở đây');
            ?>
            <div class="nk-block">
                <div class="card card-bordered card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner">
                        <?php
                            $path = ['admin', 'user', 'update'];
                            $acti = [['admin', 'user'], ['admin', 'user', 'update']];
                            if($path == $acti[0]){
                                echo "Yes";
                            }else{
                                echo "No";
                            }
                        ?>
                        </div>
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
            <?php
            require_once 'admin-footer.php';
        }
        break;
}