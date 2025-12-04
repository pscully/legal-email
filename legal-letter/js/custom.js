/**
 * Production JavaScript for NC Lawyers Advocacy Website
 * Optimized single-page functionality without mobile navigation
 */

jQuery(document).ready(function($) {
    
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
    // SIGNEE SEARCH FUNCTIONALITY
    // ==========================================================================
    
    const signeeSearch = {
        init: function() {
            const $searchInput = $('#signee-search');
            const $clearBtn = $('.clear-search');
            
            if ($searchInput.length) {
                $searchInput.on('input', this.handleSearch.bind(this));
                $clearBtn.on('click', this.clearSearch.bind(this));
                
                // Keyboard accessibility
                $searchInput.on('keydown', function(e) {
                    if (e.key === 'Escape') {
                        signeeSearch.clearSearch();
                    }
                });
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
                $resultsInfo.html('<em>No lawyers found matching your search.</em>');
                this.showNoResultsMessage();
            } else {
                $resultsInfo.text(`Showing ${visibleCount} lawyer${visibleCount !== 1 ? 's' : ''}`);
                this.hideNoResultsMessage();
            }
            
            // Announce to screen readers
            $('#main-content-status').text(`Search results updated: ${visibleCount} lawyers found`);
        },
        
        clearSearch: function() {
            $('#signee-search').val('').focus();
            $('.signee-item').show();
            $('.clear-search').hide();
            $('.search-results-info').text('');
            this.hideNoResultsMessage();
            
            // Announce to screen readers
            $('#main-content-status').text('Search cleared, showing all signees');
        },
        
        showNoResultsMessage: function() {
            const $grid = $('.signees-grid');
            if (!$grid.find('.no-results-message').length) {
                const noResultsMsg = $(`
                    <div class="no-results-message" style="
                        grid-column: 1 / -1;
                        text-align: center;
                        padding: 2rem;
                        color: #64748b;
                        font-style: italic;
                    ">
                        <p>No lawyers found matching your search criteria.</p>
                        <p style="font-size: 0.9rem; margin-top: 0.5rem;">Try adjusting your search terms.</p>
                    </div>
                `);
                $grid.append(noResultsMsg);
            }
        },
        
        hideNoResultsMessage: function() {
            $('.no-results-message').remove();
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
            }, { threshold: 0.5 });
            
            observer.observe($counter[0]);
        }
    };
    
    // ==========================================================================
    // ENHANCED ACCESSIBILITY
    // ==========================================================================
    
    const accessibility = {
        init: function() {
            this.setupFocusManagement();
            this.setupKeyboardNavigation();
        },
        
        setupFocusManagement: function() {
            // Enhanced focus visibility for keyboard users
            $(document).on('keydown', function(e) {
                if (e.key === 'Tab') {
                    $('body').addClass('keyboard-navigation');
                }
            });
            
            $(document).on('mousedown', function() {
                $('body').removeClass('keyboard-navigation');
            });
        },
        
        setupKeyboardNavigation: function() {
            // Skip to main content functionality
            $('#skip-to-main').on('click', function(e) {
                e.preventDefault();
                const $mainContent = $('#letter');
                if ($mainContent.length) {
                    $mainContent.attr('tabindex', '-1').focus();
                    setTimeout(() => {
                        $mainContent.removeAttr('tabindex');
                    }, 1000);
                }
            });
        }
    };
    
    // ==========================================================================
    // FORM ENHANCEMENTS (if forms are added later)
    // ==========================================================================
    
    const formEnhancements = {
        init: function() {
            // Basic form validation for any future forms
            $('form').on('submit', this.handleFormSubmit.bind(this));
        },
        
        handleFormSubmit: function(e) {
            const $form = $(e.target);
            const $requiredFields = $form.find('[required]');
            let isValid = true;
            
            $requiredFields.each(function() {
                const $field = $(this);
                if (!$field.val().trim()) {
                    isValid = false;
                    $field.addClass('error').focus();
                    return false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Announce error to screen readers
                $('#main-content-status').text('Please fill in all required fields');
            }
        }
    };
    
    // ==========================================================================
    // PERFORMANCE OPTIMIZATIONS
    // ==========================================================================
    
    const performance = {
        init: function() {
            // Lazy load images if any
            this.setupLazyLoading();
            
            // Mark performance timing
            if (typeof performance !== 'undefined' && performance.mark) {
                performance.mark('legal-theme-js-ready');
            }
        },
        
        setupLazyLoading: function() {
            // Simple lazy loading for images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });
                
                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        }
    };

    // ==========================================================================
    // BACK TO TOP FUNCTIONALITY
    // ==========================================================================

    const backToTop = {
        init: function() {
            const $backToTopBtn = $('#backToTop');
            if ($backToTopBtn.length) {
                $(window).on('scroll', this.handleScroll.bind(this));
                this.setupBackToTop($backToTopBtn);
            }
        },

        handleScroll: function() {
            const $backToTopBtn = $('#backToTop');
            if ($(window).scrollTop() > 500) {
                $backToTopBtn.addClass('show');
            } else {
                $backToTopBtn.removeClass('show');
            }
        },

        setupBackToTop: function($btn) {
            // Add click handler
            $btn.on('click', function(e) {
                e.preventDefault();
                backToTop.scrollToTop();
            });

            // Add keyboard accessibility
            $btn.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    backToTop.scrollToTop();
                }
            });
        },

        scrollToTop: function() {
            $('html, body').animate({
                scrollTop: 0
            }, 600, 'swing');

            // Focus management for accessibility
            setTimeout(() => {
                $('body').attr('tabindex', '-1').focus();
                setTimeout(() => {
                    $('body').removeAttr('tabindex');
                }, 1000);
            }, 600);

            // Track back to top usage
            if (typeof gtag !== 'undefined') {
                gtag('event', 'back_to_top', {
                    event_category: 'navigation',
                    event_label: 'back_to_top_button'
                });
            }
        }
    };

    // ==========================================================================
    // INITIALIZATION
    // ==========================================================================
    
    // Initialize all modules
    smoothScroll.init();
    signeeSearch.init();
    counterAnimation.init();
    accessibility.init();
    formEnhancements.init();
    performance.init();
    backToTop.init();
    
    // Hero section loads immediately without animation
    
    // Add CSS for enhanced keyboard navigation
    if (!$('#keyboard-nav-styles').length) {
        $('<style id="keyboard-nav-styles">')
            .text(`
                .keyboard-navigation *:focus {
                    outline: 3px solid #f59e0b !important;
                    outline-offset: 2px !important;
                }
                
                .error {
                    border-color: #ef4444 !important;
                    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
                }
            `)
            .appendTo('head');
    }
});