<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Live Crop Prices | Harvest Hub</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <style>
      :root {
         --primary-dark: #0d3311;
         --primary-light: #1b5e20;
         --accent-gold: #fbbf24;
         --text-main: #334155;
         --bg-light: #f8fafc;
      }

      body {
         font-family: 'Poppins', sans-serif;
         background-color: var(--bg-light);
         color: var(--text-main);
         margin: 0;
         padding: 0;
      }

      /* Hero Section */
      .page-header {
         background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
         color: #fff;
         padding: 100px 20px 80px;
         text-align: center;
         position: relative;
         overflow: hidden;
      }

      .page-header h1 {
         font-size: 2.5rem;
         font-weight: 700;
         margin-bottom: 15px;
         position: relative;
         z-index: 2;
      }

      .page-header p {
         font-size: 1.1rem;
         color: #cbd5e1;
         max-width: 600px;
         margin: 0 auto;
         position: relative;
         z-index: 2;
      }

      /* Gold glowing orb in background */
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

      /* Main Content Container */
      .container {
         max-width: 1200px;
         margin: -40px auto 50px;
         padding: 0 20px;
         position: relative;
         z-index: 10;
      }

      /* Filter & Search Bar */
      .controls-bar {
         background: #fff;
         padding: 20px 30px;
         border-radius: 16px;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
         display: flex;
         flex-wrap: wrap;
         gap: 20px;
         justify-content: space-between;
         align-items: center;
         margin-bottom: 30px;
      }

      .search-box {
         position: relative;
         flex: 1;
         min-width: 250px;
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
         padding: 12px 15px 12px 45px;
         border: 1px solid #e2e8f0;
         border-radius: 10px;
         font-family: inherit;
         outline: none;
         transition: 0.3s;
      }

      .search-box input:focus {
         border-color: var(--accent-gold);
         box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
      }

      .filter-select {
         padding: 12px 20px;
         border: 1px solid #e2e8f0;
         border-radius: 10px;
         font-family: inherit;
         outline: none;
         background: #fff;
         cursor: pointer;
      }

      /* Table Styles */
      .table-container {
         background: #fff;
         border-radius: 16px;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
         overflow-x: auto;
         max-height: 600px;
         overflow-y: auto;
      }

      table {
         width: 100%;
         border-collapse: collapse;
         text-align: left;
      }

      th {
         background-color: #f1f5f9;
         color: var(--primary-dark);
         font-weight: 600;
         padding: 18px 20px;
         white-space: nowrap;
         position: sticky;
         top: 0;
         z-index: 5;
      }

      td {
         padding: 18px 20px;
         border-bottom: 1px solid #f1f5f9;
         color: #475569;
         vertical-align: middle;
      }

      tr:last-child td {
         border-bottom: none;
      }

      tr:hover td {
         background-color: #f8fafc;
      }

      /* Badges & Indicators */
      .crop-name {
         font-weight: 600;
         color: var(--primary-dark);
         display: flex;
         align-items: center;
         gap: 10px;
      }

      .crop-icon {
         width: 35px;
         height: 35px;
         background: #f1f5f9;
         border-radius: 8px;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 1.1rem;
      }

      .price {
         font-weight: 700;
         font-size: 1.1rem;
         color: var(--primary-dark);
      }

      .trend {
         padding: 6px 12px;
         border-radius: 50px;
         font-size: 0.85rem;
         font-weight: 600;
         display: inline-flex;
         align-items: center;
         gap: 5px;
      }

      .trend-up {
         background: rgba(34, 197, 94, 0.1);
         color: #16a34a;
      }

      .trend-down {
         background: rgba(239, 68, 68, 0.1);
         color: #dc2626;
      }

      .update-time {
         text-align: right;
         font-size: 0.85rem;
         color: #94a3b8;
         margin-bottom: 15px;
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
         .page-header {
            padding: 80px 20px 60px;
         }

         .controls-bar {
            flex-direction: column;
         }

         .search-box,
         .filter-select {
            width: 100%;
         }
      }
   </style>
