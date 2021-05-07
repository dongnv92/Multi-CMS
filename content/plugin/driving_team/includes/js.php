<?php
switch ($path[2]) {
    case 'report':
        switch ($path[3]){
            case 'add':
                // Kiểm tra quyền truy cập
                if(!$role['business']['report']){
                    exit('Error');
                }
                ?>
                //<script>
                $(document).ready(function () {
                    $('#report_add').on('click', function () {
                        var ajax = $.ajax({
                            url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}/{$path[3]}"?>',
                            method      : 'POST',
                            dataType    : 'json',
                            data        : $('form').serialize(),
                            beforeSend  : function () {
                                $('#report_add').attr('disabled', true);
                                $('#report_add').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Đang thêm báo cáo ... </span>');
                            }
                        });
                        ajax.done(function (data) {
                            setTimeout(function () {
                                if(data.response == 200){
                                    NioApp.Toast(data.message, 'success',{
                                        ui: 'is-dark',
                                        position: 'top-right'
                                    });
                                    $('#report_add').attr('disabled', false);
                                    $('#report_add').html('THÊM BÁO CÁO');
                                }else{
                                    NioApp.Toast(data.message, 'error',{
                                        ui: 'is-dark',
                                        position: 'top-right'
                                    });
                                    $('#report_add').attr('disabled', false);
                                    $('#report_add').html('THÊM BÁO CÁO');
                                }
                            }, 2000);
                        });

                        ajax.fail(function( jqXHR, textStatus ) {
                            $('#report_add').attr('disabled', false);
                            $('#report_add').html('THÊM BÁO CÁO');
                            alert( "Request failed: " + textStatus );
                        });
                    });
                });
                <?php
                break;
        }
        break;
}