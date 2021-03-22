<?php
switch ($path[2]) {
    case 'add':
        ?>
        //<script>
        $(document).ready(function(){
            $('#button_add_pickup').on('click', function () {
                var ajax = $.ajax({
                    url         : '<?=URL_ADMIN_AJAX . "{$path[1]}/{$path[2]}"?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : $('form[id="form_add_pickup"]').serialize(),
                    beforeSend  : function () {
                        $('#button_add_pickup').attr('disabled', true);
                        $('#button_add_pickup').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Vui Lòng Chờ ... </span>');
                    }
                });
                ajax.done(function (data) {
                    if(data.response == 200){
                        setTimeout(function () {
                            Swal.fire("Thêm dữ liệu bốc sếp", data.message, "success");
                            $('#button_add_pickup').attr('disabled', false);
                            $('#button_add_pickup').html('THÊM MỚI');
                        }, 1000);
                    }else{
                        Swal.fire("Thêm dữ liệu bốc sếp", data.message, "error");
                        $('#button_add_pickup').attr('disabled', false);
                        $('#button_add_pickup').html('THÊM MỚI');
                    }
                });

                ajax.fail(function( jqXHR, textStatus ) {
                    $('#button_add_pickup').attr('disabled', false);
                    $('#button_add_pickup').html('THÊM MỚI');
                    alert( "Request failed: " + jqXHR.responseText );
                });
            });
        });
        <?php
        break;
    default:

        break;
}