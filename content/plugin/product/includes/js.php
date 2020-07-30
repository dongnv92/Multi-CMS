<?php
switch ($path[2]) {
    case 'category':
        // Kiểm tra quyền truy cập
        if(!$role['product']['manager']){
            echo "Forbidden";
            exit();
        }
        switch ($path[3]){
            case 'update':
                ?>
                //<script>
                $(document).ready(function () {
                    $('#button_update_cate').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#button_update_cate').attr('disabled', true);
                                $('#button_update_cate').html('ĐANG CẬP NHẬT ...');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    show_notify(data.message, 'bg-green');
                                    $('#button_update_cate').attr('disabled', false);
                                    $('#button_update_cate').html('CẬP NHẬT');
                                }else{
                                    show_notify(data.message, 'bg-red');
                                    $('#button_update_cate').attr('disabled', false);
                                    $('#button_update_cate').html('CẬP NHẬT');
                                }
                            }, 2000);
                        });

                        ajax.fail(function( jqXHR, textStatus ) {
                            $('#button_update_cate').attr('disabled', false);
                            $('#button_update_cate').html('CẬP NHẬT');
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
                    // Thêm chuyên mục
                    $('#button_add').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#button_add').attr('disabled', true);
                                $('#button_add').html('ĐANG THÊM DANH MỤC ...');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    show_notify(data.message, 'bg-green');
                                    $('#button_add').attr('disabled', false);
                                    $('#button_add').html('THÊM');
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
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
                            alert("Request failed: " + jqXHR.responseText);
                        });
                    });

                    // Xóa chuyên mục
                    $('a[data-type=delete]').on('click', function () {
                        var id = $(this).data('id');
                        swal({
                            title: "Xóa danh mục sản phẩm",
                            text: "Bạn có muốn xóa danh mục sản phẩm này không?",
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
                                        swal("Xóa danh mục sản phẩm", "Xóa danh mục sản phẩm thành công!", "success");
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);
                                    }else{
                                        swal("Xóa danh mục sản phẩm", data.message, "error");
                                    }
                                });
                                ajax.fail(function( jqXHR, textStatus ) {
                                    alert("Request failed: " + jqXHR.responseText);
                                });
                            }, 2000);
                        });
                    });
                });
                <?php
                break;
        }
    break;
    case 'add':
        ?>
        //<script>
        $(document).ready(function () {
            $('#summernote').summernote({
                placeholder: 'Nhập nội dung',
                tabsize: 2,
                height: 200
            });
        });
        <?php
        break;
}