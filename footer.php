<?php
// footer.php - Universal footer that works with any page background
$currentYear = date('Y');
?>

<style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

   /* Core Animations */
   @keyframes float {

      0%,
      100% {
         transform: translateY(-20px);
      }

      50% {
         transform: translateY(-30px);
      }
   }

   @keyframes floatOrb {

      0%,
      100% {
         transform: translate(0, 0);
      }

      50% {
         transform: translate(30px, 30px);
      }
   }

   @keyframes rotate {
      from {
         transform: rotate(0deg);
      }

      to {
         transform: rotate(360deg);
      }
   }

   @keyframes wave {
      0% {
         d: path("M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z");
      }

      100% {
         d: path("M0,0V35.29c47.79,25.2,103.59,38.17,158,35,70.36-8.37,136.33-40.31,206.8-45.5,70.47-5.19,144.17,16.05,214.83,34.43,69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z");
      }
   }

   /* Footer Container */
   .harvest-footer {
      font-family: 'Poppins', sans-serif;
      position: relative;
      margin-top: 100px;
      color: #fff;
      width: 100%;
      z-index: 1000;
      display: block;
   }

   /* Wave SVG */
   .footer-wave {
      position: absolute;
      top: -100px;
      left: 0;
      width: 100%;
      overflow: hidden;
      line-height: 0;
      transform: rotate(180deg);
      z-index: 1;
   }

   .footer-wave svg {
      position: relative;
      display: block;
      width: calc(100% + 1.3px);
      height: 120px;
      filter: drop-shadow(0 -5px 10px rgba(0, 0, 0, 0.1));
   }

   .wave-path {
      fill: #0d3311;
      animation: wave 8s ease-in-out infinite alternate;
   }

   /* Main Footer - Solid Background */
   .footer-main {
      background: linear-gradient(145deg, #0d3311 0%, #1a4d1f 100%);
      padding: 80px 0 30px;
      position: relative;
      z-index: 2;
      overflow: hidden;
      /* Fixes bottom white space */
   }

   /* Background Orbs */
   .footer-orb-1 {
      position: absolute;
      top: -100px;
      right: -100px;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(251, 191, 36, 0.2) 0%, transparent 70%);
      border-radius: 50%;
      filter: blur(60px);
      animation: floatOrb 20s ease-in-out infinite;
      pointer-events: none;
   }

   .footer-orb-2 {
      position: absolute;
      bottom: -100px;
      left: -100px;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(27, 94, 32, 0.4) 0%, transparent 70%);
      border-radius: 50%;
      filter: blur(60px);
      animation: floatOrb 25s ease-in-out infinite reverse;
      pointer-events: none;
   }

   /* Container */
   .footer-container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 20px;
      position: relative;
      z-index: 3;
   }

   /* Newsletter Card */
   .newsletter-card {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 30px;
      padding: 50px 40px;
      margin-bottom: 60px;
      text-align: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      transform: translateY(-20px);
      animation: float 6s ease-in-out infinite;
   }

   .newsletter-card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 50%);
      animation: rotate 20s linear infinite;
      pointer-events: none;
   }

   .newsletter-title {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 15px;
      color: #fff;
      position: relative;
      z-index: 2;
   }

   .newsletter-title span {
      color: #fbbf24;
      text-shadow: 0 0 10px rgba(251, 191, 36, 0.3);
   }

   .newsletter-desc {
      color: #e2e8f0;
      margin-bottom: 30px;
      font-size: 1.1rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      z-index: 2;
   }

   /* Newsletter Form */
   .newsletter-form {
      max-width: 550px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
   }

   .form-group {
      display: flex;
      gap: 10px;
      background: rgba(0, 0, 0, 0.3);
      border: 2px solid rgba(255, 255, 255, 0.1);
      border-radius: 60px;
      padding: 5px;
      transition: all 0.3s ease;
   }

   .form-group:focus-within {
      border-color: #fbbf24;
      box-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
      transform: scale(1.02);
      background: rgba(0, 0, 0, 0.4);
   }

   .newsletter-input {
      flex: 1;
      background: transparent;
      border: none;
      padding: 15px 25px;
      color: #fff;
      font-size: 1rem;
      outline: none;
   }

   .newsletter-input::placeholder {
      color: rgba(255, 255, 255, 0.6);
   }

   .newsletter-btn {
      background: linear-gradient(135deg, #fbbf24, #f59e0b);
      border: none;
      color: #0d3311;
      font-weight: 700;
      padding: 15px 35px;
      border-radius: 60px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      font-size: 1rem;
      white-space: nowrap;
   }

   .newsletter-btn:hover {
      background: #fff;
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(251, 191, 36, 0.4);
   }

   .newsletter-btn i {
      transition: transform 0.3s ease;
   }

   .newsletter-btn:hover i {
      transform: translateX(5px);
   }

   /* Footer Grid */
   .footer-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
      gap: 40px;
      margin-bottom: 50px;
   }

   /* Brand Column */
   .brand-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
   }

   .logo-icon {
      width: 50px;
      height: 50px;
      background: #fbbf24;
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0d3311;
      font-size: 1.8rem;
      transform: rotate(-5deg);
      transition: all 0.3s ease;
   }

   .brand-logo:hover .logo-icon {
      transform: rotate(0deg) scale(1.1);
      background: #fff;
   }

   .logo-text {
      font-size: 1.8rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.5px;
   }

   .brand-desc {
      color: #e2e8f0;
      line-height: 1.8;
      margin-bottom: 25px;
      font-size: 0.95rem;
   }

   /* Social Icons */
   .social-icons {
      display: flex;
      gap: 15px;
   }

   .social-icon {
      width: 45px;
      height: 45px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
   }

   .social-icon::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(251, 191, 36, 0.5);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
   }

   .social-icon:hover {
      background: #fbbf24;
      color: #0d3311;
      transform: translateY(-8px) rotate(8deg);
      border-color: #fbbf24;
   }

   .social-icon:hover::before {
      width: 200px;
      height: 200px;
   }

   .social-icon i {
      position: relative;
      z-index: 2;
   }

   /* Footer Columns */
   .footer-column {
      position: relative;
   }

   .column-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 25px;
      color: #fff;
      position: relative;
      padding-bottom: 10px;
   }

   .column-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 40px;
      height: 3px;
      background: #fbbf24;
      border-radius: 2px;
      transition: width 0.3s ease;
   }

   .footer-column:hover .column-title::after {
      width: 60px;
   }

   /* Centering Fix for Quick Links (2nd) and Resources (3rd) Columns */
   @media (min-width: 769px) {

      .footer-grid .footer-column:nth-child(2),
      .footer-grid .footer-column:nth-child(3) {
         display: flex;
         flex-direction: column;
         align-items: center;
      }

      .footer-grid .footer-column:nth-child(2) .column-title,
      .footer-grid .footer-column:nth-child(3) .column-title {
         text-align: center;
         width: 100%;
      }

      .footer-grid .footer-column:nth-child(2) .column-title::after,
      .footer-grid .footer-column:nth-child(3) .column-title::after {
         left: 50%;
         transform: translateX(-50%);
      }

      .footer-grid .footer-column:nth-child(2):hover .column-title::after,
      .footer-grid .footer-column:nth-child(3):hover .column-title::after {
         left: 50%;
         transform: translateX(-50%);
         width: 60px;
      }

      .footer-grid .footer-column:nth-child(2) .footer-links,
      .footer-grid .footer-column:nth-child(3) .footer-links {
         display: flex;
         flex-direction: column;
         align-items: flex-start;
         /* Keeps the arrows perfectly straight on the left */
         width: max-content;
      }
   }

   /* Footer Links */
   .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
   }

   .footer-links li {
      margin-bottom: 15px;
   }

   .footer-links a {
      color: #e2e8f0;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
      font-size: 0.95rem;
   }

   .footer-links a i {
      color: #fbbf24;
      font-size: 0.8rem;
      transition: all 0.3s ease;
   }

   .footer-links a:hover {
      color: #fbbf24;
      transform: translateX(10px);
   }

   .footer-links a:hover i {
      transform: scale(1.2);
   }

   /* Contact Info */
   .contact-info {
      list-style: none;
      padding: 0;
      margin: 0;
   }

   .contact-item {
      display: flex;
      align-items: flex-start;
      gap: 15px;
      margin-bottom: 20px;
      color: #e2e8f0;
      font-size: 0.95rem;
      transition: all 0.3s ease;
   }

   .contact-icon {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fbbf24;
      flex-shrink: 0;
      transition: all 0.3s ease;
   }

   .contact-item:hover .contact-icon {
      background: #fbbf24;
      color: #0d3311;
      transform: scale(1.1) rotate(5deg);
   }

   .contact-text {
      line-height: 1.6;
   }

   .contact-text strong {
      color: #fff;
      font-weight: 600;
   }

   .contact-text span {
      color: #94a3b8;
      font-size: 0.85rem;
   }

   /* Footer Bottom */
   .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 25px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
   }

   .copyright {
      color: #94a3b8;
      font-size: 0.9rem;
   }

   .copyright strong {
      color: #fff;
      font-weight: 600;
   }

   .footer-bottom-links {
      display: flex;
      gap: 25px;
      align-items: center;
   }

   .footer-bottom-links a {
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      position: relative;
   }

   .footer-bottom-links a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 1px;
      background: #fbbf24;
      transition: width 0.3s ease;
   }

   .footer-bottom-links a:hover {
      color: #fbbf24;
   }

   .footer-bottom-links a:hover::after {
      width: 100%;
   }

   /* Back to Top Button */
   .back-to-top {
      width: 45px;
      height: 45px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      color: #fbbf24;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      font-size: 1.1rem;
      border: none;
   }

   .back-to-top:hover {
      background: #fbbf24;
      color: #0d3311;
      transform: translateY(-5px) scale(1.1);
      box-shadow: 0 10px 20px rgba(251, 191, 36, 0.3);
      cursor: pointer;
   }

   /* Responsive Design */
   @media (max-width: 1024px) {
      .footer-grid {
         grid-template-columns: repeat(2, 1fr);
      }
   }

   @media (max-width: 768px) {
      .footer-grid {
         grid-template-columns: 1fr;
      }

      .newsletter-card {
         padding: 40px 20px;
      }

      .newsletter-title {
         font-size: 1.8rem;
      }

      .form-group {
         flex-direction: column;
         background: transparent;
         border: none;
         padding: 0;
      }

      .form-group:focus-within {
         transform: none;
         box-shadow: none;
      }

      .newsletter-input {
         background: rgba(0, 0, 0, 0.3);
         border: 2px solid rgba(255, 255, 255, 0.1);
         border-radius: 60px;
         margin-bottom: 10px;
         width: 100%;
         padding: 15px 25px;
      }

      .newsletter-btn {
         width: 100%;
         justify-content: center;
         padding: 15px 25px;
      }

      .footer-bottom {
         flex-direction: column;
         text-align: center;
      }

      .footer-bottom-links {
         flex-wrap: wrap;
         justify-content: center;
      }
   }

   @media (max-width: 480px) {
      .footer-bottom-links {
         flex-direction: column;
         gap: 15px;
      }

      .social-icons {
         justify-content: center;
      }

      .brand-logo {
         justify-content: center;
      }

      .brand-desc {
         text-align: center;
      }

      .column-title {
         text-align: center;
      }

      .column-title::after {
         left: 50%;
         transform: translateX(-50%);
      }

      .footer-column:hover .column-title::after {
         width: 60px;
         left: 50%;
         transform: translateX(-50%);
      }

      .footer-links a {
         justify-content: center;
         width: 100%;
      }

      .contact-item {
         justify-content: center;
      }
   }
