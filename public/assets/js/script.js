/*
 * Custom JavaScript for Zero What Solar
 * Features: Active Nav Link Highlighter & Sticky Navbar on Scroll
*/

document.addEventListener("DOMContentLoaded", function () {

    // --- 1. Active Nav Link Highlighter ---
    // Get the current page's path (e.g., "/about.php")
    const currentPage = window.location.pathname.split("/").pop();

    // Find all navigation links
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');

        // If the link's href matches the current page, add the 'active' class
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
        // Special case for the homepage (index.php or empty path)
        if (currentPage === 'index.php' || currentPage === '') {
            if (linkPage === 'index.php') {
                link.classList.add('active');
            }
        }
    });


    // --- 2. Sticky Navbar on Scroll ---
    const navbar = document.querySelector('.navbar');

    if (navbar) {
        window.addEventListener('scroll', function () {
            // If user scrolls down more than 50px, add a class to the navbar
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                // Otherwise, remove it
                navbar.classList.remove('scrolled');
            }
        });
    }

    // --- 3. Advanced Solar Calculator with Dynamic Pricing ---
    const calculatorForm = document.getElementById('solarCalculator');
    if (calculatorForm) {
        calculatorForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const fullName = document.getElementById('fullNameCalc').value.trim();
            const phone = document.getElementById('phoneCalc').value.trim();
            const email = document.getElementById('emailCalc').value.trim();
            const monthlyBill = parseFloat(document.getElementById('monthlyBill').value);
            const propertyType = document.getElementById('propertyType').value;
            const rooftopArea = parseFloat(document.getElementById('rooftopArea').value) || 0;

            // Validate phone number
            if (!/^[0-9]{10}$/.test(phone)) {
                alert('Please enter a valid 10-digit phone number');
                document.getElementById('phoneCalc').focus();
                return;
            }

            if (fullName && phone && email && monthlyBill && propertyType) {
                // Advanced solar calculations with dynamic pricing
                const unitsPerMonth = monthlyBill / 6.5; // Updated average rate per unit
                let systemSizeKW = Math.ceil(unitsPerMonth / 120); // 120 units per kW per month

                // Dynamic pricing based on property type and system size
                let basePricePerKW;
                let installationMultiplier = 1;

                switch (propertyType) {
                    case 'residential':
                        basePricePerKW = 65000; // Base price for residential
                        if (systemSizeKW <= 3) installationMultiplier = 1.1;
                        else if (systemSizeKW <= 5) installationMultiplier = 1.0;
                        else installationMultiplier = 0.95;
                        break;
                    case 'commercial':
                        basePricePerKW = 58000; // Slightly lower for commercial
                        installationMultiplier = 0.9;
                        break;
                    case 'industrial':
                        basePricePerKW = 52000; // Best rates for industrial
                        installationMultiplier = 0.85;
                        break;
                    default:
                        basePricePerKW = 65000;
                }

                // Calculate pricing
                const totalSystemCost = systemSizeKW * basePricePerKW * installationMultiplier;
                const governmentSubsidy = Math.min(78000, systemSizeKW * 18000); // Max ₹78k or ₹18k per kW
                const finalPrice = totalSystemCost - governmentSubsidy;

                // Calculate savings
                const monthlySavings = Math.round(monthlyBill * 0.87); // 87% savings
                const annualSavings = monthlySavings * 12;
                const paybackPeriod = Math.round((finalPrice / annualSavings) * 10) / 10;

                // Calculate EMI options
                const emiOptions = {
                    '12months': Math.round(finalPrice / 12),
                    '24months': Math.round(finalPrice / 24),
                    '36months': Math.round(finalPrice / 36),
                    '60months': Math.round(finalPrice / 60)
                };

                // Display results with enhanced information
                let resultsHTML = `
                    <div class="alert alert-light">
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
                            <a href="contact.php" class="btn btn-primary btn-lg me-2">Get Detailed Quote</a>
                            <a href="tel:+919876543210" class="btn btn-outline-primary">Call Now</a>
                        </div>
                    </div>
                `;

                document.getElementById('calculatorResults').innerHTML = resultsHTML;
                document.getElementById('calculatorResults').style.display = 'block';

                // Scroll to results
                document.getElementById('calculatorResults').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Enhanced lead data for CRM integration
                const leadData = {
                    name: fullName,
                    phone: phone,
                    email: email,
                    monthlyBill: monthlyBill,
                    propertyType: propertyType,
                    rooftopArea: rooftopArea,
                    systemSize: systemSizeKW,
                    estimatedCost: finalPrice,
                    monthlySavings: monthlySavings,
                    paybackPeriod: paybackPeriod,
                    timestamp: new Date().toISOString(),
                    source: 'website_calculator'
                };

                console.log('High-Quality Lead Generated:', leadData);

                // Show personalized message
                setTimeout(() => {
                    alert(`Hi ${fullName}! Your personalized solar solution is ready. A ${systemSizeKW}kW system will save you ₹${monthlySavings.toLocaleString()} monthly. Our expert will call you at ${phone} within 30 minutes with detailed pricing and next steps.`);
                }, 1500);
            }
        });
    }

    // --- 4. Dynamic Pricing Form (for pricing page) ---
    const dynamicPricingForm = document.getElementById('dynamicPricingForm');
    if (dynamicPricingForm) {
        dynamicPricingForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const fullName = document.getElementById('fullNameDP').value.trim();
            const phone = document.getElementById('phoneDP').value.trim();
            const propertyType = document.getElementById('propertyTypeDP').value;
            const monthlyBill = parseFloat(document.getElementById('monthlyBillDP').value);
            const rooftopArea = parseFloat(document.getElementById('rooftopAreaDP').value) || 0;
            const location = document.getElementById('locationDP').value;

            // Validate phone number
            if (!/^[0-9]{10}$/.test(phone)) {
                alert('Please enter a valid 10-digit phone number');
                document.getElementById('phoneDP').focus();
                return;
            }

            if (fullName && phone && propertyType && monthlyBill) {
                // Advanced pricing calculation
                let basePricePerKW = 62000; // Base price
                let locationMultiplier = 1;
                let propertyMultiplier = 1;

                // Location-based pricing (transportation, accessibility)
                switch (location) {
                    case 'malviya_nagar':
                    case 'vaishali_nagar':
                    case 'c_scheme':
                        locationMultiplier = 1.0; // Central areas
                        break;
                    case 'mansarovar':
                    case 'bani_park':
                        locationMultiplier = 0.98; // Nearby areas
                        break;
                    case 'sitapura':
                    case 'sanganer':
                        locationMultiplier = 0.95; // Industrial areas, easier access
                        break;
                    default:
                        locationMultiplier = 1.02; // Other/remote areas
                }

                // Property type multiplier
                switch (propertyType) {
                    case 'apartment':
                        propertyMultiplier = 1.1; // More complex installation
                        break;
                    case 'independent_house':
                        propertyMultiplier = 1.0; // Standard
                        break;
                    case 'villa':
                        propertyMultiplier = 0.95; // Larger installations, better rates
                        break;
                    case 'commercial':
                        propertyMultiplier = 0.88; // Commercial rates
                        break;
                }

                // Calculate system requirements
                const unitsPerMonth = monthlyBill / 6.5;
                let systemSizeKW = Math.ceil(unitsPerMonth / 120);

                // System size optimization
                if (rooftopArea > 0) {
                    const maxSystemSize = Math.floor(rooftopArea / 80); // ~80 sq ft per kW
                    systemSizeKW = Math.min(systemSizeKW, maxSystemSize);
                }

                // Final pricing calculation
                const pricePerKW = basePricePerKW * locationMultiplier * propertyMultiplier;
                const totalSystemCost = systemSizeKW * pricePerKW;
                const governmentSubsidy = Math.min(78000, systemSizeKW * 18000);
                const finalInvestment = totalSystemCost - governmentSubsidy;

                // Savings calculation
                const coveragePercentage = Math.min(95, (systemSizeKW * 120) / unitsPerMonth * 100);
                const monthlySavings = Math.round(monthlyBill * (coveragePercentage / 100));
                const annualSavings = monthlySavings * 12;
                const paybackPeriod = Math.round((finalInvestment / annualSavings) * 10) / 10;

                // Display personalized results
                const resultsHTML = `
                    <div class="alert alert-light text-dark">
                        <h4 class="text-primary mb-3">🎆 Your Personalized Solar Solution</h4>
                        <div class="row text-center mb-4">
                            <div class="col-6 col-md-3">
                                <h6>System Size</h6>
                                <div class="h5 text-primary">${systemSizeKW} kW</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <h6>Bill Coverage</h6>
                                <div class="h5 text-success">${Math.round(coveragePercentage)}%</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <h6>Monthly Savings</h6>
                                <div class="h5 text-success">₹${monthlySavings.toLocaleString()}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <h6>Payback</h6>
                                <div class="h5 text-info">${paybackPeriod} years</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">💰 Investment Breakdown</h6>
                                <table class="table table-sm">
                                    <tr><td>System Cost:</td><td class="text-end">₹${totalSystemCost.toLocaleString()}</td></tr>
                                    <tr><td>Govt. Subsidy:</td><td class="text-end text-success">-₹${governmentSubsidy.toLocaleString()}</td></tr>
                                    <tr class="fw-bold"><td>Your Investment:</td><td class="text-end">₹${finalInvestment.toLocaleString()}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">📈 25-Year Benefits</h6>
                                <table class="table table-sm">
                                    <tr><td>Total Savings:</td><td class="text-end text-success">₹${(annualSavings * 25).toLocaleString()}</td></tr>
                                    <tr><td>Net Profit:</td><td class="text-end text-success">₹${(annualSavings * 25 - finalInvestment).toLocaleString()}</td></tr>
                                    <tr><td>ROI:</td><td class="text-end text-success">${Math.round((annualSavings * 25 / finalInvestment) * 100)}%</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="contact.php" class="btn btn-primary btn-lg me-2">📧 Get Official Quote</a>
                            <a href="tel:+919876543210" class="btn btn-outline-primary">📞 Call Expert</a>
                        </div>
                        <p class="text-center mt-3 mb-0"><small class="text-muted">* This is a preliminary estimate. Final pricing will be confirmed after site survey.</small></p>
                    </div>
                `;

                document.getElementById('dynamicPricingResults').innerHTML = resultsHTML;
                document.getElementById('dynamicPricingResults').style.display = 'block';

                // Scroll to results
                document.getElementById('dynamicPricingResults').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Track the lead with contact information
                const leadData = {
                    name: fullName,
                    phone: phone,
                    propertyType,
                    monthlyBill,
                    location,
                    systemSizeKW,
                    finalInvestment,
                    monthlySavings: monthlySavings,
                    source: 'pricing_calculator',
                    timestamp: new Date().toISOString()
                };
                console.log('Dynamic Pricing Lead with Contact Info:', leadData);

                // Show personalized thank you message
                setTimeout(() => {
                    alert(`Thank you ${fullName}! Your personalized ${systemSizeKW}kW solar solution can save you ₹${monthlySavings.toLocaleString()} monthly. Our solar expert will call you at ${phone} within 2 hours with detailed pricing and next steps.`);
                }, 1000);
            }
        });
    }
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // --- 5. Number Counter Animation ---
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const numberObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalNumber = target.textContent;
                const isRupee = finalNumber.includes('₹');
                const hasPlus = finalNumber.includes('+');

                let number = parseInt(finalNumber.replace(/[^0-9]/g, ''));
                let current = 0;
                const increment = number / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= number) {
                        current = number;
                        clearInterval(timer);
                    }

                    let displayText = Math.floor(current).toString();
                    if (isRupee) displayText = '₹' + displayText + (current >= 100 ? 'Cr' : '');
                    if (hasPlus) displayText += '+';

                    target.textContent = displayText;
                }, 50);

                numberObserver.unobserve(target);
            }
        });
    }, observerOptions);

    // Observe all stat numbers
    document.querySelectorAll('.stat-number').forEach(stat => {
        numberObserver.observe(stat);
    });

    // --- 6. Popup Quote Form Logic ---
    const popupQuoteModal = document.getElementById('popupQuoteModal');
    if (popupQuoteModal) {
        // Check if we should show popup
        const currentPage = window.location.pathname.split('/').pop();
        const excludePages = ['contact.php', 'admin'];
        const shouldShowPopup = !excludePages.some(page =>
            currentPage.includes(page) || window.location.pathname.includes(page)
        );

        // Check if popup was already shown in this session
        const popupShown = sessionStorage.getItem('popupQuoteShown');

        if (shouldShowPopup && !popupShown) {
            // Show popup after 5 seconds
            setTimeout(() => {
                const modal = new bootstrap.Modal(popupQuoteModal);
                modal.show();

                // Mark as shown in session
                sessionStorage.setItem('popupQuoteShown', 'true');
            }, 5000);
        }

        // Handle popup form submission
        const popupForm = document.getElementById('popupQuoteForm');
        if (popupForm) {
            popupForm.addEventListener('submit', function (e) {
                const phone = document.getElementById('popupPhone').value.trim();

                // Validate phone number
                if (!/^[0-9]{10}$/.test(phone)) {
                    e.preventDefault();
                    alert('Please enter a valid 10-digit phone number');
                    document.getElementById('popupPhone').focus();
                    return false;
                }

                // Show success message on submission
                setTimeout(() => {
                    alert('Thank you! Your quote request has been submitted. Our solar expert will call you within 2 hours.');
                }, 100);
            });
        }
    }

});

$(document).on('input', '.phone', function () {
    // Remove all non-numeric characters
    let value = this.value.replace(/[^0-9]/g, '');

    // Ensure the first digit starts with 6, 7, 8, or 9
    if (value.length > 0 && !/^[6-9]/.test(value)) {
        value = value.replace(/^[^6-9]+/, ''); // remove invalid starting digits
    }

    // Limit to 10 digits maximum
    if (value.length > 10) {
        value = value.slice(0, 10);
    }

    // Update the input value
    this.value = value;
});
