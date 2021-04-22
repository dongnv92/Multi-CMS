<?php
switch ($path[2]){
    default:
        $header['js']      = [
            URL_JS . "{$path[1]}"
        ];
        $header['title']    = 'Quản lý Plugin';
        require_once 'admin-header.php';
        echo admin_breadcrumbs('Plugin', [URL_ADMIN . "/{$path[1]}/" => 'Plugin'],'Quản lý');
        ?>
        <div class="row">
        <?php
        foreach (get_list_plugin() AS $plugin){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . "{$plugin}/config.json");
            $config = json_decode($config, true);
            ?>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="team">
                            <div class="<?=$config['status'] == 'active' ? 'team-status bg-success text-white' : 'team-status bg-light text-white'?>"><em class="icon ni ni-check-thick"></em></div>
                            <div class="team-options">
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="javascript:;" data-action="change_status" id="plugin_status" data-type="active" data-name="<?=$plugin?>">
                                                    <em class="icon ni ni-check-circle text-success"></em><span>Kích Hoạt</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-action="change_status" id="plugin_status" data-type="not_active" data-name="<?=$plugin?>">
                                                    <em class="icon ni ni-info"></em><span>Ngừng Hoạt</span>
                                                </a>
                                            </li>
                                            <li><a href="javascript:;"><em class="icon ni ni-trash text-danger"></em><span>Xoá</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="user-card user-card-s2">
                                <div class="user-avatar sq lg bg-primary">
                                    <img src="<?=URL_HOME . '/' . PATH_PLUGIN . "$plugin/{$config['banner']}"?>" alt="">
                                </div>
                                <div class="user-info"><h6><?=$config['name']?></h6></div>
                            </div>
                            <div class="team-details">
                                <p><?=$config['description']?>.</p>
                            </div>
                            <ul class="team-statistics">
                                <li><span>Tác giả</span><span><?=$config['author']?></span></li>
                                <li><span>Version</span><span><?=$config['version']?></span></li>
                            </ul>
                        </div><!-- .team -->
                    </div><!-- .card-inner -->
                </div><!-- .card -->
                <br />
            </div><!-- .col -->
            <!--<div class="col-lg-3 col-md-12">
                <div class="card member-card">
                    <div class="header" style='background-image: url("<?/*=URL_HOME . '/' . PATH_PLUGIN . "$plugin/{$config['banner']}"*/?>"); background-size: 100% 100%; background-repeat: no-repeat'></div>
                    <div class="body">
                        <div class="col-12">
                            <h5 class="col-teal"><?/*=$config['name']*/?></h5>
                        </div>
                        <div class="col-12">
                            <p class="text-muted"><?/*=$config['description']*/?></p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <h6><?/*=$config['version']*/?></h6>
                                <small>VERSION</small>
                            </div>
                            <div class="col-5">
                                <h6><?/*=$config['website'] ? '<a href="'. $config['website'] .'" class="font-weight-bold text-danger">'. $config['author'] .'</a>' : '<span class="font-weight-bold text-danger">'. $config['author'] .'</span>'*/?></h6>
                                <small>TÁC GIẢ</small>
                            </div>
                            <div class="col-4">
                                <h6>
                                    <?/*=$config['status'] == 'active' ?
                                        '<button type="button" data-action="change_status" id="plugin_status" data-type="not_active" data-name="'. $plugin .'" class="btn btn-raised bg-teal waves-effect btn-sm">KÍCH HOẠT</button>':
                                        '<button type="button" data-action="change_status" id="plugin_status" data-type="active" data-name="'. $plugin .'" class="btn btn-raised bg-red waves-effect btn-sm">NGỪNG KÍCH HOẠT</button>'
                                    */?>
                                </h6>
                                <small>TRẠNG THÁI</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        <?php
        }
        ?>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}