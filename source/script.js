jQuery(document).ready(function ($) {
    $('#upload-form').submit(function (e) {
        e.preventDefault();
        let data = new FormData();
        let files = $('#file')[0].files[0];
        if (files){
            data.append('file',files);
            sendAjax(data, 'insert');
        }else{
            $('.alert-danger').show();
        }
    });

    $('#file').change(function () {
        let files = $('#file')[0].files[0];
        if (files){
            $('.alert-danger').hide();
        }
    });

    $(document).on('click','.pagination a', function (e) {
        e.preventDefault();
        let data = new FormData();
        data.append('page',$(this).text());
        sendAjax(data, 'pagination');
    });

    $(document).on('click', '.card-img-top', function () {
        let data = new FormData(),
            imageId = $(this).data('id'),
            src = $(this).attr('src');
            views = $(this).data('views');
        views++;
        $('#load-image').html('<img src="'+src+'" alt="" width="500px">');
        $(this).data('views', views);
        data.append('imageId',imageId);
        data.append('views',views);
        sendAjax(data, 'views');
    });

    $('#form-filter').submit(function (e) {
        e.preventDefault();
        let data = new FormData(),
            minH = $('#min-height').val(),
            maxH = $('#max-height').val(),
            minW = $('#min-width').val(),
            maxW = $('#max-width').val(),
            views = $('#views').val();
        data.append('minH',minH);
        data.append('maxH',maxH);
        data.append('minW',minW);
        data.append('minw',minW);
        data.append('views',views);
        sendAjax(data, 'filter');
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
                console.log(response)
                if(callback === 'pagination'){
                    $('#select-result').html(response);
                }else if(callback === 'insert'){
                    //@todo insert image if empty #select-result
                    $('#upload-form').trigger('reset');
                    $('#select-result .row').children().first().before(response)
                }
            },
        });
    }
});