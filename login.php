<?php
require_once 'init.php';
if($me){
    redirect(URL_ADMIN);
}
?>
<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Đăng nhập hệ thống.">
    <title>Đăng Nhập</title>
    <!-- Favicon-->
    <link rel="icon" href="<?=URL_ADMIN_ASSETS?>images/favicon.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>css/main.css">
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>css/authentication.css">
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>css/color_skins.css">
</head>
<body class="theme-orange">
<div class="authentication">
    <div class="card">
        <div class="body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header slideDown">
                        <div class="logo">
                            <a href="<?=URL_HOME?>"><img src="<?=get_config('logo')?>" style="max-height: 50px" alt="Logo"></a>
                        </div>
                        <h1 class="text-white">MULTICMS LOGIN</h1>
                    </div>
                </div>
                <form class="col-lg-12" id="sign_in" method="POST">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" value="" name="user_login" required>
                            <label class="form-label">Tên Đăng Nhập</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" name="user_pass" value="" class="form-control" required>
                            <label class="form-label">Mật Khẩu</label>
                        </div>
                    </div>
                    <div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4 text-left align-middle">
                            <input type="checkbox" name="rememberme" id="rememberme" value="1" class="filled-in chk-col-cyan">
                            <label for="rememberme">Ghi Nhớ</label>
                        </div>
                        <div class="col-lg-8 text-right">
                            <?=formButton('ĐĂNG NHẬP', ['type' => 'submit', 'name' => 'submit', 'value' => 'submit', 'id' => 'submit_login'])?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Jquery Core Js -->
<script src="<?=URL_ADMIN_ASSETS?>bundles/libscripts.bundle.js"></script>
<script src="<?=URL_ADMIN_ASSETS?>bundles/vendorscripts.bundle.js"></script>
<script src="<?=URL_ADMIN_ASSETS?>bundles/mainscripts.bundle.js"></script>
<script src="<?=URL_ADMIN_ASSETS?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
<script src="<?=URL_ADMIN_ASSETS?>js/init.js"></script>

<script>
    $(document).ready(function () {
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
                        show_notify(data.message, 'bg-red');
                        $('#submit_login').attr('disabled', false);
                        $('#submit_login').html('ĐĂNG NHẬP');
                    }, 2000);
                } else {
                    setTimeout(function () {
                        show_notify(data.message, 'bg-green');
                        $('#submit_login').attr('disabled', false);
                        $('#submit_login').html('ĐĂNG NHẬP');
                        setTimeout(function () {
                            $(location).attr('href', '<?=URL_ADMIN?>');
                        }, 2000);
                    }, 2000);
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
</html>