<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.svg">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/site.webmanifest">
    
    <?php wp_head(); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip Link for Accessibility -->
<a class="skip-link" href="#main-content" id="skip-to-main">Skip to main content</a>

<div id="page" class="site">
    
    <!-- Mobile navigation removed - single page advocacy site doesn't need navigation -->

    <div id="content" class="site-content">
        <!-- ARIA Live Region for main content updates -->
        <div aria-live="polite" 
             aria-atomic="false" 
             class="sr-only" 
             id="main-content-status"></div>