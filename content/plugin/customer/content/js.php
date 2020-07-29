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
    default:
        ?>
        //<script>
        $(document).ready(function () {
            $('a[data-type=delete]').on('click', function () {
                var id = $(this).data('id');
                swal({
                    title: "Xóa khách hàng, đối tác",
                    text: "Bạn có chắc chắn muốn xóa khách hàng, đối tác này không? sau khi xóa dữ liệu sẽ không thể khôi phục được!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    setTimeout(function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>delete/' + id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                swal("Xóa khách hàng, đối tác", "Xóa khách hàng, đối tác thành công!", "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }else{
                                swal("Xóa khách hàng, đối tác", data.message, "error");
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