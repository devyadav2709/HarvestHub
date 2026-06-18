<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Farming Equipment Marketplace | Harvest Hub</title>
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
         --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
         --shadow-md: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
         --shadow-lg: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
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
         padding: 100px 20px 80px;
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
         background-size: 80px 80px;
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
         max-width: 600px;
         margin: 0 auto;
         position: relative;
         z-index: 2;
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

      /* Main Container */
      .container {
         max-width: 1400px;
         margin: -40px auto 50px;
         padding: 0 20px;
         position: relative;
         z-index: 10;
      }

      /* Stats Bar */
      .stats-bar {
         background: #fff;
         border-radius: 20px;
         padding: 25px 30px;
         margin-bottom: 30px;
         box-shadow: var(--shadow-md);
         display: flex;
         justify-content: space-between;
         align-items: center;
         flex-wrap: wrap;
         gap: 20px;
      }

      .stat-item {
         display: flex;
         align-items: center;
         gap: 12px;
      }

      .stat-icon {
         width: 50px;
         height: 50px;
         background: rgba(13, 51, 17, 0.05);
         border-radius: 12px;
         display: flex;
         align-items: center;
         justify-content: center;
         color: var(--primary-dark);
         font-size: 1.5rem;
      }

      .stat-info h4 {
         font-size: 0.9rem;
         color: #64748b;
         font-weight: 500;
      }

      .stat-info p {
         font-size: 1.3rem;
         font-weight: 700;
         color: var(--primary-dark);
      }

      /* Filter & Search Bar */
      .controls-bar {
         background: #fff;
         padding: 25px 30px;
         border-radius: 20px;
         box-shadow: var(--shadow-sm);
         margin-bottom: 30px;
      }

      .filter-row {
         display: flex;
         flex-wrap: wrap;
         gap: 20px;
         align-items: center;
      }

      .search-box {
         position: relative;
         flex: 2;
         min-width: 280px;
      }

      .search-box i {
         position: absolute;
         left: 15px;
         top: 50%;
         transform: translateY(-50%);
         color: #94a3b8;
      }

      .search-box input {
         width: 100%;
         padding: 15px 15px 15px 45px;
         border: 2px solid #e2e8f0;
         border-radius: 12px;
         font-family: inherit;
         outline: none;
         transition: all 0.3s;
         font-size: 0.95rem;
      }

      .search-box input:focus {
         border-color: var(--accent-gold);
         box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
      }

      .filter-group {
         display: flex;
         gap: 15px;
         flex: 3;
         flex-wrap: wrap;
      }

      .filter-select {
         flex: 1;
         min-width: 150px;
         padding: 15px 20px;
         border: 2px solid #e2e8f0;
         border-radius: 12px;
         font-family: inherit;
         outline: none;
         background: #fff;
         cursor: pointer;
         color: var(--text-main);
         font-size: 0.95rem;
         transition: all 0.3s;
         appearance: none;
         background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
         background-repeat: no-repeat;
         background-position: right 15px center;
      }

      .filter-select:hover {
         border-color: var(--accent-gold);
      }

      .btn-add {
         background: var(--accent-gold);
         color: var(--primary-dark);
         border: none;
         padding: 15px 30px;
         border-radius: 12px;
         font-weight: 600;
         cursor: pointer;
         transition: all 0.3s;
         display: inline-flex;
         align-items: center;
         gap: 8px;
         font-size: 0.95rem;
         white-space: nowrap;
      }

      .btn-add:hover {
         background: #fff;
         box-shadow: var(--shadow-md);
         transform: translateY(-2px);
         border: 2px solid var(--accent-gold);
         padding: 13px 28px;
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

      /* Results Bar */
      .results-bar {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin-bottom: 25px;
         flex-wrap: wrap;
         gap: 15px;
      }

      .results-count {
         font-size: 1rem;
         color: #64748b;
         display: flex;
         align-items: center;
         gap: 8px;
      }

      .results-count span {
         font-weight: 700;
         color: var(--primary-dark);
         font-size: 1.2rem;
      }

      .sort-select {
         padding: 10px 20px;
         border: 2px solid #e2e8f0;
         border-radius: 10px;
         font-family: inherit;
         outline: none;
         background: #fff;
         cursor: pointer;
         font-size: 0.9rem;
         min-width: 200px;
      }

      /* Equipment Grid */
      .equipment-grid {
         display: grid;
         grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
         gap: 30px;
         margin-bottom: 50px;
      }

      /* Individual Card */
      .equip-card {
         background: var(--card-bg);
         border-radius: 20px;
         overflow: hidden;
         box-shadow: var(--shadow-sm);
         border: 1px solid #f1f5f9;
         transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
         position: relative;
         display: flex;
         flex-direction: column;
      }

      .equip-card:hover {
         transform: translateY(-10px);
         box-shadow: var(--shadow-lg);
         border-color: var(--accent-gold);
      }

      /* Image Container - Now with actual images */
      .equip-img-container {
         height: 220px;
         position: relative;
         overflow: hidden;
         background: #f1f5f9;
      }

      .equip-img {
         width: 100%;
         height: 100%;
         object-fit: cover;
         transition: transform 0.5s;
      }

      .equip-card:hover .equip-img {
         transform: scale(1.1);
      }

      /* Image placeholder for when image fails to load */
      .img-placeholder {
         width: 100%;
         height: 100%;
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
         color: #64748b;
      }

      .img-placeholder i {
         font-size: 4rem;
         margin-bottom: 10px;
         color: #475569;
      }

      .img-placeholder span {
         font-size: 0.9rem;
         font-weight: 500;
      }

      /* Badges */
      .badge {
         position: absolute;
         top: 15px;
         left: 15px;
         padding: 8px 18px;
         border-radius: 50px;
         font-size: 0.8rem;
         font-weight: 700;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         box-shadow: var(--shadow-md);
         z-index: 2;
      }

      .badge.rent {
         background: linear-gradient(135deg, #3b82f6, #2563eb);
         color: #fff;
      }

      .badge.new {
         background: linear-gradient(135deg, #22c55e, #16a34a);
         color: #fff;
      }

      .badge.used {
         background: linear-gradient(135deg, #f59e0b, #d97706);
         color: #fff;
      }

      .badge.hot {
         position: absolute;
         top: 15px;
         right: 15px;
         left: auto;
         background: linear-gradient(135deg, #ef4444, #dc2626);
         color: #fff;
         animation: pulse 2s infinite;
      }

      @keyframes pulse {
         0% {
            transform: scale(1);
         }

         50% {
            transform: scale(1.05);
         }

         100% {
            transform: scale(1);
         }
      }

      /* Card Content */
      .equip-content {
         padding: 25px;
         flex: 1;
         display: flex;
         flex-direction: column;
      }

      .equip-category {
         font-size: 0.8rem;
         color: var(--accent-gold);
         text-transform: uppercase;
         letter-spacing: 1px;
         margin-bottom: 8px;
         font-weight: 600;
      }

      .equip-title {
         font-size: 1.25rem;
         font-weight: 700;
         color: var(--primary-dark);
         margin: 0 0 12px 0;
         line-height: 1.4;
         min-height: 3.5rem;
      }

      .equip-location {
         color: #64748b;
         font-size: 0.9rem;
         margin-bottom: 15px;
         display: flex;
         align-items: center;
         gap: 6px;
      }

      .price-container {
         margin-bottom: 20px;
      }

      .current-price {
         font-size: 1.8rem;
         font-weight: 700;
         color: var(--primary-dark);
         line-height: 1.2;
      }

      .current-price span {
         font-size: 0.9rem;
         font-weight: 400;
         color: #64748b;
      }

      .old-price {
         font-size: 1rem;
         color: #94a3b8;
         text-decoration: line-through;
         margin-top: 5px;
      }

      .price-change {
         display: inline-block;
         padding: 4px 10px;
         border-radius: 50px;
         font-size: 0.75rem;
         font-weight: 600;
         margin-left: 10px;
      }

      .price-up {
         background: rgba(239, 68, 68, 0.1);
         color: #dc2626;
      }

      .price-down {
         background: rgba(34, 197, 94, 0.1);
         color: #16a34a;
      }

      .equip-seller {
         display: flex;
         align-items: center;
         gap: 10px;
         margin-bottom: 15px;
         padding: 10px;
         background: #f8fafc;
         border-radius: 10px;
      }

      .seller-avatar {
         width: 40px;
         height: 40px;
         background: var(--primary-dark);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         color: #fff;
         font-weight: 600;
      }

      .seller-info {
         flex: 1;
      }

      .seller-name {
         font-weight: 600;
         font-size: 0.9rem;
         color: var(--primary-dark);
      }

      .seller-rating {
         color: var(--accent-gold);
         font-size: 0.8rem;
      }

      /* Card Action Button */
      .btn-view {
         width: 100%;
         background: #f1f5f9;
         color: var(--primary-dark);
         border: none;
         padding: 14px;
         border-radius: 12px;
         font-weight: 600;
         cursor: pointer;
         transition: all 0.3s;
         display: flex;
         align-items: center;
         justify-content: center;
         gap: 8px;
         font-size: 0.95rem;
      }

      .equip-card:hover .btn-view {
         background: var(--primary-dark);
         color: var(--accent-gold);
      }

      /* No Results */
      .no-results {
         text-align: center;
         padding: 80px 20px;
         background: #fff;
         border-radius: 20px;
         border: 1px solid #e2e8f0;
         grid-column: 1 / -1;
      }

      .no-results i {
         font-size: 4rem;
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

      /* Loading Animation */
      .price-loading {
         display: inline-block;
         width: 20px;
         height: 20px;
         border: 2px solid #f3f3f3;
         border-top: 2px solid var(--accent-gold);
         border-radius: 50%;
         animation: spin 1s linear infinite;
      }

      @keyframes spin {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
      }

      /* Responsive */
      @media (max-width: 992px) {
         .filter-row {
            flex-direction: column;
            align-items: stretch;
         }

         .filter-group {
            flex-direction: column;
         }

         .btn-add {
            width: 100%;
            justify-content: center;
         }
      }

      @media (max-width: 768px) {
         .page-header h1 {
            font-size: 2rem;
         }

         .stats-bar {
            flex-direction: column;
            align-items: flex-start;
         }

         .stat-item {
            width: 100%;
         }

         .equipment-grid {
            grid-template-columns: 1fr;
         }
      }
   </style>
</head>

<body>

   <section class="page-header">
      <div class="header-glow"></div>
      <h1>Farming Equipment Marketplace</h1>
      <p>Buy, sell, or rent high-quality agricultural machinery. From heavy tractors to smart irrigation tools, find
         exactly what your farm needs.</p>
   </section>

   <div class="container">
      <!-- Stats Bar -->
      <div class="stats-bar">
         <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-tractor"></i></div>
            <div class="stat-info">
               <h4>Total Listings</h4>
               <p id="totalListings">156</p>
            </div>
         </div>
         <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-tag"></i></div>
            <div class="stat-info">
               <h4>Active Today</h4>
               <p id="activeToday">89</p>
            </div>
         </div>
         <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
            <div class="stat-info">
               <h4>Avg. Price</h4>
               <p id="avgPrice">₹ 45,200</p>
            </div>
         </div>
         <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-city"></i></div>
            <div class="stat-info">
               <h4>Locations</h4>
               <p id="locations">12 States</p>
            </div>
         </div>
      </div>

      <!-- Filter & Search Bar -->
      <div class="controls-bar">
         <div class="filter-row">
            <div class="search-box">
               <i class="fas fa-search"></i>
               <input type="text" id="searchInput" placeholder="Search tractors, harvesters, pumps...">
            </div>

            <div class="filter-group">
               <select class="filter-select" id="categoryFilter">
                  <option value="all">All Categories</option>
                  <option value="tractors">Tractors & Power</option>
                  <option value="tillers">Power Tillers</option>
                  <option value="harvesters">Harvesters</option>
                  <option value="threshers">Threshers</option>
                  <option value="ploughs">Ploughs & Cultivators</option>
                  <option value="rotavators">Rotavators</option>
                  <option value="seed-drills">Seed Drills</option>
                  <option value="sprayers">Sprayers</option>
                  <option value="irrigation">Irrigation Systems</option>
                  <option value="solar-pumps">Solar Pumps</option>
                  <option value="spreaders">Fertilizer Spreaders</option>
                  <option value="combine">Combine Harvesters</option>
               </select>

               <select class="filter-select" id="typeFilter">
                  <option value="all">All Types</option>
                  <option value="new">New - For Sale</option>
                  <option value="used">Used - For Sale</option>
                  <option value="rent">For Rent</option>
               </select>
            </div>

            <button class="btn-add" id="postAdBtn"><i class="fas fa-plus"></i> Post an Ad</button>
         </div>

         <!-- Active Filters -->
         <div class="active-filters" id="activeFilters"></div>
      </div>

      <!-- Results Bar -->
      <div class="results-bar">
         <div class="results-count">
            <i class="fas fa-list"></i>
            Showing <span id="showingCount">24</span> equipment listings
         </div>
         <select class="sort-select" id="sortSelect">
            <option value="default">Sort by: Default</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="newest">Newest First</option>
         </select>
      </div>

      <!-- Equipment Grid -->
      <div class="equipment-grid" id="equipmentGrid">
         <!-- Equipment will be populated by JavaScript -->
      </div>
   </div>

   <?php include 'footer.php'; ?>

   <script>
      // Equipment Data with realistic image URLs
      const equipmentData = [
         {
            id: 1,
            name: 'Mahindra 575 DI Tractor',
            category: 'tractors',
            type: 'rent',
            condition: 'Excellent',
            location: 'Ludhiana, Punjab',
            seller: 'Gurpreet Singh',
            rating: 4.8,
            price: 1500,
            oldPrice: 1800,
            priceUnit: '/ day',
            hot: true,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Mahindra Tractor'
         },
         {
            id: 2,
            name: 'Automatic Drip Irrigation Kit',
            category: 'irrigation',
            type: 'new',
            condition: 'Brand New',
            location: 'Rajkot, Gujarat',
            seller: 'AgriTech Solutions',
            rating: 4.5,
            price: 22000,
            oldPrice: 28000,
            priceUnit: 'fixed',
            hot: false,
            image: 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            imageAlt: 'Drip Irrigation System'
         },
         {
            id: 3,
            name: 'Heavy Duty Rotavator (7 Feet)',
            category: 'rotavators',
            type: 'used',
            condition: 'Good',
            location: 'Karnal, Haryana',
            seller: 'Farm Equipment Co.',
            rating: 4.2,
            price: 65000,
            oldPrice: 85000,
            priceUnit: 'negotiable',
            hot: true,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Rotavator Machine'
         },
         {
            id: 4,
            name: 'Wheat Combine Harvester',
            category: 'combine',
            type: 'rent',
            condition: 'Excellent',
            location: 'Patiala, Punjab',
            seller: 'Harvest Services',
            rating: 4.9,
            price: 2800,
            oldPrice: 3200,
            priceUnit: '/ hour',
            hot: true,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Combine Harvester'
         },
         {
            id: 5,
            name: 'Solar Water Pump System (5 HP)',
            category: 'solar-pumps',
            type: 'new',
            condition: 'Brand New',
            location: 'Pune, Maharashtra',
            seller: 'Green Energy Pvt Ltd',
            rating: 4.7,
            price: 180000,
            oldPrice: 210000,
            priceUnit: 'incl. installation',
            hot: false,
            image: 'https://images.unsplash.com/photo-1624397640148-949b1732bb0a?w=400&h=300&fit=crop',
            imageAlt: 'Solar Water Pump'
         },
         {
            id: 6,
            name: 'Battery Operated Knapsack Sprayer',
            category: 'sprayers',
            type: 'used',
            condition: 'Like New',
            location: 'Amritsar, Punjab',
            seller: 'Kisan Store',
            rating: 4.3,
            price: 2100,
            oldPrice: 3500,
            priceUnit: 'fixed',
            hot: false,
            image: 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            imageAlt: 'Knapsack Sprayer'
         },
         {
            id: 7,
            name: 'Power Tiller (8 HP)',
            category: 'tillers',
            type: 'new',
            condition: 'Brand New',
            location: 'Lucknow, UP',
            seller: 'Tiller House',
            rating: 4.6,
            price: 95000,
            oldPrice: 110000,
            priceUnit: 'fixed',
            hot: false,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Power Tiller'
         },
         {
            id: 8,
            name: 'Seed Drill (9 Tine)',
            category: 'seed-drills',
            type: 'used',
            condition: 'Good',
            location: 'Indore, MP',
            seller: 'Farm Machinery Depot',
            rating: 4.1,
            price: 45000,
            oldPrice: 60000,
            priceUnit: 'negotiable',
            hot: false,
            image: 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            imageAlt: 'Seed Drill'
         },
         {
            id: 9,
            name: 'Disc Plough (3 Disc)',
            category: 'ploughs',
            type: 'used',
            condition: 'Fair',
            location: 'Nagpur, Maharashtra',
            seller: 'Ramesh Patel',
            rating: 3.9,
            price: 28000,
            oldPrice: 40000,
            priceUnit: 'negotiable',
            hot: false,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Disc Plough'
         },
         {
            id: 10,
            name: 'Cultivator (11 Tine)',
            category: 'ploughs',
            type: 'new',
            condition: 'Brand New',
            location: 'Jaipur, Rajasthan',
            seller: 'Rajasthan Agro',
            rating: 4.4,
            price: 38000,
            oldPrice: 42000,
            priceUnit: 'fixed',
            hot: false,
            image: 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            imageAlt: 'Cultivator'
         },
         {
            id: 11,
            name: 'Fertilizer Spreader (200L)',
            category: 'spreaders',
            type: 'rent',
            condition: 'Good',
            location: 'Bhopal, MP',
            seller: 'Agri Rentals',
            rating: 4.2,
            price: 800,
            oldPrice: 1000,
            priceUnit: '/ day',
            hot: false,
            image: 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            imageAlt: 'Fertilizer Spreader'
         },
         {
            id: 12,
            name: 'Thresher (Multi-crop)',
            category: 'threshers',
            type: 'used',
            condition: 'Good',
            location: 'Bathinda, Punjab',
            seller: 'Singh Enterprises',
            rating: 4.0,
            price: 120000,
            oldPrice: 150000,
            priceUnit: 'negotiable',
            hot: true,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Thresher Machine'
         },
         {
            id: 13,
            name: 'Submersible Pump (10 HP)',
            category: 'irrigation',
            type: 'new',
            condition: 'Brand New',
            location: 'Ahmedabad, Gujarat',
            seller: 'Pump World',
            rating: 4.5,
            price: 45000,
            oldPrice: 52000,
            priceUnit: 'fixed',
            hot: false,
            image: 'https://images.unsplash.com/photo-1624397640148-949b1732bb0a?w=400&h=300&fit=crop',
            imageAlt: 'Submersible Pump'
         },
         {
            id: 14,
            name: 'Laser Land Leveler',
            category: 'ploughs',
            type: 'rent',
            condition: 'Excellent',
            location: 'Meerut, UP',
            seller: 'Precision Farming Co.',
            rating: 4.8,
            price: 2200,
            oldPrice: 2500,
            priceUnit: '/ hour',
            hot: true,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Laser Land Leveler'
         },
         {
            id: 15,
            name: 'Paddy Transplanter',
            category: 'seed-drills',
            type: 'rent',
            condition: 'Good',
            location: 'Kolkata, WB',
            seller: 'Bengal Agro',
            rating: 4.3,
            price: 1800,
            oldPrice: 2100,
            priceUnit: '/ day',
            hot: false,
            image: 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            imageAlt: 'Paddy Transplanter'
         },
         {
            id: 16,
            name: 'Baler Machine',
            category: 'harvesters',
            type: 'used',
            condition: 'Fair',
            location: 'Nasik, Maharashtra',
            seller: 'Green Farms',
            rating: 3.8,
            price: 250000,
            oldPrice: 320000,
            priceUnit: 'negotiable',
            hot: false,
            image: 'https://images.unsplash.com/photo-1597910032948-8d7f2c2b6e8b?w=400&h=300&fit=crop',
            imageAlt: 'Baler Machine'
         }
      ];

      // DOM Elements
      const equipmentGrid = document.getElementById('equipmentGrid');
      const searchInput = document.getElementById('searchInput');
      const categoryFilter = document.getElementById('categoryFilter');
      const typeFilter = document.getElementById('typeFilter');
      const sortSelect = document.getElementById('sortSelect');
      const showingCount = document.getElementById('showingCount');
      const activeFilters = document.getElementById('activeFilters');
      const postAdBtn = document.getElementById('postAdBtn');

      // Current filters
      let currentFilters = {
         search: '',
         category: 'all',
         type: 'all',
         sort: 'default'
      };

      // Initialize page
      document.addEventListener('DOMContentLoaded', () => {
         renderEquipment(equipmentData);
         updateStats();

         // Event listeners
         searchInput.addEventListener('input', debounce(updateFilters, 300));
         categoryFilter.addEventListener('change', updateFilters);
         typeFilter.addEventListener('change', updateFilters);
         sortSelect.addEventListener('change', updateFilters);

         // Simulate real-time price updates
         startPriceSimulation();
      });

      // Debounce function for search
      function debounce(func, wait) {
         let timeout;
         return function executedFunction(...args) {
            const later = () => {
               clearTimeout(timeout);
               func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
         };
      }

      // Update filters
      function updateFilters() {
         currentFilters.search = searchInput.value.toLowerCase();
         currentFilters.category = categoryFilter.value;
         currentFilters.type = typeFilter.value;
         currentFilters.sort = sortSelect.value;

         filterAndRender();
         updateActiveFilters();
      }

      // Filter and render equipment
      function filterAndRender() {
         let filtered = equipmentData.filter(item => {
            // Search filter
            if (currentFilters.search && !item.name.toLowerCase().includes(currentFilters.search)) {
               return false;
            }

            // Category filter
            if (currentFilters.category !== 'all' && item.category !== currentFilters.category) {
               return false;
            }

            // Type filter
            if (currentFilters.type !== 'all' && item.type !== currentFilters.type) {
               return false;
            }

            return true;
         });

         // Sort
         if (currentFilters.sort === 'price-low') {
            filtered.sort((a, b) => a.price - b.price);
         } else if (currentFilters.sort === 'price-high') {
            filtered.sort((a, b) => b.price - a.price);
         } else if (currentFilters.sort === 'newest') {
            filtered.sort((a, b) => b.id - a.id);
         }

         renderEquipment(filtered);
         showingCount.textContent = filtered.length;
      }

      // Handle image error - show placeholder
      function handleImageError(img) {
         img.style.display = 'none';
         const placeholder = document.createElement('div');
         placeholder.className = 'img-placeholder';
         placeholder.innerHTML = `
            <i class="fas fa-tractor"></i>
            <span>${img.alt || 'Equipment Image'}</span>
         `;
         img.parentNode.appendChild(placeholder);
      }

      // Render equipment cards
      function renderEquipment(items) {
         if (items.length === 0) {
            equipmentGrid.innerHTML = `
               <div class="no-results">
                  <i class="fas fa-tractor"></i>
                  <h3>No Equipment Found</h3>
                  <p>Try adjusting your search or filter criteria</p>
               </div>
            `;
            return;
         }

         let html = '';
         items.forEach(item => {
            const badgeClass = item.type === 'rent' ? 'rent' : (item.type === 'new' ? 'new' : 'used');
            const badgeText = item.type === 'rent' ? 'For Rent' : (item.type === 'new' ? 'New - For Sale' : 'Used - For Sale');

            const priceChange = ((item.price - item.oldPrice) / item.oldPrice * 100).toFixed(1);
            const priceChangeClass = priceChange < 0 ? 'price-down' : 'price-up';
            const priceChangeIcon = priceChange < 0 ? 'fa-arrow-down' : 'fa-arrow-up';

            const sellerInitial = item.seller.charAt(0);

            html += `
               <div class="equip-card" onclick="viewEquipment(${item.id})">
                  <div class="equip-img-container">
                     <span class="badge ${badgeClass}">${badgeText}</span>
                     ${item.hot ? '<span class="badge hot"><i class="fas fa-fire"></i> HOT</span>' : ''}
                     <img class="equip-img" 
                          src="${item.image}" 
                          alt="${item.imageAlt}"
                          onerror="handleImageError(this)"
                          loading="lazy">
                  </div>
                  <div class="equip-content">
                     <div class="equip-category">${item.category.replace('-', ' ').toUpperCase()}</div>
                     <h3 class="equip-title">${item.name}</h3>
                     <div class="equip-location"><i class="fas fa-map-marker-alt"></i> ${item.location}</div>
                     
                     <div class="price-container">
                        <div class="current-price">
                           ₹ ${item.price.toLocaleString()} <span>${item.priceUnit}</span>
                           <span class="price-change ${priceChangeClass}">
                              <i class="fas ${priceChangeIcon}"></i> ${Math.abs(priceChange)}%
                           </span>
                        </div>
                        <div class="old-price">₹ ${item.oldPrice.toLocaleString()}</div>
                     </div>

                     <div class="equip-seller">
                        <div class="seller-avatar">${sellerInitial}</div>
                        <div class="seller-info">
                           <div class="seller-name">${item.seller}</div>
                           <div class="seller-rating">
                              ${generateStars(item.rating)} (${item.rating})
                           </div>
                        </div>
                     </div>

                     <button class="btn-view" onclick="event.stopPropagation(); contactSeller(${item.id})">
                        <i class="fas fa-phone-alt"></i> Contact Seller
                     </button>
                  </div>
               </div>
            `;
         });

         equipmentGrid.innerHTML = html;
      }

      // Generate star ratings
      function generateStars(rating) {
         let stars = '';
         for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(rating)) {
               stars += '<i class="fas fa-star"></i>';
            } else if (i - rating < 1 && i - rating > 0) {
               stars += '<i class="fas fa-star-half-alt"></i>';
            } else {
               stars += '<i class="far fa-star"></i>';
            }
         }
         return stars;
      }

      // Update active filters display
      function updateActiveFilters() {
         let filtersHTML = '';

         if (currentFilters.search) {
            filtersHTML += `<span class="filter-tag" onclick="removeFilter('search')">Search: ${currentFilters.search} <i class="fas fa-times"></i></span>`;
         }

         if (currentFilters.category !== 'all') {
            const categoryName = categoryFilter.options[categoryFilter.selectedIndex].text;
            filtersHTML += `<span class="filter-tag" onclick="removeFilter('category')">${categoryName} <i class="fas fa-times"></i></span>`;
         }

         if (currentFilters.type !== 'all') {
            const typeName = typeFilter.options[typeFilter.selectedIndex].text;
            filtersHTML += `<span class="filter-tag" onclick="removeFilter('type')">${typeName} <i class="fas fa-times"></i></span>`;
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
         if (filterType === 'search') {
            searchInput.value = '';
            currentFilters.search = '';
         } else if (filterType === 'category') {
            categoryFilter.value = 'all';
            currentFilters.category = 'all';
         } else if (filterType === 'type') {
            typeFilter.value = 'all';
            currentFilters.type = 'all';
         }
         updateFilters();
      }

      // Clear all filters
      window.clearAllFilters = function () {
         searchInput.value = '';
         categoryFilter.value = 'all';
         typeFilter.value = 'all';
         sortSelect.value = 'default';
         currentFilters = {
            search: '',
            category: 'all',
            type: 'all',
            sort: 'default'
         };
         filterAndRender();
         activeFilters.innerHTML = '';
      }

      // View equipment details
      window.viewEquipment = function (id) {
         const equipment = equipmentData.find(e => e.id === id);
         alert(`Viewing details for: ${equipment.name}\nPrice: ₹${equipment.price}\nSeller: ${equipment.seller}\nLocation: ${equipment.location}`);
      }

      // Contact seller
      window.contactSeller = function (id) {
         const equipment = equipmentData.find(e => e.id === id);
         alert(`Contacting seller: ${equipment.seller}\nPhone: +91 XXXXX-XXXXX (Demo)`);
      }

      // Post ad button
      postAdBtn.addEventListener('click', () => {
         alert('Post your equipment listing! (Demo version)');
      });

      // Update stats
      function updateStats() {
         document.getElementById('totalListings').textContent = equipmentData.length;
         document.getElementById('activeToday').textContent = Math.floor(equipmentData.length * 0.7);

         const avgPrice = equipmentData.reduce((acc, item) => acc + item.price, 0) / equipmentData.length;
         document.getElementById('avgPrice').textContent = `₹ ${Math.round(avgPrice / 1000)}K`;

         const uniqueStates = [...new Set(equipmentData.map(item => item.location.split(', ')[1]))].length;
         document.getElementById('locations').textContent = `${uniqueStates} States`;
      }

      // Simulate real-time price updates
      function startPriceSimulation() {
         setInterval(() => {
            const randomIndex = Math.floor(Math.random() * equipmentData.length);
            const equipment = equipmentData[randomIndex];

            // Random price change between -3% and +5%
            const changePercent = (Math.random() * 8 - 3) / 100;
            const newPrice = Math.round(equipment.price * (1 + changePercent));

            // Update price
            equipment.oldPrice = equipment.price;
            equipment.price = newPrice;

            // Re-render if this item is currently visible
            filterAndRender();
         }, 5000);
      }

      // Make handleImageError globally available
      window.handleImageError = handleImageError;
   </script>

</body>

</html>