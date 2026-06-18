<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Government Agricultural Subsidies | Harvest Hub</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <style>
      :root {
         --primary-dark: #0d3311;
         --primary-light: #1b5e20;
         --accent-gold: #fbbf24;
         --text-main: #334155;
         --bg-light: #f8fafc;
         --card-bg: #ffffff;
         --success-green: #22c55e;
         --info-blue: #3b82f6;
         --warning-orange: #f97316;
         --danger-red: #ef4444;
         --purple: #8b5cf6;
      }

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      body {
         font-family: 'Poppins', sans-serif;
         background-color: var(--bg-light);
         color: var(--text-main);
         line-height: 1.5;
      }

      /* Hero Section */
      .page-header {
         background: linear-gradient(135deg, var(--primary-dark) 0%, #0f3f16 100%);
         color: #fff;
         padding: 100px 20px 100px;
         text-align: center;
         position: relative;
         overflow: hidden;
      }

      .page-header::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path fill="%23fbbf24" d="M50 15 L61 40 L88 44 L67 60 L72 88 L50 73 L28 88 L33 60 L12 44 L39 40 Z"/></svg>');
         background-size: 60px 60px;
         background-repeat: repeat;
         opacity: 0.1;
         z-index: 1;
      }

      .page-header h1 {
         font-size: 2.5rem;
         font-weight: 700;
         margin-bottom: 20px;
         position: relative;
         z-index: 2;
         text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      }

      .page-header p {
         font-size: 1.1rem;
         color: #e0f2e0;
         max-width: 700px;
         margin: 0 auto;
         position: relative;
         z-index: 2;
         line-height: 1.6;
      }

      .header-glow {
         position: absolute;
         top: -50px;
         left: 50%;
         transform: translateX(-50%);
         width: 300px;
         height: 300px;
         background: var(--accent-gold);
         filter: blur(120px);
         opacity: 0.15;
         border-radius: 50%;
         z-index: 1;
      }

      /* Quick Stats */
      .stats-container {
         max-width: 1200px;
         margin: -40px auto 30px;
         padding: 0 20px;
         position: relative;
         z-index: 20;
         display: grid;
         grid-template-columns: repeat(4, 1fr);
         gap: 20px;
      }

      .stat-card {
         background: var(--card-bg);
         border-radius: 16px;
         padding: 25px 20px;
         text-align: center;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
         border: 1px solid rgba(255, 255, 255, 0.2);
         backdrop-filter: blur(10px);
         transition: transform 0.3s;
      }

      .stat-card:hover {
         transform: translateY(-5px);
      }

      .stat-icon {
         font-size: 2rem;
         color: var(--accent-gold);
         margin-bottom: 10px;
      }

      .stat-number {
         font-size: 2rem;
         font-weight: 700;
         color: var(--primary-dark);
         line-height: 1.2;
      }

      .stat-label {
         font-size: 0.9rem;
         color: #64748b;
         font-weight: 500;
      }

      /* Main Container */
      .container {
         max-width: 1200px;
         margin: 40px auto 50px;
         padding: 0 20px;
      }

      /* Status Check Banner */
      .status-banner {
         background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
         border-radius: 24px;
         padding: 35px 40px;
         box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
         margin-bottom: 40px;
         display: flex;
         align-items: center;
         justify-content: space-between;
         flex-wrap: wrap;
         gap: 30px;
         border: 1px solid #e2e8f0;
         position: relative;
         overflow: hidden;
      }

      .status-banner::before {
         content: '';
         position: absolute;
         top: -50px;
         right: -50px;
         width: 200px;
         height: 200px;
         background: var(--accent-gold);
         opacity: 0.03;
         border-radius: 50%;
      }

      .status-info {
         flex: 2;
         min-width: 280px;
      }

      .status-info h3 {
         margin: 0 0 8px 0;
         color: var(--primary-dark);
         font-size: 1.5rem;
         font-weight: 600;
         display: flex;
         align-items: center;
         gap: 10px;
      }

      .status-info h3 i {
         color: var(--accent-gold);
      }

      .status-info p {
         margin: 0;
         color: #64748b;
         font-size: 0.95rem;
      }

      .status-form {
         flex: 3;
         display: flex;
         gap: 12px;
         min-width: 350px;
      }

      .input-group {
         flex: 1;
         position: relative;
      }

      .input-group i {
         position: absolute;
         left: 15px;
         top: 50%;
         transform: translateY(-50%);
         color: #94a3b8;
      }

      .status-form input {
         width: 100%;
         padding: 14px 15px 14px 45px;
         border: 1px solid #e2e8f0;
         border-radius: 12px;
         outline: none;
         transition: all 0.3s;
         font-size: 0.95rem;
      }

      .status-form input:focus {
         border-color: var(--accent-gold);
         box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
      }

      .status-form button {
         background: var(--primary-dark);
         color: #fff;
         border: none;
         padding: 0 30px;
         border-radius: 12px;
         font-weight: 600;
         cursor: pointer;
         transition: all 0.3s;
         display: flex;
         align-items: center;
         gap: 8px;
         white-space: nowrap;
      }

      .status-form button:hover {
         background: var(--accent-gold);
         color: var(--primary-dark);
         transform: scale(1.02);
      }

      /* Status Result Modal */
      .status-result {
         display: none;
         margin-top: 20px;
         padding: 20px;
         border-radius: 12px;
         animation: slideDown 0.3s ease;
      }

      @keyframes slideDown {
         from {
            opacity: 0;
            transform: translateY(-10px);
         }

         to {
            opacity: 1;
            transform: translateY(0);
         }
      }

      .status-approved {
         background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
         border-left: 4px solid var(--success-green);
      }

      .status-pending {
         background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
         border-left: 4px solid var(--warning-orange);
      }

      .status-rejected {
         background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
         border-left: 4px solid var(--danger-red);
      }

      /* Filters */
      .filters-section {
         background: #fff;
         border-radius: 20px;
         padding: 25px;
         margin-bottom: 30px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
         border: 1px solid #e2e8f0;
      }

      .filters-title {
         font-size: 1rem;
         color: #64748b;
         margin-bottom: 15px;
         display: flex;
         align-items: center;
         gap: 8px;
      }

      .filters-title i {
         color: var(--accent-gold);
      }

      .controls-bar {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
         gap: 15px;
      }

      .filter-select {
         padding: 14px 20px;
         border: 1px solid #e2e8f0;
         border-radius: 12px;
         font-family: inherit;
         outline: none;
         background: #fff;
         cursor: pointer;
         color: var(--text-main);
         transition: all 0.3s;
         appearance: none;
         background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
         background-repeat: no-repeat;
         background-position: right 15px center;
      }

      .filter-select:hover {
         border-color: var(--accent-gold);
      }

      .filter-select:focus {
         border-color: var(--accent-gold);
         box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
      }

      /* Active Filters */
      .active-filters {
         display: flex;
         flex-wrap: wrap;
         gap: 10px;
         margin-top: 15px;
         padding-top: 15px;
         border-top: 1px solid #e2e8f0;
      }

      .filter-tag {
         background: #f1f5f9;
         padding: 6px 15px;
         border-radius: 50px;
         font-size: 0.85rem;
         display: flex;
         align-items: center;
         gap: 8px;
         cursor: pointer;
         transition: all 0.3s;
      }

      .filter-tag:hover {
         background: #fee2e2;
      }

      .filter-tag i {
         color: #ef4444;
         font-size: 0.75rem;
      }

      .clear-all {
         color: var(--primary-dark);
         font-size: 0.85rem;
         cursor: pointer;
         text-decoration: underline;
         padding: 6px 10px;
      }

      /* Results Count */
      .results-count {
         margin-bottom: 20px;
         font-size: 0.95rem;
         color: #64748b;
         display: flex;
         align-items: center;
         gap: 8px;
      }

      .results-count span {
         font-weight: 600;
         color: var(--primary-dark);
      }

      /* Scheme Cards Grid */
      .scheme-grid {
         display: grid;
         grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
         gap: 25px;
         margin-bottom: 40px;
      }

      .scheme-card {
         background: var(--card-bg);
         border-radius: 20px;
         padding: 30px;
         box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
         border: 1px solid #e2e8f0;
         transition: all 0.3s;
         display: flex;
         flex-direction: column;
         position: relative;
         overflow: hidden;
      }

      .scheme-card::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         height: 4px;
         background: linear-gradient(90deg, var(--accent-gold), var(--primary-light));
         opacity: 0;
         transition: opacity 0.3s;
      }

      .scheme-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
         border-color: transparent;
      }

      .scheme-card:hover::before {
         opacity: 1;
      }

      /* Card Tags */
      .tag-container {
         display: flex;
         flex-wrap: wrap;
         gap: 8px;
         margin-bottom: 20px;
      }

      .tag {
         padding: 4px 12px;
         border-radius: 50px;
         font-size: 0.7rem;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 0.3px;
      }

      .tag-central {
         background: rgba(59, 130, 246, 0.1);
         color: #2563eb;
         border: 1px solid rgba(59, 130, 246, 0.2);
      }

      .tag-state {
         background: rgba(139, 92, 246, 0.1);
         color: #7c3aed;
         border: 1px solid rgba(139, 92, 246, 0.2);
      }

      .tag-financial {
         background: rgba(34, 197, 94, 0.1);
         color: #16a34a;
         border: 1px solid rgba(34, 197, 94, 0.2);
      }

      .tag-machinery {
         background: rgba(245, 158, 11, 0.1);
         color: #d97706;
         border: 1px solid rgba(245, 158, 11, 0.2);
      }

      .tag-seeds {
         background: rgba(236, 72, 153, 0.1);
         color: #db2777;
         border: 1px solid rgba(236, 72, 153, 0.2);
      }

      .tag-insurance {
         background: rgba(239, 68, 68, 0.1);
         color: #dc2626;
         border: 1px solid rgba(239, 68, 68, 0.2);
      }

      /* Card Content */
      .scheme-title {
         font-size: 1.3rem;
         font-weight: 700;
         color: var(--primary-dark);
         margin: 0 0 12px 0;
         line-height: 1.4;
      }

      .scheme-desc {
         font-size: 0.9rem;
         color: #64748b;
         margin-bottom: 20px;
         line-height: 1.6;
      }

      .details-list {
         list-style: none;
         padding: 0;
         margin: 0 0 25px 0;
         flex: 1;
      }

      .details-list li {
         margin-bottom: 15px;
         font-size: 0.9rem;
         color: #475569;
         display: flex;
         align-items: flex-start;
         gap: 12px;
      }

      .details-list i {
         color: var(--success-green);
         margin-top: 3px;
         font-size: 1rem;
         min-width: 18px;
      }

      .details-list strong {
         color: var(--primary-dark);
         font-weight: 600;
      }

      /* Card Footer */
      .card-footer {
         display: flex;
         align-items: center;
         justify-content: space-between;
         border-top: 1px solid #f1f5f9;
         padding-top: 20px;
         margin-top: auto;
      }

      .deadline {
         font-size: 0.85rem;
         font-weight: 600;
         display: flex;
         align-items: center;
         gap: 6px;
      }

      .deadline-urgent {
         color: var(--danger-red);
      }

      .deadline-soon {
         color: var(--warning-orange);
      }

      .deadline-normal {
         color: var(--success-green);
      }

      .btn-apply {
         background: var(--primary-dark);
         color: #fff;
         border: none;
         padding: 10px 20px;
         border-radius: 10px;
         font-weight: 600;
         text-decoration: none;
         transition: all 0.3s;
         font-size: 0.9rem;
         display: inline-flex;
         align-items: center;
         gap: 8px;
      }

      .scheme-card:hover .btn-apply {
         background: var(--accent-gold);
         color: var(--primary-dark);
      }

      /* No Results */
      .no-results {
         text-align: center;
         padding: 60px 20px;
         background: #fff;
         border-radius: 20px;
         border: 1px solid #e2e8f0;
      }

      .no-results i {
         font-size: 3rem;
         color: #cbd5e1;
         margin-bottom: 20px;
      }

      .no-results h3 {
         color: var(--primary-dark);
         margin-bottom: 10px;
      }

      .no-results p {
         color: #64748b;
      }

      /* Responsive */
      @media (max-width: 768px) {
         .page-header h1 {
            font-size: 2rem;
         }

         .stats-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
         }

         .status-banner {
            padding: 25px;
         }

         .status-form {
            flex-direction: column;
            min-width: 100%;
         }

         .status-form button {
            padding: 14px;
            justify-content: center;
         }

         .scheme-grid {
            grid-template-columns: 1fr;
         }
      }

      @media (max-width: 480px) {
         .stats-container {
            grid-template-columns: 1fr;
         }
      }
   </style>
