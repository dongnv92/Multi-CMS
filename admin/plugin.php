<?php
switch ($path[2]){
    default:
        $header['js']      = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}"
        ];
        $header['title']    = 'Quản lý Plugin';
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Plugin', 'Quản lý Plugin','Quản lý', [URL_ADMIN . "/{$path[1]}/" => 'Plugin']);
        ?>
        <div class="row clearfix">
        <?php
        foreach (get_list_plugin() AS $plugin){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . "{$plugin}/config.json");
            $config = json_decode($config, true);
            ?>
            <div class="col-lg-4 col-md-12">
                <div class="card member-card">
                    <div class="header" style='background-image: url("<?=URL_HOME . '/' . PATH_PLUGIN . "$plugin/{$config['banner']}"?>"); background-size: 100% 100%; background-repeat: no-repeat'></div>
                    <div class="body">
                        <div class="col-12">
                            <h5 class="col-teal"><?=$config['name']?></h5>
                        </div>
                        <div class="col-12">
                            <p class="text-muted"><?=$config['description']?></p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <h6><?=$config['version']?></h6>
                                <small>VERSION</small>
                            </div>
                            <div class="col-5">
                                <h6><?=$config['website'] ? '<a href="'. $config['website'] .'" class="font-weight-bold text-danger">'. $config['author'] .'</a>' : '<span class="font-weight-bold text-danger">'. $config['author'] .'</span>'?></h6>
                                <small>TÁC GIẢ</small>
                            </div>
                            <div class="col-4">
                                <h6>
                                    <?=$config['status'] == 'active' ?
                                        '<button type="button" id="plugin_status" data-type="not_active" data-name="'. $plugin .'" class="btn btn-raised bg-teal waves-effect btn-sm">KÍCH HOẠT</button>':
                                        '<button type="button" id="plugin_status" data-type="active" data-name="'. $plugin .'" class="btn btn-raised bg-red waves-effect btn-sm">NGỪNG KÍCH HOẠT</button>'
                                    ?>
                                </h6>
                                <small>TRẠNG THÁI</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}