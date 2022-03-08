<?php
switch ($path[2]){
    case 'send':
        if(!$role['momo']['send']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('#btsend').on('click', function (){
                let btnText     = $(this).text();
                let id          = '#' + $(this).attr('id');
                let textLoading = ' ĐANG CHUYỂN TIỀN ... ';
                let urlLoad     = '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>';

                var ajax = $.ajax({
                    url         : urlLoad,
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form').serialize(),
                    beforeSend  : function () {
                        $(id).attr('disabled', true);
                        $(id).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>'+ textLoading +'</span>');
                    }
                });
                ajax.done(function (data) {
                    setTimeout(function (){
                        if(data.response == 200){
                            $(id).attr('disabled', false);
                            $(id).html(btnText);
                            toastr.success(data.message);
                        }else{
                            $(id).attr('disabled', false);
                            $(id).html(btnText);
                            toastr.error(data.message);
                        }
                    }, 500)
                });
                ajax.fail(function( jqXHR, textStatus ) {
                    $(id).attr('disabled', false);
                    $(id).html(btnText);
                    toastr.error(jqXHR.responseText);
                });
            });
        });
        <?php
        break;
    case 'setting':
        if(!$role['momo']['manager']){
            exit('Forbidden');
        }
        $phone = $path[3];
        // Check số điện thoại có hợp lệ không
        $account = new MomoAccount();
        if(!$account->checkPhoneNumber($phone)){
            exit('Forbidden');
        }

        // Xem User Id và số điện thoại có cùng 1 người hay không
        if(!$account->checkPhoneByUserId($phone, $me['user_id'])){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            // Xóa tài khoản
            $('#button_update').on('click', function () {
                let account_setting_telegram    = $('#_account_setting_telegram').val();
                let account_setting_forward     = $('#_account_setting_forward').val();
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/setting"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'phone'                     : '<?=$phone?>',
                        'account_setting_telegram'  : account_setting_telegram,
                        'account_setting_forward'   : account_setting_forward
                    },
                    beforeSend  : function () {
                        $('#button_update').attr('disabled', true);
                        $('#button_update').html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span> Đang Cập Nhật ... </span>');
                    }
                });
                ajax.done(function (data) {
                    setTimeout(function (){
                        if(data.response == 200){
                            $('#button_update').attr('disabled', false);
                            $('#button_update').html('CẬP NHẬT');
                            toastr.success(data.message);
                        }else{
                            $('#button_update').attr('disabled', false);
                            $('#button_update').html('CẬP NHẬT');
                            toastr.error(data.message);
                        }
                    }, 500)
                });
                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_update').attr('disabled', false);
                    $('#button_update').html('CẬP NHẬT');
                    toastr.error(jqXHR.responseText);
                });
            });
        });
        <?php
        break;
    case 'history':
        if(!$role['momo']['history']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }
            $('#kt_datepicker_5').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                clearBtn: true,
                format: "dd-mm-yyyy",
                weekStart: 1,
                language: "vi",
                templates: arrows
            });
        });
        <?php
        break;
    case 'api':
        if(!$role['momo']['api']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
                e.clearSelection();
                toastr.success('Đã Copy mã Access Token');
            });
        });
        <?php
        break;
    case 'add':
        if(!$role['momo']['add']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('#_account_phone').maxlength({
                threshold: 5,
                warningClass: "label label-warning label-rounded label-inline",
                limitReachedClass: "label label-success label-rounded label-inline"
            });
            $('#_account_password').maxlength({
                threshold: 5,
                warningClass: "label label-warning label-rounded label-inline",
                limitReachedClass: "label label-success label-rounded label-inline"
            });
            $('#_account_otp').maxlength({
                threshold: 5,
                warningClass: "label label-warning label-rounded label-inline",
                limitReachedClass: "label label-success label-rounded label-inline"
            });

            // Gửi OTP
            $('#button_get_otp').on('click', function (){
                var account_phone = $('#_account_phone').val();
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/add/sendotp"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {'account_phone' : account_phone},
                    beforeSend  : function () {
                        $('#button_get_otp').attr('disabled', true);
                        $('#button_get_otp').html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span> Đang gửi OTP ... </span>');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        toastr.success('Gửi mã OTP đến số điện thoại ' + account_phone + ' thành công.');
                        setTimeout(function (){
                            $('#input_otp').show('slow');
                            $('#button_get_otp').hide();
                            $('#input_button_save').show();
                            $('#_account_phone').prop('disabled', true);
                        }, 500);
                    }else{
                        $('#button_get_otp').attr('disabled', false);
                        $('#button_get_otp').html('Lấy Mã OTP');
                        toastr.error(data.message);
                    }
                });
                ajax.fail(function( jqXHR, textStatus ) {
                    console.log("Request failed: " + textStatus );
                });
            });

            // Lưu tài khoản
            $('#button_save_account').on('click', function () {
                var account_phone       = $('#_account_phone').val();
                var account_otp         = $('#_account_otp').val();
                var account_password    = $('#_account_password').val();
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/add/save_account"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {'account_phone' : account_phone, 'account_otp' : account_otp, 'account_password' : account_password},
                    beforeSend  : function () {
                        $('#button_save_account').attr('disabled', true);
                        $('#button_save_account').html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span> Đang lưu dữ liệu ... </span>');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        $('#button_save_account').attr('disabled', false);
                        $('#button_save_account').html('Lưu Tài Khoản');
                        toastr.success(data.message);
                    }else{
                        $('#button_save_account').attr('disabled', false);
                        $('#button_save_account').html('Lưu Tài Khoản');
                        toastr.error(data.message);
                    }
                });
                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_save_account').attr('disabled', false);
                    $('#button_save_account').html('Lưu Tài Khoản');
                    console.log("Request failed: " + textStatus );
                });
            });
        });
        <?php
        break;
    default:
        if(!$role['momo']['manager']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            // Xóa tài khoản
            $('a[data-type=delete]').on('click', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Xóa tài khoản liên kết",
                    text: "Bạn có muốn xóa tài khoản MOMO này không?",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Không xóa',
                    confirmButtonText: 'Xóa luôn',
                    showLoaderOnConfirm: true,
                }).then(function (result) {
                    if (result.value) {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/delete/{$path[2]}"?>' + id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                Swal.fire("Xóa tài khoản liên kết", "Xóa tài khoản thành công!", "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 500);
                            }else{
                                Swal.fire("Xóa tài khoản liên kết", data.message, "error");
                            }
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            console.log("Request failed: " + textStatus );
                        });
                    }
                });
            });
        });
        <?php
        break;
}