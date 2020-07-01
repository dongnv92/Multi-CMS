<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';
// Check login
if(!$me){
    redirect(URL_LOGIN.'?ref=' . get_current_url());
}

switch ($path[2]){
    case 'category':
        switch ($path[3]){
            case 'add':
                $header['js']      = [
                    URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
                    URL_JS . "{$path[1]}/{$path[2]}/{$path[3]}"
                ];
                $header['title']    = 'Thêm chuyên mục bài viết';
                require_once 'admin-header.php';
                echo admin_breadcrumbs('Chuyên mục', 'Thêm chuyên mục bài viết','Thêm chuyên mục', [URL_ADMIN . '/blog/' => 'Bài viết', URL_ADMIN . '/blog/category' => 'Chuyên mục']);
                echo formOpen('', ['method' => 'POST']);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h2>Thêm chuyên mục</h2>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <a href="<?=URL_ADMIN."/{$path[1]}/"?>" class="btn btn-raised bg-blue waves-effect">DANH SÁCH</a>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?=formInputText('user_login', [
                                            'label'         => 'Tên đăng nhập. <code>*</code>',
                                            'placeholder'   => 'Nhập tên đăng nhập',
                                            'autofocus'     => ''
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputText('user_name', [
                                            'label'         => 'Tên hiển thị. <code>*</code>',
                                            'placeholder'   => 'Nhập tên hiển thị'
                                        ])?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?=formInputPassword('user_password', [
                                            'label'         => 'Mật khẩu. <code>*</code>',
                                            'placeholder'   => 'Nhập mật khẩu',
                                            'autocomplete'  => 'new-password'
                                        ])?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=formInputPassword('user_repass', [
                                            'label'         => 'Nhập lại mật khẩu. <code>*</code>',
                                            'placeholder'   => 'Nhập lại mật khẩu'
                                        ])?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?=formInputText('user_email', [
                                            'label'         => 'Email.',
                                            'placeholder'   => 'Nhập Email'
                                        ])?>
                                    </div>
                                    <div class="col-lg-4">
                                        <?=formInputText('user_phone', [
                                            'label'         => 'Nhập số điện thoại.',
                                            'placeholder'   => 'Nhập số điện thoại'
                                        ])?>
                                    </div>
                                    <div class="col-lg-4">
                                        <?=formInputSelect('user_role', $user_role, [
                                                'label'             => 'Vai trò <code>*</code>',
                                                'data-live-search'  => 'true']
                                        )?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <?=formButton('THÊM THÀNH VIÊN', [
                                            'id'    => 'button_add_user',
                                            'class' => 'btn btn-raised bg-blue waves-effect'
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo formClose();
                require_once 'admin-footer.php';
                break;
        }
        break;
}