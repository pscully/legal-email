<?php
/**
 * Template Name: Legal Advocacy Landing Page
 * Description: Custom template for the NC Lawyers Advocacy homepage
 */

get_header(); ?>

<main class="wp-site-blocks">
    
    <!-- Hero Section -->
    <section class="hero-section">
		<h1 class="hero-heading">A CALL TO OUR FELLOW LAWYERS TO ADD YOUR VOICE TO OURS…</h1>
        <div class="hero-container">
            <div class="hero-header-box">
                <div class="hero-text">
                <p>As lawyers who regularly fight for our clients in court, we know we are also fighting for <strong>fairness, due process, and the rule of law.</strong></p>

                <p>We also know that our work toward those goals, as well as the goals themselves, are now facing <strong>unprecedented attack.</strong></p>

                <p>We've heard the drumbeat for a while now.</p>

                <p>Threats against lawyers and law firms that dare to represent those not favored by the powerful.</p>

                <p>Threats against judges that dare to rule in favor of the powerless or against the powerful.</p>

                <p>Threats against schools, agencies, and private businesses that dare to recognize history and seek to remedy the ongoing legacy of that history.</p>

                <p>Threats to the very core of civil and criminal justice: that everyone in this country is entitled to due process of law before being deprived of their life, liberty, or property.</p>

                <p>Because we care deeply about those threats and have devoted our professional lives to fighting against them, in the coming days, we will be publishing the following letter in multiple statewide publications across multiple platforms.</p>

                <p>You are receiving this email because we hope you will join us and agree to add your name to the list of signers.</p>

                <p><strong>This message matters. Every voice matters matter. And the more voices we add, the stronger the message.</strong></p>

                <p><strong>Join us.</strong></p>

                <p style="margin-top: 2rem; text-decoration:underline; text-align: center; font-weight:bold;">The North Carolina Lawyers for the Rule of Law Steering Committee:</p>
                <div>
                    <p style="text-align: center;">Phil Baddour, Jr.</p>
                    <p style="text-align: center;">Brad Bannon</p>
                    <p style="text-align: center;">Joe Cheshire</p>
                    <p style="text-align: center;">Sonya Pfeiffer</p>
                    <p style="text-align: center;">David Rudolf</p>
                    <p style="text-align: center;">Tony Scheer</p>
                    <p style="text-align: center;">David Teddy</p>
                    <p style="text-align: center;">James E. Williams, Jr.</p>
                </div>
        </div>
                <a href="#letter" class="hero-button">READ THE LETTER</a>
                
                <div class="hero-count">
                    <?php 
                    $signee_count = get_signees_count();
                    echo $signee_count . ' Lawyers Have Signed The Letter';
                    ?>
                </div>
            </div>
            
            
        </div>
    </section>

    <!-- Social Proof Section -->
    <!-- <section class="social-proof">
        <span class="signature-count" data-count="247">0</span>
        <p class="signature-label">lawyers have signed this letter</p>
    </section> -->

    <!-- Letter Content Section -->
    <section class="letter-section" id="letter">
        <div class="letter-header">
		<h1 style="font-weight: bold;">A NONPARTISAN CALL TO PROTECT<br><span style="font-size: 22px;">OUR COURTS, OUR CONSTITUTION, OUR DEMOCRACY, AND</span> <br> THE RULE OF LAW</h1>
      <img src="/wp-content/uploads/nc-state-flag.png" alt="North Carolina State Flag" />
      <h3 style="font-weight: bold;">An Open Letter from North Carolina Lawyers</h3>
