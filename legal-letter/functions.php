<?php
/**
 * Hello Child Theme Functions
 * 
 * This file contains all the functions and enqueues for the child theme.
 * It properly loads the parent theme styles and adds Google Fonts integration.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent theme stylesheet and Google Fonts
 */
function hello_child_enqueue_styles() {
    // Get parent theme version for cache busting
    $parent_style = 'twentytwentyfive';
    $parent_theme = wp_get_theme('twentytwentyfive');
    $parent_version = $parent_theme->get('Version');
    
    // Enqueue parent theme stylesheet
    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css',
        array(),
        $parent_version
    );
    
    // Enqueue Google Fonts
    wp_enqueue_style(
        'hello-child-google-fonts',
        'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap',
        array(),
        null
    );
    
    // Enqueue child theme stylesheet with high priority
    wp_enqueue_style(
        'legal-theme-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style, 'hello-child-google-fonts'),
wp_get_theme()->get('Version') . '-v2.6'
    );
}
add_action('wp_enqueue_scripts', 'hello_child_enqueue_styles');

/**
 * Force load CSS on signup page as fallback
 */
function force_signup_css() {
    if (is_page('signup') || strpos($_SERVER['REQUEST_URI'], '/signup') !== false) {
        wp_enqueue_style(
            'signup-page-css',
            get_stylesheet_directory_uri() . '/style.css',
            array(),
wp_get_theme()->get('Version') . '-v2.6',
            'all'
        );
        
        // Also add critical CSS inline as absolute fallback
        $critical_css = "
        body.signup-page { margin: 0; padding: 0; min-height: 100vh; }
        body.signup-page .site-header { display: none !important; }
        body.custom-background::before { content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-image: url('" . get_stylesheet_directory_uri() . "/parchment-background.jpg'); background-size: cover; background-position: center; z-index: -2; }
        body.custom-background::after { content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255, 255, 255, 0.5); z-index: -1; }
        .signup-container { min-height: calc(100vh - 200px); display: flex; align-items: center; justify-content: center; padding: 2rem 2rem 3rem; }
        .signup-content { width: 100%; max-width: 600px; background: white; border-radius: 20px; box-shadow: 0 16px 64px rgba(0, 0, 0, 0.12); position: relative; }
        .signup-content::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #1e3a8a 0%, #f59e0b 100%); }
        .signup-header { padding: 3rem 3rem 2rem; text-align: center; }
        .signup-header h1 { font-size: 2rem; color: #0f172a; margin: 0 0 1rem; font-family: 'Merriweather', serif; }
        .signup-subtitle { color: #64748b; margin: 0; }
        
        /* Global Form Error */
        .form-error { 
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(254, 226, 226, 0.8)); 
            border: 2px solid #ef4444; 
            border-radius: 12px; 
            padding: 1rem 1.5rem; 
            margin: 0 3rem 2rem; 
            text-align: center; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 0.5rem; 
        }
        .form-error .error-icon { font-size: 1.2rem; }
        .form-error .error-text { color: #dc2626; font-weight: 600; margin: 0; }
        
        /* Form Styling */
        .signup-form { padding: 0 3rem 3rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
        .form-group { margin-bottom: 2rem; position: relative; }
        .form-group label { 
            display: block; 
            margin-bottom: 0.5rem; 
            font-weight: 600; 
            color: #0f172a; 
            text-transform: uppercase; 
            font-size: 0.9rem; 
            letter-spacing: 0.025em; 
        }
        .form-group input { 
            width: 100%; 
            padding: 1rem 1.5rem; 
            border: 2px solid rgba(30, 58, 138, 0.15); 
            border-radius: 8px; 
            font-size: 1rem; 
            box-sizing: border-box; 
            transition: all 0.3s ease; 
            background: #ffffff;
        }
        .form-group input:focus { 
            border-color: #1e3a8a; 
            outline: none; 
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); 
        }
        .form-group input::placeholder { color: #9ca3af; opacity: 0.8; }
        
        /* Field Error Messages */
        .field-error { 
            color: #dc2626; 
            font-size: 0.875rem; 
            margin-top: 0.5rem; 
            font-weight: 500; 
            min-height: 1.25rem; 
            display: flex; 
            align-items: center; 
            gap: 0.25rem; 
        }
        /* Only show warning icons when there's an actual error message */
        .field-error:not(:empty):before { content: '⚠️'; margin-right: 0.25rem; }
        
        /* Error State */
        .form-group.error input { 
            border-color: #ef4444; 
            background: rgba(254, 226, 226, 0.3); 
            color: #dc2626; 
        }
        .form-group.error input:focus { 
            border-color: #ef4444; 
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1); 
        }
        .form-group.error label { color: #dc2626; }
        
        /* Success State */
        .form-group.success input { 
            border-color: #10b981; 
            background: rgba(209, 250, 229, 0.3); 
        }
        .form-group.success input:focus { 
            border-color: #10b981; 
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); 
        }
        .form-group.success::after { 
            content: '✅'; 
            position: absolute; 
            right: 1rem; 
            top: 2.8rem; 
            font-size: 1rem; 
        }
        
        /* Trust Indicators */
        .form-trust-indicators { 
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(209, 250, 229, 0.1)); 
            border: 1px solid rgba(16, 185, 129, 0.2); 
            border-radius: 12px; 
            padding: 1.5rem; 
            margin: 2rem 0; 
        }
        .trust-item { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
            margin-bottom: 0.5rem; 
            color: #047857; 
            font-weight: 500; 
        }
        .trust-item:last-child { margin-bottom: 0; }
        .trust-icon { font-size: 1.1rem; }
        
        /* Submit Button */
        .form-submit { margin-top: 2rem; }
        .submit-btn { 
            width: 100%; 
            padding: 1.25rem 2rem; 
            background: linear-gradient(135deg, #1e3a8a, #3b82f6); 
            color: white; 
            border: none; 
            border-radius: 12px; 
            font-size: 1.1rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 0.5rem; 
        }
        .submit-btn:hover { 
            background: linear-gradient(135deg, #1e40af, #2563eb); 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3); 
        }
        .submit-btn:disabled { 
            opacity: 0.6; 
            cursor: not-allowed; 
            transform: none; 
        }
        .btn-icon { font-size: 1.2rem; }
        
        /* Footer */
        .form-footer { 
            padding: 0 3rem 3rem; 
            text-align: center; 
        }
        .legal-notice { 
            color: #64748b; 
            font-size: 0.9rem; 
            line-height: 1.6; 
            margin: 0; 
            padding: 1.5rem; 
            background: rgba(248, 250, 252, 0.8); 
            border-radius: 8px; 
            border: 1px solid #e2e8f0; 
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) { 
            .signup-container { padding: 1rem; }
            .signup-content { border-radius: 16px; }
            .signup-header, .signup-form, .form-footer { padding-left: 2rem; padding-right: 2rem; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .form-group { margin-bottom: 1.5rem; }
            .form-error { margin-left: 2rem; margin-right: 2rem; }
            .form-group.success::after { top: 2.6rem; }
        }
        @media (max-width: 480px) { 
            .signup-header, .signup-form, .form-footer { padding-left: 1.5rem; padding-right: 1.5rem; }
            .form-error { margin-left: 1.5rem; margin-right: 1.5rem; }
            .signup-header h1 { font-size: 1.75rem; }
        }
        ";
        
        wp_add_inline_style('signup-page-css', $critical_css);
    }
}
add_action('wp_enqueue_scripts', 'force_signup_css', 999);

/**
 * Add cache-busting headers for CSS files
 */
function add_css_cache_busting() {
    if (is_page('signup') || strpos($_SERVER['REQUEST_URI'], '/signup') !== false) {
        // Add cache-busting headers for signup page
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    }
}
add_action('send_headers', 'add_css_cache_busting');

/**
 * Add preconnect links for Google Fonts for better performance
 */
function hello_child_add_google_fonts_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'hello_child_add_google_fonts_preconnect', 1);

/**
 * Add custom theme support features
 */
function hello_child_theme_support() {
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    
    // Add support for custom background (for admin customizer)
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));
    
    // Add editor styles
    add_theme_support('editor-styles');
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'hello_child_theme_support');

