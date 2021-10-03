<?php
require_once 'init.php';
if($me){
    redirect(URL_ADMIN);
}
?>
<!--begin::New-->
<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title>Đăng nhập | MultiCMS</title>
    <meta name="description" content="Đăng nhập hệ thống MultiCMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?=URL_ADMIN_ASSETS?>css/pages/login/login-4.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?=URL_ADMIN_ASSETS?>plugins/global/plugins.bundle.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>plugins/custom/prismjs/prismjs.bundle.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/style.bundle.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/header/base/light.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/header/menu/light.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/brand/dark.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <link href="<?=URL_ADMIN_ASSETS?>css/themes/layout/aside/dark.css?v=7.2.8" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="<?=URL_HOME."/content/assets/images/system/favicon.png"?>">
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Content-->
        <div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white">
            <!--begin::Wrapper-->
            <div class="login-content d-flex flex-column pt-lg-0 pt-12">
                <!--begin::Logo-->
                <a href="#" class="login-logo pb-xl-20 pb-15">
                    <img src="<?=get_config('logo')?>" class="max-h-70px" alt="" />
                </a>
                <!--end::Logo-->
                <!--begin::Signin-->
                <div class="login-form">
                    <!--begin::Form-->
                    <form class="form" id="sign_in" action="">
                        <!--begin::Title-->
                        <div class="pb-5 pb-lg-15">
                            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
                            <div class="text-muted font-weight-bold font-size-h4">New Here?
                                <a href="#" class="text-primary font-weight-bolder">Create Account</a></div>
                        </div>
                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Tên đăng nhập</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" name="user_login" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mật khẩu</label>
                                <a href="/metronic/demo1/custom/pages/login/login-4/forgot.html" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a>
                            </div>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="user_pass" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="submit_login" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Đăng Nhập</button>
                            <button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/social-icons/google.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M19.9895 10.1871C19.9895 9.36767 19.9214 8.76973 19.7742 8.14966H10.1992V11.848H15.8195C15.7062 12.7671 15.0943 14.1512 13.7346 15.0813L13.7155 15.2051L16.7429 17.4969L16.9527 17.5174C18.879 15.7789 19.9895 13.221 19.9895 10.1871Z" fill="#4285F4" />
                                    <path d="M10.1993 19.9313C12.9527 19.9313 15.2643 19.0454 16.9527 17.5174L13.7346 15.0813C12.8734 15.6682 11.7176 16.0779 10.1993 16.0779C7.50243 16.0779 5.21352 14.3395 4.39759 11.9366L4.27799 11.9466L1.13003 14.3273L1.08887 14.4391C2.76588 17.6945 6.21061 19.9313 10.1993 19.9313Z" fill="#34A853" />
                                    <path d="M4.39748 11.9366C4.18219 11.3166 4.05759 10.6521 4.05759 9.96565C4.05759 9.27909 4.18219 8.61473 4.38615 7.99466L4.38045 7.8626L1.19304 5.44366L1.08875 5.49214C0.397576 6.84305 0.000976562 8.36008 0.000976562 9.96565C0.000976562 11.5712 0.397576 13.0882 1.08875 14.4391L4.39748 11.9366Z" fill="#FBBC05" />
                                    <path d="M10.1993 3.85336C12.1142 3.85336 13.406 4.66168 14.1425 5.33717L17.0207 2.59107C15.253 0.985496 12.9527 0 10.1993 0C6.2106 0 2.76588 2.23672 1.08887 5.49214L4.38626 7.99466C5.21352 5.59183 7.50242 3.85336 10.1993 3.85336Z" fill="#EB4335" />
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Đăng nhập với Google</button>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--begin::Content-->
        <!--begin::Aside-->
        <div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right">
            <div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" style="background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/illustrations/login-visual-4.svg);">
                <!--begin::Aside title-->
                <h3 class="pt-lg-40 pl-lg-20 pb-lg-0 pl-10 py-20 m-0 d-flex justify-content-lg-start font-weight-boldest display5 display1-lg text-white">We Got
                    <br />A Surprise
                    <br />For You</h3>
                <!--end::Aside title-->
            </div>
        </div>
        <!--end::Aside-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="<?=URL_ADMIN_ASSETS?>plugins/global/plugins.bundle.js?v=7.2.8"></script>
<script src="<?=URL_ADMIN_ASSETS?>plugins/custom/prismjs/prismjs.bundle.js?v=7.2.8"></script>
<script src="<?=URL_ADMIN_ASSETS?>js/scripts.bundle.js?v=7.2.8"></script>
<!--end::Global Theme Bundle-->
<script>
    $(document).ready(function () {
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        $('#submit_login').on('click', function () {
            var ajax = $.ajax({
                url         : '<?=URL_ADMIN_AJAX . "login"?>',
                method      : 'POST',
                dataType    : 'json',
                data        : $('#sign_in').serialize(),
                beforeSend  : function () {
                    $('#submit_login').attr('disabled', true);
                    $('#submit_login').html('ĐANG ĐĂNG NHẬP');
                }
            });
            ajax.done(function (data) {
                if (data.response != 200){
                    setTimeout(function () {
                        toastr.error(data.message);
                        $('#submit_login').attr('disabled', false);
                        $('#submit_login').html('ĐĂNG NHẬP');
                    }, 500);
                } else {
                    setTimeout(function () {
                        /*
                        if($('#rememberme:checkbox:checked').length > 0){
                            setCookie('access_token', data.data.user_token, 30);
                        }
                        */
                        toastr.success(data.message);
                        $('#submit_login').attr('disabled', false);
                        $('#submit_login').html('ĐĂNG NHẬP');
                        setCookie('access_token', data.data.user_token, 30);
                        setTimeout(function () {
                            $(location).attr('href', '<?=isset($_REQUEST['ref']) ? $_REQUEST['ref'] : URL_ADMIN?>');
                        }, 500);
                    }, 500);
                }
            });

            ajax.fail(function( jqXHR, textStatus ) {
                setTimeout(function () {
                    $('#submit_login').attr('disabled', false);
                    $('#submit_login').html('ĐĂNG NHẬP');
                    alert("Request failed: " + jqXHR.responseText);
                }, 2000);
            });
        })
    })
</script>
</body>
<!--end::Body-->
</html>
<!--begin::New-->