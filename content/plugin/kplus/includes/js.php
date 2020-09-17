<?php
switch ($path[2]) {
    case 'update':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
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
                    if(data.response == 200){
                        show_notify(data.message, 'bg-green');
                        $('#button_update').attr('disabled', false);
                        $('#button_update').html('CẬP NHẬT');
                    }else{
                        show_notify(data.message, 'bg-red');
                        $('#button_update').attr('disabled', false);
                        $('#button_update').html('CẬP NHẬT');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_update').attr('disabled', false);
                    $('#button_update').html('CẬP NHẬT');
                    alert( "Request failed: " + jqXHR.responseText );
                });
            })
        });
        <?php
        break;
    case 'add':
        if(!$role['kplus']['add']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('#button_adds').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/adds"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form[id="adds"]').serialize(),
                    beforeSend  : function () {
                        $('#button_adds').attr('disabled', true);
                        $('#button_adds').html('ĐANG THÊM ...');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        show_notify(data.message, 'bg-green');
                        $('#button_adds').attr('disabled', false);
                        $('#button_adds').html('THÊM MỚI');
                    }else{
                        show_notify(data.message, 'bg-red');
                        $('#button_adds').attr('disabled', false);
                        $('#button_adds').html('THÊM MỚI');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_adds').attr('disabled', false);
                    $('#button_adds').html('THÊM MỚI');
                    alert( "Request failed: " + jqXHR.responseText );
                });
            });

            $('#button_add').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form[id="add"]').serialize(),
                    beforeSend  : function () {
                        $('#button_add').attr('disabled', true);
                        $('#button_add').html('ĐANG THÊM ...');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        show_notify(data.message, 'bg-green');
                        $('#button_add').attr('disabled', false);
                        $('#button_add').html('THÊM MỚI');
                    }else{
                        show_notify(data.message, 'bg-red');
                        $('#button_add').attr('disabled', false);
                        $('#button_add').html('THÊM MỚI');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_add').attr('disabled', false);
                    $('#button_add').html('THÊM MỚI');
                    alert( "Request failed: " + jqXHR.responseText );
                });
            })
        });
        <?php
        break;
    default:
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            // Delete
            $('a[data-type=delete]').on('click', function () {
                var kpkus_code = $(this).data('id');
                swal({
                    title: "Xóa thẻ đầu thu",
                    text: "Bạn có chắc chắn muốn xóa thẻ này không? sau khi xóa dữ liệu sẽ không thể khôi phục được!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    setTimeout(function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>delete/' + kpkus_code,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                swal("Xóa thẻ", 'Xóa thẻ thành công', "success");
                                location.reload();
                            }else{
                                swal("Xóa thẻ", data.message, "error");
                            }
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            console.log("Request failed: " + textStatus );
                        });
                    }, 2000);
                });
            });

            // Update Status
            $('a[data-type=update_status]').on('click', function () {
                var kplus_code      = $(this).data('id');
                var kplus_status    = $(this).data('status');
                swal({
                    title: "Cập nhật trạng thái",
                    text: "Bạn có chắc chắn muốn cập nhật trạng thái thẻ này không?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    setTimeout(function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>update_status/' + kplus_code + '/' + kplus_status,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                swal("Cập nhật trạng thái", 'Cập nhật trạng thái thành công', "success");
                                location.reload();
                            }else{
                                swal("Cập nhật trạng thái", data.message, "error");
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