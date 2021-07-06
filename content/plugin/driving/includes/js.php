<?php
switch ($path[2]) {
    case 'oil':
        switch ($path[3]){
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['driving']['oil_add']){
                    exit('Error');
                }
                ?>
                //<script>
                $(document).ready(function () {
                    $('#button_oil_add').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#button_oil_add').attr('disabled', true);
                                $('#button_oil_add').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Đang thêm dữ liệu ... </span>');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    NioApp.Toast(data.message, 'success',{
                                        ui: 'is-dark',
                                        position: 'top-right'
                                    });
                                    $('#button_oil_add').attr('disabled', false);
                                    $('#button_oil_add').html('THÊM MỚI');
                                }else{
                                    NioApp.Toast(data.message, 'error',{
                                        ui: 'is-dark',
                                        position: 'top-right'
                                    });
                                    $('#button_oil_add').attr('disabled', false);
                                    $('#button_oil_add').html('THÊM MỚI');
                                }
                            }, 2000);
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            $('#button_oil_add').attr('disabled', false);
                            $('#button_oil_add').html('THÊM MỚI');
                            alert( "Request failed: " + textStatus );
                        });
                    });
                });
                <?php
                break;
            default:
                // Kiểm tra quyền truy cập
                if(!$role['driving']['oil_add']){
                    exit('Error');
                }
                ?>
                //<script>
                $(document).ready(function () {
                    // Xóa chuyên mục
                    $('a[data-type=delete]').on('click', function (e) {
                        var id = $(this).data('id');
                        Swal.fire({
                            title: "Xóa lịch sử đổ dầu",
                            text: "Bạn có muốn xóa lịch sử đổ dầu này không?",
                            icon: 'danger',
                            showCancelButton: true,
                            confirmButtonText: 'Xóa',
                            showLoaderOnConfirm: true,
                        }).then(function (result) {
                            if (result.value) {
                                var ajax = $.ajax({
                                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/delete"?>/' + id,
                                    method      : 'POST',
                                    dataType    : 'json',
                                });
                                ajax.done(function (data) {
                                    if(data.response == 200){
                                        Swal.fire("Xóa lịch sử đổ dầu", "Xóa lịch sử đổ dầu thành công!", "success");
                                        setTimeout(function () {
                                            location.reload();
                                        }, 1500);
                                    }else{
                                        Swal.fire("Xóa lịch sử đổ dầu", data.message, "error");
                                    }
                                });
                                ajax.fail(function( jqXHR, textStatus ) {
                                    console.log("Request failed: " + textStatus );
                                });
                            }
                        });
                        e.preventDefault();
                    });
                });
                <?php
                break;
        }
        break;
}