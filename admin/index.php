<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';

if(!$me){
    redirect(URL_LOGIN);
}

switch ($path[1]){
    case 'blog':
    case 'user':
    case 'profile':
    case 'elements':
    case 'plugin':
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
                    echo admin_breadcrumbs('PLUGIN', $config['name'],$config['name'], [URL_ADMIN . '/plugin/' => 'Plugin']);
                    echo admin_error($config['name'], "Plugin <strong>{$config['name']}</strong> chưa được kích hoạt hoặc không có trên hệ thống.");
                require_once 'admin-footer.php';
            }
            require_once (ABSPATH . PATH_PLUGIN . $path[1] . '/index.php');
        }else{
            $header['title'] = 'Trang quản trị';
            require_once 'admin-header.php';
            echo admin_breadcrumbs('Trang Chủ', [URL_ADMIN => 'Trang test'], 'Đang ở đây');
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-bordered">
                        <div class="card-inner border-bottom">
                            <!-- Title -->
                            <div class="card-title-group">
                                <div class="card-title"><h6 class="title">Card</h6></div>
                                <div class="card-tools">
                                    <a href="#" class="link">Xem tất cả</a>
                                </div>
                            </div>
                            <!-- Title -->
                        </div>
                        <!-- Content -->
                        <div class="card-inner">
                            <?php
                            echo formInputText('name', [
                                'label'     => 'Input Text Default'
                            ]);

                            echo formInputSelect('select', [
                                'option1' => 'Option',
                                'option2' => 'Option 2'
                            ], [
                                'data-search'   => 'on',
                                'multiple'      => 'multiple',
                                'data-placeholder' => 'Hello'
                            ]);
                            ?>
                        </div>
                        <!-- End Content -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-bordered">
                        <div class="card-inner border-bottom">
                            <!-- Title -->
                            <div class="card-title-group">
                                <div class="card-title"><h6 class="title">Card</h6></div>
                                <div class="card-tools">
                                    <a href="#" class="link">Xem tất cả</a>
                                </div>
                            </div>
                            <!-- Title -->
                        </div>
                        <!-- Content -->
                        <div class="card-inner">
                            Hello
                        </div>
                        <!-- End Content -->
                    </div>
                </div>
            </div>
            <?php
            require_once 'admin-footer.php';
        }
        break;
}