/**
 * Customize excerpt length for better content display
 */
function hello_child_excerpt_length($length) {
    return 25; // Shorter excerpts for better layout
}
add_filter('excerpt_length', 'hello_child_excerpt_length');

/**
 * Customize excerpt more text
 */
function hello_child_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '" class="accent-link">Read More</a>';
}
add_filter('excerpt_more', 'hello_child_excerpt_more');

/**
 * Add custom CSS classes to body for better styling control
 */
function hello_child_body_classes($classes) {
    // Add class for legal letter site
    $classes[] = 'legal-letter-site';
    
    // Add class for professional theme
    $classes[] = 'professional-theme';
    
    // Add class based on page type
    if (is_front_page()) {
        $classes[] = 'landing-page';
    }
    
    if (is_page('thank-you')) {
        $classes[] = 'thank-you-page';
    }
    
    return $classes;
}
add_filter('body_class', 'hello_child_body_classes');

/**
 * Enqueue additional scripts for enhanced functionality
 */
function hello_child_enqueue_scripts() {
    // Enqueue our custom JavaScript
    wp_enqueue_script(
        'hello-child-custom',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'hello_child_enqueue_scripts');

/**
 * Add custom meta tags for better SEO and social sharing
 */
function hello_child_add_meta_tags() {
    if (is_front_page()) {
        echo '<meta name="description" content="NC Lawyers Advocacy - Join fellow trial lawyers in opposing attacks on the rule of law. Sign the open letter today.">' . "\n";
        echo '<meta name="keywords" content="NC lawyers, trial lawyers, rule of law, legal advocacy, North Carolina">' . "\n";
        
        // Open Graph tags for social sharing
        echo '<meta property="og:title" content="NC Lawyers Advocacy - Defending the Rule of Law">' . "\n";
        echo '<meta property="og:description" content="Join fellow trial lawyers in opposing attacks on the rule of law. Sign the open letter today.">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . get_home_url() . '">' . "\n";
    }
}
add_action('wp_head', 'hello_child_add_meta_tags');

/**
 * Add security headers for better site protection
 */
function hello_child_add_security_headers() {
    // Only add headers if not in admin area
    if (!is_admin()) {
        // Prevent clickjacking
        header('X-Frame-Options: SAMEORIGIN');
        
        // XSS Protection
        header('X-XSS-Protection: 1; mode=block');
        
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // Referrer Policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'hello_child_add_security_headers');

/**
 * Customize WordPress admin bar for better user experience
 */
function hello_child_customize_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'hello_child_customize_admin_bar');

/**
 * Add custom page templates
 */
function hello_child_add_page_templates($templates) {
    $templates['page-home.php'] = 'Legal Advocacy Landing Page';
    $templates['page-signup.php'] = 'Signup Page';
    $templates['page-thank-you.php'] = 'Thank You Page';
    return $templates;
}
add_filter('theme_page_templates', 'hello_child_add_page_templates');

/**
 * Load custom page template
 */
function hello_child_load_page_template($template) {
    global $post;
    
    if ($post) {
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        if ($page_template == 'page-home.php') {
            $file = get_stylesheet_directory() . '/page-home.php';
            if (file_exists($file)) {
                return $file;
            }
        }
        if ($page_template == 'page-signup.php') {
            $file = get_stylesheet_directory() . '/page-signup.php';
            if (file_exists($file)) {
                return $file;
            }
        }
        if ($page_template == 'page-thank-you.php') {
            $file = get_stylesheet_directory() . '/page-thank-you.php';
            if (file_exists($file)) {
                return $file;
            }
        }
    }
    
    return $template;
}
add_filter('page_template', 'hello_child_load_page_template');

/**
 * Add custom shortcode for form container
 * Usage: [form_container]Your form HTML here[/form_container]
 */
function hello_child_form_container_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'class' => 'form-container',
        'id' => '',
    ), $atts);
    
    $id_attr = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';
    
    return '<div class="' . esc_attr($atts['class']) . '"' . $id_attr . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('form_container', 'twentytwentyfive_child_form_container_shortcode');

/**
 * Performance optimization: Remove unnecessary WordPress features
 */
function hello_child_optimize_performance() {
    // Remove emoji scripts (not needed for professional site)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove Windows Live Writer manifest
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'hello_child_optimize_performance');

/**
 * =============================================
 * INVITE CODE SIGNUP SYSTEM
 * =============================================
 */

/**
 * Create invite codes table
 */
function create_invite_codes_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'invite_codes';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        code varchar(10) NOT NULL,
        used tinyint(1) DEFAULT 0,
        used_date datetime DEFAULT NULL,
        created_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY code (code)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Create submissions table
 */
function create_submissions_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'signup_submissions';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name varchar(100) NOT NULL,
        last_name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        law_firm varchar(200) DEFAULT '',
        invite_code varchar(10) NOT NULL,
        submission_date datetime DEFAULT CURRENT_TIMESTAMP,
        is_founding tinyint(1) DEFAULT 0,
        display_order int DEFAULT 999,
        PRIMARY KEY (id),
        INDEX idx_invite_code (invite_code),
        INDEX idx_email (email),
        INDEX idx_founding (is_founding),
        INDEX idx_display_order (display_order)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Update existing submissions table to add new columns
 */
