<?php
require_once '../init.php';
require_once ABSPATH . PATH_ADMIN . '/includes/function-admin.php';
require_once ABSPATH . PATH_ADMIN .'/includes/function.php';
require_once ABSPATH . PATH_ADMIN .'/includes/function-form.php';

if(!$me){
    redirect(URL_LOGIN);
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
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Error-->
                    <div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url('<?=URL_ADMIN_ASSETS?>/media/error/bg6.jpg');">
                        <!--begin::Content-->
                        <div class="d-flex flex-column flex-row-fluid text-center">
                            <h1 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem;">Oops...</h1>
                            <p class="display-4 font-weight-bold text-white">Looks like something went wrong.We're working on it</p>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Error-->
                </div>
            </div>
            <?php
            require_once 'admin-footer.php';
        }
        break;
}