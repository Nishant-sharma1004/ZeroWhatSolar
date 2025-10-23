$('#update-setting, #update-pricing').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    var url = $(this).attr('action');

    // Send via AJAX
    ajaxPost(url, formData, function (res) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('.alert').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);
        $('.fas').removeClass('fa-check-circle fa-exclamation-triangle').addClass(res.icon);
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 3000);
    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});