function update_submissions_table_structure() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';

    // Check if is_founding column exists and add it if missing
    $is_founding_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'is_founding'");
    if (!$is_founding_exists) {
        $result1 = $wpdb->query("ALTER TABLE $table_name ADD COLUMN is_founding tinyint(1) DEFAULT 0");
        if ($result1 === false) {
            error_log("Failed to add is_founding column: " . $wpdb->last_error);
        }
    }

    // Check if display_order column exists and add it if missing
    $display_order_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'display_order'");
    if (!$display_order_exists) {
        $result2 = $wpdb->query("ALTER TABLE $table_name ADD COLUMN display_order int DEFAULT 999");
        if ($result2 === false) {
            error_log("Failed to add display_order column: " . $wpdb->last_error);
        }
    }

    // Add indexes if columns were just created
    if (!$is_founding_exists) {
        $wpdb->query("ALTER TABLE $table_name ADD INDEX idx_founding (is_founding)");
    }
    if (!$display_order_exists) {
        $wpdb->query("ALTER TABLE $table_name ADD INDEX idx_display_order (display_order)");
    }

    // Fix law_firm column to allow empty values (for CSV import compatibility)
    $law_firm_column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'law_firm'");
    if (!empty($law_firm_column)) {
        $column_info = $law_firm_column[0];
        if ($column_info->Null === 'NO' && $column_info->Default === null) {
            $wpdb->query("ALTER TABLE $table_name MODIFY law_firm varchar(200) DEFAULT ''");
        }
    }
}

/**
 * Import signees from CSV file
 */
function import_signees_from_csv($file_path) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';

    $results = array(
        'imported' => 0,
        'skipped' => 0,
        'errors' => array()
    );

    if (!file_exists($file_path)) {
        $results['errors'][] = 'File not found';
        return $results;
    }

    $handle = fopen($file_path, 'r');
    if (!$handle) {
        $results['errors'][] = 'Could not open file';
        return $results;
    }

    // Read header row to determine column positions
    $header = fgetcsv($handle);
    if (!$header) {
        $results['errors'][] = 'Invalid CSV format';
        fclose($handle);
        return $results;
    }

    // Find column indexes (case insensitive)
    $first_name_idx = false;
    $last_name_idx = false;
    $email_idx = false;
    $law_firm_idx = false;

    foreach ($header as $idx => $col) {
        $col = strtolower(trim($col));
        if (in_array($col, ['first_name', 'first name', 'firstname'])) {
            $first_name_idx = $idx;
        } elseif (in_array($col, ['last_name', 'last name', 'lastname'])) {
            $last_name_idx = $idx;
        } elseif (in_array($col, ['email', 'email_address', 'email address'])) {
            $email_idx = $idx;
        } elseif (in_array($col, ['law_firm', 'law firm', 'firm', 'company'])) {
            $law_firm_idx = $idx;
        }
    }

    // Check required columns
    if ($first_name_idx === false || $last_name_idx === false || $email_idx === false) {
        $results['errors'][] = 'CSV must contain first_name, last_name, and email columns';
        fclose($handle);
        return $results;
    }

    // Process data rows
    $row_num = 1;
    while (($row = fgetcsv($handle)) !== FALSE) {
        $row_num++;

        $first_name = trim($row[$first_name_idx] ?? '');
        $last_name = trim($row[$last_name_idx] ?? '');
        $email_raw = trim($row[$email_idx] ?? '');
        $law_firm = trim($row[$law_firm_idx] ?? '');

        // Extract email from "Name <email@domain.com>" format if needed
        $email = $email_raw;
        if (preg_match('/<([^>]+)>/', $email_raw, $matches)) {
            $email = trim($matches[1]);
        }

        // Validate required fields
        if (empty($first_name) || empty($last_name) || empty($email)) {
            $results['errors'][] = "Row $row_num: Missing required fields";
            continue;
        }

        // Validate email format
        if (!is_email($email)) {
            $results['errors'][] = "Row $row_num: Invalid email format ($email)";
            continue;
        }

        // Check if email already exists
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE email = %s",
            $email
        ));

        if ($existing > 0) {
            $results['skipped']++;
            continue;
        }

        // Ensure law_firm is not empty to avoid NOT NULL constraint issues
        if (empty($law_firm)) {
            $law_firm = 'Not Specified';
        }

        // Check if new columns exist before inserting
        $has_new_columns = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'is_founding'");

        if ($has_new_columns) {
            // Insert with new columns
            $insert_result = $wpdb->insert(
                $table_name,
                array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'law_firm' => $law_firm,
                    'invite_code' => 'CSV_IMPORT',
                    'submission_date' => current_time('mysql'),
                    'is_founding' => 0,
                    'display_order' => 999
                ),
                array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d')
            );
        } else {
            // Insert without new columns (fallback for old schema)
            $insert_result = $wpdb->insert(
                $table_name,
                array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'law_firm' => $law_firm,
                    'invite_code' => 'CSV_IMPORT',
                    'submission_date' => current_time('mysql')
                ),
                array('%s', '%s', '%s', '%s', '%s', '%s')
            );
        }

        if ($insert_result !== false) {
            $results['imported']++;
        } else {
            $db_error = $wpdb->last_error ? ': ' . $wpdb->last_error : '';
            $results['errors'][] = "Row $row_num: Database error inserting $email$db_error";
        }
    }

    fclose($handle);
    return $results;
}

// Note: mark_founding_signers function removed - committee members are now hardcoded in get_signees_list()

/**
 * Run table creation on theme activation
 */
add_action('after_switch_theme', 'create_invite_codes_table');
add_action('after_switch_theme', 'create_submissions_table');
add_action('after_switch_theme', 'update_submissions_table_structure');

/**
 * Check if required database tables exist
 */
function legal_letter_tables_exist() {
    global $wpdb;
    
    $invite_table = $wpdb->prefix . 'invite_codes';
    $submissions_table = $wpdb->prefix . 'signup_submissions';
    
    $invite_exists = $wpdb->get_var("SHOW TABLES LIKE '$invite_table'") === $invite_table;
    $submissions_exists = $wpdb->get_var("SHOW TABLES LIKE '$submissions_table'") === $submissions_table;
    
    return $invite_exists && $submissions_exists;
}

/**
 * Generate invite codes
 */
function generate_invite_codes($count = 1000) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'invite_codes';
    
    $generated = 0;
    $max_attempts = $count * 3; // Prevent infinite loops
    $attempts = 0;
    
    while ($generated < $count && $attempts < $max_attempts) {
        $attempts++;
        
        // Generate 6-character lowercase alphanumeric code
        $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
        
        // Check if code already exists
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE code = %s",
            $code
        ));
        
        if ($exists == 0) {
            $result = $wpdb->insert(
                $table_name,
                array('code' => $code),
                array('%s')
            );
            
            if ($result !== false) {
                $generated++;
            }
        }
    }
    
    return $generated;
}

/**
 * Handle signup form submission
 */
