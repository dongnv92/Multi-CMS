<?php
switch ($path[2]){
    case 'add':
        if(!$me) {
            exit('Error');
        }
        if(!$role['customer']['add']){
            exit('Error');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('#button_add').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form').serialize(),
                    beforeSend  : function () {
                        $('#button_add').attr('disabled', true);
                        $('#button_add').html('ĐANG THÊM ...');
                    }
                });
                ajax.done(function (data) {
                    setTimeout(function () {
                        if(data.response == 200){
                            show_notify(data.message, 'bg-green');
                            $('#button_add').attr('disabled', false);
                            $('#button_add').html('THÊM');
                        }else{
                            show_notify(data.message, 'bg-red');
                            $('#button_add').attr('disabled', false);
                            $('#button_add').html('THÊM');
                        }
                    }, 2000);
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_add').attr('disabled', false);
                    $('#button_add').html('THÊM');
                    alert( "Request failed: " + textStatus );
                });
            });
        });
        <?php
        break;
        case 'update':
        // Kiểm tra đăng nhập
        if(!$me) {
            exit('Error');
        }
        // Kiểm tra quyền truy cập
        if(!$role['customer']['update']){
            exit('Error');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('#button_update').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form').serialize(),
                    beforeSend  : function () {
                        $('#button_update').attr('disabled', true);
                        $('#button_update').html('ĐANG CẬP NHẬT ...');
                    }
                });
                ajax.done(function (data) {
                    setTimeout(function () {
                        if(data.response == 200){
                            show_notify(data.message, 'bg-green');
                            $('#button_update').attr('disabled', false);
                            $('#button_update').html('CẬP NHẬT');
                        }else{
                            show_notify(data.message, 'bg-red');
                            $('#button_update').attr('disabled', false);
                            $('#button_update').html('CẬP NHẬT');
                        }
                    }, 2000);
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_update').attr('disabled', false);
                    $('#button_update').html('CẬP NHẬT');
                    alert( "Request failed: " + jqXHR.responseText);
                });
            });
        });
    <?php
    break;
}