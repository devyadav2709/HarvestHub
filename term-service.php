<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Terms of Service | Harvest Hub</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <style>
      :root {
         --primary: #2e7d32;
         --dark: #1b5e20;
         --accent: #fbc02d;
         --light-bg: #f4f7f6;
         --text: #333;
         --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      }

      body {
         font-family: 'Poppins', sans-serif;
         background-color: var(--light-bg);
         color: var(--text);
         line-height: 1.7;
         display: flex;
         flex-direction: column;
         min-height: 100vh;
      }

      .main-content {
         flex: 1;
         padding: 50px 15px;
         display: flex;
         justify-content: center;
      }

      .terms-container {
         max-width: 1000px;
         width: 100%;
         background: white;
         border-radius: 20px;
         box-shadow: var(--shadow);
         overflow: hidden;
         border: 1px solid rgba(0, 0, 0, 0.05);
      }

      /* Header Area */
      .terms-header {
         background: linear-gradient(135deg, var(--primary), var(--dark));
         color: white;
         padding: 60px 40px;
         text-align: center;
         position: relative;
         border-bottom: 5px solid var(--accent);
      }

      .header-icon-group {
         display: flex;
         justify-content: center;
         gap: 15px;
         margin-bottom: 25px;
      }

      .header-icon-group i {
         background: rgba(255, 255, 255, 0.15);
         font-size: 2.2rem;
         width: 70px;
         height: 70px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         border: 2px solid rgba(255, 255, 255, 0.3);
      }

      .terms-header h1 {
         font-weight: 800;
         margin-bottom: 10px;
         font-size: 3rem;
      }

      .terms-header h1 small {
         display: block;
         font-size: 1.2rem;
         font-weight: 400;
         color: var(--accent);
         margin-top: 10px;
         letter-spacing: 2px;
         text-transform: uppercase;
      }

      .meta-grid {
         display: flex;
         flex-wrap: wrap;
         gap: 15px;
         justify-content: center;
         margin-top: 30px;
      }

      .meta-grid .badge-pill {
         background: rgba(0, 0, 0, 0.2);
         padding: 10px 20px;
         border-radius: 50px;
         font-weight: 600;
         border: 1px solid rgba(255, 255, 255, 0.2);
         font-size: 0.95rem;
         color: #fff;
         display: inline-flex;
         align-items: center;
         gap: 8px;
      }

      .meta-grid .badge-pill i {
         color: var(--accent);
      }

      /* Body Sections */
      .terms-body {
         padding: 50px;
      }

      .terms-chapter {
         margin-bottom: 50px;
      }

      .chapter-head {
         display: flex;
         align-items: center;
         gap: 15px;
         border-bottom: 2px dashed #e0e0e0;
         padding-bottom: 15px;
         margin-bottom: 25px;
      }

      .chapter-icon {
         background: #e8f5e9;
         color: var(--primary);
         width: 60px;
         height: 60px;
         border-radius: 15px;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 1.8rem;
      }

      .chapter-head h2 {
         font-weight: 700;
         color: var(--dark);
         margin: 0;
         font-size: 2rem;
      }

      .chapter-head h2 span {
         font-size: 1rem;
         background: var(--dark);
         color: white;
         padding: 5px 15px;
         border-radius: 50px;
         margin-left: 15px;
         vertical-align: middle;
         font-weight: 500;
      }

      .insight-box {
         background: #f1f8e9;
         border-radius: 15px;
         padding: 25px;
         margin: 25px 0;
         border-left: 5px solid var(--primary);
         font-size: 1.05rem;
         color: #444;
      }

      /* Grids */
      .feature-grid {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
         gap: 20px;
         margin: 30px 0;
      }

      .feature-card {
         background: white;
         border-radius: 15px;
         padding: 25px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
         border: 1px solid #eee;
         transition: 0.3s;
      }

      .feature-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }

      .feature-card i {
         font-size: 2rem;
         color: var(--primary);
         background: #e8f5e9;
         padding: 15px;
         border-radius: 12px;
         margin-bottom: 15px;
         display: inline-block;
      }

      .feature-card h5 {
         font-weight: 700;
         color: var(--dark);
         margin-bottom: 10px;
      }

      .feature-card p {
         color: #666;
         font-size: 0.95rem;
         margin: 0;
      }

      /* Lists */
      .list-harvest {
         list-style: none;
         padding-left: 0;
      }

      .list-harvest li {
         margin-bottom: 12px;
         padding-left: 35px;
         position: relative;
         color: #555;
         font-weight: 500;
      }

      .list-harvest li::before {
         content: "\f4d8";
         /* FontAwesome seedling */
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         position: absolute;
         left: 0;
         top: 2px;
         color: var(--primary);
         font-size: 1.1rem;
      }

      .list-harvest.alt li::before {
         content: "\f058";
         /* check circle */
      }

      .list-harvest.prohibited li::before {
         content: "\f071";
         /* Exclamation triangle */
         color: #d32f2f;
      }

      /* Contact Estate */
      .contact-estate {
         background: white;
         border-radius: 20px;
         padding: 30px;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
         border: 1px solid #eee;
         margin-top: 30px;
      }

      .contact-row {
         display: flex;
         align-items: center;
         padding: 12px 0;
         border-bottom: 1px solid #f5f5f5;
      }

      .contact-row:last-child {
         border-bottom: none;
      }

      .contact-row i {
         width: 45px;
         height: 45px;
         background: #e8f5e9;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 20px;
         color: var(--primary);
         font-size: 1.2rem;
      }

      .contact-row a {
         color: var(--primary);
         font-weight: 600;
         text-decoration: none;
         transition: 0.3s;
      }

      .contact-row a:hover {
         color: var(--dark);
         text-decoration: underline;
      }

      .badge-farm {
         background: var(--accent);
         color: #000;
         padding: 4px 15px;
         border-radius: 50px;
         font-weight: 700;
         font-size: 0.85rem;
         margin-left: 10px;
         text-transform: uppercase;
      }

      .footer-note {
         background: #e8f5e9;
         border-radius: 15px;
         padding: 25px;
         text-align: center;
         color: var(--dark);
         font-weight: 500;
         margin-top: 50px;
      }

      @media (max-width: 768px) {
         .terms-body {
            padding: 30px 20px;
         }

         .terms-header {
            padding: 40px 20px;
         }

         .terms-header h1 {
            font-size: 2.2rem;
         }

         .chapter-head h2 {
            font-size: 1.5rem;
         }

         .chapter-head h2 span {
            display: block;
            margin: 10px 0 0 0;
            width: fit-content;
         }
      }
   </style>