function handle_signup_form() {
    // Only handle POST requests with our nonce
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['signup_nonce']) || !wp_verify_nonce($_POST['signup_nonce'], 'signup_form')) {
        return;
    }
    
    // Log the form submission attempt
    error_log('Legal Letter: Form submission started for IP: ' . $_SERVER['REMOTE_ADDR']);
    
    global $wpdb;
    $invite_table = $wpdb->prefix . 'invite_codes';
    $submissions_table = $wpdb->prefix . 'signup_submissions';
    
    // Ensure database tables exist (create if missing)
    if (!legal_letter_tables_exist()) {
        error_log('Legal Letter: Database tables missing, creating...');
        create_invite_codes_table();
        create_submissions_table();
        
        // Verify tables were created
        if (!legal_letter_tables_exist()) {
            error_log('Legal Letter: ERROR - Failed to create database tables');
            $_SESSION['signup_error'] = 'System error: Database not properly configured. Please contact support.';
            return;
        }
        error_log('Legal Letter: Database tables created successfully');
    }
    
    $invite_code = sanitize_text_field($_POST['invite_code']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    
    // Log received data (without sensitive info)
    error_log('Legal Letter: Processing submission for: ' . $email . ' with code: ' . $invite_code);
    
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email)) {
        error_log('Legal Letter: Validation failed - missing required fields');
        $_SESSION['signup_error'] = 'All fields are required.';
        return;
    }
    
    // Validate email format
    if (!is_email($email)) {
        error_log('Legal Letter: Validation failed - invalid email format: ' . $email);
        $_SESSION['signup_error'] = 'Please enter a valid email address.';
        return;
    }
    
    // Check if email already exists
    $email_exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $submissions_table WHERE email = %s",
        $email
    ));
    
    if ($email_exists > 0) {
        error_log('Legal Letter: Validation failed - email already exists: ' . $email);
        $_SESSION['signup_error'] = 'This email address has already been used for signup.';
        return;
    }
    
    // Validate invite code
    error_log('Legal Letter: Validating invite code: ' . $invite_code);
    $code_check = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $invite_table WHERE code = %s",
        $invite_code
    ));
    
    if (!$code_check) {
        error_log('Legal Letter: Validation failed - invite code not found: ' . $invite_code);
        $_SESSION['signup_error'] = 'Invalid invitation code. Please reach out to the committee for an invite code.';
    } elseif ($code_check->used) {
        error_log('Legal Letter: Validation failed - invite code already used: ' . $invite_code);
        $_SESSION['signup_error'] = 'This invitation has already been used.';
    } else {
        // Mark code as used
        error_log('Legal Letter: Marking invite code as used: ' . $invite_code);
        $update_result = $wpdb->update(
            $invite_table,
            array('used' => 1, 'used_date' => current_time('mysql')),
            array('code' => $invite_code),
            array('%d', '%s'),
            array('%s')
        );
        
        if ($update_result === false) {
            error_log('Legal Letter: ERROR - Failed to mark invite code as used');
            $_SESSION['signup_error'] = 'System error occurred. Please try again.';
            return;
        }
        
        // Store submission data
        error_log('Legal Letter: Storing submission data for: ' . $email);
        $insert_result = $wpdb->insert(
            $submissions_table,
            array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'law_firm' => '', // Keep field for database compatibility but set empty
                'invite_code' => $invite_code,
                'submission_date' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        // If database insert was successful, notify Laravel
        if ($insert_result !== false) {
            error_log('Legal Letter: Successfully stored submission, notifying Laravel');

            // Notify Laravel that signup is complete
            $webhook_result = call_laravel_signup_webhook($invite_code);
            if (!$webhook_result['success']) {
                error_log('Legal Letter: Laravel webhook failed for code ' . $invite_code . ': ' . $webhook_result['message']);
            } else {
                error_log('Legal Letter: Laravel webhook successful for code ' . $invite_code);
            }

            // Clear any previous session errors
            unset($_SESSION['signup_error']);

            // Redirect to success page
            error_log('Legal Letter: Redirecting to thank you page');
            wp_redirect(home_url('/thank-you/'));
            exit;
        } else {
            error_log('Legal Letter: ERROR - Failed to insert submission into database');
            $_SESSION['signup_error'] = 'System error occurred while saving your information. Please try again.';
            return;
        }
    }
}
add_action('init', 'handle_signup_form');

/**
 * Start session for error handling with better compatibility
 */
function start_session() {
    if (!session_id() && !headers_sent()) {
        // Set session parameters for better compatibility
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', is_ssl() ? 1 : 0);
        
        if (session_start()) {
            error_log('Legal Letter: Session started successfully');
        } else {
            error_log('Legal Letter: WARNING - Failed to start session');
        }
    }
}
add_action('init', 'start_session', 1);

/**
 * Add admin menu item to generate codes
 */
function add_invite_codes_admin_menu() {
    add_management_page(
        'Invite Codes Management',
        'Invite Codes',
        'manage_options',
        'invite-codes',
        'invite_codes_admin_page'
    );
}
add_action('admin_menu', 'add_invite_codes_admin_menu');

/**
 * Admin page for invite code management
 */
