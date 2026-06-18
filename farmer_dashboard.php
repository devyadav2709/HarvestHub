<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
include "php/db.php";

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit();
}

$current_farmer_id = (int) $_SESSION['user_id'];

// ─── Handle POST actions ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    if (isset($_POST['accept_bid'])) {
        $product_id = (int) $_POST['product_id'];
        $check = $conn->prepare("SELECT id FROM products WHERE id = ? AND (user_id = ? OR farmer_id = ?)");
        $check->bind_param("iii", $product_id, $current_farmer_id, $current_farmer_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $upd = $conn->prepare("UPDATE products SET is_sold = 1, status = 'sold' WHERE id = ?");
            $upd->bind_param("i", $product_id);
            $upd->execute();
            $upd->close();
        }
        $check->close();
        header("Location: farmer_dashboard.php?msg=accepted");
        exit;
    }

    if (isset($_POST['delete_product'])) {
        $prod_id = (int) $_POST['prod_id'];
        $del = $conn->prepare("DELETE FROM products WHERE id = ? AND (user_id = ? OR farmer_id = ?)");
        $del->bind_param("iii", $prod_id, $current_farmer_id, $current_farmer_id);
        $del->execute();
        $del->close();
        header("Location: farmer_dashboard.php?msg=deleted");
        exit;
    }
}

// ─── A. Pending Bids ─────────────────────────────────────────────────────────
// Show every pending bid (is_highest=1) — one row per bid, not one per product
$bids_sql = "SELECT b.id AS bid_id, b.bid_amount, p.id AS product_id, p.name AS product_name, p.image,
                    u.name AS bidder_name, n.id AS notification_id
             FROM bids b
             JOIN products p ON b.product_id = p.id
             JOIN users u ON b.user_id = u.id
             LEFT JOIN notifications n ON n.product_id = p.id AND (n.is_read = 0 OR n.is_read IS NULL)
             WHERE (p.user_id = ? OR p.farmer_id = ?)
               AND p.status = 'active'
               AND p.is_sold = 0
               AND b.is_highest = 1
             ORDER BY b.id DESC";
$stmt = $conn->prepare($bids_sql);
$stmt->bind_param("ii", $current_farmer_id, $current_farmer_id);
$stmt->execute();
$bids = $stmt->get_result();
$pending_bids_count = $bids->num_rows;
$stmt->close();

// ─── B. Inventory list (for the cards at bottom) ─────────────────────────────
$inv_stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ? OR farmer_id = ? ORDER BY id DESC");
$inv_stmt->bind_param("ii", $current_farmer_id, $current_farmer_id);
$inv_stmt->execute();
$inventory = $inv_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$inventory_count = count($inventory);
$inv_stmt->close();

// ─── C. Total Profits ────────────────────────────────────────────────────────
$prof_stmt = $conn->prepare(
    "SELECT COALESCE(SUM(b.bid_amount), 0) AS total_profits
     FROM bids b
     JOIN products p ON b.product_id = p.id
     WHERE (p.user_id = ? OR p.farmer_id = ?) AND p.is_sold = 1 AND b.is_highest = 1"
);
$prof_stmt->bind_param("ii", $current_farmer_id, $current_farmer_id);
$prof_stmt->execute();
$total_profits = $prof_stmt->get_result()->fetch_assoc()['total_profits'];
$prof_stmt->close();

// ─── D. Bid History — every bid on every product owned by this farmer ─────────
//   Ordered oldest-to-newest per product so the chart line flows left → right
$hist_stmt = $conn->prepare(
    "SELECT
        b.id           AS bid_id,
        b.bid_amount,
        b.bid_time,
        b.is_highest,
        b.is_winner,
        u.name         AS bidder_name,
        p.id           AS product_id,
        p.name         AS product_name,
        p.base_price,
        p.quantity,
        p.image,
        p.is_sold,
        p.status,
        p.bid_end,
        p.created_at   AS product_created
     FROM bids b
     JOIN products p ON b.product_id = p.id
     JOIN users u     ON b.user_id   = u.id
     WHERE (p.user_id = ? OR p.farmer_id = ?)
     ORDER BY p.id DESC, b.bid_time ASC"
);
$hist_stmt->bind_param("ii", $current_farmer_id, $current_farmer_id);
$hist_stmt->execute();
$hist_result = $hist_stmt->get_result();
$hist_stmt->close();

