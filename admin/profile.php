<?php
switch ($path[2]){
    default:
        if($_REQUEST['type'] == 'avatar' && $_REQUEST['submit']){
            if($_FILES['user_avatar']){
                require_once ABSPATH . 'includes/class/class.uploader.php';
                $path_upload        = 'content/uploads/avatar/'. $me['user_id'] .'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time()).'/';
                $uploader           = new Uploader();
                $data_upload        = $uploader->upload($_FILES['user_avatar'], array(
                    'limit'         => 1, //Maximum Limit of files. {null, Number}
                    'maxSize'       => 2, //Maximum Size of files {null, Number(in MB's)}
                    'extensions'    => ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                    'required'      => true, //Minimum one file is required for upload {Boolean}
                    'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                    'title'         => array('auto', 15), //New file name {null, String, Array} *please read documentation in README.md
                    'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                    'replace'       => false, //Replace the file if it already exists {Boolean}
                    'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                ));

                /*echo '<pre>';
                print_r($data_upload);
                echo '</pre>';
                break;*/

                if($data_upload['isSuccess']){
                    $data_images    =  $path_upload . $data_upload['data']['metas'][0]['name'];
                    $update_avatar  = new user($database);
                    $update_avatar  = $update_avatar->update_avatar($data_images);
                    if($update_avatar['response'] == 200){
                        $success = '<div class="alert alert-success">Đổi ảnh đại diện thành công.</div>';
                    }
                }
                if($data_upload['hasErrors']){
                    $error = '<div class="alert alert-danger">'. $data_upload['errors'][0][0] .'</div>';
                }
            }
        }
        $header['js']      = [
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title']    = 'Cập nhật hồ sơ';
        $header['toolbar']  = admin_breadcrumbs('Cập nhật hồ sơ', [URL_ADMIN . '/profile/' => 'Hồ sơ'],'Cập nhật hồ sơ');
        $user_role          = new meta($database, 'role');
        $user_role          = $user_role->get_data_select();
        require_once 'admin-header.php';
        ?>
        <div class="d-flex flex-row">
            <!--begin::Aside-->
            <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                <!--begin::Profile Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                            <div class="navi-item mb-2">
                                <a href="<?=URL_ADMIN . "/{$path[1]}"?>" class="navi-link py-4 <?=!$_REQUEST['type'] ? 'active' : ''?>">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Design/Layers.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
                                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text font-size-lg">Thông tin cá nhân</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="<?=URL_ADMIN . "/{$path[1]}?type=password"?>" class="navi-link py-4 <?=($_REQUEST['type'] == 'password' ? 'active' : '')?>">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Shield-user.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
                                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"></path>
                                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text font-size-lg">Đổi mật khẩu</span>
                                    <!--<span class="navi-label">
                                        <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                    </span>-->
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="<?=URL_ADMIN . "/{$path[1]}?type=avatar"?>" class="navi-link py-4 <?=($_REQUEST['type'] == 'avatar' ? 'active' : '')?>">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Contact1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 L7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </span>
                                    <span class="navi-text font-size-lg">Đổi Avatar</span>
                                </a>
                            </div>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Profile Card-->
            </div>
            <!--end::Aside-->
            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::Card-->
                <?php
                switch ($_REQUEST['type']){
                    case 'avatar':
                        ?>
                        <!--begin::Form-->
                        <form class="form" action="" method="post" enctype="multipart/form-data">
                        <div class="card card-custom">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">Đổi Avatar</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Thay đổi ảnh Avatar của bạn</span>
                                </div>
                                <div class="card-toolbar">
                                    <button type="submit" name="submit" value="submit" class="btn btn-success mr-2">Lưu thay đổi</button>
                                </div>
                            </div>
                            <!--end::Header-->
                                <div class="card-body text-center">
                                    <?=$success ? '<div class="text-center">'. $success .'</div>' : ''?>
                                    <?=$error ? '<div class="text-center">'. $error .'</div>' : ''?>
                                    <div class="image-input image-input-outline image-input-circle" id="kt_image_3">
                                        <div class="image-input-wrapper" style="background-image: url('<?=($me['user_avatar'] ? URL_HOME.'/'.$me['user_avatar'] : URL_HOME.'/'.get_config('avatar_default'))?>')"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input type="file" name="user_avatar" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="profile_avatar_remove" />
                                        </label>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    </div>
                                    <span class="form-text text-muted">Cho phép các định dạng File: png, jpg, jpeg và dưới 1Mb/file.</span>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                        <?php
                        break;
                    case 'password':
                        ?>
                        <div class="card card-custom">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">Đổi mật khẩu</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Thay đổi mật khẩu đăng nhập của bạn</span>
                                </div>
                                <div class="card-toolbar">
                                    <button type="submit" id="change_password" class="btn btn-success mr-2">Lưu thay đổi</button>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form class="form">
                                <div class="card-body">
                                    <!--begin::Alert-->
                                    <div class="alert alert-custom alert-light-danger fade show mb-10" role="alert">
                                        <div class="alert-icon">
                                    <span class="svg-icon svg-icon-3x svg-icon-danger">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Code/Info-circle.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"></rect>
                                                <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"></rect>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                        </div>
                                        <div class="alert-text font-weight-bold">Đổi mật khẩu không liên quan đến các mã Token, muốn đổi mã Token hãy vào tab Thông tin Token,
                                            <br>Sau khi đổi mật khẩu mới thành công bạn sẽ phải đăng nhập lại!</div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="ki ki-close"></i>
                                        </span>
                                            </button>
                                        </div>
                                    </div>
                                    <!--end::Alert-->
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Mật khẩu hiện tại</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" name="pass_old" class="form-control form-control-lg form-control-solid mb-2" value="" placeholder="Nhập mật khẩu hiện tại">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Mật khẩu mới</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" name="pass_new" class="form-control form-control-lg form-control-solid" value="" placeholder="Nhập mật khẩu mới">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Nhập lại mật khẩu mới</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" name="pass_renew" class="form-control form-control-lg form-control-solid" value="" placeholder="Nhập lại mật khẩu mới">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <?php
                        break;
                    default:
                        ?>
                        <div class="card card-custom">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">Thông tin tài khoản</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Thay đổi thông tin tài khoản của bạn</span>
                                </div>
                                <div class="card-toolbar">
                                    <button type="submit" id="button_update_me" class="btn btn-success mr-2">Lưu thay đổi</button>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form class="form">
                                <div class="card-body">
                                    <div class="row gy-4">
                                        <div class="col-lg-6">
                                            <?=formInputText('', [
                                                'label'         => 'Tên đăng nhập',
                                                'value'         => $me['user_login'],
                                                'disabled'      => 'disabled'
                                            ])?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?=formInputText('user_name', [
                                                'label'         => 'Tên hiển thị',
                                                'value'         => $me['user_name']
                                            ])?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?=formInputText('user_email', [
                                                'label'         => 'Email.',
                                                'placeholder'   => 'Nhập Email',
                                                'value'         => $me['user_email']
                                            ])?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?=formInputText('user_phone', [
                                                'label'         => 'Điện thoại.',
                                                'placeholder'   => 'Nhập số điện thoại',
                                                'value'         => $me['user_phone']
                                            ])?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <?php
                        break;
                }
                ?>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}