function invite_codes_admin_page() {
    // Handle form submissions
    if (isset($_POST['generate_codes'])) {
        $count = intval($_POST['code_count']);
        if ($count > 0) {
            $generated = generate_invite_codes($count);
            echo '<div class="notice notice-success"><p>Generated ' . $generated . ' invite codes successfully.</p></div>';
        }
    }
    
    // Get statistics
    global $wpdb;
    $codes_table = $wpdb->prefix . 'invite_codes';
    $submissions_table = $wpdb->prefix . 'signup_submissions';
    
    $total_codes = $wpdb->get_var("SELECT COUNT(*) FROM $codes_table");
    $used_codes = $wpdb->get_var("SELECT COUNT(*) FROM $codes_table WHERE used = 1");
    $available_codes = $total_codes - $used_codes;
    $total_submissions = $wpdb->get_var("SELECT COUNT(*) FROM $submissions_table");
    
    ?>
    <div class="wrap">
        <h1>Invite Codes Management</h1>
        
        <div class="card" style="max-width: 600px;">
            <h2 class="title">Statistics</h2>
            <table class="wp-list-table widefat fixed striped">
                <tbody>
                    <tr><td><strong>Total Codes Generated:</strong></td><td><?php echo $total_codes; ?></td></tr>
                    <tr><td><strong>Codes Used:</strong></td><td><?php echo $used_codes; ?></td></tr>
                    <tr><td><strong>Codes Available:</strong></td><td><?php echo $available_codes; ?></td></tr>
                    <tr><td><strong>Total Submissions:</strong></td><td><?php echo $total_submissions; ?></td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="card" style="max-width: 600px; margin-top: 20px;">
            <h2 class="title">Generate New Codes</h2>
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th scope="row">Number of Codes</th>
                        <td>
                            <input type="number" name="code_count" value="1000" min="1" max="10000" class="regular-text" />
                            <p class="description">How many invite codes to generate (max: 10,000 at once)</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button('Generate Codes', 'primary', 'generate_codes'); ?>
            </form>
        </div>
        
        <div class="card" style="max-width: 600px; margin-top: 20px;">
            <h2 class="title">Export for Email Campaign</h2>
            <p>Download a CSV file containing all unused invite codes with their complete signup URLs for your email campaign.</p>
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="export_invite_codes">
                <?php wp_nonce_field('export_codes_nonce'); ?>
                <?php submit_button('Export Available Codes (CSV)', 'secondary', 'export_codes'); ?>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Handle CSV export via admin-post.php to avoid header issues
 */
function handle_export_invite_codes() {
    // Verify nonce and permissions
    if (!wp_verify_nonce($_POST['_wpnonce'], 'export_codes_nonce') || !current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'invite_codes';
    
    $codes = $wpdb->get_results("SELECT code FROM $table_name WHERE used = 0 ORDER BY created_date ASC");
    
    // Clean any output buffers
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="invite_codes_' . date('Y-m-d_H-i-s') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Output CSV content
    $output = fopen('php://output', 'w');
    
    // Add CSV headers
    fputcsv($output, array('invite_code', 'signup_url'));
    
    // Add each code with its URL
    foreach ($codes as $code) {
        fputcsv($output, array(
            $code->code,
            home_url('/signup/?code=' . $code->code)
        ));
    }
    
    fclose($output);
    exit;
}
add_action('admin_post_export_invite_codes', 'handle_export_invite_codes');

/**
 * =============================================
 * SIGNEES DISPLAY SYSTEM
 * =============================================
 */

/**
 * Get and display the list of signees
 */
function get_signees_list($limit = 100, $show_law_firm = true, $order = 'DESC') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';

    // Hardcoded steering committee members (in specified order)
    $steering_committee = array(
        'Joe Cheshire',
        'Wade Smith',
        'Phil Baddour, Jr.',
        'Brad Bannon',
        'Sonya Pfeiffer',
        'David Rudolf',
        'Tony Scheer',
        'David Teddy',
        'James E. Williams, Jr.'
    );

    // Query all signees from database (alphabetically by last name)
    $query = "SELECT first_name, last_name, law_firm, submission_date
              FROM $table_name
              ORDER BY last_name ASC, first_name ASC";

    $database_signees = $wpdb->get_results($query);

    // Check if we want unlimited results (-1 or very high number)
    $unlimited = ($limit == -1 || $limit >= 9999);

    if (!$unlimited && $limit > 0) {
        // Apply limit to database signees only (steering committee always shows)
        $remaining_limit = max(0, $limit - count($steering_committee));
        if ($remaining_limit > 0) {
            $database_signees = array_slice($database_signees, 0, $remaining_limit);
        } else {
            $database_signees = array();
        }
    }

    // Get total count for display (database + hardcoded committee)
    $total_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name") + count($steering_committee);

    $html = '<div class="signees-list">';
    $html .= '<div class="signees-count"><strong>' . $total_count . '</strong> lawyers have signed</div>';
    $html .= '<div class="signees-grid">';

    // First, display steering committee members
    foreach ($steering_committee as $committee_member) {
        $search_text = strtolower($committee_member);

        $html .= '<div class="signee-item priority-signee" data-search="' . esc_attr($search_text) . '">';
        $html .= '<span class="signee-name">' . esc_html($committee_member) . '</span>';
        $html .= '</div>';
    }

    // Then, display database signees
    foreach ($database_signees as $signee) {
        // Display names as originally entered (preserves Roman numerals, initials, etc.)
        $first_name = trim($signee->first_name);
        $last_name = trim($signee->last_name);
        $name = esc_html($first_name . ' ' . $last_name);

        $law_firm = $show_law_firm ? esc_html($signee->law_firm) : '';
        $search_text = strtolower($name . ' ' . $law_firm);

        $html .= '<div class="signee-item" data-search="' . esc_attr($search_text) . '">';
        $html .= '<span class="signee-name">' . $name . '</span>';
        $html .= '</div>';
    }

    $html .= '</div></div>';

    return $html;
}

/**
 * Shortcode to display signees list
 * Usage: [signees_list limit="50" show_firm="true" order="DESC"]
 */
function signees_list_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 100,
        'show_firm' => 'true',
        'order' => 'DESC'
    ), $atts);
    
    $limit = intval($atts['limit']);
    $show_firm = $atts['show_firm'] === 'true';
    $order = strtoupper($atts['order']) === 'ASC' ? 'ASC' : 'DESC';
    
    return get_signees_list($limit, $show_firm, $order);
}
add_shortcode('signees_list', 'signees_list_shortcode');

/**
 * Get signees count for display (includes hardcoded steering committee)
 */
function get_signees_count() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';

    // Database count + 9 hardcoded steering committee members
    $database_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    return intval($database_count) + 9;
}

/**
 * Add signees management to admin
 */
function add_signees_admin_menu() {
    add_management_page(
        'Signees Management',
        'Letter Signees',
        'manage_options',
        'letter-signees',
        'signees_admin_page'
    );
}
add_action('admin_menu', 'add_signees_admin_menu');

/**
 * Admin page for signees management
 */
