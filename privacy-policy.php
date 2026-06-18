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
   <title>Privacy Policy | Harvest Hub</title>

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

      .policy-container {
         max-width: 1000px;
         width: 100%;
         background: white;
         border-radius: 20px;
         box-shadow: var(--shadow);
         overflow: hidden;
         border: 1px solid rgba(0, 0, 0, 0.05);
      }

      /* Header Area */
      .policy-header {
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

      .policy-header h1 {
         font-weight: 800;
         margin-bottom: 10px;
         font-size: 3rem;
      }

      .policy-header h1 small {
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
      .policy-body {
         padding: 50px;
      }

      .policy-chapter {
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

      .stat-highlight {
         background: #f1f8e9;
         border-radius: 15px;
         padding: 25px;
         margin: 25px 0;
         border-left: 5px solid var(--primary);
         font-size: 1.1rem;
      }

      /* Grids */
      .data-grid {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
         gap: 20px;
         margin: 30px 0;
      }

      .data-card {
         background: white;
         border-radius: 15px;
         padding: 25px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
         border: 1px solid #eee;
         transition: 0.3s;
      }

      .data-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }

      .data-card i {
         font-size: 2rem;
         color: var(--primary);
         background: #e8f5e9;
         padding: 15px;
         border-radius: 12px;
         margin-bottom: 15px;
      }

      .data-card h4 {
         font-weight: 700;
         color: var(--dark);
         margin-bottom: 10px;
      }

      .data-card p {
         color: #666;
         font-size: 0.95rem;
         margin: 0;
      }

      .sub-article {
         font-weight: 700;
         font-size: 1.3rem;
         color: var(--primary);
         margin: 30px 0 15px 0;
         padding-left: 15px;
         border-left: 5px solid var(--accent);
      }

      .bullet-list-fancy {
         list-style: none;
         padding-left: 0;
      }

      .bullet-list-fancy li {
         margin-bottom: 12px;
         padding-left: 30px;
         position: relative;
         color: #555;
      }

      .bullet-list-fancy li::before {
         content: "\f058";
         /* FontAwesome check-circle */
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         position: absolute;
         left: 0;
         top: 2px;
         color: var(--primary);
         font-size: 1.1rem;
      }

      /* Cookie Grid */
      .cookie-grid {
         display: flex;
         flex-wrap: wrap;
         gap: 15px;
         margin: 20px 0;
      }

      .cookie-item {
         background: white;
         border-radius: 50px;
         padding: 8px 20px;
         border: 1px solid #ddd;
         display: inline-flex;
         align-items: center;
         gap: 10px;
         font-weight: 600;
         box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
         color: #444;
      }

      .cookie-item i {
         color: var(--primary);
         font-size: 1.1rem;
      }

      /* Rights Panel */
      .rights-panel {
         background: #fffdf5;
         border-radius: 20px;
         padding: 30px;
         border: 1px solid #ffe082;
         margin-top: 30px;
      }

      .right-icon {
         background: #ffecb3;
         width: 45px;
         height: 45px;
         border-radius: 50%;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         color: #f57f17;
         font-size: 1.2rem;
         margin-right: 15px;
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

      .badge-new {
         background: var(--accent);
         color: #000;
         padding: 4px 12px;
         border-radius: 50px;
         font-weight: 700;
         font-size: 0.8rem;
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
         .policy-body {
            padding: 30px 20px;
         }

         .policy-header {
            padding: 40px 20px;
         }

         .policy-header h1 {
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
      <div class="policy-container">

         <div class="policy-header">
            <div class="header-icon-group">
               <i class="fas fa-shield-alt"></i>
               <i class="fas fa-seedling"></i>
               <i class="fas fa-tree"></i>
            </div>
            <h1>The Harvest Promise <small>Privacy & Data Pledge</small></h1>
            <div class="meta-grid">
               <span class="badge-pill"><i class="fas fa-calendar-check"></i> Effective: 01 June 2025</span>
               <span class="badge-pill"><i class="fas fa-sync-alt"></i> Revised: 2 Weeks Ago</span>
               <span class="badge-pill"><i class="fas fa-users"></i> 15K+ Trusted Members</span>
               <span class="badge-pill"><i class="fas fa-award"></i> Fair Trade Certified</span>
            </div>
         </div>

         <div class="policy-body">

            <div class="policy-chapter" id="intro">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-handshake"></i></div>
                  <h2>Our Common Ground <span>Why We’re Here</span></h2>
               </div>
               <p><strong>Harvest Hub</strong> is a grower‑first digital marketplace. We empower local farmers and
                  conscious eaters to trade directly through an open bidding system — fair prices, no middlemen. This
                  policy explains the <strong>what, why and how</strong> of your data. We treat your information like
                  heirloom seeds: with respect, transparency, and care for the future.</p>
               <div class="stat-highlight">
                  <i class="fas fa-chart-line me-2" style="color:var(--primary);"></i> <strong>430+</strong> farms
                  active · <strong>12K</strong> consumers · <strong>98%</strong> satisfaction on data clarity
               </div>
            </div>

            <div class="policy-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-database"></i></div>
                  <h2>What We Gather <span>Detailed Breakdown</span></h2>
               </div>
               <p>We collect only the fields necessary to sow trust and efficiency.</p>
               <div class="data-grid">
                  <div class="data-card">
                     <i class="fas fa-id-card"></i>
                     <h4>Identity</h4>
                     <p>Full name, email, phone, encrypted password. Farmer? We also ask for farm name & tax info (for
                        payments).</p>
                  </div>
                  <div class="data-card">
                     <i class="fas fa-map-marker-alt"></i>
                     <h4>Location</h4>
                     <p>Region / address for local listings & delivery radius. Never shared publicly without consent.
                     </p>
                  </div>
                  <div class="data-card">
                     <i class="fas fa-shopping-basket"></i>
                     <h4>Farm Products</h4>
                     <p>Listings: photos, descriptions, starting bids. Consumer bid history & winning bids.</p>
                  </div>
                  <div class="data-card">
                     <i class="fas fa-credit-card"></i>
                     <h4>Payment</h4>
                     <p>Stripe / PayPal tokens (we never store raw card numbers). Transaction records for
                        reconciliation.</p>
                  </div>
               </div>

               <div class="sub-article"><i class="fas fa-laptop-code me-2"></i> 2.1 Technical & Cookies</div>
               <ul class="bullet-list-fancy">
                  <li>IP address, browser fingerprint (anonymized after 30 days), device type — to fend off bots.</li>
                  <li>Session cookies, preference cookies, and a <strong>“remember me”</strong> cookie (opt-out
                     possible).</li>
               </ul>
            </div>

            <div class="policy-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-cogs"></i></div>
                  <h2>How We Use Your Data <span>6 Core Purposes</span></h2>
               </div>
               <div class="row g-4 mt-2">
                  <div class="col-md-6 d-flex align-items-start gap-3">
                     <i class="fas fa-check-circle fs-4 text-success"></i>
                     <div><strong>Service Operation</strong><br><small class="text-muted">Accounts, bidding engine,
                           outbid notifications.</small></div>
                  </div>
                  <div class="col-md-6 d-flex align-items-start gap-3">
                     <i class="fas fa-check-circle fs-4 text-success"></i>
                     <div><strong>Transaction Support</strong><br><small class="text-muted">Confirm orders, invoices,
                           farmer payouts.</small></div>
                  </div>
                  <div class="col-md-6 d-flex align-items-start gap-3">
                     <i class="fas fa-check-circle fs-4 text-success"></i>
                     <div><strong>Safety & Moderation</strong><br><small class="text-muted">Detect suspicious bidding or
                           fake listings.</small></div>
                  </div>
                  <div class="col-md-6 d-flex align-items-start gap-3">
                     <i class="fas fa-check-circle fs-4 text-success"></i>
                     <div><strong>Customer Care</strong><br><small class="text-muted">Respond to your requests within 2h
                           (average).</small></div>
                  </div>
                  <div class="col-md-6 d-flex align-items-start gap-3">
                     <i class="fas fa-check-circle fs-4 text-success"></i>
                     <div><strong>Platform Improvement</strong><br><small class="text-muted">A/B test features,
                           anonymized analytics.</small></div>
                  </div>
                  <div class="col-md-6 d-flex align-items-start gap-3">
                     <i class="fas fa-check-circle fs-4 text-success"></i>
                     <div><strong>Legal Compliance</strong><br><small class="text-muted">Tax reporting, dispute
                           resolution.</small></div>
                  </div>
               </div>
            </div>

            <div class="policy-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-lock"></i></div>
                  <h2>Storage + Retention <span>Your Safety, Our Duty</span></h2>
               </div>
               <p>All passwords are hashed (bcrypt). Data at rest encrypted (AES-256). We keep account data as long as
                  you’re active; after 2 years of inactivity, we anonymize personal fields. Transaction records kept for
                  7 years (tax obligations).</p>
               <div class="stat-highlight">
                  <i class="fas fa-user-secret me-2"></i> Regular third‑party security audits (latest: May 2025) · ISO
                  27001 aligned.
               </div>
            </div>

            <div class="policy-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-cookie-bite"></i></div>
                  <h2>Cookie Garden <span>What’s Planted</span></h2>
               </div>
               <div class="cookie-grid">
                  <span class="cookie-item"><i class="fas fa-history"></i> session_csrf · 24h</span>
                  <span class="cookie-item"><i class="fas fa-star"></i> user_pref · 1 year</span>
                  <span class="cookie-item"><i class="fas fa-shopping-cart"></i> bid_session · 2h</span>
                  <span class="cookie-item"><i class="fas fa-chart-pie"></i> analytics_id (opt‑out via settings)</span>
                  <span class="cookie-item"><i class="fas fa-shield-alt"></i> auth_token · httpOnly</span>
               </div>
               <p class="mt-3 text-muted">You can manage consent via our <a href="#"
                     style="color:var(--primary); font-weight: 600;">cookie preference center</a> (GDPR & CCPA
                  compliant).</p>
            </div>

            <div class="policy-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-user-shield"></i></div>
                  <h2>Your Rights & Choices</h2>
               </div>
               <div class="rights-panel">
                  <div class="row g-4">
                     <div class="col-md-6 d-flex align-items-center">
                        <span class="right-icon"><i class="fas fa-edit"></i></span>
                        <span><strong>Edit Profile</strong> anytime from dashboard</span>
                     </div>
                     <div class="col-md-6 d-flex align-items-center">
                        <span class="right-icon"><i class="fas fa-download"></i></span>
                        <span><strong>Export Data</strong> (CSV) via settings</span>
                     </div>
                     <div class="col-md-6 d-flex align-items-center">
                        <span class="right-icon"><i class="fas fa-trash-alt"></i></span>
                        <span><strong>Delete Account</strong> – self‑serve or request</span>
                     </div>
                     <div class="col-md-6 d-flex align-items-center">
                        <span class="right-icon"><i class="fas fa-ban"></i></span>
                        <span><strong>Opt‑out of Marketing</strong> with one click</span>
                     </div>
                  </div>
                  <p class="mt-4 mb-0 fw-bold text-dark"><i class="fas fa-envelope text-warning me-2"></i> For deletion,
                     email privacy@harvesthub.com — we comply within 15 days.</p>
               </div>
            </div>

            <div class="policy-chapter">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-exclamation-circle"></i></div>
                  <h2>Special Notes <span>Minors & Transfers</span></h2>
               </div>
               <p>Harvest Hub is not intended for users under 16. We do not knowingly collect data from children. In
                  case of merger or acquisition, your data would remain under similar privacy commitments – we’ll notify
                  you 30 days before.</p>
            </div>

            <div class="policy-chapter mb-0">
               <div class="chapter-head">
                  <div class="chapter-icon"><i class="fas fa-envelope-open-text"></i></div>
                  <h2>Talk to the Keepers</h2>
               </div>
               <p>Our data stewards are real humans, usually replying within 2 hours (9am–8pm farm time).</p>

               <div class="contact-estate">
                  <div class="contact-row">
                     <i class="fas fa-at"></i>
                     <span><a href="mailto:dirctplace@harvesthub.com">dirctplace@harvesthub.com</a> <span
                           class="badge-new">Direct Privacy Line</span></span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-phone-alt"></i>
                     <span><a href="tel:+18004785264">+1 (800) 478-5264</a> <span class="text-muted ms-1">(Support &
                           privacy requests)</span></span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-comments"></i>
                     <span>Live chat at <strong>harvesthub.com/help</strong> <span class="text-muted ms-1">(8am–10pm
                           ET)</span></span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-building"></i>
                     <span class="text-muted">Post: 14 Orchard Lane, Agro Valley, NC 28715</span>
                  </div>
                  <div class="contact-row">
                     <i class="fas fa-globe"></i>
                     <span><a href="#">www.harvesthub.com/privacy</a> <span class="text-muted ms-1">(This page always
                           updated)</span></span>
                  </div>
               </div>
            </div>

            <div class="footer-note">
               <i class="fas fa-cloud-sun me-2" style="color:var(--accent);"></i> Version 3.1.0 · Last language review:
               25 May 2025 · Printed copies available on request
            </div>

         </div>
      </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <?php include "footer.php"; ?>

</body>

</html>