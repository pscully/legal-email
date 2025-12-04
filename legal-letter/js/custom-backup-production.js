/**
 * Enhanced JavaScript for NC Lawyers Advocacy Website
 * Production-ready mobile navigation and accessibility features
 */

jQuery(document).ready(function($) {
    
    // ==========================================================================
    // MOBILE NAVIGATION SYSTEM
    // ==========================================================================
    
    const mobileNav = {
        toggle: $('#mobile-menu-toggle'),
        overlay: $('#mobile-nav-overlay'),
        menu: $('#mobile-navigation'),
        closeBtn: $('#mobile-nav-close'),
        menuItems: $('.mobile-nav-link'),
        navStatus: $('#nav-status'),
        
        // Focus management
        focusableElements: null,
        firstFocusable: null,
        lastFocusable: null,
        
        init: function() {
            this.bindEvents();
            this.setupFocusManagement();
            this.setupAriaAttributes();
        },
        
        bindEvents: function() {
            // Toggle menu
            this.toggle.on('click', this.openMenu.bind(this));
            
            // Close menu
            this.closeBtn.on('click', this.closeMenu.bind(this));
            this.overlay.on('click', this.closeMenu.bind(this));
            
            // Keyboard navigation
            $(document).on('keydown', this.handleKeyDown.bind(this));
            
            // Menu item clicks
            this.menuItems.on('click', this.handleMenuItemClick.bind(this));
            
            // Resize handler
            $(window).on('resize', this.handleResize.bind(this));
        },
        
        setupFocusManagement: function() {
            // Get all focusable elements in the mobile menu
            this.focusableElements = this.menu.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            this.firstFocusable = this.focusableElements.first();
            this.lastFocusable = this.focusableElements.last();
        },
        
        setupAriaAttributes: function() {
            // Set initial ARIA states
            this.menu.attr('aria-hidden', 'true');
            this.overlay.attr('aria-hidden', 'true');
            this.toggle.attr('aria-expanded', 'false');
            
            // Set proper tabindex for menu items
            this.menuItems.attr('tabindex', '-1');
        },
        
        openMenu: function(e) {
            e.preventDefault();
            
            // Prevent body scroll
            $('body').addClass('mobile-menu-open').css('overflow', 'hidden');
            
            // Show menu and overlay
            this.menu.addClass('is-open').attr('aria-hidden', 'false');
            this.overlay.addClass('is-visible').attr('aria-hidden', 'false');
            
            // Update button state
            this.toggle.attr('aria-expanded', 'true');
            
            // Enable menu item focus
            this.menuItems.attr('tabindex', '0');
            
            // Focus first menu item
            setTimeout(() => {
                this.firstFocusable.focus();
            }, 300);
            
            // Announce to screen readers
            this.navStatus.text('Navigation menu opened');
            
            // Track for analytics
            this.trackEvent('mobile_navigation', 'open');
        },
        
        closeMenu: function(e) {
            if (e) e.preventDefault();
            
            // Restore body scroll
            $('body').removeClass('mobile-menu-open').css('overflow', '');
            
            // Hide menu and overlay
            this.menu.removeClass('is-open').attr('aria-hidden', 'true');
            this.overlay.removeClass('is-visible').attr('aria-hidden', 'true');
            
            // Update button state
            this.toggle.attr('aria-expanded', 'false');
            
            // Disable menu item focus
            this.menuItems.attr('tabindex', '-1');
            
            // Return focus to toggle button
            this.toggle.focus();
            
            // Announce to screen readers
            this.navStatus.text('Navigation menu closed');
            
            // Track for analytics
            this.trackEvent('mobile_navigation', 'close');
        },
        
        handleKeyDown: function(e) {
            // Only handle keys when menu is open
            if (!this.menu.hasClass('is-open')) return;
            
            switch(e.key) {
                case 'Escape':
                    this.closeMenu();
                    break;
                    
                case 'Tab':
                    this.handleTabKey(e);
                    break;
                    
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem();
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousItem();
                    break;
                    
                case 'Home':
                    e.preventDefault();
                    this.firstFocusable.focus();
                    break;
                    
                case 'End':
                    e.preventDefault();
                    this.lastFocusable.focus();
                    break;
            }
        },
        
        handleTabKey: function(e) {
            // Trap focus within menu
            if (e.shiftKey) {
                if (document.activeElement === this.firstFocusable[0]) {
                    e.preventDefault();
                    this.lastFocusable.focus();
                }
            } else {
                if (document.activeElement === this.lastFocusable[0]) {
                    e.preventDefault();
                    this.firstFocusable.focus();
                }
            }
        },
        
        focusNextItem: function() {
            const current = this.focusableElements.index(document.activeElement);
            const next = (current + 1) % this.focusableElements.length;
            this.focusableElements.eq(next).focus();
        },
        
        focusPreviousItem: function() {
            const current = this.focusableElements.index(document.activeElement);
            const previous = current === 0 ? this.focusableElements.length - 1 : current - 1;
            this.focusableElements.eq(previous).focus();
        },
        
        handleMenuItemClick: function(e) {
            const href = $(e.currentTarget).attr('href');
            
            // If it's an anchor link, close menu after short delay
            if (href && href.startsWith('#')) {
                setTimeout(() => {
                    this.closeMenu();
                }, 100);
                
                // Track navigation
                this.trackEvent('mobile_navigation', 'navigate', href);
            }
        },
        
        handleResize: function() {
            // Close menu on desktop resize
            if ($(window).width() > 767 && this.menu.hasClass('is-open')) {
                this.closeMenu();
            }
        },
        
        trackEvent: function(category, action, label = '') {
            // Google Analytics 4 event tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', action, {
                    event_category: category,
                    event_label: label
                });
            }
        }
    };
    
    // ==========================================================================
    // SMOOTH SCROLLING WITH ACCESSIBILITY
    // ==========================================================================
    
    const smoothScroll = {
        init: function() {
            $("a[href^='#']").on("click", this.handleAnchorClick.bind(this));
        },
        
        handleAnchorClick: function(e) {
            const href = $(e.currentTarget).attr('href');
            const target = $(href);
            
            if (target.length) {
                e.preventDefault();
                
                // Calculate scroll position
                const offset = target.offset().top - 100;
                
                // Smooth scroll
                $("html, body").animate({
                    scrollTop: offset
                }, 500, () => {
                    // Focus management for accessibility
                    target.attr('tabindex', '-1').focus();
                    
                    // Remove tabindex after focus
                    setTimeout(() => {
                        target.removeAttr('tabindex');
                    }, 1000);
                });
                
                // Track anchor navigation
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'anchor_navigation', {
                        event_category: 'navigation',
                        event_label: href
                    });
                }
            }
        }
    };
    
    // ==========================================================================
    // ENHANCED FORM HANDLING
    // ==========================================================================
    
    const formHandler = {
        init: function() {
            this.setupFormValidation();
            this.setupFormSubmission();
            this.setupFieldEnhancements();
        },
        
        setupFormValidation: function() {
            // Real-time validation
            $('.form-field input, .form-field select, .form-field textarea').on('blur', this.validateField);
            $('.form-field input, .form-field select, .form-field textarea').on('input', this.clearErrors);
        },
        
        validateField: function() {
            const $field = $(this);
            const $formGroup = $field.closest('.form-field, .form-group');
            const value = $field.val().trim();
            const isRequired = $field.attr('required') || $field.attr('aria-required') === 'true';
            
            // Clear previous states
            $formGroup.removeClass('success error');
            $formGroup.find('.field-error, .field-success').remove();
            
            if (isRequired && !value) {
                formHandler.showFieldError($formGroup, 'This field is required');
            } else if (value && $field.attr('type') === 'email' && !formHandler.isValidEmail(value)) {
                formHandler.showFieldError($formGroup, 'Please enter a valid email address');
            } else if (value) {
                formHandler.showFieldSuccess($formGroup);
            }
        },
        
        clearErrors: function() {
            const $formGroup = $(this).closest('.form-field, .form-group');
            $formGroup.removeClass('error');
            $formGroup.find('.field-error').remove();
        },
        
        showFieldError: function($formGroup, message) {
            $formGroup.addClass('error');
            $formGroup.append(`<div class="field-error" role="alert">${message}</div>`);
            
            // Announce to screen readers
            const $status = $('#main-content-status');
            $status.text(`Error: ${message}`);
        },
        
        showFieldSuccess: function($formGroup) {
            $formGroup.addClass('success');
            $formGroup.append('<div class="field-success">Valid</div>');
        },
        
        isValidEmail: function(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },
        
        setupFormSubmission: function() {
            $('#lawyer-signup-form, .professional-form').on('submit', this.handleFormSubmit);
        },
        
        handleFormSubmit: function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('.submit-button, button[type="submit"]');
            const originalText = $submitBtn.text();
            
            // Validate all fields
            let isValid = true;
            $form.find('input[required], select[required], textarea[required]').each(function() {
                $(this).trigger('blur');
                if ($(this).closest('.form-field, .form-group').hasClass('error')) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                // Focus first error field
                const $firstError = $form.find('.error').first().find('input, select, textarea');
                $firstError.focus();
                
                // Announce error to screen readers
                $('#main-content-status').text('Please correct the errors in the form before submitting');
                return;
            }
            
            // Show loading state
            $submitBtn.text('Processing...').prop('disabled', true).attr('aria-busy', 'true');
            
            // Simulate form processing (replace with actual form submission)
            setTimeout(() => {
                formHandler.showSuccessMessage($form, $submitBtn);
                
                // Track form submission
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'form_submit', {
                        event_category: 'engagement',
                        event_label: 'lawyer_signup'
                    });
                }
            }, 2000);
        },
        
        showSuccessMessage: function($form, $submitBtn) {
            $submitBtn.text('Thank You!').css({
                'background': 'linear-gradient(135deg, #059669, #10b981)',
                'border': 'none'
            }).attr('aria-busy', 'false');
            
            // Create accessible success message
            const successMsg = $(`
                <div class="success-message" role="alert" aria-live="polite" style="
                    background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.1)); 
                    border: 2px solid #10b981; 
                    border-radius: 12px; 
                    padding: 2rem; 
                    margin: 2rem 0; 
                    text-align: center;
                ">
                    <h3 style="color: #059669; margin-bottom: 1rem;">Thank you for signing!</h3>
                    <p style="color: #064e3b;">Your signature has been added to the letter. You will receive a confirmation email shortly.</p>
                </div>
            `);
            
            $form.after(successMsg);
            
            // Update counter if exists
            const $counter = $('.signature-count');
            if ($counter.length) {
                const newCount = parseInt($counter.text()) + 1;
                $counter.text(newCount);
            }
            
            // Scroll to success message
            $('html, body').animate({
                scrollTop: successMsg.offset().top - 100
            }, 500);
            
            // Focus success message for screen readers
            successMsg.attr('tabindex', '-1').focus();
        },
        
        setupFieldEnhancements: function() {
            // Enhanced focus states
            $('.form-field input, .form-field select, .form-field textarea').on('focus', function() {
                $(this).closest('.form-field').addClass('focused');
            }).on('blur', function() {
                $(this).closest('.form-field').removeClass('focused');
            });
        }
    };
    
    // ==========================================================================
    // SIGNEE SEARCH FUNCTIONALITY
    // ==========================================================================
    
    const signeeSearch = {
        init: function() {
            const $searchInput = $('#signee-search');
            const $clearBtn = $('.clear-search');
            const $resultsInfo = $('.search-results-info');
            
            if ($searchInput.length) {
                $searchInput.on('input', this.handleSearch.bind(this));
                $clearBtn.on('click', this.clearSearch.bind(this));
            }
        },
        
        handleSearch: function(e) {
            const query = $(e.target).val().toLowerCase().trim();
            const $signeeItems = $('.signee-item');
            const $clearBtn = $('.clear-search');
            const $resultsInfo = $('.search-results-info');
            
            if (query.length === 0) {
                // Show all items
                $signeeItems.show();
                $clearBtn.hide();
                $resultsInfo.text('');
                return;
            }
            
            // Show clear button
            $clearBtn.show();
            
            // Filter signees
            let visibleCount = 0;
            $signeeItems.each(function() {
                const searchText = $(this).data('search') || '';
                if (searchText.includes(query)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
            
            // Update results info
            if (visibleCount === 0) {
                $resultsInfo.html('<em>No signees found matching your search.</em>');
            } else {
                $resultsInfo.text(`Showing ${visibleCount} signee${visibleCount !== 1 ? 's' : ''}`);
            }
            
            // Announce to screen readers
            $('#main-content-status').text(`Search results updated: ${visibleCount} signees found`);
        },
        
        clearSearch: function() {
            $('#signee-search').val('').focus();
            $('.signee-item').show();
            $('.clear-search').hide();
            $('.search-results-info').text('');
            
            // Announce to screen readers
            $('#main-content-status').text('Search cleared, showing all signees');
        }
    };
    
    // ==========================================================================
    // SIGNATURE COUNTER ANIMATION
    // ==========================================================================
    
    const counterAnimation = {
        init: function() {
            const $counter = $('.signature-count');
            if ($counter.length && typeof IntersectionObserver !== 'undefined') {
                this.animateCounter($counter);
            }
        },
        
        animateCounter: function($counter) {
            const targetCount = parseInt($counter.text()) || 247;
            let currentCount = 0;
            
            const animateStep = () => {
                const increment = Math.ceil(targetCount / 50);
                if (currentCount < targetCount) {
                    currentCount = Math.min(currentCount + increment, targetCount);
                    $counter.text(currentCount);
                    setTimeout(animateStep, 30);
                }
            };
            
            // Start animation when element is visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStep();
                        observer.disconnect();
                    }
                });
            });
            
            observer.observe($counter[0]);
        }
    };
    
    // ==========================================================================
    // INITIALIZATION
    // ==========================================================================
    
    // Initialize all modules
    mobileNav.init();
    smoothScroll.init();
    formHandler.init();
    signeeSearch.init();
    counterAnimation.init();
    
    // Add loading animations to page elements
    $(window).on('load', function() {
        $('.hero-section, .letter-section, .form-section').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(20px)'
            }).delay(index * 200).animate({
                'opacity': '1'
            }, 800, function() {
                $(this).css('transform', 'translateY(0)');
            });
        });
    });
    
    // Performance monitoring
    if (typeof performance !== 'undefined' && performance.mark) {
        performance.mark('legal-theme-js-ready');
    }
});