</style>

<footer class="harvest-footer">
   <div class="footer-wave">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
         <path class="wave-path"
            d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
            fill="#0d3311" />
      </svg>
   </div>

   <div class="footer-main">
      <div class="footer-orb-1"></div>
      <div class="footer-orb-2"></div>

      <div class="footer-container">
         <div class="newsletter-card">
            <h2 class="newsletter-title">Grow With <span>Harvest Hub</span> 🌱</h2>
            <p class="newsletter-desc">Join 10,000+ farmers and buyers. Get the latest crop market trends, weather
               updates, and trading tips delivered weekly.</p>

            <form class="newsletter-form" onsubmit="event.preventDefault(); handleNewsletterSubmit(this);">
               <div class="form-group">
                  <input type="email" class="newsletter-input" placeholder="Enter your email address..." required>
                  <button type="submit" class="newsletter-btn">
                     Subscribe <i class="fas fa-paper-plane"></i>
                  </button>
               </div>
            </form>
         </div>

         <div class="footer-grid">
            <div class="footer-column">
               <div class="brand-logo">
                  <div class="logo-icon">
                     <i class="fas fa-leaf"></i>
                  </div>
                  <span class="logo-text">Harvest Hub</span>
               </div>
               <p class="brand-desc">
                  Bridging the gap between hardworking farmers and conscious consumers. Fair trade, fresh produce, and a
                  greener future for everyone.
               </p>
               <div class="social-icons">
                  <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
               </div>
            </div>

            <div class="footer-column">
               <h3 class="column-title">Quick Links</h3>
               <ul class="footer-links">
                  <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                  <li><a href="marketplace.php"><i class="fas fa-chevron-right"></i> Marketplace</a></li>
                  <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                  <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                  <li><a href="become-seller.php"><i class="fas fa-chevron-right"></i> Become a Seller</a></li>
               </ul>
            </div>

            <div class="footer-column">
               <h3 class="column-title">Resources</h3>
               <ul class="footer-links">
                  <li><a href="crop-prices.php"><i class="fas fa-chevron-right"></i> Crop Market Prices</a></li>
                  <li><a href="weather-forecast.php"><i class="fas fa-chevron-right"></i> Weather Forecast</a></li>
                  <li><a href="farming-equipment.php"><i class="fas fa-chevron-right"></i> Farming Equipment</a></li>
                  <li><a href="government-subsidy.php"><i class="fas fa-chevron-right"></i> Government Subsidy</a></li>
                  <li><a href="farming-tips.php"><i class="fas fa-chevron-right"></i> Farming Tips</a></li>
               </ul>
            </div>

            <div class="footer-column">
               <h3 class="column-title">Get in Touch</h3>
               <ul class="contact-info">
                  <li class="contact-item">
                     <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                     <div class="contact-text">
                        <strong>101, Opp. Sir BPTI Vidhyanagar</strong><br>
                        <span>Gujarat, India 364004</span>
                     </div>
                  </li>
                  <li class="contact-item">
                     <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                     <div class="contact-text">
                        <strong>+91 98765 43210</strong><br>
                        <span>Mon - Sat, 9AM - 6PM</span>
                     </div>
                  </li>
                  <li class="contact-item">
                     <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                     <div class="contact-text">
                        <strong>support@harvesthub.com</strong><br>
                        <span>24/7 Support</span>
                     </div>
                  </li>
               </ul>
            </div>
         </div>

         <div class="footer-bottom">
            <div class="copyright">
               &copy; <?php echo $currentYear; ?> <strong>Harvest Hub</strong>. All Rights Reserved.
            </div>
            <div class="footer-bottom-links">
               <a href="privacy-policy.php">Privacy Policy</a>
               <a href="terms-of-service.php">Terms of Service</a>
               <button class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                  aria-label="Back to top">
                  <i class="fas fa-arrow-up"></i>
               </button>
            </div>
         </div>
      </div>
   </div>
</footer>

<script>
   // Handle newsletter submission
   function handleNewsletterSubmit(form) {
      const email = form.querySelector('input[type="email"]').value;
      if (email) {
         alert(`Thank you for subscribing with: ${email}`);
         form.querySelector('input[type="email"]').value = '';
      }
   }

   // Smooth scroll for back to top button
   document.addEventListener('DOMContentLoaded', function () {
      const backToTopBtn = document.querySelector('.back-to-top');
      if (backToTopBtn) {
         backToTopBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
               top: 0,
               behavior: 'smooth'
            });
         });
      }
   });

   // Add animation on scroll for newsletter card
   window.addEventListener('scroll', function () {
      const newsletterCard = document.querySelector('.newsletter-card');
      if (newsletterCard) {
         const rect = newsletterCard.getBoundingClientRect();
         const isVisible = rect.top < window.innerHeight && rect.bottom >= 0;
         if (isVisible) {
            newsletterCard.style.animation = 'float 6s ease-in-out infinite';
         }
      }
   });
</script>