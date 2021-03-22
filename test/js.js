$(document).ready(function () {
    $('#search').on('click', function () {
        var id = $('#id').val();
        var ajax = $.ajax({
            url         : 'ajax.php',
            method      : 'POST',
            dataType    : 'text',
            data        : {'act' : 'get_list_feed', 'id' : id},
            beforeSend  : function () {
                $('#search').attr('disabled', true);
                $('#search').html('SEARCHING ...');
            }
        });
        ajax.done(function (data) {
            $('#search').attr('disabled', false);
            $('#search').html('SEARCH');
            $('#result').html(data);
        });
        ajax.fail(function( jqXHR, textStatus ) {
            $('#search').attr('disabled', false);
            $('#search').html('SEARCH');
            alert("Request failed: " + jqXHR.responseText);
        });
    });
})

var ajax = $.ajax({
    url         : '<?=URL_ADMIN_AJAX . "login"?>',
    method      : 'POST',
    dataType    : 'json',
    data        : $('form').serialize(),
    beforeSend  : function () {
        $('#submit_login').attr('disabled', true);
        $('#submit_login').html('Text Disable ...');
    }
});
ajax.done(function (data) {
    $('#id').attr('disabled', false);
    $('#id').html('Text Enable');
    alert(data.message);
});

ajax.fail(function( jqXHR, textStatus ) {
    $('#id').attr('disabled', false);
    $('#id').html('Text Enable');
    alert( "Request failed: " + textStatus );
});