<?php
// Define page-specific SEO data
$seoData = [
    'Home' => [
        'description' => 'Zero What Solar - Jaipur\'s #1 solar energy company. Get up to ₹78,000 government subsidy. 500+ happy customers. Professional solar installation with 25-year warranty.',
        'keywords' => 'solar panels Jaipur, rooftop solar installation Jaipur, government solar subsidy, residential solar systems, commercial solar Rajasthan',
        'schema' => '{
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Zero What Solar",
            "description": "Solar energy installation company in Jaipur",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Sitapura Industrial Area",
                "addressLocality": "Jaipur",
                "addressRegion": "Rajasthan",
                "postalCode": "302022",
                "addressCountry": "IN"
            },
            "telephone": "+919876543210",
            "email": "contact@zerowhatsolar.in",
            "url": "https://zerowhatsolar.in",
            "openingHours": "Mo-Sa 10:00-18:00",
            "priceRange": "₹₹₹",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.9",
                "reviewCount": "500"
            }
        }'
    ],
    'About Us' => [
        'description' => 'About Zero What Solar - Jaipur\'s trusted solar energy partner. 5+ years experience, 500+ installations, government-approved solar solutions with guaranteed savings.',
        'keywords' => 'about Zero What Solar, solar company Jaipur, solar installer experience, government approved solar partner',
        'schema' => null
    ],
    'Our Services' => [
        'description' => 'Complete solar solutions in Jaipur - Residential, Commercial & Industrial. 1kW-10MW systems, government subsidy processing, maintenance & financing available.',
        'keywords' => 'solar services Jaipur, residential solar, commercial solar, industrial solar, solar maintenance, solar financing',
        'schema' => null
    ],
    'Our Projects' => [
        'description' => 'Zero What Solar project portfolio - 500+ successful installations across Jaipur. View our residential, commercial & industrial solar project gallery.',
        'keywords' => 'solar projects Jaipur, solar installation portfolio, residential solar examples, commercial solar case studies',
        'schema' => null
    ],
    'Contact Us' => [
        'description' => 'Contact Zero What Solar for FREE consultation. Get instant quote, government subsidy assistance. Call +91-9876543210 or visit Sitapura, Jaipur.',
        'keywords' => 'contact solar company Jaipur, free solar consultation, solar quote Jaipur, Zero What Solar contact',
        'schema' => null
    ],
    'Solar Subsidy Information' => [
        'description' => 'Government of India solar subsidy information - Get up to ₹78,000 subsidy for rooftop solar. Zero What Solar handles complete paperwork.',
        'keywords' => 'solar subsidy India, government solar benefits, rooftop solar subsidy, MNRE subsidy, solar financing',
        'schema' => null
    ],
    'Solar Energy Blog' => [
        'description' => 'Expert solar energy blog by Zero What Solar. Get latest updates, installation guides, maintenance tips, and government policy news for Jaipur solar market.',
        'keywords' => 'solar energy blog Jaipur, solar installation guide, solar maintenance tips, solar policy updates, renewable energy news',
        'schema' => null
    ],
    'Blog Post' => [
        'description' => 'Read detailed solar energy articles by Zero What Solar experts. Installation guides, cost analysis, maintenance tips for Jaipur solar customers.',
        'keywords' => 'solar energy articles, solar installation guide, solar cost analysis, solar maintenance, Jaipur solar tips',
        'schema' => null
    ]
];

$currentSEO = $seoData[$pageTitle] ?? $seoData['Home'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?> | Zero What Solar - Jaipur's #1 Solar Company</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $currentSEO['description']; ?>">
    <meta name="keywords" content="<?php echo $currentSEO['keywords']; ?>">
    <meta name="author" content="Zero What Solar">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://zerowhatsolar.in/<?php echo strtolower(str_replace(' ', '-', $pageTitle)); ?>.php">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://zerowhatsolar.in/">
    <meta property="og:title" content="<?php echo $pageTitle; ?> | Zero What Solar">
    <meta property="og:description" content="<?php echo $currentSEO['description']; ?>">
    <meta property="og:image" content="https://zerowhatsolar.in/assets/images/og-image.jpg">
    <meta property="og:site_name" content="Zero What Solar">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://zerowhatsolar.in/">
    <meta property="twitter:title" content="<?php echo $pageTitle; ?> | Zero What Solar">
    <meta property="twitter:description" content="<?php echo $currentSEO['description']; ?>">
    <meta property="twitter:image" content="https://zerowhatsolar.in/assets/images/og-image.jpg">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <?php if ($currentSEO['schema']): ?>
    <!-- Structured Data -->
    <script type="application/ld+json">
    <?php echo $currentSEO['schema']; ?>
    </script>
    <?php endif; ?>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="Zero What Solar Logo" style="height: 50px;">
            <!-- Zero What Solar -->
        </a>
        <!-- Always visible Quote button -->
        <a href="contact.php" class="btn btn-success d-block d-lg-none me-2" style="font-size: 0.85rem; padding: 8px 12px;">Get Quote</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="projects.php">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="subsidy.php">Subsidy Info</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
            <!-- Desktop Quote button -->
            <a href="contact.php" class="btn btn-success ms-lg-3 d-none d-lg-block">Get a Free Quote</a>
        </div>
    </div>
</nav>

<main>