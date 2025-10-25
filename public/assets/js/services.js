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
    var form = this;
    // Send via AJAX
    ajaxPost(url, formData, function (res) {
        $('html, body').animate({
            scrollTop: $(form).offset().top - 200
        }, 'slow');
        $('.alert').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);
        $('.btn-close').click();
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 3000);
        if (res.status) {
            $(form).trigger('reset');
        }
    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});