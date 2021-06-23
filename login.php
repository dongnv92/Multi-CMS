<?php
require_once 'init.php';
if($me){
    redirect(URL_ADMIN);
}
?>
<!-- New -->
<!DOCTYPE html>
<html lang="vi" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Đăng nhập hệ thống.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=URL_HOME."/content/assets/images/system/favicon.png"?>">
    <!-- Page Title  -->
    <title>Đăng Nhập</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>assets/css/dashlite.css?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>assets/css/theme.css?ver=2.2.0">
</head>
<body class="nk-body bg-white npc-general pg-auth">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                    <div class="brand-logo pb-4 text-center">
                        <a href="<?=URL_HOME?>" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="<?=get_config('logo')?>" srcset="<?=get_config('logo')?> 2x" alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="<?=get_config('logo')?>" srcset="<?=get_config('logo')?> 2x" alt="logo-dark">
                        </a>
                    </div>
                    <div class="card card-bordered">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Đăng Nhập</h4>
                                    <div class="nk-block-des">
                                        <p>Đăng nhập vào hệ thống.</p>
                                    </div>
                                </div>
                            </div>
                            <form action="<?=URL_HOME?>" method="post" id="sign_in">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Email hoặc Tên đăng nhập</label>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="user_login" id="default-01" placeholder="Nhập Email hoặc tên đăng nhập">
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Mật Khẩu</label>
                                        <a class="link link-primary link-sm" href="#">Quên mật khẩu?</a>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" name="user_pass" id="password" placeholder="Nhập mật khẩu">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="sunmit" id="submit_login">Đăng Nhập</button>
                                </div>
                            </form>
                            <div class="form-note-s2 text-center pt-4"> Đăng nhập với? <a href="#">Tạo tài khoản mới</a>
                            </div>
                            <div class="text-center pt-4 pb-3">
                                <h6 class="overline-title overline-title-sap"><span>Hoặc</span></h6>
                            </div>
                            <ul class="nav justify-center gx-4">
                                <li class="nav-item"><a class="nav-link" href="#">Facebook</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Google</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="nk-footer nk-auth-footer-full">
                    <div class="container wide-lg">
                        <div class="row g-3">
                            <div class="col-lg-6 order-lg-last">
                                <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Quy định sử dụng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Pháp lý</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Hỗ trợ</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <div class="nk-block-content text-center text-lg-left">
                                    <p class="text-soft">&copy; 20121 All Rights Reserved By Dong Nguyen.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="<?=URL_ADMIN_ASSETS?>assets/js/bundle.js?ver=2.2.0"></script>
<script src="<?=URL_ADMIN_ASSETS?>assets/js/scripts.js?ver=2.2.0"></script>
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
                    $('#submit_login').html('ĐANG ĐĂNG NHẬP ...');
                }
            });
            ajax.done(function (data) {
                if (data.response != 200){
                    setTimeout(function () {
                        toastr.clear();
                        NioApp.Toast(data.message, 'error',{
                            position: 'top-right'
                        });
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
                        toastr.clear();
                        NioApp.Toast(data.message, 'success',{
                            position: 'top-right'
                        });
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
</html>
<!-- New -->