// Group bids under each product_id key
$bid_history = [];
while ($hrow = $hist_result->fetch_assoc()) {
    $pid = $hrow['product_id'];
    if (!isset($bid_history[$pid])) {
        $bid_history[$pid] = [
            'product_name' => $hrow['product_name'],
            'base_price' => (float) $hrow['base_price'],
            'quantity' => (float) $hrow['quantity'],
            'image' => $hrow['image'],
            'is_sold' => (int) $hrow['is_sold'],
            'status' => $hrow['status'],
            'bid_end' => $hrow['bid_end'],
            'product_created' => $hrow['product_created'],
            'bids' => [],
        ];
    }
    $bid_history[$pid]['bids'][] = [
        'bid_id' => (int) $hrow['bid_id'],
        'amount' => (float) $hrow['bid_amount'],
        'time' => $hrow['bid_time'],
        'bidder' => $hrow['bidder_name'],
        'is_highest' => (int) $hrow['is_highest'],
        'is_winner' => (int) $hrow['is_winner'],
    ];
}

// Build chart JSON (sent to JS): base price point + every bid in time order
$chart_datasets = [];
foreach ($bid_history as $cpid => $cph) {
    $base_total = $cph['base_price'] * $cph['quantity'];
    $labels = ['Base'];
    $amounts = [$base_total];
    foreach ($cph['bids'] as $cb) {
        $labels[] = date('d M H:i', strtotime($cb['time']));
        $amounts[] = round($cb['amount'], 2);
    }
    $chart_datasets[$cpid] = [
        'labels' => $labels,
        'data' => $amounts,
        'base' => $base_total,
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard | Harvest Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2e7d32;
            --dark: #1b5e20;
            --light: #f4f7f6;
            --text: #333;
            --accent: #fbc02d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin-top: 70px;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(46, 125, 50, .2);
            position: sticky;
            top: 90px;
        }

        .user-avatar {
            font-size: 3rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, .9);
        }

        .sidebar-stat {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: .88rem;
        }

        .btn-add-crop {
            background: white;
            color: var(--primary);
            padding: 11px 18px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            margin-top: 18px;
            transition: .3s;
            display: block;
            border: none;
            width: 100%;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: .9rem;
        }

        .btn-add-crop:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .2);
            color: var(--primary);
        }

        /* ── Generic dashboard card ── */
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .05);
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 1.35rem;
            color: var(--dark);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge-count {
            background: var(--accent);
            color: #000;
            font-size: .82rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 700;
        }

        /* ── Profit banner ── */
        .profit-card {
            background: linear-gradient(135deg, #051e06, #125b16);
            color: white;
            border-radius: 15px;
            padding: 28px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(76, 175, 80, .3);
            text-align: center;
        }

        .profit-amount {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 8px;
            text-shadow: 0 3px 8px rgba(0, 0, 0, .2);
        }

        /* ── Pending bid cards ── */
        .bid-card {
            background: linear-gradient(135deg, #fff8e1, #fff3e0);
            border: 1px solid #ffe0b2;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 14px;
            transition: .3s;
        }

        .bid-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(255, 152, 0, .15);
        }

        .bid-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: #e65100;
        }

        .bid-product-img {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .1);
        }

        .btn-accept {
            background: var(--primary);
            color: white;
            border: none;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-accept:hover {
            background: var(--dark);
        }

        .btn-wait {
            background: #e0e0e0;
            color: #555;
            border: none;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-wait:hover {
            background: #bdbdbd;
        }

        /* ── Inventory cards ── */
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .06);
            border: 1px solid #eee;
            height: 100%;
            transition: .3s;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        .product-img {
            width: 100%;
            height: 165px;
            object-fit: cover;
            border-bottom: 2px solid #f5f5f5;
            display: block;
        }

        .product-body {
            padding: 16px;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .73rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-active {
            background: #e8f5e9;
            color: var(--primary);
        }

        .status-sold {
            background: #ffebee;
            color: #d32f2f;
        }

        .btn-delete {
            background: #ffebee;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 600;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            cursor: pointer;
            transition: .3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-delete:hover {
            background: #d32f2f;
            color: white;
        }

        /* ── Flash alert ── */
        .alert-flash {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            min-width: 260px;
            animation: slideIn .3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ══════════════════════════════════════════════════════
           BID HISTORY — dedicated full-width section
        ══════════════════════════════════════════════════════ */

        /* Tab pills — one per product */
        .hist-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .hist-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0f4f0;
            border: 1.5px solid #c8e6c9;
            color: var(--primary);
            font-size: .8rem;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 30px;
            cursor: pointer;
            transition: .25s;
            white-space: nowrap;
            font-family: 'Poppins', sans-serif;
        }

        .hist-tab:hover {
            background: #dcedc8;
        }

        .hist-tab.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .hist-tab .tab-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #81c784;
            flex-shrink: 0;
        }

        .hist-tab.active .tab-dot {
            background: rgba(255, 255, 255, .65);
        }

        .hist-tab .tab-count {
            font-size: .72rem;
            opacity: .75;
        }

        /* Panes */
        .hist-pane {
            display: none;
        }

        .hist-pane.active {
            display: block;
            animation: fadeUp .3s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Product info strip */
        .prod-info-strip {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #f7faf7;
            border: 1px solid #dcedc8;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .prod-info-strip img {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #c8e6c9;
            flex-shrink: 0;
        }

        .prod-info-name {
            font-weight: 700;
            font-size: .95rem;
            color: var(--dark);
        }

        .prod-info-meta {
            font-size: .76rem;
            color: #888;
            margin-top: 2px;
        }

        /* 4-box summary stats */
        .hist-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .hist-stat {
            background: #f7faf7;
            border: 1px solid #e4ede4;
            border-radius: 12px;
            padding: 14px 10px;
            text-align: center;
        }

        .hist-stat.green {
            background: #e8f5e9;
            border-color: #a5d6a7;
        }

        .hist-stat.yellow {
            background: #fff8e1;
            border-color: #ffe082;
        }

        .hist-stat .sv {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.2;
        }

        .hist-stat .sl {
            font-size: .7rem;
            color: #888;
            margin-top: 3px;
        }

        /* Chart area */
        .hist-chart-box {
            background: #fafcfa;
            border: 1px solid #e4ede4;
            border-radius: 12px;
            padding: 16px 16px 10px;
            margin-bottom: 20px;
            height: 210px;
            position: relative;
        }

        .chart-legend {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .chart-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .72rem;
            color: #666;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Timeline */
        .tl-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .tl-title {
            font-size: .83rem;
            font-weight: 700;
            color: var(--dark);
        }

        .tl-count {
            font-size: .72rem;
            color: #aaa;
        }

        .tl-scroll {
            max-height: 360px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .tl-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .tl-scroll::-webkit-scrollbar-thumb {
            background: #c8e6c9;
            border-radius: 4px;
        }

        .tl {
            position: relative;
            padding-left: 28px;
        }

        .tl::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary), #c8e6c9);
        }

        .tl-item {
            position: relative;
            margin-bottom: 13px;
        }

        .tl-dot {
            position: absolute;
            left: -22px;
            top: 6px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .tl-dot.d-base {
            background: #bdbdbd;
            box-shadow: 0 0 0 2px #bdbdbd;
        }

        .tl-dot.d-normal {
            background: #81c784;
            box-shadow: 0 0 0 2px #81c784;
        }

        .tl-dot.d-top {
            background: var(--primary);
            box-shadow: 0 0 0 2px var(--primary);
        }

        .tl-dot.d-winner {
            background: var(--accent);
            box-shadow: 0 0 0 2px var(--accent);
        }

        .tl-card {
            background: #f9fafb;
            border: 1px solid #e4ede4;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .82rem;
        }

        .tl-card.c-base {
            background: #f5f5f5;
            border-color: #e0e0e0;
        }

        .tl-card.c-top {
            background: #fff8e1;
            border-color: #ffe082;
        }

        .tl-card.c-winner {
            background: #e8f5e9;
            border-color: #a5d6a7;
        }

        .tl-bidder {
            font-weight: 700;
            color: #333;
        }

        .tl-amount {
            font-weight: 800;
            color: #e65100;
            font-size: .94rem;
        }

        .tl-delta {
            font-size: .68rem;
            color: #43a047;
        }

        .tl-rate {
            font-size: .72rem;
            background: rgba(0, 0, 0, .05);
            padding: 2px 7px;
            border-radius: 8px;
            color: #555;
        }

        .tl-time {
            font-size: .7rem;
            color: #bbb;
        }

        .badge-winner {
            background: var(--accent);
            color: #000;
            font-size: .62rem;
            padding: 2px 7px;
            border-radius: 8px;
            font-weight: 700;
            vertical-align: middle;
        }

        .badge-top {
            background: #fff3e0;
            color: #e65100;
            font-size: .62rem;
            padding: 2px 7px;
            border-radius: 8px;
            font-weight: 700;
            border: 1px solid #ffe0b2;
            vertical-align: middle;
        }

        /* No bids */
        .hist-empty {
            text-align: center;
            padding: 40px 20px;
            color: #bbb;
        }

        .hist-empty i {
            font-size: 2.8rem;
            opacity: .3;
            margin-bottom: 12px;
            display: block;
        }

        /* General empty */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #888;
        }

        .empty-state i {
            font-size: 4rem;
            opacity: .3;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                position: static;
                margin-bottom: 25px;
            }
        }

        @media (max-width: 768px) {
            .hist-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .hist-chart-box {
                height: 175px;
            }
        }

        @media (max-width: 480px) {
            .hist-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .profit-amount {
                font-size: 2.3rem;
            }
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible alert-flash" role="alert">
            <?php echo $_GET['msg'] === 'accepted' ? '✅ Bid accepted! Product marked as sold.' : '🗑️ Product deleted successfully.'; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="container py-4">
        <div class="row">

            <!-- ═══════ SIDEBAR ═══════ -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="sidebar">
                    <div class="user-avatar"><i class="fas fa-user-circle"></i></div>
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($_SESSION['name']); ?></h5>
                    <p class="opacity-75 mb-4" style="font-size:.82rem;">Farmer Account</p>
                    <div class="mb-4">
                        <div class="sidebar-stat"><span>Pending
                                Bids</span><strong><?php echo $pending_bids_count; ?></strong></div>
                        <div class="sidebar-stat"><span>My
                                Products</span><strong><?php echo $inventory_count; ?></strong></div>
                        <div class="sidebar-stat"><span>Total
                                Earnings</span><strong>₹<?php echo number_format($total_profits, 0); ?></strong></div>
                    </div>
                    <a href="add_product.php" class="btn-add-crop">
                        <i class="fas fa-plus me-2"></i>Add New Crop
                    </a>
                </div>
            </div>

            <!-- ═══════ MAIN ═══════ -->
            <div class="col-lg-9 col-md-8">

                <!-- Profit banner -->
                <div class="profit-card">
                    <div style="font-size:2.8rem;margin-bottom:14px;opacity:.85;"><i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="profit-amount">₹<?php echo number_format($total_profits, 2); ?></div>
                    <div style="font-size:1.05rem;opacity:.9;margin-bottom:4px;">Total Farm Earnings</div>
                    <div style="font-size:.82rem;opacity:.7;"><i class="fas fa-info-circle me-1"></i>Sum of highest
                        accepted bids on all sold crops</div>
                </div>

                <!-- ─── PENDING BIDS ─── -->
                <?php if ($pending_bids_count > 0): ?>
                    <div class="dashboard-card">
                        <div class="section-title">
                            <div><i class="fas fa-bell text-warning me-2"></i>Pending Bids <span
                                    class="badge-count ms-2"><?php echo $pending_bids_count; ?></span></div>
                        </div>
                        <?php while ($row = $bids->fetch_assoc()): ?>
                            <div class="bid-card d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="bid-product-img"
                                        onerror="this.onerror=null;this.src='https://placehold.co/56x56/e8f5e9/2e7d32?text=Crop'">
                                    <div>
                                        <div class="fw-bold" style="font-size:.92rem;">
                                            <?php echo htmlspecialchars($row['product_name']); ?>
                                        </div>
                                        <div class="text-muted" style="font-size:.8rem;"><i
                                                class="fas fa-user me-1"></i><?php echo htmlspecialchars($row['bidder_name']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bid-price">₹<?php echo number_format($row['bid_amount'], 2); ?></div>
                                    <div class="d-flex gap-2">
                                        <form method="post"
                                            onsubmit="return confirm('Accept ₹<?php echo number_format($row['bid_amount'], 2); ?> for <?php echo addslashes(htmlspecialchars($row['product_name'])); ?>?');">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            <button type="submit" name="accept_bid" class="btn-accept"><i
                                                    class="fas fa-check me-1"></i>Accept</button>
                                        </form>
                                        <?php if (!empty($row['notification_id'])): ?>
                                            <form action="wait_bid.php" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="notification_id"
                                                    value="<?php echo $row['notification_id']; ?>">
                                                <button type="submit" class="btn-wait"><i
                                                        class="fas fa-clock me-1"></i>Wait</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <!-- ══════════════════════════════════════════════
                     BID HISTORY SECTION
                ══════════════════════════════════════════════ -->
                <div class="dashboard-card">
                    <div class="section-title">
                        <div>
                            <i class="fas fa-chart-line text-success me-2"></i>
                            <b>Bid History</b>
                            <span class="badge-count ms-2"><?php echo $inventory_count; ?>
                                crop<?php echo $inventory_count != 1 ? 's' : ''; ?></span>
                        </div>
                        <small class="text-muted" style="font-size:.76rem;font-weight:400;">Select a crop tab to view
                            its complete bid journey</small>
                    </div>

                    <?php if ($inventory_count > 0): ?>

                        <!-- ── Crop selector tabs ── -->
                        <div class="hist-tabs">
                            <?php foreach ($inventory as $i => $p):
                                $pid = $p['id'];
                                $bid_count = isset($bid_history[$pid]) ? count($bid_history[$pid]['bids']) : 0;
                                ?>
                                <button class="hist-tab <?php echo $i === 0 ? 'active' : ''; ?>"
                                    onclick="switchTab(<?php echo $pid; ?>, this)" id="htab-<?php echo $pid; ?>">
                                    <span class="tab-dot"></span>
                                    <?php echo htmlspecialchars($p['name']); ?>
                                    <span class="tab-count">(<?php echo $bid_count; ?>)</span>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- ── One pane per crop ── -->
                        <?php foreach ($inventory as $i => $p):
                            $pid = $p['id'];
                            $has_bids = !empty($bid_history[$pid]);
                            $ph = $has_bids ? $bid_history[$pid] : null;
                            $base_total = (float) $p['base_price'] * (float) $p['quantity'];
                            ?>
                            <div class="hist-pane <?php echo $i === 0 ? 'active' : ''; ?>" id="hpane-<?php echo $pid; ?>">

                                <!-- Product info strip -->
                                <div class="prod-info-strip">
                                    <img src="images/<?php echo htmlspecialchars($p['image']); ?>"
                                        onerror="this.onerror=null;this.src='https://placehold.co/54x54/e8f5e9/2e7d32?text=Crop'"
                                        style="width:54px;height:54px;border-radius:10px;object-fit:cover;border:2px solid #c8e6c9;flex-shrink:0;background:#e8f5e9;">
                                    <div class="flex-grow-1">
                                        <div class="prod-info-name"><?php echo htmlspecialchars($p['name']); ?></div>
                                        <div class="prod-info-meta">
                                            Base ₹<?php echo number_format($p['base_price'], 2); ?>/kg
                                            &nbsp;·&nbsp; <?php echo number_format($p['quantity'], 1); ?> kg
                                            &nbsp;·&nbsp; Total base value ₹<?php echo number_format($base_total, 2); ?>
                                            &nbsp;·&nbsp; Listed <?php echo date('d M Y', strtotime($p['created_at'])); ?>
                                            <?php if ($p['bid_end']): ?>
                                                &nbsp;·&nbsp; Bid ends <?php echo date('d M Y, h:i A', strtotime($p['bid_end'])); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <span class="status-badge <?php echo $p['is_sold'] ? 'status-sold' : 'status-active'; ?>">
                                        <?php echo $p['is_sold'] ? 'SOLD' : strtoupper($p['status']); ?>
                                    </span>
                                </div>

                                <?php if ($has_bids):
                                    $bids_arr = $ph['bids'];
                                    $amounts = array_column($bids_arr, 'amount');
                                    $highest = max($amounts);
                                    $lowest = min($amounts);
                                    $total_bids = count($bids_arr);
                                    $per_kg_top = $p['quantity'] > 0 ? $highest / $p['quantity'] : 0;
                                    $growth_pct = $base_total > 0 ? (($highest - $base_total) / $base_total * 100) : 0;
                                    ?>

                                    <!-- 4 stat boxes -->
                                    <div class="hist-stats">
                                        <div class="hist-stat">
                                            <div class="sv"><?php echo $total_bids; ?></div>
                                            <div class="sl">Total Bids</div>
                                        </div>
                                        <div class="hist-stat green">
                                            <div class="sv">₹<?php echo number_format($highest, 2); ?></div>
                                            <div class="sl">Highest Bid</div>
                                        </div>
                                        <div class="hist-stat yellow">
                                            <div class="sv">₹<?php echo number_format($per_kg_top, 2); ?></div>
                                            <div class="sl">Best Rate /kg</div>
                                        </div>
                                        <div class="hist-stat <?php echo $growth_pct >= 0 ? 'green' : ''; ?>">
                                            <div class="sv"
                                                style="color:<?php echo $growth_pct >= 0 ? 'var(--primary)' : '#d32f2f'; ?>">
                                                <?php echo ($growth_pct >= 0 ? '+' : '') . number_format($growth_pct, 1); ?>%
                                            </div>
                                            <div class="sl">Growth vs Base</div>
                                        </div>
                                    </div>

                                    <!-- Line chart: base price → every bid over time -->
                                    <div class="hist-chart-box">
                                        <canvas id="chart-<?php echo $pid; ?>"></canvas>
                                    </div>
                                    <div class="chart-legend mb-3">
                                        <div class="chart-legend-item">
                                            <div class="legend-dot" style="background:#bdbdbd;"></div>Base Price
                                        </div>
                                        <div class="chart-legend-item">
                                            <div class="legend-dot" style="background:#2e7d32;"></div>Bid
                                        </div>
                                        <div class="chart-legend-item">
                                            <div class="legend-dot" style="background:#fbc02d;"></div>Highest Bid
                                        </div>
                                    </div>

                                    <!-- Timeline — newest bid at top -->
                                    <div class="tl-header">
                                        <span class="tl-title"><i class="fas fa-history me-1"></i>All Bids — newest first</span>
                                        <span class="tl-count"><?php echo $total_bids; ?>
                                            bid<?php echo $total_bids !== 1 ? 's' : ''; ?></span>
                                    </div>
                                    <div class="tl-scroll">
                                        <div class="tl">

                                            <?php
                                            $reversed = array_reverse($bids_arr);   // newest first
                                            foreach ($reversed as $idx => $b):
                                                $per_kg = $p['quantity'] > 0 ? $b['amount'] / $p['quantity'] : 0;
                                                $is_win = (int) $b['is_winner'];
                                                $is_top = (int) $b['is_highest'];
                                                $dot_cls = $is_win ? 'd-winner' : ($is_top ? 'd-top' : 'd-normal');
                                                $card_cls = $is_win ? 'c-winner' : ($is_top ? 'c-top' : '');
                                                // delta vs the previous bid in chronological order
                                                $chron_idx = $total_bids - 1 - $idx;   // index in $bids_arr (oldest→newest)
                                                $prev_amount = $chron_idx > 0 ? $bids_arr[$chron_idx - 1]['amount'] : $base_total;
                                                $delta = $b['amount'] - $prev_amount;
                                                ?>
                                                <div class="tl-item">
                                                    <div class="tl-dot <?php echo $dot_cls; ?>"></div>
                                                    <div class="tl-card <?php echo $card_cls; ?>">
                                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                                            <div>
                                                                <span
                                                                    class="tl-bidder"><?php echo htmlspecialchars($b['bidder']); ?></span>
                                                                <?php if ($is_win): ?>
                                                                    <span class="badge-winner ms-1">🏆 WINNER</span>
                                                                <?php elseif ($is_top): ?>
                                                                    <span class="badge-top ms-1">⬆ CURRENT TOP</span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="text-end">
                                                                <div class="tl-amount">₹<?php echo number_format($b['amount'], 2); ?>
                                                                </div>
                                                                <?php if ($delta > 0): ?>
                                                                    <div class="tl-delta">+₹<?php echo number_format($delta, 2); ?> above
                                                                        prev</div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-1">
                                                            <span class="tl-rate">₹<?php echo number_format($per_kg, 2); ?>/kg</span>
                                                            <span class="tl-time"><i
                                                                    class="far fa-clock me-1"></i><?php echo date('d M Y, h:i A', strtotime($b['time'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            <!-- Base price anchor (bottom of timeline) -->
                                            <div class="tl-item">
                                                <div class="tl-dot d-base"></div>
                                                <div class="tl-card c-base">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span style="color:#999;"><i class="fas fa-tag me-1"></i>Your Base
                                                            Price</span>
                                                        <strong>₹<?php echo number_format($base_total, 2); ?></strong>
                                                    </div>
                                                    <div style="font-size:.72rem;color:#aaa;margin-top:4px;">
                                                        ₹<?php echo number_format($p['base_price'], 2); ?>/kg
                                                        &times; <?php echo number_format($p['quantity'], 1); ?> kg
                                                    </div>
                                                </div>
                                            </div>

                                        </div><!-- .tl -->
                                    </div><!-- .tl-scroll -->

                                <?php else: /* no bids on this product */ ?>
                                    <div class="hist-empty">
                                        <i class="fas fa-gavel"></i>
                                        <div style="font-size:.92rem;font-weight:600;margin-bottom:6px;color:#999;">No bids placed
                                            yet on this crop</div>
                                        <div style="font-size:.8rem;">
                                            Base value: <strong
                                                style="color:var(--dark);">₹<?php echo number_format($base_total, 2); ?></strong>
                                            &nbsp;(₹<?php echo number_format($p['base_price'], 2); ?>/kg ×
                                            <?php echo number_format($p['quantity'], 1); ?> kg)
                                        </div>
                                        <?php if ($p['bid_end']): ?>
                                            <div style="font-size:.75rem;color:#ccc;margin-top:6px;">
                                                Bidding open until <?php echo date('d M Y, h:i A', strtotime($p['bid_end'])); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            </div><!-- .hist-pane -->
                        <?php endforeach; ?>

                    <?php else: ?>
                        <div class="hist-empty">
                            <i class="fas fa-seedling"></i>
                            <div>No products listed yet. <a href="add_product.php" style="color:var(--primary);">Add your
                                    first crop</a> to start receiving bids.</div>
                        </div>
                    <?php endif; ?>
                </div><!-- BID HISTORY card -->

                <!-- ─── MY CROPS INVENTORY ─── -->
                <div class="dashboard-card">
                    <div class="section-title">
                        <div><i class="fas fa-boxes text-success me-2"></i><b>My Crops Inventory</b> <span
                                class="badge-count ms-2"><?php echo $inventory_count; ?></span></div>
                    </div>
                    <?php if ($inventory_count > 0): ?>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            <?php foreach ($inventory as $prod): ?>
                                <div class="col">
                                    <div class="product-card">
                                        <img src="images/<?php echo htmlspecialchars($prod['image']); ?>" class="product-img"
                                            onerror="this.onerror=null;this.src='https://placehold.co/300x165/e8f5e9/2e7d32?text=No+Image'">
                                        <div class="product-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="fw-bold mb-0" style="font-size:.92rem;">
                                                    <?php echo htmlspecialchars($prod['name']); ?>
                                                </h6>
                                                <span
                                                    class="status-badge <?php echo $prod['is_sold'] ? 'status-sold' : 'status-active'; ?>">
                                                    <?php echo $prod['is_sold'] ? 'SOLD' : 'ACTIVE'; ?>
                                                </span>
                                            </div>
                                            <div
                                                style="color:var(--primary);font-weight:700;font-size:.92rem;margin-bottom:5px;">
                                                Base: ₹<?php echo number_format($prod['total_value'], 2); ?>
                                            </div>
                                            <div class="text-muted small mb-3">
                                                <i
                                                    class="far fa-calendar me-1"></i><?php echo date('d M Y', strtotime($prod['created_at'])); ?>
                                            </div>
                                            <form method="post"
                                                onsubmit="return confirm('Delete <?php echo addslashes(htmlspecialchars($prod['name'])); ?>? This cannot be undone.');">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="prod_id" value="<?php echo $prod['id']; ?>">
                                                <button type="submit" name="delete_product" class="btn-delete">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-seedling mb-3 d-block"></i>
                            <h5 class="mb-2">No Crops Yet</h5>
                            <p class="mb-4">You haven't added any crops to your inventory.</p>
                            <a href="add_product.php" class="btn btn-success px-4"><i class="fas fa-plus me-2"></i>Add Your
                                First Crop</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div><!-- col main -->
        </div><!-- row -->
    </div><!-- container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart data built by PHP — keyed by product_id
        const chartData = <?php echo json_encode($chart_datasets); ?>;
        const chartInstances = {};

        // ── Switch between crop tabs ────────────────────────────────────────────────
        function switchTab(pid, btn) {
            document.querySelectorAll('.hist-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.hist-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('hpane-' + pid).classList.add('active');
            drawChart(pid);
        }

        // ── Draw (or skip if already drawn) a chart for a product ──────────────────
        function drawChart(pid) {
            if (chartInstances[pid]) return;
            const canvas = document.getElementById('chart-' + pid);
            if (!canvas || !chartData[pid]) return;

            const d = chartData[pid];
            const base = d.base;
            const maxVal = Math.max(...d.data);
            const minVal = Math.min(...d.data);

            chartInstances[pid] = new Chart(canvas, {
                type: 'line',
                data: {
                    labels: d.labels,
                    datasets: [{
                        label: 'Bid Amount (₹)',
                        data: d.data,
                        borderColor: '#2e7d32',
                        backgroundColor: function (ctx) {
                            const chart = ctx.chart;
                            const { ctx: c, chartArea } = chart;
                            if (!chartArea) return 'rgba(46,125,50,0.07)';
                            const grad = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            grad.addColorStop(0, 'rgba(46,125,50,0.18)');
                            grad.addColorStop(1, 'rgba(46,125,50,0.01)');
                            return grad;
                        },
                        // colour each point: grey=base, gold=highest, green=normal
                        pointBackgroundColor: d.data.map((v, i) =>
                            i === 0 ? '#bdbdbd'
                                : v === maxVal ? '#fbc02d'
                                    : '#2e7d32'
                        ),
                        pointRadius: d.data.map((v, i) =>
                            i === 0 ? 5 : v === maxVal ? 9 : 5
                        ),
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        borderWidth: 2.5,
                        tension: 0.38,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 650, easing: 'easeInOutQuart' },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1b5e20',
                            titleFont: { family: 'Poppins', size: 11 },
                            bodyFont: { family: 'Poppins', size: 12 },
                            padding: 10,
                            callbacks: {
                                title: (items) => items[0].label,
                                label: (item) => {
                                    const v = item.parsed.y;
                                    const delta = v - base;
                                    const pct = base > 0 ? ((delta / base) * 100).toFixed(1) : 0;
                                    const lines = [' ₹' + v.toLocaleString('en-IN', { minimumFractionDigits: 2 })];
                                    if (delta > 0) lines.push(' +' + pct + '% above base price');
                                    return lines;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { font: { size: 9, family: 'Poppins' }, maxRotation: 35, color: '#999' },
                            grid: { display: false }
                        },
                        y: {
                            ticks: {
                                font: { size: 9, family: 'Poppins' },
                                color: '#999',
                                callback: v =>
                                    v >= 10000000 ? '₹' + (v / 10000000).toFixed(1) + 'Cr'
                                        : v >= 100000 ? '₹' + (v / 100000).toFixed(1) + 'L'
                                            : v >= 1000 ? '₹' + (v / 1000).toFixed(1) + 'k'
                                                : '₹' + v
                            },
                            grid: { color: 'rgba(0,0,0,0.04)' }
                        }
                    }
                }
            });
        }

        // Draw chart for whichever pane is active on first load
        document.addEventListener('DOMContentLoaded', () => {
            const active = document.querySelector('.hist-pane.active');
            if (active) drawChart(parseInt(active.id.replace('hpane-', '')));
        });
    </script>

    <?php include "footer.php"; ?>
</body>

</html>