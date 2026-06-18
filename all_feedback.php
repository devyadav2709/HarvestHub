<?php
include "php/db.php";

// Ensure session is started safely
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

// 1. Determine Active Tab (Default: Farmers)
$active_tab = isset($_GET['tab']) && $_GET['tab'] == 'consumers' ? 'consumers' : 'farmers';
$role_query = ($active_tab == 'farmers') ? 'farmer' : 'consumer';

// 2. Fetch ALL reviews for the selected role (No Limit)
$sql = "SELECT * FROM feedbacks WHERE role='$role_query' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total_reviews = mysqli_num_rows($result);

// Helper: Render Stars
function renderStars($rating)
{
   $stars = "";
   for ($i = 0; $i < $rating; $i++) {
      $stars .= '<i class="fas fa-star"></i>';
   }
   for ($i = $rating; $i < 5; $i++) {
      $stars .= '<i class="far fa-star" style="opacity:0.3"></i>';
   }
   return $stars;
}

// Helper: Format Date
function formatDate($date_string)
{
   return date("d M Y", strtotime($date_string));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Stories | Harvest Hub</title>

   <!-- Bootstrap CSS -->
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
         --white: #ffffff;
         --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         --text-dark: #333;
      }

      body,
      h1,
      h2,
      h3,
      p,
      button,
      input,
      a {
         font-family: 'Poppins', sans-serif;
      }

      body {
         background-color: var(--light-bg);
         margin: 0;
         color: var(--text-dark);
         line-height: 1.6;
      }

      /* Page Header */
      .page-header {
         background: var(--dark);
         color: white;
         padding: 80px 20px 50px;
         text-align: center;
         margin-bottom: 40px;
      }

      @media (max-width: 768px) {
         .page-header {
            padding: 60px 15px 40px;
         }

         .page-header h1 {
            font-size: 1.8rem;
         }
      }

      .back-link {
         color: rgba(255, 255, 255, 0.7);
         text-decoration: none;
         font-weight: 600;
         font-size: 0.9rem;
         display: inline-block;
         margin-bottom: 15px;
         transition: 0.3s;
      }

      .back-link:hover {
         color: var(--accent);
      }

      /* Review Card */
      .review-card {
         background: var(--white);
         padding: 25px;
         border-radius: 15px;
         box-shadow: var(--shadow);
         border: 1px solid rgba(0, 0, 0, 0.03);
         transition: 0.3s;
         height: 100%;
         position: relative;
      }

      .review-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      }

      .review-date {
         position: absolute;
         top: 20px;
         right: 20px;
         font-size: 0.75rem;
         color: #999;
         font-weight: 500;
      }

      .user-profile {
         display: flex;
         align-items: center;
         gap: 15px;
         margin-bottom: 15px;
      }

      .avatar {
         width: 50px;
         height: 50px;
         background: #f0f0f0;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: bold;
         color: var(--dark);
         font-size: 1.2rem;
         flex-shrink: 0;
      }

      .role-badge {
         font-size: 0.7rem;
         padding: 3px 10px;
         border-radius: 20px;
         text-transform: uppercase;
         font-weight: 700;
         margin-top: 5px;
         display: inline-block;
      }

      .badge-farmer {
         background: #fffde7;
         color: #f57f17;
         border: 1px solid #fff9c4;
      }

      .badge-consumer {
         background: #e3f2fd;
         color: #1565c0;
         border: 1px solid #bbdefb;
      }

      .stars {
         color: var(--accent);
         font-size: 0.9rem;
         margin-top: 5px;
      }

      .review-text {
         font-style: italic;
         color: #555;
         font-size: 0.95rem;
         line-height: 1.6;
         margin-bottom: 0;
      }

      /* Toggle buttons */
      .toggle-switch {
         background: #e0e0e0;
         border-radius: 50px;
         padding: 5px;
         display: flex;
         box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
         width: fit-content;
         margin: 0 auto;
      }

      .toggle-btn {
         padding: 10px 25px;
         border-radius: 50px;
         font-weight: 600;
         color: #666;
         text-decoration: none;
         transition: 0.3s;
         display: flex;
         align-items: center;
         gap: 8px;
         font-size: 0.95rem;
      }

      .toggle-btn.active {
         background: var(--primary);
         color: white;
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      }

      .toggle-btn:hover:not(.active) {
         background: rgba(255, 255, 255, 0.5);
         color: var(--primary);
         text-decoration: none;
      }

      /* Mobile adjustments */
      @media (max-width: 576px) {
         .toggle-btn {
            padding: 8px 15px;
            font-size: 0.85rem;
         }

         .review-card {
            padding: 20px;
         }

         .user-profile {
            gap: 12px;
         }

         .avatar {
            width: 45px;
            height: 45px;
            font-size: 1rem;
         }

         .review-text {
            font-size: 0.9rem;
         }
      }

      @media (max-width: 400px) {
         .toggle-switch {
            flex-direction: column;
            width: 100%;
            max-width: 250px;
            padding: 10px;
            gap: 10px;
            background: transparent;
            box-shadow: none;
         }

         .toggle-btn {
            width: 100%;
            justify-content: center;
            background: #e0e0e0;
            margin: 0;
         }

         .toggle-btn.active {
            background: var(--primary);
         }
      }
   </style>