</head>

<body>

   <section class="page-header">
      <div class="header-glow"></div>
      <h1>Government Schemes & Subsidies</h1>
      <p>Discover financial aid, equipment grants, crop insurance, and seed subsidies provided by Central and State
         Governments to support your farming journey.</p>
   </section>

   <!-- Quick Stats -->
   <div class="stats-container">
      <div class="stat-card">
         <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
         <div class="stat-number">₹15,000+</div>
         <div class="stat-label">Max Subsidy</div>
      </div>
      <div class="stat-card">
         <div class="stat-icon"><i class="fas fa-tractor"></i></div>
         <div class="stat-number">24</div>
         <div class="stat-label">Equipment Schemes</div>
      </div>
      <div class="stat-card">
         <div class="stat-icon"><i class="fas fa-seedling"></i></div>
         <div class="stat-number">18</div>
         <div class="stat-label">Seed Subsidies</div>
      </div>
      <div class="stat-card">
         <div class="stat-icon"><i class="fas fa-users"></i></div>
         <div class="stat-number">2.5L+</div>
         <div class="stat-label">Farmers Benefited</div>
      </div>
   </div>

   <div class="container">

      <!-- Application Status Checker -->
      <div class="status-banner">
         <div class="status-info">
            <h3><i class="fas fa-search"></i> Track Your Application</h3>
            <p>Already applied for a scheme? Enter your Aadhaar number or Application ID to check real-time status.</p>
         </div>
         <div class="status-form">
            <div class="input-group">
               <i class="fas fa-id-card"></i>
               <input type="text" id="applicationId" placeholder="Enter Aadhaar or Application ID">
            </div>
            <button type="button" id="checkStatusBtn">
               <i class="fas fa-arrow-right"></i> Check Status
            </button>
         </div>
         <div id="statusResult" class="status-result"></div>
      </div>

      <!-- Filters Section -->
      <div class="filters-section">
         <div class="filters-title">
            <i class="fas fa-sliders-h"></i>
            <span>Filter Schemes</span>
         </div>

         <div class="controls-bar">
            <select class="filter-select" id="stateFilter">
               <option value="all">All States</option>
               <option value="gujarat">Gujarat</option>
               <option value="punjab">Punjab</option>
               <option value="haryana">Haryana</option>
               <option value="maharashtra">Maharashtra</option>
               <option value="up">Uttar Pradesh</option>
               <option value="mp">Madhya Pradesh</option>
               <option value="rajasthan">Rajasthan</option>
               <option value="bihar">Bihar</option>
            </select>

            <select class="filter-select" id="typeFilter">
               <option value="all">All Scheme Types</option>
               <option value="financial">Financial Assistance</option>
               <option value="machinery">Machinery & Equipment</option>
               <option value="seeds">Seeds & Fertilizers</option>
               <option value="insurance">Crop Insurance</option>
            </select>

            <select class="filter-select" id="authorityFilter">
               <option value="all">All Authorities</option>
               <option value="central">Central Government</option>
               <option value="state">State Government</option>
            </select>
         </div>

         <!-- Active Filters Display -->
         <div class="active-filters" id="activeFilters"></div>
      </div>

      <!-- Results Count -->
      <div class="results-count" id="resultsCount">
         <i class="fas fa-list"></i>
         Showing <span id="showingCount">15</span> schemes
      </div>

      <!-- Schemes Grid -->
      <div class="scheme-grid" id="schemeGrid">
         <!-- Schemes will be populated by JavaScript -->
      </div>

   </div>

   <?php include 'footer.php'; ?>

   <script>
      // Scheme Data
      const schemes = [
         {
            id: 1,
            name: 'PM-KUSUM Yojana',
            description: 'Provides massive subsidies to farmers for installing standalone solar agriculture pumps to reduce dependence on the grid.',
            tags: ['central', 'machinery'],
            state: 'all',
            type: 'machinery',
            authority: 'central',
            benefits: 'Up to 60% subsidy on solar pump cost (max ₹45,000)',
            eligibility: 'Individual farmers, FPOs, and Cooperatives with land ownership',
            deadline: '2024-06-30',
            deadlineStatus: 'urgent',
            link: 'https://pmkusum.mnre.gov.in',
            icon: 'fa-solar-panel'
         },
         {
            id: 2,
            name: 'PM-KISAN Samman Nidhi',
            description: 'Direct income support for farmers to aid in procuring inputs to ensure crop health and appropriate yields.',
            tags: ['central', 'financial'],
            state: 'all',
            type: 'financial',
            authority: 'central',
            benefits: '₹6,000 per year in three equal installments',
            eligibility: 'All landholding farmer families (subject to exclusions)',
            deadline: '2024-12-31',
            deadlineStatus: 'normal',
            link: 'https://pmkisan.gov.in',
            icon: 'fa-hand-holding-heart'
         },
         {
            id: 3,
            name: 'PMFBY - Crop Insurance',
            description: 'Comprehensive crop insurance scheme to protect farmers against unexpected loss due to natural calamities, pests, and diseases.',
            tags: ['central', 'insurance'],
            state: 'all',
            type: 'insurance',
            authority: 'central',
            benefits: 'Extremely low premium rates (1.5% - 2%) for maximum coverage',
            eligibility: 'Both loanee and non-loanee farmers growing notified crops',
            deadline: '2024-05-15',
            deadlineStatus: 'soon',
            link: 'https://pmfby.gov.in',
            icon: 'fa-shield-alt'
         },
         {
            id: 4,
            name: 'SMAM - Tractor Subsidy',
            description: 'Financial assistance to farmers for purchase of tractors and power tillers to promote farm mechanization.',
            tags: ['central', 'machinery'],
            state: 'all',
            type: 'machinery',
            authority: 'central',
            benefits: 'Up to ₹60,000 or 25% of tractor cost (whichever is less)',
            eligibility: 'Small & marginal farmers with landholding up to 2 hectares',
            deadline: '2024-08-20',
            deadlineStatus: 'normal',
            link: 'https://agrimachinery.nic.in',
            icon: 'fa-tractor'
         },
         {
            id: 5,
            name: 'Gujarat - AGR-2 Tractor Subsidy',
            description: 'Special scheme for Gujarat farmers for purchase of tractors and heavy power tillers.',
            tags: ['state', 'machinery'],
            state: 'gujarat',
            type: 'machinery',
            authority: 'state',
            benefits: 'Up to ₹60,000 or 25% subsidy on tractor cost',
            eligibility: 'Must hold land records (8-A) in Gujarat state',
            deadline: '2024-04-10',
            deadlineStatus: 'urgent',
            link: 'https://ikhedut.gujarat.gov.in',
            icon: 'fa-tractor'
         },
         {
            id: 6,
            name: 'Gujarat - Micro Irrigation Fund',
            description: 'Subsidy for installation of drip and sprinkler irrigation systems to promote water conservation.',
            tags: ['state', 'financial'],
            state: 'gujarat',
            type: 'financial',
            authority: 'state',
            benefits: '50% subsidy up to ₹40,000 per hectare',
            eligibility: 'Farmers with assured water source',
            deadline: '2024-07-30',
            deadlineStatus: 'normal',
            link: 'https://ikhedut.gujarat.gov.in',
            icon: 'fa-water'
         },
         {
            id: 7,
            name: 'Punjab - Crop Diversification',
            description: 'Financial support for farmers shifting from water-guzzling crops to alternative crops.',
            tags: ['state', 'financial'],
            state: 'punjab',
            type: 'financial',
            authority: 'state',
            benefits: '₹12,000 per acre for diversification',
            eligibility: 'Farmers in identified blocks',
            deadline: '2024-05-25',
            deadlineStatus: 'soon',
            link: 'https://agripunjab.gov.in',
            icon: 'fa-seedling'
         },
         {
            id: 8,
            name: 'Haryana - Soil Health Card',
            description: 'Subsidy on soil testing and micronutrient application based on soil health recommendations.',
            tags: ['state', 'seeds'],
            state: 'haryana',
            type: 'seeds',
            authority: 'state',
            benefits: '50% subsidy on micronutrients up to ₹5,000',
            eligibility: 'All farmers with Soil Health Card',
            deadline: '2024-09-15',
            deadlineStatus: 'normal',
            link: 'https://agriharyana.gov.in',
            icon: 'fa-leaf'
         },
         {
            id: 9,
            name: 'Maharashtra - Organic Farming',
            description: 'Promotion of organic farming through financial assistance and certification support.',
            tags: ['state', 'seeds'],
            state: 'maharashtra',
            type: 'seeds',
            authority: 'state',
            benefits: '₹15,000 per hectare for organic inputs',
            eligibility: 'Farmers willing to convert to organic farming',
            deadline: '2024-06-05',
            deadlineStatus: 'soon',
            link: 'https://mahagov.in',
            icon: 'fa-seedling'
         },
         {
            id: 10,
            name: 'RKVY - Farm Pond Scheme',
            description: 'Assistance for construction of farm ponds for rainwater harvesting and storage.',
            tags: ['central', 'financial'],
            state: 'all',
            type: 'financial',
            authority: 'central',
            benefits: '75% subsidy up to ₹50,000 for pond construction',
            eligibility: 'Small and marginal farmers',
            deadline: '2024-10-20',
            deadlineStatus: 'normal',
            link: 'https://rkvy.nic.in',
            icon: 'fa-water'
         },
         {
            id: 11,
            name: 'NABARD - Warehouse Subsidy',
            description: 'Subsidy for construction of scientific storage godowns and warehouses at farm level.',
            tags: ['central', 'machinery'],
            state: 'all',
            type: 'machinery',
            authority: 'central',
            benefits: '33% subsidy up to ₹3 lakh for warehouse construction',
            eligibility: 'Individual farmers, FPOs, and farmer groups',
            deadline: '2024-11-30',
            deadlineStatus: 'normal',
            link: 'https://nabard.org',
            icon: 'fa-warehouse'
         },
         {
            id: 12,
            name: 'Gujarat - Bee Keeping Subsidy',
            description: 'Financial assistance for apiculture (honey bee keeping) equipment and training.',
            tags: ['state', 'machinery'],
            state: 'gujarat',
            type: 'machinery',
            authority: 'state',
            benefits: '50% subsidy up to ₹15,000 for bee boxes',
            eligibility: 'Farmers interested in apiculture',
            deadline: '2024-04-25',
            deadlineStatus: 'urgent',
            link: 'https://ikhedut.gujarat.gov.in',
            icon: 'fa-bug'
         },
         {
            id: 13,
            name: 'MIDH - Horticulture Mission',
            description: 'Comprehensive support for cultivation of fruits, vegetables, and spices.',
            tags: ['central', 'seeds'],
            state: 'all',
            type: 'seeds',
            authority: 'central',
            benefits: '50% subsidy on planting material and inputs',
            eligibility: 'Farmers growing horticultural crops',
            deadline: '2024-08-10',
            deadlineStatus: 'normal',
            link: 'https://midh.gov.in',
            icon: 'fa-apple-alt'
         },
         {
            id: 14,
            name: 'Pradhan Mantri Fasal Bima Yojana',
            description: 'Comprehensive crop insurance scheme with very low premium rates.',
            tags: ['central', 'insurance'],
            state: 'all',
            type: 'insurance',
            authority: 'central',
            benefits: 'Premium 1.5% for Kharif, 2% for Rabi, 5% for commercial crops',
            eligibility: 'All farmers including sharecroppers',
            deadline: '2024-03-31',
            deadlineStatus: 'urgent',
            link: 'https://pmfby.gov.in',
            icon: 'fa-umbrella'
         },
         {
            id: 15,
            name: 'KCC - Kisan Credit Card',
            description: 'Easy access to credit for farmers with subsidized interest rates.',
            tags: ['central', 'financial'],
            state: 'all',
            type: 'financial',
            authority: 'central',
            benefits: '₹3 lakh collateral-free loan, 4% interest subvention',
            eligibility: 'All farmers with land records',
            deadline: '2024-12-31',
            deadlineStatus: 'normal',
            link: 'https://kcc.gov.in',
            icon: 'fa-credit-card'
         }
      ];

      // DOM Elements
      const schemeGrid = document.getElementById('schemeGrid');
      const stateFilter = document.getElementById('stateFilter');
      const typeFilter = document.getElementById('typeFilter');
      const authorityFilter = document.getElementById('authorityFilter');
      const activeFilters = document.getElementById('activeFilters');
      const showingCount = document.getElementById('showingCount');
      const checkStatusBtn = document.getElementById('checkStatusBtn');
      const applicationId = document.getElementById('applicationId');
      const statusResult = document.getElementById('statusResult');

      // Current filters
      let currentFilters = {
         state: 'all',
         type: 'all',
         authority: 'all'
      };

      // Initialize page
      document.addEventListener('DOMContentLoaded', () => {
         renderSchemes();
         updateActiveFilters();

         // Add event listeners to filters
         stateFilter.addEventListener('change', updateFilters);
         typeFilter.addEventListener('change', updateFilters);
         authorityFilter.addEventListener('change', updateFilters);
      });

      // Update filters
      function updateFilters() {
         currentFilters.state = stateFilter.value;
         currentFilters.type = typeFilter.value;
         currentFilters.authority = authorityFilter.value;

         renderSchemes();
         updateActiveFilters();
      }

      // Render schemes based on filters
      function renderSchemes() {
         const filteredSchemes = schemes.filter(scheme => {
            // State filter
            if (currentFilters.state !== 'all' && scheme.state !== currentFilters.state && scheme.state !== 'all') {
               return false;
            }

            // Type filter
            if (currentFilters.type !== 'all' && scheme.type !== currentFilters.type) {
               return false;
            }

            // Authority filter
            if (currentFilters.authority !== 'all' && scheme.authority !== currentFilters.authority) {
               return false;
            }

            return true;
         });

         // Update count
         showingCount.textContent = filteredSchemes.length;

         if (filteredSchemes.length === 0) {
            schemeGrid.innerHTML = `
               <div class="no-results">
                  <i class="fas fa-search"></i>
                  <h3>No Schemes Found</h3>
                  <p>Try adjusting your filters to see more schemes</p>
               </div>
            `;
            return;
         }

         // Generate HTML
         let html = '';
         filteredSchemes.forEach(scheme => {
            const deadlineClass = scheme.deadlineStatus === 'urgent' ? 'deadline-urgent' :
               scheme.deadlineStatus === 'soon' ? 'deadline-soon' : 'deadline-normal';

            const deadlineText = scheme.deadlineStatus === 'urgent' ? 'Closing Soon!' :
               scheme.deadlineStatus === 'soon' ? 'Limited Time' : 'Open';

            // Format tags
            const tagHTML = scheme.tags.map(tag => {
               if (tag === 'central') {
                  return '<span class="tag tag-central">Central Govt</span>';
               } else if (tag === 'state') {
                  return '<span class="tag tag-state">State Govt</span>';
               } else if (tag === 'financial') {
                  return '<span class="tag tag-financial">Financial Aid</span>';
               } else if (tag === 'machinery') {
                  return '<span class="tag tag-machinery">Machinery</span>';
               } else if (tag === 'seeds') {
                  return '<span class="tag tag-seeds">Seeds</span>';
               } else if (tag === 'insurance') {
                  return '<span class="tag tag-insurance">Insurance</span>';
               }
               return '';
            }).join('');

            html += `
               <div class="scheme-card">
                  <div class="tag-container">
                     ${tagHTML}
                  </div>
                  <h3 class="scheme-title">${scheme.name}</h3>
                  <p class="scheme-desc">${scheme.description}</p>
                  <ul class="details-list">
                     <li><i class="fas fa-check-circle"></i> <strong>Benefit:</strong> ${scheme.benefits}</li>
                     <li><i class="fas fa-check-circle"></i> <strong>Eligibility:</strong> ${scheme.eligibility}</li>
                  </ul>
                  <div class="card-footer">
                     <div class="deadline ${deadlineClass}">
                        <i class="fas fa-clock"></i> ${deadlineText}
                     </div>
                     <a href="${scheme.link}" target="_blank" class="btn-apply">
                        <i class="fas fa-external-link-alt"></i> Apply Now
                     </a>
                  </div>
               </div>
            `;
         });

         schemeGrid.innerHTML = html;
      }

      // Update active filters display
      function updateActiveFilters() {
         let filtersHTML = '';

         if (currentFilters.state !== 'all') {
            const stateName = stateFilter.options[stateFilter.selectedIndex].text;
            filtersHTML += `<span class="filter-tag" onclick="removeFilter('state')">${stateName} <i class="fas fa-times"></i></span>`;
         }

         if (currentFilters.type !== 'all') {
            const typeName = typeFilter.options[typeFilter.selectedIndex].text;
            filtersHTML += `<span class="filter-tag" onclick="removeFilter('type')">${typeName} <i class="fas fa-times"></i></span>`;
         }

         if (currentFilters.authority !== 'all') {
            const authorityName = authorityFilter.options[authorityFilter.selectedIndex].text;
            filtersHTML += `<span class="filter-tag" onclick="removeFilter('authority')">${authorityName} <i class="fas fa-times"></i></span>`;
         }

         if (filtersHTML) {
            filtersHTML += '<span class="clear-all" onclick="clearAllFilters()">Clear All</span>';
            activeFilters.innerHTML = filtersHTML;
         } else {
            activeFilters.innerHTML = '';
         }
      }

      // Remove specific filter
      window.removeFilter = function (filterType) {
         if (filterType === 'state') {
            stateFilter.value = 'all';
         } else if (filterType === 'type') {
            typeFilter.value = 'all';
         } else if (filterType === 'authority') {
            authorityFilter.value = 'all';
         }
         updateFilters();
      }

      // Clear all filters
      window.clearAllFilters = function () {
         stateFilter.value = 'all';
         typeFilter.value = 'all';
         authorityFilter.value = 'all';
         updateFilters();
      }

      // Check application status
      checkStatusBtn.addEventListener('click', () => {
         const appId = applicationId.value.trim();

         if (!appId) {
            showStatus('Please enter a valid Aadhaar or Application ID', 'error');
            return;
         }

         // Simulate API call
         setTimeout(() => {
            // Random status for demo
            const statuses = ['approved', 'pending', 'rejected'];
            const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];

            let statusHTML = '';

            if (randomStatus === 'approved') {
               statusHTML = `
                  <div class="status-result status-approved">
                     <i class="fas fa-check-circle" style="color: var(--success-green); font-size: 1.5rem; margin-bottom: 10px;"></i>
                     <h4 style="color: #166534; margin-bottom: 5px;">Application Approved!</h4>
                     <p style="color: #15803d;">Your subsidy of ₹45,000 has been approved. Amount will be credited within 7 working days.</p>
                     <p style="color: #166534; margin-top: 10px;"><strong>Application ID:</strong> ${appId}</p>
                  </div>
               `;
            } else if (randomStatus === 'pending') {
               statusHTML = `
                  <div class="status-result status-pending">
                     <i class="fas fa-clock" style="color: var(--warning-orange); font-size: 1.5rem; margin-bottom: 10px;"></i>
                     <h4 style="color: #92400e; margin-bottom: 5px;">Application Under Review</h4>
                     <p style="color: #b45309;">Your application is being processed by the concerned department. Expected completion: 5-7 working days.</p>
                     <p style="color: #92400e; margin-top: 10px;"><strong>Application ID:</strong> ${appId}</p>
                  </div>
               `;
            } else {
               statusHTML = `
                  <div class="status-result status-rejected">
                     <i class="fas fa-times-circle" style="color: var(--danger-red); font-size: 1.5rem; margin-bottom: 10px;"></i>
                     <h4 style="color: #991b1b; margin-bottom: 5px;">Additional Documents Required</h4>
                     <p style="color: #b91c1c;">Please upload your land records (8-A) and Aadhaar to complete the application.</p>
                     <p style="color: #991b1b; margin-top: 10px;"><strong>Application ID:</strong> ${appId}</p>
                  </div>
               `;
            }

            statusResult.innerHTML = statusHTML;
            statusResult.style.display = 'block';
         }, 1000);
      });

      function showStatus(message, type) {
         statusResult.innerHTML = `
            <div class="status-result" style="background: #fee2e2; border-left-color: #ef4444;">
               <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 1.5rem; margin-bottom: 10px;"></i>
               <p style="color: #991b1b;">${message}</p>
            </div>
         `;
         statusResult.style.display = 'block';
      }
   </script>

</body>

</html>