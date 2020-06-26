<?php
require '../init.php';
header('Content-type: application/javascript; charset=utf-8');
switch ($path[1]){
    case 'user':
        switch ($path[2]){
            case 'role':
                switch ($path[3]){
                    case 'update':
                        ?>
                        //<script>
                        $(document).ready(function () {
                            $('#button_update_role').on('click', function () {
                                var ajax = $.ajax({
                                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"?>',
                                    method      : 'POST',
                                    dataType    : 'json',
                                    data        : $('form').serialize(),
                                    beforeSend  : function () {
                                        $('#button_update_role').attr('disabled', true);
                                        $('#button_update_role').html('ĐANG CẬP NHẬT ...');
                                    }
                                });
                                ajax.done(function (data) {
                                    setTimeout(function () {
                                        if(data.response == 200){
                                            show_notify(data.message, 'bg-green');
                                            $('#button_update_role').attr('disabled', false);
                                            $('#button_update_role').html('CẬP NHẬT');
                                        }else{
                                            show_notify(data.message, 'bg-red');
                                            $('#button_update_role').attr('disabled', false);
                                            $('#button_update_role').html('CẬP NHẬT');
                                        }
                                    }, 2000);
                                });

                                ajax.fail(function( jqXHR, textStatus ) {
                                    $('#button_update_role').attr('disabled', false);
                                    $('#button_update_role').html('CẬP NHẬT');
                                    alert( "Request failed: " + textStatus );
                                });
                            });
                        });
                        <?php
                        break;
                    case 'add':
                        ?>
                        //<script>
                        $(document).ready(function () {
                            $('#button_add_role').on('click', function () {
                                var ajax = $.ajax({
                                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                                    method      : 'POST',
                                    dataType    : 'json',
                                    data        : $('form').serialize(),
                                    beforeSend  : function () {
                                        $('#button_add_role').attr('disabled', true);
                                        $('#button_add_role').html('ĐANG THÊM VAI TRÒ ...');
                                    }
                                });
                                ajax.done(function (data) {
                                    setTimeout(function () {
                                        if(data.response == 200){
                                            show_notify(data.message, 'bg-green');
                                            $('#button_add_role').attr('disabled', false);
                                            $('#button_add_role').html('THÊM');
                                        }else{
                                            show_notify(data.message, 'bg-red');
                                            $('#button_add_role').attr('disabled', false);
                                            $('#button_add_role').html('THÊM');
                                        }
                                    }, 2000);
                                });

                                ajax.fail(function( jqXHR, textStatus ) {
                                    $('#button_add_role').attr('disabled', false);
                                    $('#button_add_role').html('THÊM');
                                    alert( "Request failed: " + textStatus );
                                });
                            });
                        });
                        <?php
                        break;
                    default:
                        ?>
                        //<script>
                        $(document).ready(function () {
                            $('a[data-type=delete]').on('click', function () {
                                var id = $(this).data('id');
                                swal({
                                    title: "Xóa vai trò thành viên",
                                    text: "Bạn có muốn xóa vai trò thanh viên này không?",
                                    type: "warning",
                                    showCancelButton: true,
                                    closeOnConfirm: false,
                                    showLoaderOnConfirm: true,
                                }, function () {
                                    setTimeout(function () {
                                        var ajax = $.ajax({
                                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>/delete/' + id,
                                            method      : 'POST',
                                            dataType    : 'json',
                                        });
                                        ajax.done(function (data) {
                                            if(data.response == 200){
                                                swal("Xóa vai trò thành viên", "Xóa vai trò thành viên thành công!", "success");
                                                setTimeout(function () {
                                                    location.reload();
                                                }, 2000);
                                            }else{
                                                swal("Xóa vai trò thành viên", data.message, "error");
                                            }
                                        });
                                        ajax.fail(function( jqXHR, textStatus ) {
                                            console.log("Request failed: " + textStatus );
                                        });
                                    }, 2000);
                                });
                            });
                        });
                        <?php
                        break;
                }
                break;
        }
        break;
}