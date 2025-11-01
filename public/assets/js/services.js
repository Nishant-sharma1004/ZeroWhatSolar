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
            scrollTop: $(form).offset().top - 250
        }, 'slow');
        $('.alert.alert-dismissible').removeClass('alert-success alert-danger').addClass(res.msg_class).removeAttr('style');
        $('.msg').html(res.message);

        setTimeout(function () {
            $('.alert.alert-dismissible').fadeOut('slow');
        }, 3000);

        // If success, reset form and process calculator
        if (res.status) {
            // Check if solar calculator section exists
            if ($(form).hasClass('solarCalculator')) {
                const fullName = $('#fullNameCalc').val();
                const phone = $('#phoneCalc').val();
                const email = $('#emailCalc').val();
                const monthlyBill = parseFloat($('#monthlyBill').val());
                const propertyType = $('#propertyType').val();
                const rooftopArea = parseFloat($('#rooftopArea').val()) || 0;

                if (fullName && phone && email && monthlyBill && propertyType) {
                    // Solar calculation logic
                    const unitsPerMonth = monthlyBill / 6.5;
                    let systemSizeKW = Math.ceil(unitsPerMonth / 120);

                    let basePricePerKW;
                    let installationMultiplier = 1;

                    switch (propertyType) {
                        case 'residential':
                            basePricePerKW = 65000;
                            if (systemSizeKW <= 3) installationMultiplier = 1.1;
                            else if (systemSizeKW <= 5) installationMultiplier = 1.0;
                            else installationMultiplier = 0.95;
                            break;
                        case 'commercial':
                            basePricePerKW = 58000;
                            installationMultiplier = 0.9;
                            break;
                        case 'industrial':
                            basePricePerKW = 52000;
                            installationMultiplier = 0.85;
                            break;
                        default:
                            basePricePerKW = 65000;
                    }

                    const totalSystemCost = systemSizeKW * basePricePerKW * installationMultiplier;
                    const governmentSubsidy = Math.min(78000, systemSizeKW * 18000);
                    const finalPrice = totalSystemCost - governmentSubsidy;

                    const monthlySavings = Math.round(monthlyBill * 0.87);
                    const annualSavings = monthlySavings * 12;
                    const paybackPeriod = Math.round((finalPrice / annualSavings) * 10) / 10;

                    const emiOptions = {
                        '12months': Math.round(finalPrice / 12),
                        '24months': Math.round(finalPrice / 24),
                        '36months': Math.round(finalPrice / 36),
                        '60months': Math.round(finalPrice / 60)
                    };

                    // Build result HTML
                    const resultsHTML = `
                        <div class="alert alert-light mt-3">
                            <h4 class="text-primary mb-3">Your Personalized Solar Solution:</h4>
                            <div class="row text-center mb-3">
                                <div class="col-md-3 col-6">
                                    <strong>System Size:</strong><br>
                                    <span class="h5 text-primary">${systemSizeKW} kW</span>
                                </div>
                                <div class="col-md-3 col-6">
                                    <strong>Monthly Savings:</strong><br>
                                    <span class="h5 text-success">₹${monthlySavings.toLocaleString()}</span>
                                </div>
                                <div class="col-md-3 col-6">
                                    <strong>Annual Savings:</strong><br>
                                    <span class="h5 text-success">₹${annualSavings.toLocaleString()}</span>
                                </div>
                                <div class="col-md-3 col-6">
                                    <strong>Payback Period:</strong><br>
                                    <span class="h5 text-info">${paybackPeriod} years</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">💰 Investment Details:</h6>
                                    <p class="mb-1">Total System Cost: <strong>₹${totalSystemCost.toLocaleString()}</strong></p>
                                    <p class="mb-1 text-success">Government Subsidy: <strong>₹${governmentSubsidy.toLocaleString()}</strong></p>
                                    <p class="mb-3">Final Investment: <strong>₹${finalPrice.toLocaleString()}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">📊 Easy EMI Options:</h6>
                                    <p class="mb-1">12 months: <strong>₹${emiOptions['12months'].toLocaleString()}/month</strong></p>
                                    <p class="mb-1">24 months: <strong>₹${emiOptions['24months'].toLocaleString()}/month</strong></p>
                                    <p class="mb-1">36 months: <strong>₹${emiOptions['36months'].toLocaleString()}/month</strong></p>
                                    <p class="mb-3">60 months: <strong>₹${emiOptions['60months'].toLocaleString()}/month</strong></p>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="${baseUrl}contact" class="btn btn-primary btn-lg me-2">Get Detailed Quote</a>
                                <a href="tel:+919876543210" class="btn btn-outline-primary">Call Now</a>
                            </div>
                        </div>
                    `;

                    // ✅ Make sure #calculatorResults is outside form
                    $('#calculatorResults').html(resultsHTML).show();

                    // Reset form only (do not affect #calculatorResults)
                    $(form).trigger('reset');

                    // Smooth scroll to calculator
                    $('html, body').animate({
                        scrollTop: $('#calculatorResults').offset().top - 250
                    }, 800);

                    // Show alert last (after DOM updates)
                    setTimeout(() => {
                        alert(`Hi ${fullName}! Your personalized solar solution is ready. A ${systemSizeKW}kW system will save you ₹${monthlySavings.toLocaleString()} monthly. Our expert will call you at ${phone} within 30 minutes with detailed pricing and next steps.`);
                    }, 800);
                }
            } else {
                // Other normal forms
                $(form).trigger('reset');
            }
        }

    }, function (err) {
        console.error('Form submission failed:', err);
        alert('Error submitting form.');
    });
});

