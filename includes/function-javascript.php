<?php
require '../init.php';
header('Content-type: application/javascript; charset=utf-8');
switch ($path[1]){
    case 'user':
        switch ($path[2]){
            case 'role':
                switch ($path[3]){
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
                            })
                        });
                        <?php
                        break;
                    default:

                        break;
                }
                break;
        }
        break;
}