</div>  
       <article>
   

		   <p><strong>Fellow North Carolinians,</strong></p>

    <p>Our nation was founded on the principle that legal disputes should be resolved in courtrooms, not through threats or violence. This principle protects every one of us, ensuring equal access to justice and equal protection under the law.</p>

		   <p><strong>Today, that principle is under unprecedented attack.</strong></p>

    <p>Judges across America face death threats because of their rulings. In 2025 alone, nearly 200 federal judges have received serious death threats, often directly tied to decisions they have made from the bench.</p>

    <p>Lawyers are being intimidated and targeted by government agencies because of the clients and causes they represent.</p>
		   
		  

    <p><strong>When courts cannot guarantee equal protection and due process for all citizens, our democracy fails everyone.</strong></p>

     <ul id="our-shared-principles">
      <li><span style="font-weight: bold;">Equal Protection:</span> True equality under the law demands a full and fair commitment to ensuring that everyone is treated equally regardless of who you are, the color of your skin, or your station in life.</li>
      <li><span style="font-weight: bold;">Due Process:</span> Every person deserves a fair hearing before being deprived of his or her life, liberty, or property, and every party to a legal dispute should follow the law and comply with court orders throughout that process.</li>
      <li><span style="font-weight: bold;">Judicial Independence:</span> Judges must decide cases based on the facts and the law, not fear of violence. Threatening judges or court staff is never acceptable.</li>
      <li><span style="font-weight: bold;">Right To Zealous Representation:</span> Lawyers must be free to represent all clients without fear of government retaliation, and lawyers must be candid and truthful with the court regardless of the client or cause they represent.</li>
    </ul>

    <p><strong>These are not partisan positions, they are democratic principles.</strong> When any judge rules against any politician, that politician should pursue appropriate appeals, not attack the judge personally. The law must be above politics.</p>

    <p>We condemn government actions targeting law firms for representing clients in cases adverse to any administration. Stripping lawyers’ security clearances and restricting courthouse access based on client representation chills attorney-client relationships and denies citizens their right to counsel. <strong>If lawyers are subject to government retaliation for taking cases, access to justice dies for all.</strong></p>

    <p>Our courts provide peaceful resolution for legal disputes while ensuring equal protection for all citizens. Whether rich or poor, popular or unpopular, your rights must be protected.</p>

    <p>But this system only works when judges can judge fairly, lawyers can advocate fearlessly, and all participants feel safe.</p>

    <p style="text-align:center;"><strong>We call on all North Carolinians to join us as we commit to the following action:</strong></p>
		   
		   <ul style="text-align:center; list-style:none;">
			   <li>Ensuring Equal Protection</li>
			   <li>Guaranteeing Due Process</li>
<li>Supporting Judicial Independence</li>
<li>Defending the Right to Representation
</li>
			   <li>Condemning All Threats to Justice</li>

		   </ul>

		   <p style="text-align:center;"><strong>These are fundamental rule of law principles.</strong></p>

    <p>We agree with the late United States Congressman John Lewis:</p>

    <blockquote>
      <p>"When you see something that is not right, not fair, not just, you have to speak up. You have to say something; you have to do something."</p>
    </blockquote>

    <p style="text-align:center;">Protecting the least among us protects us all.</p>
		   <p style="text-align:center;">
		    <?php 
                    $signee_count = get_signees_count();
                    echo 'SIGNED BY ' . $signee_count . ' NORTH CAROLINA LAWYERS';
                    ?>
		   </p>