</head>

<body>

   <?php include "navbar.php"; ?>

   <div class="main-content">
      <div class="terms-container">

         <div class="terms-header">
            <div class="header-icon-group">
               <i class="fas fa-file-signature"></i>
               <i class="fas fa-seedling"></i>
               <i class="fas fa-balance-scale"></i>
            </div>
            <h1>Terms of Service <small>Farmer & Consumer Agreement</small></h1>
            <div class="meta-grid">
               <span class="badge-pill"><i class="fas fa-calendar-check"></i> Effective: 01 June 2025</span>
               <span class="badge-pill"><i class="fas fa-pen-nib"></i> Version 3.2</span>
               <span class="badge-pill"><i class="fas fa-leaf"></i> Harvest Hub</span>
            </div>
         </div>

         <div class="terms-body">

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-handshake"></i></div>
                  <h2>Introduction & Acceptance <span>Welcome</span></h2>
               </div>
               <p><strong>Harvest Hub</strong> connects farmers directly with consumers through a fair bidding system.
                  By accessing or using the platform — whether you're listing heirloom tomatoes or placing a bid — you
                  agree to be bound by these Terms. If you don't agree, please do not use the services.</p>
               <div class="insight-box">
                  <i class="fas fa-shield-check text-success me-2"></i> <strong>Platform role:</strong> Harvest Hub is a
                  facilitator, not a seller. We provide the digital soil; users grow the transactions.
               </div>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-store"></i></div>
                  <h2>What We Offer</h2>
               </div>
               <p>A transparent online marketplace for agricultural trade:</p>
               <ul class="list-harvest">
                  <li>Farmers list products with descriptions and starting bids.</li>
                  <li>Consumers browse and place bids in real time.</li>
                  <li>Winning bids connect both parties to complete the deal.</li>
                  <li>We cut out intermediaries – more value for both ends.</li>
               </ul>
               <p class="mt-3 text-muted"><i class="fas fa-info-circle me-1"></i> Harvest Hub does not grow, sell, or
                  deliver produce; we simply enable the connection.</p>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-user-check"></i></div>
                  <h2>Eligibility & Your Account</h2>
               </div>
               <div class="feature-grid">
                  <div class="feature-card">
                     <i class="fas fa-user-plus"></i>
                     <h5>Age 18+</h5>
                     <p>You must be at least 18 years old or the age of majority in your region.</p>
                  </div>
                  <div class="feature-card">
                     <i class="fas fa-id-card"></i>
                     <h5>Accurate Info</h5>
                     <p>Provide true, current, and complete registration details.</p>
                  </div>
                  <div class="feature-card">
                     <i class="fas fa-lock"></i>
                     <h5>Confidentiality</h5>
                     <p>You are responsible for all activity under your credentials.</p>
                  </div>
               </div>
               <p>Notify us immediately at <strong>security@harvesthub.com</strong> if you suspect unauthorized use. We
                  reserve the right to suspend any account with false information.</p>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-thumbs-up"></i></div>
                  <h2>Acceptable Use</h2>
               </div>
               <ul class="list-harvest alt">
                  <li>List genuine farm products</li>
                  <li>Bid fairly and respectfully</li>
                  <li>Communicate without harassment</li>
                  <li>Provide accurate descriptions</li>
               </ul>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-images"></i></div>
                  <h2>Your Content, Your Rights</h2>
               </div>
               <p>You retain ownership of photos, descriptions, and reviews you post. By uploading, you grant Harvest
                  Hub a non‑exclusive license to display and distribute that content solely for platform operation. We
                  never claim ownership of your farm’s identity.</p>
               <div class="insight-box">
                  <i class="fas fa-info-circle text-primary me-2"></i> We may remove content that violates these terms
                  (e.g., misleading images).
               </div>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-user-shield"></i></div>
                  <h2>Privacy Policy</h2>
               </div>
               <p>Your privacy matters. How we collect, use, and protect your data is detailed in our separate <a
                     href="privacy.php" style="color:var(--primary);"><strong>Privacy Policy</strong></a> — it's part of
                  these Terms.</p>
               <a href="privacy.php" class="badge-farm text-decoration-none"><i class="fas fa-arrow-right me-1"></i>
                  Please Review It</a>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-exclamation-triangle"></i></div>
                  <h2>Prohibited Activities</h2>
               </div>
               <ul class="list-harvest prohibited">
                  <li>Misleading or fake listings</li>
                  <li>Bid manipulation (shill bidding, etc.)</li>
                  <li>Harassment or hateful communication</li>
                  <li>Attempting to hack, scrape, or disrupt</li>
                  <li>Using bots to place bids</li>
                  <li>Any violation of local/international law</li>
               </ul>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-shopping-basket"></i></div>
                  <h2>Transactions – Our Role</h2>
               </div>
               <p>Harvest Hub is the neutral ground. We don't guarantee product quality, delivery, or the outcome of any
                  transaction. Buyers and sellers are responsible for verifying details and fulfilling agreements. We
                  are not liable for disputes between users.</p>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-balance-scale-right"></i></div>
                  <h2>Limitation of Liability</h2>
               </div>
               <p>To the fullest extent permitted by law, Harvest Hub (including its owners, employees, and affiliates)
                  shall not be liable for any indirect, incidental, or consequential damages arising from your use of
                  the platform. Your use is at your own risk.</p>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-ban"></i></div>
                  <h2>Account Termination</h2>
               </div>
               <p>We may suspend or terminate accounts that violate these Terms, engage in fraud, or harm the community.
                  You may also delete your account anytime via settings.</p>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-sync-alt"></i></div>
                  <h2>Changes to These Terms</h2>
               </div>
               <p>If we update this agreement, we'll post the new version here and update the effective date. Continuing
                  to use Harvest Hub after changes means you accept the revised terms.</p>
            </div>

            <div class="terms-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-gavel"></i></div>
                  <h2>Governing Law & Disputes</h2>
               </div>
               <p>These Terms are governed by the laws of your jurisdiction. We encourage amicable resolution first —
                  contact support before initiating formal proceedings.</p>
            </div>

            <div class="terms-chapter mb-0">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-envelope-open-text"></i></div>
                  <h2>Contact Us</h2>
               </div>
               <p>Questions about these Terms? Our support team is here to help.</p>

               <div class="contact-estate">
                  <div class="contact-row">
                     <i class="fas fa-at"></i>
                     <span><a href="mailto:terms@harvesthub.com">terms@harvesthub.com</a> <span class="badge-farm">Legal
                           Team</span></span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-comments"></i>
                     <span>Live chat at <strong>harvesthub.com/support</strong></span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-phone-alt"></i>
                     <span><a href="tel:+18004785264">+1 (800) 478-5264</a> <span class="text-muted ms-1">(Privacy &
                           terms line)</span></span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-building"></i>
                     <span class="text-muted">14 Orchard Lane, Agro Valley, NC 28715</span>
                  </div>
               </div>
            </div>

            <div class="footer-note">
               <i class="fas fa-check-circle text-success me-2"></i> By using Harvest Hub you acknowledge that you have
               read and accept these Terms of Service.
            </div>

         </div>
      </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <?php include "footer.php"; ?>

</body>

</html>