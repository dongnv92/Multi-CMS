<?php
switch ($path[2]) {
    case 'payment':
        $account            = new pAccount();
        $transaction        = $account->get_transaction(['transaction_code' => $_REQUEST['account']]);
        ?>
        //<script>
        $(document).ready(function () {
            var timer2 = $('.countdown').html();
            var interval = setInterval(function() {
                var timer = timer2.split(':');
                //by parsing integer, I avoid all extra string processing
                var minutes = parseInt(timer[0], 10);
                var seconds = parseInt(timer[1], 10);
                --seconds;
                minutes = (seconds < 0) ? --minutes : minutes;
                if (minutes < 0) clearInterval(interval);
                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;
                //minutes = (minutes < 10) ?  minutes : minutes;
                if(minutes == 0 && seconds == 0){
                    location.reload();
                }
                $('.countdown').html(minutes + ':' + seconds);
                timer2 = minutes + ':' + seconds;
            }, 1000);

            var interval2 = setInterval(function () {
                var ajax = $.ajax({
                    url         : '<?=URL_API . "account/transaction_check"?>',
                    method      : 'GET',
                    dataType    : 'json',
                    data        : {
                        date_start  : '<?=$transaction['transaction_create']?>',
                        date_end    : '<?=date('Y-m-d H:i:s', $transaction['transaction_deadline'])?>',
                        comment     : '<?=$transaction['transaction_payment_content']?>',
                        money       : '<?=$transaction['transaction_total_money']?>',
                        code        : '<?=$transaction['transaction_code']?>'
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        location.reload();
                    }else{
                        console.log(data.message);
                    }
                });
                ajax.fail(function( jqXHR, textStatus ) {
                    console.log("Request failed: " + jqXHR.responseText );
                });
            }, 5000)
        });
        <?php
        break;
    case 'update':
        if(!$role['account']['manager']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 150,
                placeholder : 'Nội dung',
                tabsize: 2
            });
            var drEvent = $('.dropify').dropify({
                messages: {
                    'default': '<center>Kéo, thả File vào đây hoặc Bấm để chọn tập tin</center>',
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
            drEvent.on('dropify.errors', function(event, element){
                toastr.error('Lỗi tập tin, vui lòng chọn tại File.');
            });

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
            $('#_account_expired').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                clearBtn: true,
                format: "dd-mm-yyyy",
                weekStart: 1,
                language: "vi",
                orientation: "bottom left",
                templates: arrows
            });

            // Xóa ảnh
            $('a[data-action=delete_image]').on('click', function () {
                var id = $(this).data('id');
                swal.fire({
                    title: "Xóa ảnh tài khoản",
                    text: "Bạn có chắc chắn muốn xóa ảnh này không?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    cancelButtonText: 'Không Xóa',
                    confirmButtonText: 'Xóa'
                }). then(function (result) {
                    if(result.value){
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/delete_image/"?>' + id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                swal.fire("Xóa ảnh tài khoản", data.message, "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }else{
                                swal.fire("Xóa ảnh tài khoản", data.message, "error");
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
    case 'add':
        if(!$role['account']['add']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 150,
                placeholder : 'Nội dung',
                tabsize: 2
            });
            var drEvent = $('.dropify').dropify({
                messages: {
                    'default': '<center>Kéo, thả File vào đây hoặc Bấm để chọn tập tin</center>',
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
            drEvent.on('dropify.errors', function(event, element){
                toastr.error('Lỗi tập tin, vui lòng chọn tại File.');
            });

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
            $('#_account_expired').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                clearBtn: true,
                format: "dd-mm-yyyy",
                weekStart: 1,
                language: "vi",
                orientation: "bottom left",
                templates: arrows
            });
        });
        <?php
        break;
    default:
        if(!$role['account']['manager']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            // Xóa
            $('a[data-action=delete]').on('click', function () {
                var id = $(this).data('id');
                swal.fire({
                    title: "Xóa tài khoản",
                    text: "Bạn có chắc chắn muốn xóa tài khoản này không?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    cancelButtonText: 'Không Xóa',
                    confirmButtonText: 'Xóa'
                }). then(function (result) {
                    if(result.value){
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/delete/"?>' + id,
                            method      : 'POST',
                            dataType    : 'json',
                        });
                        ajax.done(function (data) {
                            if(data.response == 200){
                                swal.fire("Xóa tài khoản", data.message, "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }else{
                                swal.fire("Xóa tài khoản", data.message, "error");
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