<!-- 		   <div class="signee-instructions">
            <p>To sign the letter please click the link in your invitation email. If you are a North Carolina lawyer and have not received an invitation, please email admin@NCLawyer4theRuleofLaw.org with a photo of your Bar card and we will send you a sign-up link.</p>
        </div> -->
  </article>

    </section>
    <!-- Signees Section -->
    <section class="form-section signees-section">
        <h2 class="form-title">Current Signees</h2>
        
        <!-- Search Input -->
        <div class="signee-search-container">
            <div class="search-input-wrapper">
                <input type="text" id="signee-search" placeholder="Search lawyers by name..." aria-label="Search signees">
                <span class="search-icon">🔍</span>
                <button type="button" class="clear-search" id="clear-search" aria-label="Clear search">✕</button>
            </div>
            <div class="search-results-info" id="search-results-info"></div>
        </div>
        
        <!-- Letter Signees List -->
        <div id="letter-signees">
            <?php echo get_signees_list(-1, false, 'DESC'); ?>
        </div>

        <!-- Back to Top Button -->
        <button class="back-to-top" id="backToTop" title="Back to top">
            ↑
        </button>

        <!-- Sign Up Instructions -->
        
    </section>

   

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('signee-search');
    const clearButton = document.getElementById('clear-search');
    const resultsInfo = document.getElementById('search-results-info');
    const signeesGrid = document.querySelector('.signees-grid');
    const signeesCount = document.querySelector('.signees-count');
    
    if (!searchInput || !signeesGrid) return;
    
    const signeeItems = signeesGrid.querySelectorAll('.signee-item');
    const totalCount = signeeItems.length;
    let searchTimeout;
    
    // Initialize
    updateResultsInfo(totalCount, totalCount);
    
    // Search functionality
    function performSearch(query) {
        const searchTerm = query.toLowerCase().trim();
        let visibleCount = 0;
        
        signeeItems.forEach(item => {
            const searchData = item.getAttribute('data-search') || '';
            const isMatch = searchTerm === '' || searchData.includes(searchTerm);
            
            if (isMatch) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        updateResultsInfo(visibleCount, totalCount);
        toggleClearButton(searchTerm !== '');
        
        // Show/hide no results message
        showNoResultsMessage(visibleCount === 0 && searchTerm !== '');
    }
    
    // Update results information
    function updateResultsInfo(visible, total) {
        if (visible === total) {
            resultsInfo.textContent = '';
        } else {
            resultsInfo.textContent = `Showing ${visible} of ${total} lawyers`;
        }
    }
    
    // Toggle clear button visibility
    function toggleClearButton(show) {
        clearButton.style.display = show ? 'block' : 'none';
    }
    
    // Show/hide no results message
    function showNoResultsMessage(show) {
        let noResultsMsg = signeesGrid.querySelector('.no-results-message');
        
        if (show && !noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results-message';
            noResultsMsg.innerHTML = '<p>No lawyers found matching your search.</p>';
            signeesGrid.appendChild(noResultsMsg);
        } else if (!show && noResultsMsg) {
            noResultsMsg.remove();
        }
    }
    
    // Debounced search
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });
    
    // Clear search
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        performSearch('');
        searchInput.focus();
    });
    
    // Keyboard accessibility
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            performSearch('');
        }
    });
});
</script>

<style>
/* Page-specific enhancements */
.wp-site-blocks {
    max-width: none;
    margin: 0;
    padding: 0;
}

/* Only apply container styles to non-hero sections */
.letter-section,
.form-section,
.endorsements {
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 2rem;
    padding-right: 2rem;
}
/* .form-section {
    border: #8b1e16 2px solid;
    border-radius: 5px;
} */

@media (max-width: 768px) {
    .letter-section,
    .form-section,
    .endorsements {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>

<script>
// Enhanced form handling and animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate signature counter
    const counter = document.querySelector('.signature-count');
    if (counter) {
        const targetCount = parseInt(counter.dataset.count) || 247;
        let currentCount = 0;
        
        const animateCounter = () => {
            const increment = Math.ceil(targetCount / 50);
            if (currentCount < targetCount) {
                currentCount = Math.min(currentCount + increment, targetCount);
                counter.textContent = currentCount;
                setTimeout(animateCounter, 30);
            }
        };
        
        // Start animation when element is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.disconnect();
                }
            });
        });
        
        observer.observe(counter);
    }

    // Form submission handling
    const form = document.getElementById('lawyer-signup-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('.submit-button');
            const originalText = submitBtn.textContent;
            
            // Show loading state
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            // Simulate form processing (replace with actual Paperform integration)
            setTimeout(() => {
                submitBtn.textContent = 'Thank You!';
                submitBtn.style.background = 'linear-gradient(135deg, #059669, #10b981)';
                
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.innerHTML = `
                    <div style="background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.1)); 
                                border: 2px solid #10b981; 
                                border-radius: 12px; 
                                padding: 2rem; 
                                margin: 2rem 0; 
                                text-align: center;">
                        <h3 style="color: #059669; margin-bottom: 1rem;">Thank you for signing!</h3>
                        <p style="color: #064e3b;">Your signature has been added to the letter. You will receive a confirmation email shortly.</p>
                        <p style="color: #064e3b; font-size: 0.9rem; margin-top: 1rem;"><em>This is a demo form. In production, this will integrate with Paperform.</em></p>
                    </div>
                `;
                form.parentNode.appendChild(successMsg);
                
                // Update counter
                const newCount = parseInt(counter.textContent) + 1;
                counter.textContent = newCount;
                counter.dataset.count = newCount;
                
            }, 2000);
        });
    }

    // Smooth scrolling for anchor links
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
});
</script>

<?php get_footer(); ?>