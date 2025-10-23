$('#add_testimonials').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    var url = $(this).attr('action');

    // Send via AJAX
    ajaxPost(url, formData, function (res) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('.alert').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 3000);
        if (res.status) {
            $('#add_testimonials').trigger("reset");
        }
    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});

$('#edit_testimonials').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    var url = $(this).attr('action');

    // Send via AJAX
    ajaxPost(url, formData, function (res) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('.alert').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 3000);
    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});

// Delete project
$('#delete_testimonials').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    var url = $(this).attr('action');

    // Send via AJAX
    ajaxPost(url, formData, function (res) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('.alert').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);
        if (res.status) {
            $('.btn-close').click();
            window.location.reload();
        }
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 3000);
    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});