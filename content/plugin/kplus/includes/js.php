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
                        $('#button_update').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Đang cập nhật ... </span>');
                    }
                });
                ajax.done(function (data) {
                    setTimeout(function (){
                        if(data.response == 200){
                            NioApp.Toast(data.message, 'success',{
                                ui: 'is-dark',
                                position: 'top-right'
                            });
                            $('#button_update').attr('disabled', false);
                            $('#button_update').html('CẬP NHẬT');
                        }else{
                            NioApp.Toast(data.message, 'error',{
                                ui: 'is-dark',
                                position: 'top-right'
                            });
                            $('#button_update').attr('disabled', false);
                            $('#button_update').html('CẬP NHẬT');
                        }
                    }, 1000)
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
            $('#button_checkname').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/check_name"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form[id="add"]').serialize(),
                    beforeSend  : function () {
                        $('#button_checkname').attr('disabled', true);
                        $('#button_checkname').html('ĐANG KIỂM TRA ...');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        toastr.clear();
                        NioApp.Toast(data.message, 'success',{
                            position: 'bottom-right'
                        });
                        $('#button_checkname').attr('disabled', false);
                        $('#button_checkname').html('CHECK NAME');
                    }else{
                        toastr.clear();
                        NioApp.Toast(data.message, 'error',{
                            position: 'top-right'
                        });
                        $('#button_checkname').attr('disabled', false);
                        $('#button_checkname').html('CHECK NAME');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_checkname').attr('disabled', false);
                    $('#button_checkname').html('CHECK NAME');
                    alert( "Request failed: " + jqXHR.responseText );
                });
            });

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
                        toastr.clear();
                        NioApp.Toast(data.message, 'success',{
                            position: 'top-right'
                        });
                        $('#button_adds').attr('disabled', false);
                        $('#button_adds').html('THÊM MỚI');
                    }else{
                        toastr.clear();
                        NioApp.Toast(data.message, 'error',{
                            position: 'top-right'
                        });
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
                        toastr.clear();
                        NioApp.Toast(data.message, 'success',{
                            position: 'top-right'
                        });
                        $('#button_add').attr('disabled', false);
                        $('#button_add').html('THÊM MỚI');
                        $('input[name="kplus_code"]').val('');
                        $('input[name="kplus_expired"]').val('');
                    }else{
                        toastr.clear();
                        NioApp.Toast(data.message, 'error',{
                            position: 'top-right'
                        });
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
            // Verify
            $('a[data-type=update_verify]').on('click', function () {
                var id = $(this).data('id');
                swal.fire({
                    title: "Cập nhật trạng thái đã check",
                    text: "Bạn có muốn cập nhật trạng thái đã check không?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    cancelButtonText: 'Bỏ',
                    confirmButtonText: 'Cập nhật'
                }). then(function (result) {
                    if(result){
                        setTimeout(function () {
                            var ajax = $.ajax({
                                url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/update_verify/"?>' + id,
                                method      : 'POST',
                                dataType    : 'json',
                            });
                            ajax.done(function (data) {
                                if(data.response == 200){
                                    swal.fire("Cập nhật trạng thái xác nhận", data.message, "success");
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1500);
                                }else{
                                    swal.fire("Cập nhật trạng thái xác nhận", data.message, "error");
                                }
                            });
                            ajax.fail(function( jqXHR, textStatus ) {
                                console.log("Request failed: " + textStatus );
                            });
                        }, 1500);
                    }
                });
            });

            // Paid
            $('#confirm_paid').on('click', function () {
                var id = $(this).data('id');
                swal({
                    title: "Cập nhật thanh toán",
                    text: "Bạn có muốn xác nhận thanh toán không?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    setTimeout(function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/paid/"?>' + id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                swal("Cập nhật thanh toán", "Cập nhật thanh toán thành công!", "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }else{
                                swal("Cập nhật thanh toán", data.message, "error");
                            }
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            console.log("Request failed: " + textStatus );
                        });
                    }, 2000);
                });
            });

            // Delete
            $('a[data-type=delete]').on('click', function (e) {
                var kpkus_code = $(this).data('id');
                Swal.fire({
                    title: "Xóa thẻ đầu thu",
                    text: "Bạn có chắc chắn muốn xóa thẻ này không? sau khi xóa dữ liệu sẽ không thể khôi phục được!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    showLoaderOnConfirm: true,
                }).then(function (result) {
                    if (result.value) {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>delete/' + kpkus_code,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                Swal.fire("Xóa thẻ đầu thu", "Xoá mã thẻ đầu thu thành công!", "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }else{
                                Swal.fire("Xóa thẻ đầu thu", data.message, "error");
                            }
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            console.log("Request failed: " + textStatus );
                        });
                    }
                });
                e.preventDefault();
            });

            // Update Status
            $('a[data-type=update_status]').on('click', function () {
                var kplus_code      = $(this).data('id');
                var kplus_status    = $(this).data('status');
                swal.fire({
                    title: "Cập nhật trạng thái",
                    text: "Bạn có chắc chắn muốn cập nhật trạng thái thẻ này không?",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Bỏ',
                    confirmButtonText: 'Cập nhật',
                    showLoaderOnConfirm: true,
                }).then(function (result) {
                    if(result.value){
                        setTimeout(function () {
                            var ajax = $.ajax({
                                url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>update_status/' + kplus_code + '/' + kplus_status,
                                method      : 'POST',
                                dataType    : 'json',
                            });
                            ajax.done(function (data) {
                                if(data.response == 200){
                                    swal.fire("Cập nhật trạng thái", 'Cập nhật trạng thái thành công', "success");
                                    location.reload();
                                }else{
                                    swal.fire("Cập nhật trạng thái", data.message, "error");
                                }
                            });
                            ajax.fail(function( jqXHR, textStatus ) {
                                console.log("Request failed: " + textStatus );
                            });
                        }, 2000);
                    }
                });
            });
        });
        <?php
        break;
}