</head>

<body>

   <?php include "navbar.php"; ?>

   <div class="page-header">
      <div class="container">
         <a href="about.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Stories
         </a>
         <h1 class="display-5 fw-bold mb-3">Community Voices 💬</h1>
         <p class="lead opacity-75">Read every story from our network.</p>
      </div>
   </div>

   <div class="container mb-5">
      <div class="row mb-4">
         <div class="col-12 text-center">
            <div class="toggle-switch">
               <a href="?tab=farmers" class="toggle-btn <?php echo ($active_tab == 'farmers') ? 'active' : ''; ?>">
                  <i class="fas fa-tractor"></i> Farmers
               </a>
               <a href="?tab=consumers" class="toggle-btn <?php echo ($active_tab == 'consumers') ? 'active' : ''; ?>">
                  <i class="fas fa-shopping-basket"></i> Consumers
               </a>
            </div>
            <p class="text-muted mt-3">
               <i class="fas fa-chart-bar me-2"></i>
               Showing <?php echo $total_reviews; ?> <?php echo $active_tab; ?> reviews
            </p>
         </div>
      </div>

      <?php if ($total_reviews > 0): ?>
         <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($row = mysqli_fetch_assoc($result)):
               // Style logic based on role
               $initial = strtoupper(substr($row['name'], 0, 1));
               $badgeClass = ($row['role'] == 'farmer') ? 'badge-farmer' : 'badge-consumer';
               $avatarColor = ($row['role'] == 'farmer') ? '' : 'color: #1565c0; background: #e3f2fd;';
               ?>
               <div class="col">
                  <div class="review-card">
                     <span class="review-date"><?php echo formatDate($row['created_at']); ?></span>

                     <div class="user-profile">
                        <div class="avatar" style="<?php echo $avatarColor; ?>"><?php echo $initial; ?></div>
                        <div>
                           <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></div>
                           <span class="role-badge <?php echo $badgeClass; ?>">
                              <?php echo htmlspecialchars($row['location']); ?>
                           </span>
                           <div class="stars"><?php echo renderStars($row['rating']); ?></div>
                        </div>
                     </div>
                     <p class="review-text">"<?php echo htmlspecialchars($row['review']); ?>"</p>
                  </div>
               </div>
            <?php endwhile; ?>
         </div>
      <?php else: ?>
         <div class="row">
            <div class="col-12">
               <div class="text-center py-5 my-5">
                  <i class="far fa-comment-dots fa-4x text-muted mb-4"></i>
                  <h3 class="text-muted mb-3">No stories found yet</h3>
                  <p class="text-muted mb-4">There are no stories for this category yet.</p>
                  <a href="feedback.php" class="btn btn-success px-4 py-2">
                     <i class="fas fa-plus-circle me-2"></i>Be the first to share!
                  </a>
               </div>
            </div>
         </div>
      <?php endif; ?>

      <!-- Back to top button -->
      <div class="row mt-5">
         <div class="col-12 text-center">
            <a href="#" class="btn btn-outline-success" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
               <i class="fas fa-arrow-up me-2"></i>Back to Top
            </a>
         </div>
      </div>
   </div>

   <!-- Bootstrap JS Bundle -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <?php include "footer.php"; ?>

</body>

</html>