function signees_admin_page() {
    global $wpdb;
    $submissions_table = $wpdb->prefix . 'signup_submissions';
    
    // Handle actions
    if (isset($_GET['action']) && $_GET['action'] === 'export_signees' && wp_verify_nonce($_GET['_wpnonce'], 'export_signees_nonce')) {
        export_signees_csv();
        return;
    }
    
    // Handle delete signee action
    if (isset($_GET['action']) && $_GET['action'] === 'delete_signee' && isset($_GET['signee_id']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_signee_nonce')) {
        $signee_id = intval($_GET['signee_id']);
        
        // Get signee info before deletion for confirmation message
        $signee = $wpdb->get_row($wpdb->prepare("SELECT first_name, last_name FROM $submissions_table WHERE id = %d", $signee_id));
        
        if ($signee) {
            $deleted = $wpdb->delete($submissions_table, array('id' => $signee_id), array('%d'));
            
            if ($deleted !== false) {
                echo '<div class="notice notice-success"><p>Successfully deleted signee: ' . esc_html($signee->first_name . ' ' . $signee->last_name) . '</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>Error deleting signee. Please try again.</p></div>';
            }
        } else {
            echo '<div class="notice notice-error"><p>Signee not found.</p></div>';
        }
    }
    
    // Handle preload action
    if (isset($_POST['preload_signees']) && wp_verify_nonce($_POST['_wpnonce'], 'preload_signees_nonce')) {
        $inserted = force_preload_initial_signees();
        if ($inserted > 0) {
            echo '<div class="notice notice-success"><p>Successfully preloaded ' . $inserted . ' prominent NC lawyers as initial signees!</p></div>';
        } else {
            echo '<div class="notice notice-info"><p>All prominent lawyers are already in the signees list.</p></div>';
        }
    }

    // Handle database update action
    if (isset($_POST['update_database']) && wp_verify_nonce($_POST['_wpnonce'], 'update_database_nonce')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'signup_submissions';

        // Check current table structure
        $before_is_founding = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'is_founding'");
        $before_display_order = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'display_order'");

        update_submissions_table_structure();

        // Check after update
        $after_is_founding = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'is_founding'");
        $after_display_order = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'display_order'");

        $changes = array();
        if (!$before_is_founding && $after_is_founding) {
            $changes[] = "Added 'is_founding' column";
        }
        if (!$before_display_order && $after_display_order) {
            $changes[] = "Added 'display_order' column";
        }

        if (!empty($changes)) {
            echo '<div class="notice notice-success"><p>Database updated: ' . implode(', ', $changes) . '</p></div>';
        } else {
            echo '<div class="notice notice-info"><p>Database structure is already up to date.</p></div>';
        }
    }

    // Handle CSV import action
    if (isset($_POST['import_csv']) && wp_verify_nonce($_POST['_wpnonce'], 'import_csv_nonce')) {
        if (!empty($_FILES['csv_file']['tmp_name'])) {
            $results = import_signees_from_csv($_FILES['csv_file']['tmp_name']);

            if ($results['imported'] > 0) {
                echo '<div class="notice notice-success"><p>Successfully imported ' . $results['imported'] . ' signees!</p></div>';
            }

            if ($results['skipped'] > 0) {
                echo '<div class="notice notice-warning"><p>' . $results['skipped'] . ' signees were skipped (already exist).</p></div>';
            }

            if (!empty($results['errors'])) {
                echo '<div class="notice notice-error"><p>Import errors:<br>';
                foreach ($results['errors'] as $error) {
                    echo '• ' . esc_html($error) . '<br>';
                }
                echo '</p></div>';
            }
        } else {
            echo '<div class="notice notice-error"><p>Please select a CSV file to import.</p></div>';
        }
    }

    // Note: Removed mark founding signers action - committee members are now hardcoded

    // Handle edit signee action
    if (isset($_POST['edit_signee']) && wp_verify_nonce($_POST['_wpnonce'], 'edit_signee_nonce')) {
        $signee_id = intval($_POST['signee_id']);
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $law_firm = sanitize_text_field($_POST['law_firm']);

        if (!empty($first_name) && !empty($last_name) && is_email($email)) {
            // Check if email already exists for a different signee
            $existing_email = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $submissions_table WHERE email = %s AND id != %d",
                $email, $signee_id
            ));

            if ($existing_email > 0) {
                echo '<div class="notice notice-error"><p>Error: This email address is already used by another signee.</p></div>';
            } else {
                $updated = $wpdb->update(
                    $submissions_table,
                    array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'law_firm' => $law_firm
                    ),
                    array('id' => $signee_id),
                    array('%s', '%s', '%s', '%s'),
                    array('%d')
                );

                if ($updated !== false) {
                    echo '<div class="notice notice-success"><p>Successfully updated signee information.</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error updating signee. Please try again.</p></div>';
                }
            }
        } else {
            echo '<div class="notice notice-error"><p>Please fill in all required fields with valid information.</p></div>';
        }
    }
    
    // Check if we're editing a signee
    $editing_signee = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit_signee' && isset($_GET['signee_id']) && wp_verify_nonce($_GET['_wpnonce'], 'edit_signee_nonce')) {
        $signee_id = intval($_GET['signee_id']);
        $editing_signee = $wpdb->get_row($wpdb->prepare("SELECT * FROM $submissions_table WHERE id = %d", $signee_id));
    }

    // Handle search
    $search_term = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $search_condition = '';
    $search_params = array();

    if (!empty($search_term)) {
        $search_condition = " WHERE (first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR law_firm LIKE %s)";
        $search_like = '%' . $wpdb->esc_like($search_term) . '%';
        $search_params = array($search_like, $search_like, $search_like, $search_like);
    }

    // Get statistics and all signees
    if (!empty($search_term)) {
        $total_signees = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $submissions_table" . $search_condition,
            ...$search_params
        ));
    } else {
        $total_signees = $wpdb->get_var("SELECT COUNT(*) FROM $submissions_table");
    }

    $per_page = 50; // Show 50 signees per page
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    // Query with search and alphabetical ordering
    if (!empty($search_term)) {
        $query_params = array_merge($search_params, array($per_page, $offset));
        $all_signees = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $submissions_table" . $search_condition . " ORDER BY last_name ASC, first_name ASC LIMIT %d OFFSET %d",
            ...$query_params
        ));
    } else {
        $all_signees = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $submissions_table ORDER BY last_name ASC, first_name ASC LIMIT %d OFFSET %d",
            $per_page, $offset
        ));
    }

    $total_pages = ceil($total_signees / $per_page);
    
    ?>
    <div class="wrap">
        <h1>Letter Signees Management</h1>

        <!-- 1. Statistics -->
        <div class="card" style="max-width: 800px;">
            <h2 class="title">Statistics</h2>
            <p><strong>Total Signees in Database:</strong> <?php echo $wpdb->get_var("SELECT COUNT(*) FROM $submissions_table"); ?> lawyers</p>
            <?php if (!empty($search_term)): ?>
                <p><strong>Search Results:</strong> <?php echo $total_signees; ?> lawyers</p>
            <?php endif; ?>
        </div>

        <!-- 2. Export Signees -->
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Export Signees</h2>
            <p>Download a CSV file containing all signees for record keeping.</p>
            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=letter-signees&action=export_signees'), 'export_signees_nonce'); ?>" class="button button-secondary">Export All Signees (CSV)</a>
        </div>

        <!-- 3. Database Maintenance (Optional) -->
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Database Maintenance</h2>
            <p>This section helps maintain database structure for CSV imports. Only use if experiencing import issues.</p>
            <form method="post" action="">
                <?php wp_nonce_field('update_database_nonce'); ?>
                <?php submit_button('Update Database Structure', 'secondary', 'update_database'); ?>
            </form>
        </div>

        <!-- 4. Import Signees from CSV -->
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Import Signees from CSV</h2>
            <p>Upload a CSV file to bulk import signees. The CSV must contain columns for <strong>first_name</strong>, <strong>last_name</strong>, and <strong>email</strong>. Law firm is optional.</p>
            <p><strong>CSV Format Example:</strong></p>
            <code style="background: #f1f1f1; padding: 10px; display: block; margin: 10px 0;">
