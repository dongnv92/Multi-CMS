<?php
require_once 'init.php';
if($me){
    redirect(URL_ADMIN);
}
?>

<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="vi">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title>Đăng Nhập</title>
    <meta name="description" content="Đăng nhập hệ thống" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="<?=URL_HOME?>" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?=URL_ADMIN_ASSETS?>css/pages/login/classic/login-3.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?=URL_ADMIN_ASSETS?>plugins/global/plugins.bundle.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>plugins/custom/prismjs/prismjs.bundle.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/style.bundle.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/header/base/light.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/header/menu/light.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/brand/dark.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/aside/dark.css?v=7.2.9" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="<?=URL_ADMIN_ASSETS?>media/logos/favicon.ico" />
    <!-- Hotjar Tracking Code for keenthemes.com -->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(<?=URL_ADMIN_ASSETS?>media/bg/bg-1.jpg);">
            <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="<?=get_config('logo')?>" class="max-h-100px" alt="" />
                    </a>
                </div>
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="login-signin">
                    <div class="mb-20">
                        <h3>Đăng Nhập Hệ Thống</h3>
                        <p class="opacity-60 font-weight-bold">Nhập tên đăng nhập và mật khẩu để đăng nhập:</p>
                    </div>
                    <form class="form" id="kt_login_signin_form">
                        <div class="form-group">
                            <input class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5" type="text" placeholder="Tên đăng nhập" name="user_login" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5" type="password" placeholder="Mật khẩu" name="user_pass" />
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                                    <input type="checkbox" name="remember" checked />
                                    <span></span>Ghi nhớ đăng nhập</label>
                            </div>
                            <a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Quên mật khẩu ?</a>
                        </div>
                        <div class="form-group text-center mt-10">
                            <button id="submit_login" class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3">Đăng Nhập</button>
                        </div>
                    </form>
                    <div class="mt-10">
                        <span class="opacity-70 mr-4">Nếu bạn chưa có tài khoản?</span>
                        <a href="javascript:;" id="kt_login_signup" class="text-white font-weight-bold">Đăng Ký</a>
                    </div>
                </div>
                <!--end::Login Sign in form-->
                <!--begin::Login Sign up form-->
                <div class="login-signup">
                    <div class="mb-20">
                        <h3>Đăng Ký</h3>
                        <p class="opacity-60">Đăng ký tài khoản mới</p>
                    </div>
                    <form class="form text-center" id="add">
                        <div class="form-group">
                            <input autocomplete="new-password" class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="text" placeholder="Tên đăng nhập" name="user_login" />
                        </div>
                        <div class="form-group">
                            <input autocomplete="new-password" class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="user_email" />
                        </div>
                        <div class="form-group">
                            <input autocomplete="new-password" class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="password" placeholder="Mật khẩu" name="user_password" />
                        </div>
                        <div class="form-group">
                            <input autocomplete="new-password" class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="password" placeholder="Nhập lại mật khẩu" name="user_repass" />
                        </div>
                        <div class="form-group text-left px-8">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                                    <input type="checkbox" name="agree" />
                                    <span></span>Tôi đồng ý với
                                    <a href="#" class="text-white font-weight-bold ml-1">các quy định và điều khoản</a>.</label>
                            </div>
                            <div class="form-text text-muted text-center"></div>
                        </div>
                        <div class="form-group">
                            <button id="kt_login_signup_submit" class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3 m-2">Đăng Ký</button>
                            <button id="kt_login_signup_cancel" class="btn btn-pill btn-outline-white font-weight-bold opacity-70 px-15 py-3 m-2">Đăng Nhập</button>
                        </div>
                    </form>
                </div>
                <!--end::Login Sign up form-->
                <!--begin::Login forgot password form-->
                <div class="login-forgot">
                    <div class="mb-20">
                        <h3>Quên mật khẩu ?</h3>
                        <p class="opacity-60">Nhập Email để lấy lại mật khẩu</p>
                    </div>
                    <form class="form" id="kt_login_forgot_form">
                        <div class="form-group mb-10">
                            <input class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <button id="kt_login_forgot_submit" class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3 m-2">Gửi thông tin</button>
                            <button id="kt_login_forgot_cancel" class="btn btn-pill btn-outline-white font-weight-bold opacity-70 px-15 py-3 m-2">Quay lại</button>
                        </div>
                    </form>
                </div>
                <!--end::Login forgot password form-->
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="<?=URL_ADMIN_ASSETS?>plugins/global/plugins.bundle.js?v=7.2.9"></script>
<script src="<?=URL_ADMIN_ASSETS?>plugins/custom/prismjs/prismjs.bundle.js?v=7.2.9"></script>
<script src="<?=URL_ADMIN_ASSETS?>js/scripts.bundle.js?v=7.2.9"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="<?=URL_ADMIN_ASSETS?>js/pages/custom/login/login-general.js?v=7.2.9"></script>
<!--end::Page Scripts-->
<script>
    $(document).ready(function () {
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        $('#submit_login').on('click', function () {
            let btnText     = $(this).text();
            let id          = '#' + $(this).attr('id');
            let textLoading = ' Đang Đăng Nhập ... ';
            let urlLoad     = '<?=URL_ADMIN_AJAX . "login"?>';

            var ajax = $.ajax({
                url         : urlLoad,
                method      : 'POST',
                dataType    : 'json',
                data        : $('#kt_login_signin_form').serialize(),
                beforeSend  : function () {
                    $(id).attr('disabled', true);
                    $(id).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>'+ textLoading +'</span>');
                }
            });
            ajax.done(function (data) {
                if (data.response != 200){
                    setTimeout(function () {
                        toastr.error(data.message);
                        $(id).attr('disabled', false);
                        $(id).html(btnText);
                    }, 500);
                } else {
                    setTimeout(function () {
                        /*
                        if($('#rememberme:checkbox:checked').length > 0){
                            setCookie('access_token', data.data.user_token, 30);
                        }
                        */
                        toastr.success(data.message);
                        $(id).attr('disabled', false);
                        $(id).html(btnText);
                        setCookie('access_token', data.data.user_token, 30);
                        setTimeout(function () {
                            $(location).attr('href', '<?=isset($_REQUEST['ref']) ? $_REQUEST['ref'] : URL_ADMIN?>');
                        }, 500);
                    }, 500);
                }
            });

            ajax.fail(function( jqXHR, textStatus ) {
                setTimeout(function () {
                    $(id).attr('disabled', false);
                    $(id).html(btnText);
                    alert("Request failed: " + jqXHR.responseText);
                }, 2000);
            });
        });

        // Đăng ký
        $('#kt_login_signup_submit').on('click', function () {
            let btnText     = $(this).text();
            let id          = '#' + $(this).attr('id');
            let textLoading = ' Vui lòng chờ ... ';
            let urlLoad     = '<?=URL_ADMIN_AJAX . "add"?>';

            var ajax = $.ajax({
                url         : urlLoad,
                method      : 'POST',
                dataType    : 'json',
                data        : $('#add').serialize(),
                beforeSend  : function () {
                    $(id).attr('disabled', true);
                    $(id).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>'+ textLoading +'</span>');
                }
            });
            ajax.done(function (data) {
                if (data.response != 200){
                    setTimeout(function () {
                        toastr.error(data.message);
                        $(id).attr('disabled', false);
                        $(id).html(btnText);
                    }, 500);
                } else {
                    setTimeout(function () {
                        /*
                        if($('#rememberme:checkbox:checked').length > 0){
                            setCookie('access_token', data.data.user_token, 30);
                        }
                        */
                        toastr.success(data.message);
                        $(id).attr('disabled', false);
                        $(id).html(btnText);
                        setCookie('access_token', data.data.user_token, 30);
                        setTimeout(function () {
                            $(location).attr('href', '<?=isset($_REQUEST['ref']) ? $_REQUEST['ref'] : URL_ADMIN?>');
                        }, 500);
                    }, 500);
                }
            });

            ajax.fail(function( jqXHR, textStatus ) {
                setTimeout(function () {
                    $(id).attr('disabled', false);
                    $(id).html(btnText);
                    alert("Request failed: " + jqXHR.responseText);
                }, 2000);
            });
        });
    })
</script>
</body>
<!--end::Body-->
</html>