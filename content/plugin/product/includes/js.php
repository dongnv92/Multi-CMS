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
                    $('#button_update').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"?>',
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
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000)
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
    case 'brand':
        // Kiểm tra quyền truy cập
        if(!$role['product']['brand']){
            echo "Forbidden";
            exit();
        }
        switch ($path[3]){
            case 'update':
                ?>
                //<script>
                $(document).ready(function () {
                    var drEvent = $('.dropify').dropify({
                        messages: {
                            'default': '<center>Kéo, thả File vào đây hoặc Bấm để tải file</center>',
                            'replace': 'Kéo thả hoặc bấm để đổi File',
                            'remove':  'Xóa',
                            'error':   'Ohhh có lỗi rồi.'
                        },
                        error: {
                            'fileSize': 'Tập tin quá nặng.).',
                            'minWidth': 'The image width is too small ({{ value }}}px min).',
                            'maxWidth': 'The image width is too big ({{ value }}}px max).',
                            'minHeight': 'The image height is too small ({{ value }}}px min).',
                            'maxHeight': 'The image height is too big ({{ value }}px max).',
                            'imageFormat': 'Chỉ hỗ trợ file ảnh ({{ value }} ).',
                            'fileExtension' : 'Kiểu File không được hỗ trợ. Hỗ trợ định các định dạng ({{ value }})'
                        }
                    });

                    $('#button_update').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}/{$path[4]}"?>',
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
                                    // Upload Ảnh
                                    var file_data = $('#input-file-now').prop('files')[0];
                                    var form_data = new FormData();
                                    form_data.append('file', file_data);
                                    $.ajax({
                                        url: '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/update_image/{$path[4]}"?>', // point to server-side controller method
                                        dataType: 'text', // what to expect back from the server
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        data: form_data,
                                        type: 'post',
                                        success: function (data_image) {
                                            setTimeout(function () {
                                                location.reload();
                                            }, 2000);
                                        }
                                    });
                                    // Upload Ảnh
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
                    var drEvent = $('.dropify').dropify({
                        messages: {
                            'default': '<center>Kéo, thả File vào đây hoặc Bấm để tải file</center>',
                            'replace': 'Kéo thả hoặc bấm để đổi File',
                            'remove':  'Xóa',
                            'error':   'Ohhh có lỗi rồi.'
                        },
                        error: {
                            'fileSize': 'Tập tin quá nặng.).',
                            'minWidth': 'The image width is too small ({{ value }}}px min).',
                            'maxWidth': 'The image width is too big ({{ value }}}px max).',
                            'minHeight': 'The image height is too small ({{ value }}}px min).',
                            'maxHeight': 'The image height is too big ({{ value }}px max).',
                            'imageFormat': 'Chỉ hỗ trợ file ảnh ({{ value }} ).',
                            'fileExtension' : 'Kiểu File không được hỗ trợ. Hỗ trợ định các định dạng ({{ value }})'
                        }
                    });

                    // Thêm chuyên mục
                    $('#button_add').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
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
                                    // Upload Ảnh
                                    var file_data = $('#input-file-now').prop('files')[0];
                                    var form_data = new FormData();
                                    form_data.append('file', file_data);
                                    $.ajax({
                                        url: '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/update_image/"?>' + data.data, // point to server-side controller method
                                        dataType: 'text', // what to expect back from the server
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        data: form_data,
                                        type: 'post',
                                        success: function (data_image) {
                                            setTimeout(function () {
                                                location.reload();
                                            }, 2000);
                                        }
                                    });
                                    // Upload Ảnh
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
                            title: "Xóa Brand",
                            text: "Bạn có muốn xóa Brand này không?",
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
                                        swal("Xóa Brand", "Xóa Brand thành công!", "success");
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);
                                    }else{
                                        swal("Xóa Brand", data.message, "error");
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
        if(!$role['product']['add']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('.summernote').summernote({
                placeholder: 'Nhập nội dung',
                tabsize: 2,
                height: 200
            });
            var drEvent = $('.dropify').dropify({
                messages: {
                    'default': '<center>Kéo, thả File vào đây hoặc Bấm để tải file</center>',
                    'replace': 'Kéo thả hoặc bấm để đổi File',
                    'remove':  'Xóa',
                    'error':   'Ohhh có lỗi rồi.'
                },
                error: {
                    'fileSize': 'Tập tin quá nặng.).',
                    'minWidth': 'The image width is too small ({{ value }}}px min).',
                    'maxWidth': 'The image width is too big ({{ value }}}px max).',
                    'minHeight': 'The image height is too small ({{ value }}}px min).',
                    'maxHeight': 'The image height is too big ({{ value }}px max).',
                    'imageFormat': 'Chỉ hỗ trợ file ảnh ({{ value }} ).',
                    'fileExtension' : 'Kiểu File không được hỗ trợ. Hỗ trợ định các định dạng ({{ value }})'
                }
            });

            $('input[name=product_name]').focusout(function () {
                var product_name = $(this).val();
                $.post(
                    '<?=URL_ADMIN_AJAX . "{$path[1]}/create_url/?product_name="?>' + product_name,
                    function (data) {
                        $('input[name=product_url]').val(data);
                    }
                );
            });

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
                    if(data.response == 200){
                        // Upload ảnh sản phẩm
                        var file_data = $('#product_image').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('product_image', file_data);
                        form_data.append('product_id', data.data);
                        $.ajax({
                            url: '<?=URL_ADMIN_AJAX . "{$path[1]}/update_product_image/"?>', // point to server-side controller method
                            dataType: 'text', // what to expect back from the server
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            success: function () {
                            }
                        });
                        // Upload ảnh sản phẩm
                        // Upload Danh sách ảnh sản phẩm
                        var form_data_1 = new FormData();
                        var ins = document.getElementById('product_images').files.length;
                        for (var x = 0; x < ins; x++) {
                            form_data_1.append("product_images[]", document.getElementById('product_images').files[x]);
                        }
                        form_data_1.append('product_id', data.data);
                        $.ajax({
                            url: '<?=URL_ADMIN_AJAX . "{$path[1]}/add_images/"?>', // point to server-side controller method
                            dataType: 'text', // what to expect back from the server
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_1,
                            type: 'post',
                            success: function (data_images) {

                            }
                        });
                        // Upload Danh sách ảnh sản phẩm
                        setTimeout(function () {
                            show_notify(data.message, 'bg-green');
                            $('#button_add').attr('disabled', false);
                            $('#button_add').html('THÊM MỚI');
                        }, 1500);
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
    case 'update':
        if(!$role['product']['update']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('.summernote').summernote({
                placeholder: 'Nhập nội dung',
                tabsize: 2,
                height: 200
            });

            $('#aniimated-thumbnials').lightGallery({
                thumbnail: true,
                selector: 'a'
            });

            $('div[data-type=delete_image]').on('click', function () {
                var image_id = $(this).data('id');
                swal({
                    title: "Xóa ảnh",
                    text: "Bạn có chắc chắn muốn ảnh sản phẩm này không? sau khi xóa dữ liệu sẽ không thể khôi phục được!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    setTimeout(function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>delete_image/' + image_id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                setTimeout(function () {
                                    $('#list_image_' + image_id).remove();
                                    swal("Xóa ảnh", "Xóa ảnh thành công!", "success");
                                }, 1000);
                            }else{
                                swal("Xóa ảnh", data.message, "error");
                            }
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            console.log("Request failed: " + textStatus );
                        });
                    }, 2000);
                });
            });

            var drEvent = $('.dropify').dropify({
                messages: {
                    'default': '<center>Kéo, thả File vào đây hoặc Bấm để tải file</center>',
                    'replace': 'Kéo thả hoặc bấm để đổi File',
                    'remove':  'Xóa',
                    'error':   'Ohhh có lỗi rồi.'
                },
                error: {
                    'fileSize': 'Tập tin quá nặng.).',
                    'minWidth': 'The image width is too small ({{ value }}}px min).',
                    'maxWidth': 'The image width is too big ({{ value }}}px max).',
                    'minHeight': 'The image height is too small ({{ value }}}px min).',
                    'maxHeight': 'The image height is too big ({{ value }}px max).',
                    'imageFormat': 'Chỉ hỗ trợ file ảnh ({{ value }} ).',
                    'fileExtension' : 'Kiểu File không được hỗ trợ. Hỗ trợ định các định dạng ({{ value }})'
                }
            });

            $('#button_submit').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form').serialize(),
                    beforeSend  : function () {
                        $('#button_submit').attr('disabled', true);
                        $('#button_submit').html('ĐANG CẬP NHẬT ...');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        // Upload ảnh sản phẩm
                        var file_data = $('#product_image').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('product_image', file_data);
                        form_data.append('product_id', '<?=$path[3]?>');
                        $.ajax({
                            url: '<?=URL_ADMIN_AJAX . "{$path[1]}/update_product_image/"?>', // point to server-side controller method
                            dataType: 'text', // what to expect back from the server
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            success: function () {
                            }
                        });
                        // Upload ảnh sản phẩm
                        // Upload Danh sách ảnh sản phẩm
                        var form_data_1 = new FormData();
                        var ins = document.getElementById('product_images').files.length;
                        for (var x = 0; x < ins; x++) {
                            form_data_1.append("product_images[]", document.getElementById('product_images').files[x]);
                        }
                        form_data_1.append('product_id', '<?=$path[3]?>');
                        $.ajax({
                            url: '<?=URL_ADMIN_AJAX . "{$path[1]}/add_images/"?>', // point to server-side controller method
                            dataType: 'text', // what to expect back from the server
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_1,
                            type: 'post',
                            success: function (data_images) {

                            }
                        });
                        // Upload Danh sách ảnh sản phẩm
                        setTimeout(function () {
                            show_notify(data.message, 'bg-green');
                            $('#button_submit').attr('disabled', false);
                            $('#button_submit').html('CẬP NHẬT');
                        }, 1500);
                    }else{
                        show_notify(data.message, 'bg-red');
                        $('#button_submit').attr('disabled', false);
                        $('#button_submit').html('CẬP NHẬT');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_submit').attr('disabled', false);
                    $('#button_submit').html('CẬP NHẬT');
                    alert( "Request failed: " + jqXHR.responseText );
                });
            })
        });
        <?php
        break;
    default:
        ?>
        $(document).ready(function () {
            // Product Manager
            $('tr[data-label=manager]').hover(function () {
                var product_id = $(this).data('id');
                $('#show_'+product_id).hide();
                $('#hide_'+product_id).show().fadeIn(500);
            }, function () {
                var product_id = $(this).data('id');
                $('#show_' + product_id).show();
                $('#hide_' + product_id).hide();
            });

            // Delete
            $('a[data-type=product_delete]').on('click', function () {
                var product_id = $(this).data('id');
                swal({
                    title: "Xóa sản phẩm",
                    text: "Bạn có chắc chắn muốn sản phẩm này không? sau khi xóa dữ liệu sẽ không thể khôi phục được!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    setTimeout(function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/"?>delete/' + product_id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                setTimeout(function () {
                                    swal("Xóa sản phẩm", 'Xóa sản phẩm thành công', "success");
                                    $('tr[data-id=' + product_id + ']').remove();
                                }, 1000);
                            }else{
                                swal("Xóa sản phẩm", data.message, "error");
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