first_name,last_name,email,law_firm<br>
John,Smith,john@example.com,Smith Law<br>
Jane,Doe,jane@example.com,
            </code>
            <form method="post" enctype="multipart/form-data" action="">
                <?php wp_nonce_field('import_csv_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">CSV File</th>
                        <td><input type="file" name="csv_file" accept=".csv" required /></td>
                    </tr>
                </table>
                <?php submit_button('Import CSV', 'primary', 'import_csv'); ?>
            </form>
        </div>

        <!-- 5. Steering Committee -->
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Steering Committee</h2>
            <p>The following steering committee members are automatically displayed at the top of the signees list:</p>
            <ul style="margin-left: 20px;">
                <li>1. Joe Cheshire</li>
                <li>2. Wade Smith</li>
                <li>3. Phil Baddour, Jr.</li>
                <li>4. Brad Bannon</li>
                <li>5. Sonya Pfeiffer</li>
                <li>6. David Rudolf</li>
                <li>7. Tony Scheer</li>
                <li>8. David Teddy</li>
                <li>9. James E. Williams, Jr.</li>
            </ul>
            <p><em>Note: These names are hardcoded and will always appear at the top in this order.</em></p>
        </div>
        
        <?php if ($total_signees == 0): ?>
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Preload Initial Signees</h2>
            <p>Add prominent NC lawyers to get started with your signees list. This will add:</p>
            <ul style="margin-left: 20px;">
                <li>Phil Baddour - Baddour Law Firm</li>
                <li>Brad Bannon - Bannon Law Group</li>
                <li>Joe Cheshire - Cheshire Parker Schneider</li>
                <li>Sonya Pfeiffer - Pfeiffer Law</li>
                <li>David Rudolf - Rudolf Widenhouse</li>
                <li>Tony Scheer - Scheer Law Offices</li>
                <li>David Teddy - Teddy, Meekins & Talbert</li>
                <li>James Williams - Williams Law Firm</li>
            </ul>
            <form method="post" action="">
                <?php wp_nonce_field('preload_signees_nonce'); ?>
                <?php submit_button('Preload Initial Prominent Signees', 'primary', 'preload_signees'); ?>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($editing_signee): ?>
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Edit Signee</h2>
            <form method="post" action="">
                <?php wp_nonce_field('edit_signee_nonce'); ?>
                <input type="hidden" name="signee_id" value="<?php echo esc_attr($editing_signee->id); ?>" />

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="first_name">First Name *</label>
                        </th>
                        <td>
                            <input type="text" name="first_name" id="first_name"
                                   value="<?php echo esc_attr($editing_signee->first_name); ?>"
                                   class="regular-text" required />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="last_name">Last Name *</label>
                        </th>
                        <td>
                            <input type="text" name="last_name" id="last_name"
                                   value="<?php echo esc_attr($editing_signee->last_name); ?>"
                                   class="regular-text" required />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="email">Email *</label>
                        </th>
                        <td>
                            <input type="email" name="email" id="email"
                                   value="<?php echo esc_attr($editing_signee->email); ?>"
                                   class="regular-text" required />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="law_firm">Law Firm</label>
                        </th>
                        <td>
                            <input type="text" name="law_firm" id="law_firm"
                                   value="<?php echo esc_attr($editing_signee->law_firm); ?>"
                                   class="regular-text" />
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 20px;">
                    <?php submit_button('Update Signee', 'primary', 'edit_signee'); ?>
                    <a href="<?php echo admin_url('admin.php?page=letter-signees'); ?>" class="button button-secondary">Cancel</a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- 6. Search Box -->
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2 class="title">Search Signees</h2>
            <form method="get" action="">
                <input type="hidden" name="page" value="letter-signees" />
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="search-signees">Search by Name, Email, or Law Firm</label>
                        </th>
                        <td>
                            <input type="text" name="s" id="search-signees"
                                   value="<?php echo esc_attr($search_term); ?>"
                                   placeholder="Enter name, email, or law firm..."
                                   class="regular-text" />
                            <input type="submit" value="Search" class="button button-secondary" style="margin-left: 10px;" />
                            <?php if (!empty($search_term)): ?>
                                <a href="<?php echo admin_url('admin.php?page=letter-signees'); ?>"
                                   class="button button-secondary" style="margin-left: 5px;">Clear Search</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- 7. All Signees List -->
        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2 class="title">
                <?php if (!empty($search_term)): ?>
                    Search Results (Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>) - Sorted Alphabetically
                <?php else: ?>
                    All Signees (Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>) - Sorted Alphabetically
                <?php endif; ?>
            </h2>
            
            <?php if ($total_pages > 1): ?>
                <div class="tablenav" style="margin-bottom: 10px;">
                    <div class="tablenav-pages">
                        <?php
                        // Preserve search parameter in pagination
                        $base_url = admin_url('admin.php');
                        $query_args = array('page' => 'letter-signees');
                        if (!empty($search_term)) {
                            $query_args['s'] = $search_term;
                        }

                        $page_links = paginate_links(array(
                            'base' => add_query_arg($query_args, $base_url) . '%_%',
                            'format' => '&paged=%#%',
                            'prev_text' => '&laquo; Previous',
                            'next_text' => 'Next &raquo;',
                            'total' => $total_pages,
                            'current' => $current_page,
                            'type' => 'list'
                        ));
                        echo $page_links;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($all_signees)): ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Name</th>
                            <th style="width: 25%;">Email</th>
                            <th style="width: 20%;">Law Firm</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_signees as $signee): ?>
                        <tr>
                            <td><?php echo esc_html(trim($signee->first_name) . ' ' . trim($signee->last_name)); ?></td>
                            <td><?php echo esc_html($signee->email); ?></td>
                            <td><?php echo esc_html($signee->law_firm); ?></td>
                            <td><?php echo esc_html(date('M j, Y g:i A', strtotime($signee->submission_date))); ?></td>
                            <td>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=letter-signees&action=edit_signee&signee_id=' . $signee->id), 'edit_signee_nonce'); ?>"
                                   class="button button-small button-secondary"
                                   style="margin-right: 5px;">
                                    Edit
                                </a>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=letter-signees&action=delete_signee&signee_id=' . $signee->id), 'delete_signee_nonce'); ?>"
                                   class="button button-small button-link-delete"
                                   onclick="return confirm('Are you sure you want to delete <?php echo esc_js($signee->first_name . ' ' . $signee->last_name); ?>? This action cannot be undone.');"
                                   style="color: #d63638;">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <?php if ($total_pages > 1): ?>
                    <div class="tablenav" style="margin-top: 10px;">
                        <div class="tablenav-pages">
                            <?php echo $page_links; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p>No signees yet. Use the preload function above to add initial prominent lawyers.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Export signees to CSV
 */
function export_signees_csv() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';
    
    $signees = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    
    // Clean any output buffers
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="letter_signees_' . date('Y-m-d_H-i-s') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Output CSV content
    $output = fopen('php://output', 'w');
    
    // Add CSV headers
    fputcsv($output, array('First Name', 'Last Name', 'Email', 'Law Firm', 'Submission Date', 'Invite Code'));
    
    // Add each signee
    foreach ($signees as $signee) {
        fputcsv($output, array(
            $signee->first_name,
            $signee->last_name,
            $signee->email,
            $signee->law_firm,
            $signee->submission_date,
            $signee->invite_code
        ));
    }
    
    fclose($output);
    exit;
}

/**
 * Preload initial prominent signees
 */
