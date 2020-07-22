<?php
switch ($path[2]){
    default:
        $header['title'] = 'Quản lý Plugin';
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
                            <p class="text-muted"><?=$config['description']?></p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <h5>57</h5>
                                <small>Files</small>
                            </div>
                            <div class="col-4">
                                <h5>12GB</h5>
                                <small>Used</small>
                            </div>
                            <div class="col-4">
                                <h5>1,256$</h5>
                                <small>Spent</small>
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