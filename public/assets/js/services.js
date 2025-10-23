var baseUrl = $('base').attr('href');

function ajaxGet(url, params = {}, onSuccess, onError) {
    $.ajax({
        url: baseUrl + url,
        type: 'GET',
        data: params,
        dataType: 'json',
        cache: false,
        success: function (response) {
            if (onSuccess) onSuccess(response);
        },
        error: function (xhr, status, error) {
            if (onError) onError(error);
        }
    });
}

function ajaxPost(url, formData = {}, onSuccess, onError) {
    console.log(baseUrl + url);
    $.ajax({
        url: baseUrl + url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function (response) {
            if (onSuccess) onSuccess(response);
        },
        error: function (xhr, status, error) {
            if (onError) onError(error);
        }
    });
}


$('#popupQuoteForm, #InquiryForm').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    var url = $(this).attr('action');

    // Send via AJAX
    ajaxPost(url, formData, function (res) {
        $('.alert').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);
        $('.fas').removeClass('fa-check-circle fa-exclamation-triangle').addClass(res.icon);
        if (res.status) {
            // setTimeout(function () {
            //     $('.alert').fadeOut('slow');
            //     window.location.href = res.redirect_url;
            // }, 3000);
        }
    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});