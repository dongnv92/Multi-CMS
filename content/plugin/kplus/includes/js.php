<?php
switch ($path[2]) {
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
}