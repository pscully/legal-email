<?php
/**
 * Template Name: Thank You Page
 * 
 * Custom template for the thank you page after signing the letter
 */

// Add body class for styling
add_filter('body_class', function($classes) {
    $classes[] = 'thank-you-page';
    $classes[] = 'custom-background';
    return $classes;
});

get_header();
?>

<main id="primary" class="site-main">
    <div class="thank-you-container">
        <div class="thank-you-content">
            <div class="thank-you-header">
                <div class="success-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#10b981" stroke-width="2" fill="none"/>
                        <path d="m9 12 2 2 4-4" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h1>⚖️ Thank You for Signing the Letter</h1>
            </div>
            
            <div class="thank-you-message">
                <div class="message-card">
                    <div class="publication-notice">
                        <h2>📰 Publication Notice</h2>
                        <p class="publication-date">
                            The letter will be published <strong>Wednesday, September 17, 2025</strong>.
                        </p>
                        
                    </div>
                    
                
                
                </div>
            </div>
            
            
        </div>
    </div>
</main>

<style>
/* Thank You Page Specific Styles */
.thank-you-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.thank-you-content {
    width: 100%;
    max-width: 800px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    box-shadow: 
        0 16px 64px rgba(0, 0, 0, 0.12),
        0 0 0 1px rgba(255, 255, 255, 0.05);
    position: relative;
    overflow: hidden;
}

.thank-you-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
}

.thank-you-header {
    padding: 3rem 3rem 2rem;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

.success-icon {
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: center;
}

.success-icon svg {
    animation: successPulse 2s ease-in-out infinite;
}

@keyframes successPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.thank-you-header h1 {
    font-size: 2.2rem;
    color: #0f172a;
    margin: 0 0 1rem;
    font-family: 'Merriweather', serif;
    font-weight: 700;
}

.thank-you-subtitle {
    color: #10b981;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.thank-you-message {
    padding: 2rem 3rem;
}

.message-card {
    display: grid;
    gap: 2.5rem;
}

.publication-notice {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.05));
    border: 2px solid #10b981;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
}

.publication-notice h2 {
    color: #059669;
    margin-bottom: 1rem;
    font-size: 1.4rem;
    font-weight: 700;
}

.publication-date {
    font-size: 1.3rem;
    color: #0f172a;
    margin-bottom: 1rem;
    font-weight: 600;
}

.publication-details {
    color: #475569;
    line-height: 1.6;
    margin: 0;
}

.next-steps h3,
.sharing-section h3 {
    color: #0f172a;
    margin-bottom: 1.5rem;
    font-size: 1.3rem;
    font-weight: 700;
}

.steps-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    gap: 1rem;
}

.steps-list li {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    border-left: 4px solid #10b981;
}

.step-icon {
    font-size: 1.2rem;
    flex-shrink: 0;
}

.step-text {
    color: #475569;
    font-weight: 500;
}

.sharing-section p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.sharing-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    text-align: center;
}

.share-btn.primary {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
}

.share-btn.primary:hover {
    background: linear-gradient(135deg, #1e40af, #2563eb);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
}

.share-btn.secondary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.share-btn.secondary:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

.thank-you-footer {
    padding: 2rem 3rem 3rem;
    border-top: 1px solid #e2e8f0;
    background: linear-gradient(135deg, rgba(30, 58, 138, 0.03), rgba(248, 250, 252, 0.8));
}

.steering-committee {
    margin-bottom: 2rem;
}

.committee-label {
    color: #64748b;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.steering-committee blockquote {
    border-left: 4px solid #1e3a8a;
    padding-left: 1.5rem;
    margin: 1rem 0;
    font-style: italic;
    color: #475569;
    line-height: 1.6;
}

.committee-signature {
    color: #1e3a8a;
    font-weight: 600;
    text-align: right;
    margin-top: 1rem;
}

.legal-notice {
    color: #64748b;
    font-size: 0.9rem;
    text-align: center;
    line-height: 1.6;
    margin: 0;
    padding: 1.5rem;
    background: rgba(248, 250, 252, 0.8);
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .thank-you-container {
        padding: 1rem;
    }
    
    .thank-you-content {
        border-radius: 16px;
    }
    
    .thank-you-header {
        padding: 2rem 2rem 1.5rem;
    }
    
    .thank-you-header h1 {
        font-size: 1.8rem;
    }
    
    .thank-you-message {
        padding: 1.5rem 2rem;
    }
    
    .thank-you-footer {
        padding: 1.5rem 2rem 2rem;
    }
    
    .sharing-buttons {
        grid-template-columns: 1fr;
    }
    
    .publication-notice {
        padding: 1.5rem;
    }
    
    .publication-date {
        font-size: 1.1rem;
    }
}

/* Animation for page entrance */
.thank-you-content {
    animation: thankYouEntrance 0.8s ease-out;
}

@keyframes thankYouEntrance {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling for any internal links
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
    
    // Add copy to clipboard functionality if needed
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add any additional analytics tracking here if needed
            console.log('Share button clicked:', this.textContent.trim());
        });
    });
});
</script>

<?php get_footer(); ?>