</head>

<body>

   <section class="page-header">
      <div class="header-glow"></div>
      <h1>Live Market Crop Prices</h1>
      <p>Stay updated with the latest mandi rates across all major markets in Gujarat. Prices are updated daily to help
         you make the best trading decisions.
      </p>
   </section>

   <div class="container">

      <div class="update-time">
         <i class="fas fa-clock"></i> Last updated: <?php echo date("F j, Y, g:i a"); ?>
      </div>

      <div class="controls-bar">
         <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search for a crop or location (e.g., Wheat, Bhuj)...">
         </div>
         <select class="filter-select">
            <option value="all">All Categories</option>
            <option value="cereals">Cereals & Grains</option>
            <option value="vegetables">Vegetables</option>
            <option value="fruits">Fruits</option>
            <option value="cash-crops">Cash Crops</option>
         </select>
         <select class="filter-select">
            <option value="all">All Districts</option>
            <option value="ahmedabad">Ahmedabad</option>
            <option value="amreli">Amreli</option>
            <option value="anand">Anand</option>
            <option value="banaskantha">Banaskantha</option>
            <option value="bhavnagar">Bhavnagar</option>
            <option value="bharuch">Bharuch</option>
            <option value="dahod">Dahod</option>
            <option value="gandhinagar">Gandhinagar</option>
            <option value="kheda">Kheda</option>
            <option value="kutch">Kutch</option>
            <option value="mahisagar">Mahisagar</option>
            <option value="mehsana">Mehsana</option>
            <option value="navsari">Navsari</option>
            <option value="panchmahal">Panchmahal</option>
            <option value="rajkot">Rajkot</option>
            <option value="sabarkantha">Sabarkantha</option>
            <option value="surat">Surat</option>
            <option value="surendranagar">Surendranagar</option>
            <option value="vadodara">Vadodara</option>
            <option value="valsad">Valsad</option>
         </select>
      </div>

      <div class="table-container">
         <table>
            <thead>
               <tr>
                  <th>Crop Name</th>
                  <th>Category</th>
                  <th>Market Location (Taluka)</th>
                  <th>Price (per Quintal)</th>
                  <th>Today's Trend</th>
               </tr>
            </thead>
            <tbody>
               <!-- Ahmedabad -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat (Sharbati)</div>
                  </td>
                  <td>Cereals</td>
                  <td>Ahmedabad (Jampur)</td>
                  <td class="price">₹ 2,850</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧅</span>Onion (Red)</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Dholka</td>
                  <td class="price">₹ 2,100</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +5.1%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍅</span>Tomato (Desi)</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Dhandhuka</td>
                  <td class="price">₹ 1,500</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -3.4%</span></td>
               </tr>
               <!-- Amreli -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥜</span>Groundnut</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Rajula</td>
                  <td class="price">₹ 5,800</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton (BT)</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Dhari</td>
                  <td class="price">₹ 7,150</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.0%</span></td>
               </tr>
               <!-- Anand -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana (Robusta)</div>
                  </td>
                  <td>Fruits</td>
                  <td>Anand</td>
                  <td class="price">₹ 2,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥛</span>Dairy (Milk)</div>
                  </td>
                  <td>Dairy</td>
                  <td>Borsad</td>
                  <td class="price">₹ 4,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy (Common)</div>
                  </td>
                  <td>Cereals</td>
                  <td>Khambhat</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧅</span>Onion (White)</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Petlad</td>
                  <td class="price">₹ 1,950</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +3.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍅</span>Tomato (Hybrid)</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Umreth</td>
                  <td class="price">₹ 1,600</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Tarapur</td>
                  <td class="price">₹ 2,100</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +4.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🫘</span>Mung Bean</div>
                  </td>
                  <td>Pulses</td>
                  <td>Anklav</td>
                  <td class="price">₹ 6,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.5%</span></td>
               </tr>
               <!-- Banaskantha -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌶️</span>Chili (Red)</div>
                  </td>
                  <td>Spices</td>
                  <td>Palanpur</td>
                  <td class="price">₹ 8,200</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -2.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat (Lokwan)</div>
                  </td>
                  <td>Cereals</td>
                  <td>Deesa</td>
                  <td class="price">₹ 2,750</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Isabgol</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Dhanera</td>
                  <td class="price">₹ 9,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +7.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌵</span>Castor Seed</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Tharad</td>
                  <td class="price">₹ 5,400</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Bajra (Pearl Millet)</div>
                  </td>
                  <td>Cereals</td>
                  <td>Thara</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧅</span>Onion (Red)</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Bhabhar</td>
                  <td class="price">₹ 2,050</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.0%</span></td>
               </tr>
               <!-- Bhavnagar -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton (Desi)</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Bhavnagar (Chitra)</td>
                  <td class="price">₹ 7,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥥</span>Coconut</div>
                  </td>
                  <td>Fruits</td>
                  <td>Mahuva</td>
                  <td class="price">₹ 2,000 (per 100)</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +3.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat</div>
                  </td>
                  <td>Cereals</td>
                  <td>Talaja</td>
                  <td class="price">₹ 2,700</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Jowar (Sorghum)</div>
                  </td>
                  <td>Cereals</td>
                  <td>Gariyadhar</td>
                  <td class="price">₹ 2,900</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.1%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌴</span>Date (Khajur)</div>
                  </td>
                  <td>Fruits</td>
                  <td>Palitana</td>
                  <td class="price">₹ 12,000</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.3%</span></td>
               </tr>
               <!-- Bharuch -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana (G-9)</div>
                  </td>
                  <td>Fruits</td>
                  <td>Bharuch</td>
                  <td class="price">₹ 2,800</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Amod</td>
                  <td class="price">₹ 7,200</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Jambusar</td>
                  <td class="price">₹ 2,300</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Hasot</td>
                  <td class="price">₹ 2,150</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🫘</span>Tuver (Pigeon Pea)</div>
                  </td>
                  <td>Pulses</td>
                  <td>Valia</td>
                  <td class="price">₹ 6,800</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.9%</span></td>
               </tr>
               <!-- Dahod -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Dahod</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +3.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat</div>
                  </td>
                  <td>Cereals</td>
                  <td>Zalod</td>
                  <td class="price">₹ 2,650</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.7%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🫘</span>Mung Bean</div>
                  </td>
                  <td>Pulses</td>
                  <td>Devgadbaria</td>
                  <td class="price">₹ 6,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.5%</span></td>
               </tr>
               <!-- Gandhinagar -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat</div>
                  </td>
                  <td>Cereals</td>
                  <td>Kalol</td>
                  <td class="price">₹ 2,800</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧅</span>Onion</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Mansa</td>
                  <td class="price">₹ 2,000</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -4.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍅</span>Tomato</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Dehgam</td>
                  <td class="price">₹ 1,450</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -2.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌶️</span>Green Chili</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Randheja</td>
                  <td class="price">₹ 3,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +6.0%</span></td>
               </tr>
               <!-- Kheda -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana</div>
                  </td>
                  <td>Fruits</td>
                  <td>Nadiad</td>
                  <td class="price">₹ 2,600</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Kapadvanj</td>
                  <td class="price">₹ 2,250</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧅</span>Onion</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Matar</td>
                  <td class="price">₹ 1,980</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Thasra</td>
                  <td class="price">₹ 2,080</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Mahemdavad</td>
                  <td class="price">₹ 7,000</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -3.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Tobacco</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Kheda</td>
                  <td class="price">₹ 6,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.1%</span></td>
               </tr>
               <!-- Kutch -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌵</span>Castor Seed</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Bhuj</td>
                  <td class="price">₹ 5,300</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Bajra</div>
                  </td>
                  <td>Cereals</td>
                  <td>Anjar</td>
                  <td class="price">₹ 2,150</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧂</span>Salt (Sea)</div>
                  </td>
                  <td>Commodity</td>
                  <td>Bhachau</td>
                  <td class="price">₹ 800</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat</div>
                  </td>
                  <td>Cereals</td>
                  <td>Rapar</td>
                  <td class="price">₹ 2,720</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.9%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥭</span>Mango (Kesar)</div>
                  </td>
                  <td>Fruits</td>
                  <td>Mandvi</td>
                  <td class="price">₹ 8,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +12.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">⚓</span>Fish (Marine)</div>
                  </td>
                  <td>Seafood</td>
                  <td>Mundra</td>
                  <td class="price">₹ 15,000</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.2%</span></td>
               </tr>
               <!-- Mahisagar -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Lunawada</td>
                  <td class="price">₹ 2,180</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🫘</span>Tuver</div>
                  </td>
                  <td>Pulses</td>
                  <td>Virpur</td>
                  <td class="price">₹ 6,700</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.1%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat</div>
                  </td>
                  <td>Cereals</td>
                  <td>Balasinor</td>
                  <td class="price">₹ 2,680</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.7%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Santrampur</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Jowar</div>
                  </td>
                  <td>Cereals</td>
                  <td>Khanpur</td>
                  <td class="price">₹ 2,800</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.4%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Kadana</td>
                  <td class="price">₹ 7,300</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.8%</span></td>
               </tr>
               <!-- Mehsana -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥛</span>Dairy (Milk)</div>
                  </td>
                  <td>Dairy</td>
                  <td>Mehsana</td>
                  <td class="price">₹ 4,600</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.3%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Bajra</div>
                  </td>
                  <td>Cereals</td>
                  <td>Vijapur</td>
                  <td class="price">₹ 2,250</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +3.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Mustard</div>
                  </td>
                  <td>Oilseeds</td>
                  <td>Kadi</td>
                  <td class="price">₹ 5,100</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🧅</span>Onion</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Vadnagar</td>
                  <td class="price">₹ 2,020</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +4.5%</span></td>
               </tr>
               <!-- Navsari -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍃</span>Tea (Green Leaf)</div>
                  </td>
                  <td>Plantation</td>
                  <td>Navsari (Viraval)</td>
                  <td class="price">₹ 2,000</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.6%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana</div>
                  </td>
                  <td>Fruits</td>
                  <td>Bilimora</td>
                  <td class="price">₹ 2,700</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥭</span>Mango (Hapus)</div>
                  </td>
                  <td>Fruits</td>
                  <td>Chikhli</td>
                  <td class="price">₹ 9,000</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +5.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Vansda</td>
                  <td class="price">₹ 2,280</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.9%</span></td>
               </tr>
               <!-- Panchmahal -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Godhra</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Derol</td>
                  <td class="price">₹ 2,150</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.6%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Ghogamba</td>
                  <td class="price">₹ 7,100</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.2%</span></td>
               </tr>
               <!-- Rajkot -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥜</span>Groundnut</div>
                  </td>
                  <td>Oilseeds</td>
                  <td>Rajkot</td>
                  <td class="price">₹ 5,900</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.9%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Gondal</td>
                  <td class="price">₹ 7,250</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.3%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Bajra</div>
                  </td>
                  <td>Cereals</td>
                  <td>Jasdan</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌶️</span>Chili</div>
                  </td>
                  <td>Spices</td>
                  <td>Dhoraji</td>
                  <td class="price">₹ 8,000</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -3.0%</span></td>
               </tr>
               <!-- Sabarkantha -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Himatnagar</td>
                  <td class="price">₹ 2,190</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Wheat</div>
                  </td>
                  <td>Cereals</td>
                  <td>Talod</td>
                  <td class="price">₹ 2,700</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.3%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🪵</span>Teak Wood</div>
                  </td>
                  <td>Forest</td>
                  <td>Idar</td>
                  <td class="price">₹ 25,000 (per ton)</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Isabgol</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Khedbrahma</td>
                  <td class="price">₹ 9,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +3.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🫘</span>Mung Bean</div>
                  </td>
                  <td>Pulses</td>
                  <td>Prantij</td>
                  <td class="price">₹ 6,300</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Mustard</div>
                  </td>
                  <td>Oilseeds</td>
                  <td>Bayad</td>
                  <td class="price">₹ 5,050</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🪵</span>Bamboo</div>
                  </td>
                  <td>Forest</td>
                  <td>Modasa</td>
                  <td class="price">₹ 1,500 (per piece)</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Bhiloda</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.4%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Jowar</div>
                  </td>
                  <td>Cereals</td>
                  <td>Meghraj</td>
                  <td class="price">₹ 2,750</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.5%</span></td>
               </tr>
               <!-- Surat -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana</div>
                  </td>
                  <td>Fruits</td>
                  <td>Surat</td>
                  <td class="price">₹ 2,650</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍃</span>Sugarcane</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Bardoli</td>
                  <td class="price">₹ 350</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Mahuva</td>
                  <td class="price">₹ 2,250</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥥</span>Coconut</div>
                  </td>
                  <td>Fruits</td>
                  <td>Mandvi</td>
                  <td class="price">₹ 2,100 (per 100)</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍂</span>Teak Wood</div>
                  </td>
                  <td>Forest</td>
                  <td>Vyara</td>
                  <td class="price">₹ 26,000 (per ton)</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.2%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Songadh</td>
                  <td class="price">₹ 2,200</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.7%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Nizar</td>
                  <td class="price">₹ 2,180</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.3%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Uchhal</td>
                  <td class="price">₹ 2,120</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +3.1%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍅</span>Tomato</div>
                  </td>
                  <td>Vegetables</td>
                  <td>Valod</td>
                  <td class="price">₹ 1,550</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +4.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Kosamba</td>
                  <td class="price">₹ 2,300</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.2%</span></td>
               </tr>
               <!-- Surendranagar -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌵</span>Castor Seed</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Chotila</td>
                  <td class="price">₹ 5,350</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +0.8%</span></td>
               </tr>
               <!-- Vadodara -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Vadodara</td>
                  <td class="price">₹ 2,280</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana</div>
                  </td>
                  <td>Fruits</td>
                  <td>Daboi</td>
                  <td class="price">₹ 2,500</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.6%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Maize</div>
                  </td>
                  <td>Cereals</td>
                  <td>Savli</td>
                  <td class="price">₹ 2,150</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌱</span>Cotton</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Bodeli</td>
                  <td class="price">₹ 7,000</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -2.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌽</span>Jowar</div>
                  </td>
                  <td>Cereals</td>
                  <td>Chhotaudepur</td>
                  <td class="price">₹ 2,800</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.5%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Shinor</td>
                  <td class="price">₹ 2,220</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -0.2%</span></td>
               </tr>
               <!-- Valsad -->
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🥭</span>Mango (Alphonso)</div>
                  </td>
                  <td>Fruits</td>
                  <td>Valsad (Dhamdachi)</td>
                  <td class="price">₹ 9,500</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +6.0%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍌</span>Banana</div>
                  </td>
                  <td>Fruits</td>
                  <td>Pardi</td>
                  <td class="price">₹ 2,600</td>
                  <td><span class="trend trend-down"><i class="fas fa-arrow-trend-down"></i> -1.4%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🍃</span>Sugarcane</div>
                  </td>
                  <td>Cash Crops</td>
                  <td>Dharampur</td>
                  <td class="price">₹ 340</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +1.8%</span></td>
               </tr>
               <tr>
                  <td>
                     <div class="crop-name"><span class="crop-icon">🌾</span>Paddy</div>
                  </td>
                  <td>Cereals</td>
                  <td>Kaprada</td>
                  <td class="price">₹ 2,150</td>
                  <td><span class="trend trend-up"><i class="fas fa-arrow-trend-up"></i> +2.1%</span></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>

   <?php include 'footer.php'; ?>

</body>

</html>