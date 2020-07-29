<?php
require '../init.php';
header('Content-type: application/javascript; charset=utf-8');
switch ($path[1]){
    case 'plugin':
            switch ($path[2]){
                default:
                    // Kiểm tra quyền truy cập
                    if(!$role['plugin']['manager']){
                        echo "Forbidden";
                        exit();
                    }
                    ?>
                    //<script>
                    $(document).ready(function () {
                        $('button[data-action=change_status]').on('click', function () {
                            var status  = $(this).data('type');
                            var name    = $(this).data('name');
                            var text    = (status == 'active' ? 'NGỪNG KÍCH HOẠT' : 'KÍCH HOẠT');

                            var ajax = $.ajax({
                                url         : '<?=URL_ADMIN_AJAX . "{$path[1]}"?>',
                                method      : 'POST',
                                dataType    : 'json',
                                data        : {status : status, plugin : name},
                                beforeSend  : function () {
                                    $('#plugin_status').attr('disabled', true);
                                    $('#plugin_status').html('ĐANG UPDATE ...');
                                }
                            });
                            ajax.done(function (data) {
                                if(data.response == 200){
                                    location.reload();
                                }else{
                                    $('#plugin_status').attr('disabled', false);
                                    $('#plugin_status').html(text);
                                    show_notify(data.message, 'bg-red');
                                }
                            });

                            ajax.fail(function( jqXHR, textStatus ) {
                                $('#plugin_status').attr('disabled', false);
                                $('#plugin_status').html(text);
                                alert( "Request failed: " + textStatus );
                            });
                        });
                    });
                    <?php
                    break;
            }
        break;
    case 'blog':
        switch ($path[2]){
            case 'category':
                // Kiểm tra quyền truy cập
                if(!$role['blog']['manager']){
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
                            $('#button_add_category').on('click', function () {
                                var ajax = $.ajax({
                                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                                    method      : 'POST',
                                    dataType    : 'json',
                                    data        : $('form').serialize(),
                                    beforeSend  : function () {
                                        $('#button_add_category').attr('disabled', true);
                                        $('#button_add_category').html('ĐANG THÊM CHUYÊN MỤC ...');
                                    }
                                });
                                ajax.done(function (data) {
                                    setTimeout(function () {
                                        if(data.response == 200){
                                            show_notify(data.message, 'bg-green');
                                            $('#button_add_category').attr('disabled', false);
                                            $('#button_add_category').html('THÊM');
                                            setTimeout(function () {
                                                location.reload();
                                            }, 2000);
                                        }else{
                                            show_notify(data.message, 'bg-red');
                                            $('#button_add_category').attr('disabled', false);
                                            $('#button_add_category').html('THÊM');
                                        }
                                    }, 2000);
                                });

                                ajax.fail(function( jqXHR, textStatus ) {
                                    $('#button_add_role').attr('disabled', false);
                                    $('#button_add_role').html('THÊM');
                                    alert("Request failed: " + jqXHR.responseText);
                                });
                            });

                            // Xóa chuyên mục
                            $('a[data-type=delete]').on('click', function () {
                                var id = $(this).data('id');
                                swal({
                                    title: "Xóa chuyên mục blog",
                                    text: "Bạn có muốn xóa chuyên mục blog này không?",
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
                                                swal("Xóa chuyên mục blog", "Xóa chuyên mục blog thành công!", "success");
                                                setTimeout(function () {
                                                    location.reload();
                                                }, 2000);
                                            }else{
                                                swal("Xóa chuyên mục blog", data.message, "error");
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
            case 'update':
            ?>
            //<script>
            $(document).ready(function () {
                $('#summernote').summernote({
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

            });
            <?php
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

                    $('input[name=post_title]').focusout(function () {
                        var post_title = $(this).val();
                        $.post(
                            '<?=URL_ADMIN_AJAX . "{$path[1]}/create_url/?post_title="?>' + post_title,
                            function (data) {
                                $('input[name=post_url]').val(data);
                            }
                        );
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
                            title: "Xóa bài viết",
                            text: "Bạn có chắc chắn muốn xóa bài viết này không? sau khi xóa dữ liệu sẽ không thể khôi phục được!",
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
                                        swal("Xóa bài viết", "Xóa bài viết thành công!", "success");
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);
                                    }else{
                                        swal("Bài viết", data.message, "error");
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
    case 'profile':
        switch ($path[2]){
            case 'change-avatar':
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
                });
                <?php
                break;
            default:
                ?>
                //<script>
                $(document).ready(function () {
                    $('#button_update_me').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#button_update_me').attr('disabled', true);
                                $('#button_update_me').html('ĐANG CẬP NHẬT HỒ SƠ ...');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    show_notify(data.message, 'bg-green');
                                    $('#button_update_me').attr('disabled', false);
                                    $('#button_update_me').html('CẬP NHẬT');
                                }else{
                                    show_notify(data.message, 'bg-red');
                                    $('#button_update_me').attr('disabled', false);
                                    $('#button_update_me').html('CẬP NHẬT');
                                }
                            }, 2000);
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            $('#button_update_me').attr('disabled', false);
                            $('#button_update_me').html('CẬP NHẬT');
                            alert("Request failed: " + jqXHR.responseText);
                        });
                    });
                });
                <?php
                break;
        }
        break;
    case 'user':
        switch ($path[2]){
            case 'update':
                // Kiểm tra quyền truy cập
                if(!$role['user']['update']){
                    echo "Forbidden";
                    exit();
                }
                ?>
                //<script>
                $(document).ready(function () {
                    $('#button_update_user').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#button_update_user').attr('disabled', true);
                                $('#button_update_user').html('ĐANG CẬP NHẬT THÀNH VIÊN ...');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    show_notify(data.message, 'bg-green');
                                    $('#button_update_user').attr('disabled', false);
                                    $('#button_update_user').html('CẬP NHẬT');
                                }else{
                                    show_notify(data.message, 'bg-red');
                                    $('#button_update_user').attr('disabled', false);
                                    $('#button_update_user').html('CẬP NHẬT');
                                }
                            }, 2000);
                        });
                        ajax.fail(function( jqXHR, textStatus ) {
                            $('#button_update_user').attr('disabled', false);
                            $('#button_update_user').html('CẬP NHẬT');
                            alert( "Request failed: " + textStatus );
                        });
                    });
                });
                <?php
                break;
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['user']['add']){
                    echo "Forbidden";
                    exit();
                }
                ?>
                //<script>
                $(document).ready(function () {
                    $('#button_add_user').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#button_add_user').attr('disabled', true);
                                $('#button_add_user').html('ĐANG THÊM THÀNH VIÊN ...');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    show_notify(data.message, 'bg-green');
                                    $('#button_add_user').attr('disabled', false);
                                    $('#button_add_user').html('THÊM THÀNH VIÊN');
                                }else{
                                    show_notify(data.message, 'bg-red');
                                    $('#button_add_user').attr('disabled', false);
                                    $('#button_add_user').html('THÊM THÀNH VIÊN');
                                }
                            }, 2000);
                        });

                        ajax.fail(function( jqXHR, textStatus ) {
                            $('#button_add_user').attr('disabled', false);
                            $('#button_add_user').html('THÊM THÀNH VIÊN');
                            alert( "Request failed: " + textStatus );
                        });
                    });
                });
            <?php
            break;
            case 'role':
                // Kiểm tra quyền truy cập
                if(!$role['user']['role']){
                    echo "Forbidden";
                    exit();
                }
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
            default:
                // Kiểm tra quyền truy cập
                if(!$role['user']['manager']){
                    echo "Forbidden";
                    exit();
                }
                ?>
                //<script>
                $(document).ready(function () {
                    $('a[data-type=delete]').on('click', function () {
                        var id = $(this).data('id');
                        swal({
                            title: "Xóa thành viên",
                            text: "Bạn có muốn xóa thành viên này không? sau khi xóa dữ liệu sẽ không thể khôi phục được",
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
                                        swal("Xóa thành viên", "Xóa thành viên thành công!", "success");
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);
                                    }else{
                                        swal("Xóa thành viên", data.message, "error");
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
    default:
        if(in_array($path[1], get_list_plugin())){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . $path[1] . '/config.json');
            $config = json_decode($config, true);
            if($config['status'] == 'active'){
                require_once ABSPATH . PATH_PLUGIN . $path[1] . "/{$config['source']['javascript']}";
            }
        }
        break;
}