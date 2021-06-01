<?php
switch ($path[2]) {
    case 'add':
        if(!$role['covid']['add']){
            exit('Forbidden');
        }
        ?>
        //<script>
        $(document).ready(function () {
            $('#button_covid_add').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form').serialize(),
                    beforeSend  : function () {
                        $('#button_covid_add').attr('disabled', true);
                        $('#button_covid_add').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> ĐANG THÊM DỮ LIỆU ... </span>');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        setTimeout(function () {
                            NioApp.Toast(data.message, 'success',{
                                ui: 'is-dark',
                                position: 'top-right'
                            });
                            $('#button_covid_add').attr('disabled', false);
                            $('#button_covid_add').html('THÊM MỚI');
                        }, 2000);
                    }else{
                        NioApp.Toast(data.message, 'error',{
                            ui: 'is-dark',
                            position: 'top-right'
                        });
                        $('#button_covid_add').attr('disabled', false);
                        $('#button_covid_add').html('THÊM MỚI');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_covid_add').attr('disabled', false);
                    $('#button_covid_add').html('THÊM MỚI');
                    alert( "Request failed: " + textStatus );
                });
            });
        });
        <?php
        break;
    default:

        break;
}