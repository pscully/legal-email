<?php
/**
 * Template Name: Signup Page
 * 
 * Custom template for the invite code signup form
 */

// Add body class for styling
add_filter('body_class', function($classes) {
    $classes[] = 'signup-page';
    $classes[] = 'custom-background';
    return $classes;
});

// Template: NC Lawyers Legal Theme - Signup Page

get_header();

// Handle form submission FIRST before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup_nonce'])) {
    // This will handle the form and redirect on success, or set session error
    // The handle_signup_form() function is already defined in functions.php
}

$invite_code = isset($_GET['code']) ? sanitize_text_field($_GET['code']) : '';
$error = isset($_SESSION['signup_error']) ? $_SESSION['signup_error'] : '';
if ($error) {
    unset($_SESSION['signup_error']);
}

// If no invite code in URL, show error
if (empty($invite_code)) {
    ?>
    <main id="primary" class="site-main">
        <div class="signup-container error-state">
            <div class="signup-content">
                <div class="signup-header">
                    <h1>⚖️ Invalid Access</h1>
                    <p class="error-message">You need a valid invitation code to access this page. Please reach out to the committee for an invite code.</p>
                </div>
            </div>
        </div>
    </main>
    <?php
    get_footer();
    return;
}
?>

<main id="primary" class="site-main">
    <div class="signup-container">
        <div class="signup-content">
            <div class="signup-header">
                <h1>⚖️ Sign The Letter</h1>
                <p class="signup-subtitle">Join fellow North Carolina lawyers in defending the rule of law</p>
            </div>
        
        <?php if ($error): ?>
            <div class="form-error" role="alert" aria-live="polite">
                <span class="error-icon">⚠️</span>
                <span class="error-text"><?php echo esc_html($error); ?></span>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="signup-form" novalidate>
            <?php wp_nonce_field('signup_form', 'signup_nonce'); ?>
            
            <input type="hidden" name="invite_code" value="<?php echo esc_attr($invite_code); ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" name="first_name" id="first_name" required 
                           value="<?php echo isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : ''; ?>"
                           aria-describedby="first-name-error">
                    <div class="field-error" id="first-name-error" role="alert"></div>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" name="last_name" id="last_name" required 
                           value="<?php echo isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : ''; ?>"
                           aria-describedby="last-name-error">
                    <div class="field-error" id="last-name-error" role="alert"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" name="email" id="email" required 
                       value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>"
                       aria-describedby="email-error">
                <div class="field-error" id="email-error" role="alert"></div>
            </div>
            

            <div class="form-submit">
                <button type="submit" class="submit-btn">
                    <span class="btn-icon">📝</span>
                    <span class="btn-text">Sign the Open Letter</span>
                </button>
            </div>
            
            <div class="form-trust-indicators">
                <div class="trust-item">
                    <span class="trust-icon">🔒</span>
                    <span>Your information is secure and confidential</span>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">✅</span>
                    <span>One-time signup with unique invitation code</span>
                </div>
            </div>
            
            
        </form>
        
        <div class="form-footer">
            <p class="legal-notice" style="text-align: center;">
                By signing this open letter, you join fellow North Carolina trial lawyers in 
                defending our constitutional system and the rule of law.
            </p>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.signup-form');
    const inputs = form.querySelectorAll('input[required]');
    
    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            // Focus first invalid field
            const firstError = form.querySelector('.form-group.error input');
            if (firstError) {
                firstError.focus();
            }
        }
    });
    
    function validateField(field) {
        const group = field.closest('.form-group');
        const errorElement = group.querySelector('.field-error');
        let isValid = true;
        let errorMessage = '';
        
        // Clear previous state
        group.classList.remove('error', 'success');
        errorElement.textContent = '';
        
        // Check if field is empty
        if (!field.value.trim()) {
            isValid = false;
            errorMessage = 'This field is required.';
        }
        // Email specific validation
        else if (field.type === 'email' && !isValidEmail(field.value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        }
        // Name specific validation
        else if (field.name.includes('name') && field.value.trim().length < 2) {
            isValid = false;
            errorMessage = 'Please enter at least 2 characters.';
        }
        
        if (isValid) {
            group.classList.add('success');
        } else {
            group.classList.add('error');
            errorElement.textContent = errorMessage;
        }
        
        return isValid;
    }
    
    function clearFieldError(field) {
        const group = field.closest('.form-group');
        if (group.classList.contains('error') && field.value.trim()) {
            group.classList.remove('error');
            group.querySelector('.field-error').textContent = '';
        }
    }
    
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>

<?php get_footer(); ?>