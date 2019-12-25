jQuery(document).ready(function ($) {
    $('#upload-form').submit(function (e) {
        e.preventDefault();
        let data = new FormData();
        let files = $('#file')[0].files[0];
        if (files){
            data.append('file',files);
            sendAjax(data, 'insert');
        }else{
            //@todo show error message
        }
    });

    $(document).on('click','.pagination a', function (e) {
        e.preventDefault();
        console.log()
        let data = new FormData();
        data.append('page',$(this).text());
        sendAjax(data, 'pagination');
    });

    function sendAjax(data, callback) {
        data.append('callback',callback);
        $.ajax({
            url: '../ajax.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function(response){
                if(callback === 'pagination'){
                    $('#select-result').html(response);
                }else if(callback === 'insert'){
                    $('#upload-form').trigger('reset');
                    $('#select-result .row').children().first().before(response)
                }
            },
        });
    }
});