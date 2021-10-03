<?php
switch ($path[2]){
    default:
        $header['js']      = [
            URL_JS . "{$path[1]}"
        ];
        $header['title']    = 'Quản lý Plugin';
        $header['toolbar']  = admin_breadcrumbs('Plugin', [URL_ADMIN . "/{$path[1]}/" => 'Plugin'],'Quản lý');
        require_once 'admin-header.php';
        ?>
        <div class="row">
        <?php
        foreach (get_list_plugin() AS $plugin){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . "{$plugin}/config.json");
            $config = json_decode($config, true);
            ?>
            <!--begin::content-->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <!--begin::Card-->
                <div class="card card-custom gutter-b card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-7">
                            <!--begin::Pic-->
                            <div class="flex-shrink-0 mr-4">
                                <div class="symbol symbol-circle symbol-lg-75">
                                    <img src="<?=URL_HOME . '/' . PATH_PLUGIN . "$plugin/{$config['banner']}"?>" alt="image">
                                </div>
                            </div>
                            <!--end::Pic-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0"><?=$config['name']?></a>
                                <span class="text-muted font-weight-bold">@<?=$config['author']?></span>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::User-->
                        <!--begin::Desc-->
                        <p class="mb-7"><?=$config['description']?>.</p>
                        <!--end::Desc-->
                        <!--begin::Info-->
                        <div class="mb-7">
                            <div class="d-flex justify-content-between align-items-cente my-1">
                                <span class="text-dark-75 font-weight-bolder mr-2">Website</span>
                                <a href="#" class="text-muted text-hover-primary"><?=($config['website'] ? '<a href="'. $config['website'] .'" target="_blank">Đi đến Website</a>' : '---')?></a>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark-75 font-weight-bolder mr-2">Phiên bản:</span>
                                <a href="#" class="text-muted text-hover-primary"><?=$config['version']?></a>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark-75 font-weight-bolder mr-2">Trạng thái</span>
                                <span class="text-muted font-weight-bold"><?=$config['status'] == 'active' ? 'Đang hoạt động' : 'Chưa kích hoạt'?></span>
                            </div>
                        </div>
                        <!--end::Info-->
                        <?=$config['status'] == 'active' ? '<a href="javascript:;" data-action="change_status" id="plugin_status" data-type="not_active" data-name="'. $plugin .'" class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4">ĐÃ KÍCH HOẠT</a>' : '<a href="javascript:;" data-action="change_status" id="plugin_status" data-type="active" data-name="'. $plugin .'" class="btn btn-block btn-sm btn-light-danger font-weight-bolder text-uppercase py-4">CHƯA KÍCH HOẠT</a>'?>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end:: Card-->
            </div>
            <!--end::content-->

        <?php
        }
        ?>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}