function preload_initial_signees() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';
    
    // Check if we already have signees to avoid duplicates
    $existing_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    if ($existing_count > 0) {
        return false; // Don't preload if we already have signees
    }
    
    // Prominent NC lawyers to preload
    $initial_signees = array(
        array('Phil', 'Baddour', 'phil.baddour@example.com', 'Baddour Law Firm'),
        array('Brad', 'Bannon', 'brad.bannon@example.com', 'Bannon Law Group'),
        array('Joe', 'Cheshire', 'joe.cheshire@example.com', 'Cheshire Parker Schneider'),
        array('Sonya', 'Pfeiffer', 'sonya.pfeiffer@example.com', 'Pfeiffer Law'),
        array('David', 'Rudolf', 'david.rudolf@example.com', 'Rudolf Widenhouse'),
        array('Tony', 'Scheer', 'tony.scheer@example.com', 'Scheer Law Offices'),
        array('David', 'Teddy', 'david.teddy@example.com', 'Teddy, Meekins & Talbert'),
        array('James', 'Williams', 'james.williams@example.com', 'Williams Law Firm')
    );
    
    $inserted = 0;
    foreach ($initial_signees as $signee) {
        $result = $wpdb->insert(
            $table_name,
            array(
                'first_name' => $signee[0],
                'last_name' => $signee[1],
                'email' => $signee[2],
                'law_firm' => $signee[3],
                'invite_code' => 'PRELOAD',
                'submission_date' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result !== false) {
            $inserted++;
        }
    }
    
    return $inserted;
}

/**
 * Force preload initial signees (admin function)
 */
function force_preload_initial_signees() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signup_submissions';
    
    // Prominent NC lawyers to preload
    $initial_signees = array(
        array('Phil', 'Baddour', 'phil.baddour@example.com', 'Baddour Law Firm'),
        array('Brad', 'Bannon', 'brad.bannon@example.com', 'Bannon Law Group'),
        array('Joe', 'Cheshire', 'joe.cheshire@example.com', 'Cheshire Parker Schneider'),
        array('Sonya', 'Pfeiffer', 'sonya.pfeiffer@example.com', 'Pfeiffer Law'),
        array('David', 'Rudolf', 'david.rudolf@example.com', 'Rudolf Widenhouse'),
        array('Tony', 'Scheer', 'tony.scheer@example.com', 'Scheer Law Offices'),
        array('David', 'Teddy', 'david.teddy@example.com', 'Teddy, Meekins & Talbert'),
        array('James', 'Williams', 'james.williams@example.com', 'Williams Law Firm')
    );
    
    $inserted = 0;
    foreach ($initial_signees as $signee) {
        // Check if this signee already exists by name
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE first_name = %s AND last_name = %s",
            $signee[0], $signee[1]
        ));
        
        if ($exists == 0) {
            $result = $wpdb->insert(
                $table_name,
                array(
                    'first_name' => $signee[0],
                    'last_name' => $signee[1],
                    'email' => $signee[2],
                    'law_firm' => $signee[3],
                    'invite_code' => 'PRELOAD',
                    'submission_date' => current_time('mysql')
                ),
                array('%s', '%s', '%s', '%s', '%s', '%s')
            );
            
            if ($result !== false) {
                $inserted++;
            }
        }
    }
    
    return $inserted;
}

/**
 * Generate a single test invite code for debugging
 */
function generate_test_invite_code() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'invite_codes';
    
    // Generate a simple test code
    $test_code = 'test' . rand(100, 999);
    
    $result = $wpdb->insert(
        $table_name,
        array('code' => $test_code),
        array('%s')
    );
    
    if ($result !== false) {
        error_log('Legal Letter: Generated test invite code: ' . $test_code);
        return $test_code;
    }
    
    return false;
}

/**
 * Debug function to check form processing
 */
function debug_form_status() {
    if (current_user_can('administrator') && isset($_GET['debug_form'])) {
        echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h3>Form Debug Information</h3>';
        
        global $wpdb;
        
        // Check if tables exist
        $invite_table = $wpdb->prefix . 'invite_codes';
        $submissions_table = $wpdb->prefix . 'signup_submissions';
        
        $invite_exists = $wpdb->get_var("SHOW TABLES LIKE '$invite_table'") === $invite_table;
        $submissions_exists = $wpdb->get_var("SHOW TABLES LIKE '$submissions_table'") === $submissions_table;
        
        echo '<p><strong>Database Tables:</strong></p>';
        echo '<p>Invite Codes Table: ' . ($invite_exists ? '✅ EXISTS' : '❌ MISSING') . '</p>';
        echo '<p>Submissions Table: ' . ($submissions_exists ? '✅ EXISTS' : '❌ MISSING') . '</p>';
        
        if ($invite_exists) {
            $invite_count = $wpdb->get_var("SELECT COUNT(*) FROM $invite_table");
            $used_count = $wpdb->get_var("SELECT COUNT(*) FROM $invite_table WHERE used = 1");
            echo '<p>Total Invite Codes: ' . $invite_count . '</p>';
            echo '<p>Used Invite Codes: ' . $used_count . '</p>';
            
            // Generate a test code
            $test_code = generate_test_invite_code();
            if ($test_code) {
                echo '<p><strong>Generated Test Code:</strong> <code>' . $test_code . '</code></p>';
                echo '<p><strong>Test URL:</strong> <a href="' . home_url('/signup/?code=' . $test_code) . '" target="_blank">' . home_url('/signup/?code=' . $test_code) . '</a></p>';
            }
        }
        
        if ($submissions_exists) {
            $submission_count = $wpdb->get_var("SELECT COUNT(*) FROM $submissions_table");
            echo '<p>Total Submissions: ' . $submission_count . '</p>';
        }
        
        echo '<p><strong>Session Status:</strong> ' . (session_id() ? '✅ Active (' . session_id() . ')' : '❌ No Session') . '</p>';
        
        echo '</div>';
    }
}
add_action('wp_footer', 'debug_form_status');

/**
 * =============================================
 * LARAVEL WEBHOOK INTEGRATION
 * =============================================
 */

/**
 * Call Laravel webhook to mark invitee as accepted
 */
function call_laravel_signup_webhook($signup_code) {
    $webhook_url = get_option('laravel_webhook_url', '');

    if (empty($webhook_url)) {
        error_log('Laravel webhook URL not configured');
        return array('success' => false, 'message' => 'Webhook URL not configured');
    }

    $response = wp_remote_post($webhook_url, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => json_encode(array('signup_code' => $signup_code)),
        'timeout' => 15
    ));

    if (is_wp_error($response)) {
        error_log('Laravel webhook error: ' . $response->get_error_message());
        return array('success' => false, 'message' => $response->get_error_message());
    }

    $status = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    error_log('Laravel webhook response: ' . $status . ' - ' . $body);

    return array('success' => ($status === 200), 'status' => $status, 'body' => $body);
}

/**
 * Register Laravel webhook URL setting
 */
function register_laravel_webhook_setting() {
    register_setting('general', 'laravel_webhook_url', 'esc_url');

    add_settings_field(
        'laravel_webhook_url',
        'Laravel Webhook URL',
        'laravel_webhook_url_callback',
        'general'
    );
}
add_action('admin_init', 'register_laravel_webhook_setting');

/**
 * Laravel webhook URL settings field callback
 */
function laravel_webhook_url_callback() {
    $value = get_option('laravel_webhook_url', '');
    echo '<input type="url" name="laravel_webhook_url" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">Full URL to Laravel signup webhook (e.g., https://your-app.com/api/webhooks/signup-accepted)</p>';
}
?>