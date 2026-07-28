<?php
include "php/db.php";

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 1. LOGIC: Fetch "Winning Bids" (If User is Consumer) ---
$winnings = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'consumer') {
    $my_id = $_SESSION['user_id'];

    $win_sql = "SELECT p.*, b.bid_amount 
                FROM products p 
                JOIN bids b ON p.id = b.product_id 
                WHERE b.user_id = '$my_id' 
                AND p.is_sold = 1 
                AND b.is_highest = 1
                AND NOT EXISTS (
                    SELECT 1 FROM purchases pur 
                    WHERE pur.product_id = p.id 
                    AND pur.user_id = '$my_id'
                )
                ORDER BY p.id DESC";

    $winnings = mysqli_query($conn, $win_sql);
}

// --- 2. LOGIC: Search Functionality ---
$search_term = "";
$search_sql = "";
$is_searching = false;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_sql = " AND (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%') ";
    $is_searching = true;
}

// --- 3. LOGIC: Standard Product Limit ---
$limit_query = "LIMIT 6";
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'consumer') {
    $limit_query = "";
}

// --- 4. DATA: Fetch Active AND Sold Market Products ---
$query_sql = "
    SELECT p.*,
           (SELECT MAX(bid_amount) 
            FROM bids 
            WHERE product_id = p.id) AS highest_bid
    FROM products p
    WHERE p.status = 'active'
    $search_sql
    ORDER BY p.is_sold ASC, p.id DESC
    $limit_query
";

$products = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="en" class="is-loading">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest Hub - Premium Agricultural Auction Platform</title>
    <meta name="description"
        content="Direct farm-to-buyer sourcing with transparent bidding. Fresh quality from verified farmers.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Changa+One&display=swap"
        rel="stylesheet">

    <style>
        /* ============================================
           HARVEST HUB — Premium Modern Design
           Enhanced: Glassmorphism, Advanced Animations, 
           Smooth Interactions, Professional UI/UX
           ============================================ */

        :root {
            --font-display: 'Changa One', sans-serif;
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Noto Sans, 'Helvetica Neue', Noto Sans, sans-serif;
            --soil: #0a1f14;
            --forest: #1a4d2e;
            --leaf: #2d6a4f;
            --leaf-bright: #40916c;
            --leaf-light: #52b788;
            --gold: #f4a261;
            --gold-soft: #f8c471;
            --gold-deep: #e07a3f;
            --terracotta: #d62828;
            --terracotta-deep: #a41e34;
            --cream: #fefdf9;
            --cream-deep: #f8f6f1;
            --ink: #1a1a1a;
            --ink-soft: #6b7280;
            --paper: #ffffff;

            --glass: rgba(255, 255, 255, 0.08);
            --glass-strong: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-dark: rgba(10, 31, 20, 0.4);

            --line: rgba(42, 106, 79, 0.12);
            --line-light: rgba(42, 106, 79, 0.08);

            --shadow-sm: 0 2px 8px rgba(10, 31, 20, 0.08);
            --shadow-md: 0 8px 24px rgba(10, 31, 20, 0.12);
            --shadow-lg: 0 16px 48px rgba(10, 31, 20, 0.16);
            --shadow-xl: 0 24px 64px rgba(10, 31, 20, 0.2);
            --shadow-glow: 0 0 24px rgba(244, 162, 97, 0.15);

            --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
            --ease-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
            --ease-standard: cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body,
        button,
        input,
        select,
        textarea {
            font-family: var(--font-body);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-display);
            font-weight: 400;
        }

        html,
        body {
            background-color: var(--cream);
            color: var(--ink);
            line-height: 1.6;
            overflow-x: hidden;
            max-width: 100vw;
            scroll-behavior: smooth;
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
                scroll-behavior: auto !important;
            }

            #splash {
                display: none !important;
            }

            html.is-loading,
            html.is-loading body {
                overflow: auto !important;
                height: auto !important;
            }

            .parallax-section {
                background-attachment: scroll !important;
            }
        }

        /* Premium grain texture overlay */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='150'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23grain)' opacity='0.08'/%3E%3C/svg%3E");
            mix-blend-mode: overlay;
        }

        /* ============================================
           SPLASH / ANIMATED LOADING SCREEN
           ============================================ */
        html.is-loading,
        html.is-loading body {
            overflow: hidden;
            height: 100%;
        }

        #splash {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a1f14 0%, #1a4d2e 50%, #0a1f14 100%);
            overflow: hidden;
            transition: opacity 0.8s var(--ease-smooth), visibility 0.8s var(--ease-smooth);
        }

        #splash.splash-hide {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .splash-curtain {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 50%;
            background: linear-gradient(135deg, #0a1f14 0%, #1a4d2e 100%);
            z-index: 2;
            transition: transform 1s var(--ease-smooth);
        }

        .splash-curtain.left {
            left: 0;
        }

        .splash-curtain.right {
            right: 0;
        }

        #splash.splash-hide .splash-curtain.left {
            transform: translateX(-100%);
        }

        #splash.splash-hide .splash-curtain.right {
            transform: translateX(100%);
        }

        .splash-content {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        #splash.splash-hide .splash-content {
            opacity: 0;
            transform: scale(0.92);
        }

        .splash-particles {
            position: absolute;
            inset: 0;
            z-index: 1;
            overflow: hidden;
            pointer-events: none;
        }

        .splash-particles span {
            position: absolute;
            bottom: -10%;
            opacity: 0;
            font-size: 1.3rem;
            animation: splashFloat 5.5s linear infinite;
        }

        .splash-particles span:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
        }

        .splash-particles span:nth-child(2) {
            left: 25%;
            animation-delay: 1.2s;
            font-size: 0.95rem;
        }

        .splash-particles span:nth-child(3) {
            left: 45%;
            animation-delay: 0.6s;
        }

        .splash-particles span:nth-child(4) {
            left: 65%;
            animation-delay: 1.8s;
            font-size: 1.1rem;
        }

        .splash-particles span:nth-child(5) {
            left: 85%;
            animation-delay: 1s;
        }

        @keyframes splashFloat {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            15% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-110vh) rotate(240deg);
                opacity: 0;
            }
        }

        .splash-mark {
            width: 100px;
            height: 100px;
            margin-bottom: 28px;
            position: relative;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.3));
        }

        .splash-mark svg {
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        .splash-seed {
            transform-origin: 50% 92%;
            animation: seedSettle 0.7s var(--ease-bounce) both;
        }

        @keyframes seedSettle {
            from {
                transform: translateY(-18px) scale(0.5);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .splash-stem {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: growStem 1s var(--ease-smooth) 0.5s forwards;
        }

        @keyframes growStem {
            to {
                stroke-dashoffset: 0;
            }
        }

        .splash-leaf-l,
        .splash-leaf-r {
            transform-origin: 50% 100%;
            opacity: 0;
            animation: unfurl 0.7s var(--ease-bounce) forwards;
        }

        .splash-leaf-l {
            animation-delay: 1.15s;
            transform: scale(0) rotate(-35deg);
        }

        .splash-leaf-r {
            animation-delay: 1.32s;
            transform: scale(0) rotate(35deg);
        }

        @keyframes unfurl {
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        .splash-wordmark {
            font-family: var(--font-display);
            font-size: 2.4rem;
            font-weight: 400;
            color: #ffffff;
            letter-spacing: -0.8px;
            opacity: 0;
            animation: scaleIn 0.8s var(--ease-bounce) 1.5s forwards;
        }

        .splash-wordmark em {
            font-style: italic;
            color: var(--gold-soft);
            font-weight: 600;
        }

        .splash-tagline {
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 10px;
            opacity: 0;
            animation: scaleIn 0.8s var(--ease-bounce) 1.7s forwards;
        }

        .splash-bar-track {
            width: 200px;
            height: 4px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.15);
            margin-top: 36px;
            overflow: hidden;
            opacity: 0;
            animation: scaleIn 0.6s var(--ease-smooth) 1.55s forwards;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .splash-bar-fill {
            height: 100%;
            width: 0%;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--leaf-bright), var(--gold-soft));
            animation: splashProgress 2s var(--ease-smooth) 0.4s forwards;
            box-shadow: 0 0 12px rgba(244, 162, 97, 0.4);
        }

        @keyframes splashProgress {
            0% {
                width: 0%;
            }

            60% {
                width: 82%;
            }

            100% {
                width: 100%;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* ============================================
           HERO SECTION — Cinematic Animated Hero
           ============================================ */
        .hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 100px 20px 60px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            margin-bottom: 0;
            overflow: hidden;
            isolation: isolate;
            background: linear-gradient(135deg, #0a1f14 0%, #1a4d2e 50%, #0a1f14 100%);
        }

        .hero-cover-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            object-fit: cover;
            animation: kenBurns 30s ease-in-out infinite alternate;
        }

        @keyframes kenBurns {
            from {
                transform: scale(1) translateX(0);
            }

            to {
                transform: scale(1.12) translateX(2%);
            }
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg,
                    rgba(10, 31, 20, 0.88) 0%,
                    rgba(16, 41, 29, 0.52) 35%,
                    rgba(16, 41, 29, 0.62) 65%,
                    rgba(10, 31, 20, 0.92) 100%);
            backdrop-filter: blur(0px);
        }

        .hero-particles {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .hero-particles span {
            position: absolute;
            bottom: -8%;
            font-size: 1.5rem;
            opacity: 0;
            animation: floatUp 14s linear infinite;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
        }

        .hero-particles span:nth-child(1) {
            left: 8%;
            animation-delay: 0s;
        }

        .hero-particles span:nth-child(2) {
            left: 22%;
            animation-delay: 2.8s;
            font-size: 1rem;
        }

        .hero-particles span:nth-child(3) {
            left: 40%;
            animation-delay: 5.6s;
        }

        .hero-particles span:nth-child(4) {
            left: 62%;
            animation-delay: 1.4s;
            font-size: 1.2rem;
        }

        .hero-particles span:nth-child(5) {
            left: 78%;
            animation-delay: 8.4s;
        }

        .hero-particles span:nth-child(6) {
            left: 92%;
            animation-delay: 4.2s;
            font-size: 0.95rem;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            8% {
                opacity: 0.6;
            }

            92% {
                opacity: 0.4;
            }

            100% {
                transform: translateY(-125vh) rotate(360deg);
                opacity: 0;
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 1.2s var(--ease-smooth) 0.3s forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--glass-strong);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 24px;
            opacity: 0;
            animation: slideDown 0.9s var(--ease-smooth) 0.2s forwards;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-eyebrow .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--gold-soft);
            box-shadow: 0 0 0 0 rgba(248, 196, 113, 0.8);
            animation: pulseDot 2.2s ease-out infinite;
        }

        @keyframes pulseDot {
            0% {
                box-shadow: 0 0 0 0 rgba(248, 196, 113, 0.8);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(248, 196, 113, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(248, 196, 113, 0);
            }
        }

        .hero h1 {
            font-size: clamp(2.8rem, 7vw, 4.8rem);
            margin: 0 0 16px;
            font-weight: 400;
            letter-spacing: -1.8px;
            text-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
            opacity: 0;
            animation: slideDown 1s var(--ease-smooth) 0.35s forwards;
            line-height: 1.1;
        }

        .hero h1 em {
            font-style: italic;
            color: var(--gold-soft);
            font-weight: 400;
            display: inline-block;
            animation: popIn 0.8s var(--ease-bounce) 0.6s forwards;
            opacity: 0;
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.8) rotate(-10deg);
            }

            to {
                opacity: 1;
                transform: scale(1) rotate(0);
            }
        }

        .hero p.tagline {
            font-size: 1.2rem;
            font-weight: 400;
            max-width: 600px;
            opacity: 0;
            color: rgba(255, 255, 255, 0.95);
            margin: 0 0 40px;
            animation: slideDown 1s var(--ease-smooth) 0.5s forwards;
            letter-spacing: 0.3px;
        }

        .search-container {
            width: 100%;
            max-width: 650px;
            position: relative;
            opacity: 0;
            animation: slideDown 1s var(--ease-smooth) 0.65s forwards;
        }

        .search-form {
            display: flex;
            background: var(--paper);
            border-radius: 60px;
            padding: 8px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25), inset 0 1px 2px rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.4s var(--ease-smooth);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .search-form:focus-within {
            transform: translateY(-4px);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.3), inset 0 1px 2px rgba(255, 255, 255, 0.5);
            border-color: rgba(244, 162, 97, 0.4);
        }

        .search-input {
            flex: 1;
            min-width: 0;
            border: none;
            padding: 16px 28px;
            border-radius: 60px;
            font-size: 1.05rem;
            outline: none;
            text-overflow: ellipsis;
            background: transparent;
            font-family: var(--font-body);
            color: var(--ink);
            font-weight: 500;
        }

        .search-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .search-btn {
            background: linear-gradient(135deg, var(--leaf), var(--leaf-bright));
            color: white;
            border: none;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s var(--ease-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(45, 106, 79, 0.3);
        }

        .search-btn:hover {
            background: linear-gradient(135deg, var(--soil), var(--leaf));
            transform: scale(1.1) rotate(-8deg);
            box-shadow: 0 12px 28px rgba(45, 106, 79, 0.4);
        }

        .search-btn:active {
            transform: scale(0.98) rotate(-8deg);
        }

        .hero-scroll-cue {
            position: absolute;
            left: 50%;
            bottom: 32px;
            transform: translateX(-50%);
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            opacity: 0;
            animation: slideDown 0.8s var(--ease-smooth) 1.1s forwards;
            cursor: pointer;
        }

        .hero-scroll-cue span {
            font-size: 0.75rem;
            letter-spacing: 2.5px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
        }

        .hero-scroll-cue .mouse {
            width: 24px;
            height: 38px;
            border: 2.5px solid rgba(255, 255, 255, 0.6);
            border-radius: 16px;
            position: relative;
            animation: bounce 2.2s ease-in-out infinite;
        }

        .hero-scroll-cue .mouse::before {
            content: "";
            position: absolute;
            top: 8px;
            left: 50%;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--gold-soft);
            transform: translateX(-50%);
            animation: scrollWheel 1.8s ease-in-out infinite;
            box-shadow: 0 0 8px rgba(248, 196, 113, 0.6);
        }

        @keyframes scrollWheel {
            0% {
                opacity: 1;
                top: 8px;
            }

            70% {
                opacity: 0;
                top: 22px;
            }

            100% {
                opacity: 0;
                top: 8px;
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(8px);
            }
        }

        /* ============================================
           GLASS STATS STRIP
           ============================================ */
        .stats-strip {
            position: relative;
            z-index: 4;
            max-width: 1200px;
            margin: -60px auto 80px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-box {
            background: var(--paper);
            border: 1px solid rgba(10, 31, 20, 0.06);
            border-radius: 24px;
            padding: 28px 20px;
            text-align: center;
            box-shadow: 0 16px 40px rgba(10, 31, 20, 0.18), 0 2px 8px rgba(10, 31, 20, 0.06);
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            animation: slideUp 0.7s var(--ease-bounce) forwards;
            transition: all 0.4s var(--ease-smooth);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .stat-box::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(248, 196, 113, 0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes shimmer {

            0%,
            100% {
                transform: translate(0, 0);
                opacity: 0;
            }

            50% {
                transform: translate(20px, -20px);
                opacity: 1;
            }
        }

        .stat-box:nth-child(1) {
            animation-delay: 0.2s;
        }

        .stat-box:nth-child(2) {
            animation-delay: 0.35s;
        }

        .stat-box:nth-child(3) {
            animation-delay: 0.5s;
        }

        .stat-box:nth-child(4) {
            animation-delay: 0.65s;
        }

        .stat-box:hover {
            transform: translateY(-8px) scale(1.02);
            background: var(--paper);
            border-color: rgba(244, 162, 97, 0.4);
            box-shadow: 0 20px 48px rgba(244, 162, 97, 0.2), 0 2px 8px rgba(10, 31, 20, 0.08);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .stat-box .stat-num {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 400;
            color: var(--soil);
            line-height: 1;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, var(--soil), var(--leaf));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-box .stat-label {
            font-size: 0.8rem;
            color: var(--ink-soft);
            font-weight: 600;
            letter-spacing: 0.4px;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 968px) {
            .stats-strip {
                grid-template-columns: repeat(2, 1fr);
                margin-top: -50px;
                gap: 16px;
            }
        }

        @media (max-width: 640px) {
            .stats-strip {
                grid-template-columns: repeat(2, 1fr);
                margin-top: -40px;
                gap: 12px;
            }

            .stat-box {
                padding: 20px 14px;
            }

            .stat-box .stat-num {
                font-size: 1.8rem;
            }

            .stat-box .stat-label {
                font-size: 0.7rem;
            }
        }

        /* ============================================
           SECTION TITLES WITH ANIMATIONS
           ============================================ */
        .section-title {
            text-align: center;
            margin: 90px 0 50px;
            font-weight: 400;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            color: var(--soil);
            position: relative;
            letter-spacing: -0.6px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.8s var(--ease-smooth) forwards;
        }

        .section-title .sub {
            display: block;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--leaf-bright);
            margin-bottom: 12px;
            opacity: 0.8;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--gold), var(--gold-soft));
            margin: 18px auto 0;
            border-radius: 3px;
            opacity: 0;
            animation: expandWidth 0.8s var(--ease-smooth) 0.4s forwards;
            box-shadow: 0 2px 8px rgba(244, 162, 97, 0.3);
        }

        @keyframes expandWidth {
            from {
                width: 0;
                opacity: 0;
            }

            to {
                width: 80px;
                opacity: 1;
            }
        }

        /* ============================================
           REVEAL & SCROLL ANIMATIONS
           ============================================ */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s var(--ease-smooth), transform 0.8s var(--ease-smooth);
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ============================================
           PRODUCT GRID & CARDS
           ============================================ */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 32px;
            max-width: 1400px;
            margin: 0 auto 70px;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .product-card {
            background: var(--paper);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.5s var(--ease-smooth);
            display: flex;
            flex-direction: column;
            border: 1.5px solid var(--line);
            position: relative;
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            animation: cardBloom 0.7s var(--ease-bounce) forwards;
            cursor: pointer;
        }

        @keyframes cardBloom {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .products .product-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .products .product-card:nth-child(2) {
            animation-delay: 0.15s;
        }

        .products .product-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .products .product-card:nth-child(4) {
            animation-delay: 0.25s;
        }

        .products .product-card:nth-child(5) {
            animation-delay: 0.3s;
        }

        .products .product-card:nth-child(6) {
            animation-delay: 0.35s;
        }

        .products .product-card:nth-child(n+7) {
            animation-delay: 0.4s;
        }

        .product-card:hover {
            transform: translateY(-16px) scale(1.01);
            box-shadow: var(--shadow-xl);
            border-color: var(--gold);
        }

        .product-card:hover .card-img-wrap img {
            transform: scale(1.12);
        }

        .product-card:hover .badge-category {
            animation: bounce 0.4s var(--ease-bounce);
        }

        .card-img-wrap {
            position: relative;
            overflow: hidden;
            height: 240px;
            background: linear-gradient(135deg, #f5f5f5, #e5e5e5);
        }

        .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s var(--ease-smooth);
            display: block;
        }

        .card-img-wrap::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.4), transparent 50%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s var(--ease-smooth);
        }

        .product-card:hover .card-img-wrap::after {
            opacity: 1;
        }

        .badge-pill {
            position: absolute;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            z-index: 3;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            text-transform: uppercase;
        }

        .badge-category {
            top: 14px;
            right: 14px;
            background: rgba(244, 162, 97, 0.95);
            color: #3a2c05;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s var(--ease-smooth);
        }

        .badge-status {
            top: 14px;
            left: 14px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .badge-status.active {
            background: rgba(64, 145, 108, 0.95);
        }

        .badge-status.active .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fff;
            animation: pulseDot 1.6s ease-out infinite;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
        }

        .badge-status.sold {
            background: rgba(214, 40, 40, 0.95);
        }

        .badge-won {
            top: 16px;
            right: 16px;
            background: linear-gradient(135deg, var(--gold), var(--gold-soft));
            color: #3a2c05;
            font-weight: 800;
            z-index: 10;
            border: none;
            box-shadow: 0 6px 16px rgba(244, 162, 97, 0.3);
            animation: scaleInBounce 0.6s var(--ease-bounce);
        }

        @keyframes scaleInBounce {
            from {
                opacity: 0;
                transform: scale(0) rotate(-45deg);
            }

            to {
                opacity: 1;
                transform: scale(1) rotate(0);
            }
        }

        .card-content {
            padding: 28px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-content h3 {
            margin: 0 0 12px;
            font-size: 1.4rem;
            color: var(--soil);
            font-weight: 400;
            letter-spacing: -0.3px;
        }

        .card-desc {
            color: var(--ink-soft);
            font-size: 0.92rem;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 0.9rem;
            color: var(--ink-soft);
        }

        .meta-row i {
            color: var(--leaf-bright);
            margin-right: 6px;
            font-size: 0.95rem;
        }

        .value-box {
            background: linear-gradient(135deg, rgba(82, 183, 136, 0.1), rgba(64, 145, 108, 0.08));
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 18px;
            text-align: center;
            border: 1.5px solid rgba(64, 145, 108, 0.2);
            transition: all 0.3s var(--ease-smooth);
        }

        .product-card:hover .value-box {
            background: linear-gradient(135deg, rgba(82, 183, 136, 0.15), rgba(64, 145, 108, 0.12));
            border-color: rgba(64, 145, 108, 0.35);
        }

        .value-box .label {
            display: block;
            font-size: 0.75rem;
            color: var(--leaf);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .value-box .amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--soil);
            margin-top: 4px;
        }

        .bid-info {
            background: linear-gradient(135deg, #fffbf0, #fef5e7);
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 20px;
            border-left: 5px solid transparent;
            transition: all 0.3s var(--ease-smooth);
        }

        .bid-info.has-bid {
            border-left-color: var(--terracotta);
            background: linear-gradient(135deg, #fff5f2, #fef0eb);
        }

        .bid-info.won-style {
            border-left-color: var(--gold);
            background: linear-gradient(135deg, #fffbf0, #fef8f2);
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-row .lbl {
            font-size: 0.87rem;
            color: var(--ink-soft);
            font-weight: 600;
        }

        .price-row .lbl i {
            color: var(--terracotta);
            margin-right: 4px;
        }

        .price-row .bid-amt {
            color: var(--terracotta-deep);
            font-weight: 800;
            font-size: 1.3rem;
        }

        .price-row .no-bid {
            color: #9ca3af;
            font-size: 0.92rem;
            font-style: italic;
        }

        .time-row {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .time-row i {
            animation: spin 3s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* BUTTONS */
        .btn-main {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, var(--leaf), var(--leaf-bright));
            color: white;
            padding: 14px 20px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: none;
            width: 100%;
            font-size: 0.98rem;
            position: relative;
            overflow: hidden;
            transition: all 0.35s var(--ease-smooth);
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(45, 106, 79, 0.2);
        }

        .btn-main::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-main:hover::before {
            left: 100%;
        }

        .btn-main:hover:not(:disabled) {
            background: linear-gradient(135deg, var(--soil), var(--leaf));
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(45, 106, 79, 0.35);
        }

        .btn-main:active:not(:disabled) {
            transform: translateY(-2px);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-soft)) !important;
            color: #3a2c05 !important;
            box-shadow: 0 6px 16px rgba(244, 162, 97, 0.25) !important;
        }

        .btn-gold:hover:not(:disabled) {
            background: linear-gradient(135deg, var(--gold-deep), var(--gold)) !important;
            box-shadow: 0 10px 28px rgba(244, 162, 97, 0.4) !important;
            transform: translateY(-4px) scale(1.02);
        }

        .btn-disabled {
            background: #e6e2d8 !important;
            cursor: not-allowed;
            color: #9a9284 !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .btn-sold {
            background: linear-gradient(135deg, var(--terracotta), var(--terracotta-deep)) !important;
            cursor: not-allowed;
            color: white !important;
            box-shadow: none !important;
            opacity: 0.75;
            transform: none !important;
        }

        .farmer-preview {
            background: linear-gradient(135deg, #f0f9f4, #e8f5f0);
            padding: 14px;
            border-radius: 14px;
            text-align: center;
            border: 1.5px dashed rgba(64, 145, 108, 0.3);
        }

        .farmer-preview span {
            color: var(--leaf);
            font-size: 0.87rem;
            font-weight: 600;
        }

        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 100px 20px;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #d8d2c2;
            margin-bottom: 20px;
            display: inline-block;
            animation: sway 3.5s ease-in-out infinite;
        }

        @keyframes sway {

            0%,
            100% {
                transform: rotate(-8deg);
            }

            50% {
                transform: rotate(8deg);
            }
        }

        .empty-state p {
            color: var(--ink-soft);
            font-size: 1.15rem;
        }

        .section-divider {
            margin: 70px auto;
            width: 70%;
            max-width: 900px;
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--line), transparent);
        }

        /* ============================================
           REGISTER CTA SECTION
           ============================================ */
        .register-cta {
            position: relative;
            background: linear-gradient(135deg, var(--soil) 0%, #0d2818 50%, #0a1f14 100%);
            padding: 120px 20px;
            color: white;
            text-align: center;
            margin-top: 100px;
            overflow: hidden;
            border-radius: 0;
        }

        .register-cta::before {
            content: "";
            position: absolute;
            inset: -40%;
            background: radial-gradient(circle at 20% 30%, rgba(82, 183, 136, 0.15), transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(244, 162, 97, 0.12), transparent 55%);
            animation: drift 25s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes drift {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(30px, -30px);
            }
        }

        .register-cta>div {
            position: relative;
            z-index: 2;
        }

        .register-cta i.seedling {
            font-size: 3.8rem;
            color: var(--gold-soft);
            margin-bottom: 24px;
            display: inline-block;
            animation: bounceGrow 2.8s ease-in-out infinite;
        }

        @keyframes bounceGrow {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-12px) scale(1.08);
            }
        }

        .register-cta h3 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 400;
            margin-bottom: 20px;
            letter-spacing: -0.6px;
        }

        .register-cta p {
            font-size: 1.15rem;
            margin-bottom: 48px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-btn {
            background: linear-gradient(135deg, var(--gold), var(--gold-soft));
            color: #0d3311;
            padding: 18px 48px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.08rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.4s var(--ease-smooth);
            box-shadow: 0 12px 32px rgba(244, 162, 97, 0.3);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .cta-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.8s;
        }

        .cta-btn:hover::before {
            left: 100%;
        }

        .cta-btn:hover {
            background: linear-gradient(135deg, var(--gold-deep), var(--gold));
            transform: translateY(-6px) scale(1.05);
            box-shadow: 0 16px 40px rgba(244, 162, 97, 0.45);
        }

        .cta-btn i {
            transition: transform 0.3s var(--ease-smooth);
        }

        .cta-btn:hover i {
            transform: translateX(6px);
        }

        /* ============================================
           RESPONSIVE DESIGN
           ============================================ */
        @media (max-width: 768px) {
            .hero {
                min-height: 85vh;
                min-height: 85svh;
                padding: 80px 20px 45px;
            }

            .hero h1 {
                font-size: clamp(2.2rem, 5.5vw, 3.5rem);
            }

            .hero p.tagline {
                font-size: 1rem;
                margin-bottom: 30px;
            }

            .search-form {
                padding: 6px;
            }

            .search-input {
                padding: 14px 20px;
                font-size: 0.95rem;
            }

            .search-btn {
                width: 50px;
                height: 50px;
                font-size: 1.1rem;
            }

            .stats-strip {
                margin-top: -45px;
                gap: 14px;
            }

            .stat-box {
                padding: 22px 16px;
            }

            .products {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 24px;
                padding: 0 16px;
            }

            .card-content {
                padding: 20px;
            }

            .register-cta {
                padding: 80px 20px;
            }

            .register-cta h3 {
                font-size: clamp(1.6rem, 4vw, 2.2rem);
            }

            .cta-btn {
                padding: 14px 36px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 640px) {
            .hero {
                min-height: 80vh;
                padding: 70px 16px 40px;
            }

            .hero-eyebrow {
                font-size: 0.72rem;
                padding: 8px 16px;
            }

            .hero h1 {
                font-size: clamp(1.8rem, 5vw, 2.6rem);
                margin-bottom: 12px;
            }

            .hero p.tagline {
                font-size: 0.9rem;
                margin-bottom: 24px;
            }

            .search-container {
                max-width: 100%;
            }

            .search-input {
                padding: 12px 16px;
                font-size: 0.9rem;
            }

            .search-btn {
                width: 46px;
                height: 46px;
            }

            .stats-strip {
                grid-template-columns: 1fr 1fr;
                margin-top: -35px;
                gap: 12px;
                margin-bottom: 60px;
            }

            .stat-box {
                padding: 18px 12px;
            }

            .stat-box .stat-num {
                font-size: 1.6rem;
            }

            .stat-box .stat-label {
                font-size: 0.65rem;
            }

            .section-title {
                margin: 70px 0 40px;
                font-size: clamp(1.4rem, 3.5vw, 2rem);
            }

            .products {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 12px;
            }

            .product-card {
                border-radius: 20px;
            }

            .card-img-wrap {
                height: 200px;
            }

            .card-content {
                padding: 16px;
            }

            .card-content h3 {
                font-size: 1.15rem;
                margin-bottom: 8px;
            }

            .card-desc {
                font-size: 0.85rem;
                line-height: 1.5;
                margin-bottom: 12px;
            }

            .register-cta {
                padding: 60px 16px;
            }

            .register-cta i.seedling {
                font-size: 3rem;
                margin-bottom: 16px;
            }

            .register-cta h3 {
                font-size: clamp(1.3rem, 3.5vw, 1.8rem);
                margin-bottom: 12px;
            }

            .register-cta p {
                font-size: 0.95rem;
                margin-bottom: 32px;
            }

            .cta-btn {
                padding: 12px 28px;
                font-size: 0.9rem;
                width: fit-content;
            }
        }

        @supports (padding: max(0px)) {
            .hero {
                padding-left: max(20px, env(safe-area-inset-left));
                padding-right: max(20px, env(safe-area-inset-right));
            }

            .products {
                padding-left: max(20px, env(safe-area-inset-left));
                padding-right: max(20px, env(safe-area-inset-right));
            }
        }
    </style>
</head>

<body>

    <div id="splash" aria-hidden="true">
        <div class="splash-particles">
            <span>🌿</span>
            <span>🍃</span>
            <span>🌾</span>
            <span>🌱</span>
            <span>🍃</span>
        </div>
        <div class="splash-content">
            <div class="splash-mark">
                <svg viewBox="0 0 100 100" fill="none">
                    <line class="splash-stem" x1="50" y1="88" x2="50" y2="38" stroke="currentColor" stroke-width="4"
                        stroke-linecap="round" />
                    <path class="splash-leaf-l" d="M50 55 C 30 50, 18 32, 26 14 C 44 20, 54 38, 50 55 Z"
                        fill="currentColor" />
                    <path class="splash-leaf-r" d="M50 48 C 70 42, 82 26, 76 8 C 58 15, 47 32, 50 48 Z"
                        fill="var(--leaf)" />
                    <ellipse class="splash-seed" cx="50" cy="90" rx="13" ry="9" fill="var(--gold)" />
                </svg>
            </div>
            <div class="splash-wordmark">Harvest Hub</div>
            <div class="splash-tagline">Sourcing Freshness</div>
            <div class="splash-bar-track">
                <div class="splash-bar-fill"></div>
            </div>
        </div>
        <div class="splash-curtain left"></div>
        <div class="splash-curtain right"></div>
    </div>

    <?php include "navbar.php"; ?>

    <div class="hero">
        <img class="hero-cover-img"
            src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1800&q=80"
            alt="Fresh harvested crops at Harvest Hub" loading="eager">
        <div class="hero-particles" aria-hidden="true">
            <span>🌿</span>
            <span>🌾</span>
            <span>🍃</span>
            <span>🌱</span>
            <span>🌾</span>
            <span>🍃</span>
        </div>
        <div class="hero-content">
            <div class="hero-eyebrow"><span class="dot"></span> Live auctions running</div>
            <h1>Harvest Hub</h1>
            <p class="tagline">Direct Farm Sourcing • Transparent Bidding • Fresh Quality</p>
            <div class="search-container">
                <form action="index.php" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input"
                        placeholder="Search onions, wheat, tomatoes..."
                        value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <!-- <div class="hero-scroll-cue" aria-hidden="true">
            <span>SCROLL</span>
            <div class="mouse"></div>
        </div> -->
    </div>

    <div class="stats-strip">
        <div class="stat-box">
            <div class="stat-num">2014</div>
            <div class="stat-label">Serving Farmers</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">100%</div>
            <div class="stat-label">Transparent</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">Direct</div>
            <div class="stat-label">Farm-to-Buyer</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">Live</div>
            <div class="stat-label">Auctions Daily</div>
        </div>
    </div>

    <?php if ($winnings && mysqli_num_rows($winnings) > 0): ?>
        <h2 class="section-title reveal"><span class="sub">Congratulations</span>🏆 Your Successful Bids</h2>
        <div class="products">
            <?php while ($row = mysqli_fetch_assoc($winnings)) { ?>
                <div class="product-card"
                    style="border: 2px solid var(--gold); background: linear-gradient(135deg, #fffbf0, #fef8f2);">
                    <span class="badge-pill badge-won">🏆 WON</span>
                    <div class="card-img-wrap">
                        <img src="images/<?php echo $row['image']; ?>" alt="Product">
                    </div>
                    <div class="card-content">
                        <h3><?php echo $row['name']; ?></h3>
                        <p class="card-desc"><?php echo substr($row['description'], 0, 100); ?>...</p>
                        <div class="bid-info won-style">
                            <small style="color: var(--ink-soft);">Final Price</small>
                            <div style="font-size: 1.6rem; font-weight: 800; color: var(--soil); margin-top: 4px;">
                                ₹<?php echo $row['bid_amount']; ?></div>
                        </div>
                        <a href="payment.php?product_id=<?php echo $row['id']; ?>" class="btn-main btn-gold">Complete
                            Payment</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="section-divider">
    <?php endif; ?>

    <h2 class="section-title reveal">
        <span class="sub"><?php echo $is_searching ? 'Found for you' : 'Fresh from the field'; ?></span>
        <?php echo $is_searching ? 'Search Results' : 'Active Auctions'; ?>
    </h2>

    <div class="products">
        <?php
        if (mysqli_num_rows($products) > 0) {
            while ($row = mysqli_fetch_assoc($products)) {

                // 1. Calculate Total Value
                $calculated_total_value = $row['base_price'] * $row['quantity'];

                // 2. Check Sold Status
                $is_sold = ($row['is_sold'] == 1);

                // 3. Check Bid Time / Expiration Logic
                $is_expired = false;
                $time_display = "Ongoing";
                $time_color = "#40916c";

                if ($is_sold) {
                    $time_display = "Sold Out";
                    $time_color = "#d62828";
                } elseif (!empty($row['bid_end'])) {
                    $end_time = new DateTime($row['bid_end']);
                    $now = new DateTime();

                    if ($now > $end_time) {
                        $is_expired = true;
                        $time_display = "Bidding Closed";
                        $time_color = "#d62828";
                    } else {
                        $time_display = "Ends: " . $end_time->format('d M, h:i A');
                    }
                }

                // Determine Status Badge color and text
                $status_text = $is_sold ? "SOLD" : "ACTIVE";
                ?>

                <div class="product-card">
                    <div class="card-img-wrap">
                        <img src="images/<?php echo $row['image']; ?>" alt="Product Image">

                        <span class="badge-pill badge-category">
                            <?php echo $row['category']; ?>
                        </span>

                        <span class="badge-pill badge-status <?php echo $is_sold ? 'sold' : 'active'; ?>">
                            <?php if (!$is_sold) { ?><span class="live-dot"></span><?php } ?>
                            <?php echo $status_text; ?>
                        </span>
                    </div>

                    <div class="card-content">
                        <h3><?php echo $row['name']; ?></h3>

                        <p class="card-desc">
                            <?php echo substr($row['description'], 0, 120); ?>...
                        </p>

                        <div class="meta-row">
                            <span><i class="fas fa-weight-hanging"></i> <strong>Qty:</strong> <?php echo $row['quantity']; ?>
                                kg</span>
                            <span><i class="fas fa-tag"></i> <strong>Price:</strong>
                                ₹<?php echo $row['base_price']; ?>/kg</span>
                        </div>

                        <div class="value-box">
                            <span class="label">Total Value</span>
                            <span class="amount">₹<?php echo number_format($calculated_total_value, 2); ?></span>
                        </div>

                        <div class="bid-info <?php echo $row['highest_bid'] !== null ? 'has-bid' : ''; ?>">
                            <div class="price-row">
                                <span class="lbl">
                                    <i class="fas fa-gavel"></i> Highest Bid
                                </span>
                                <?php if ($row['highest_bid'] !== null) { ?>
                                    <span class="bid-amt">₹<?php echo number_format($row['highest_bid'], 2); ?></span>
                                <?php } else { ?>
                                    <span class="no-bid">No bids yet</span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="time-row">
                            <i class="far fa-clock" style="color: <?php echo $time_color; ?>;"></i>
                            <span style="color: <?php echo $time_color; ?>;">
                                <?php echo $time_display; ?>
                            </span>
                        </div>

                        <?php
                        // Button Logic
                        if ($is_sold) { ?>
                            <button class="btn-main btn-sold" disabled>Sold Out</button>
                        <?php } elseif ($is_expired) { ?>
                            <button class="btn-main btn-disabled" disabled>Bidding Closed</button>
                        <?php } elseif (!isset($_SESSION['role'])) { ?>
                            <a href="login.php" class="btn-main btn-disabled">Login to Bid</a>
                        <?php } elseif ($_SESSION['role'] === 'consumer') { ?>
                            <a href="place_bid.php?product_id=<?php echo $row['id']; ?>" class="btn-main">Place Bid Now</a>
                        <?php } else { ?>
                            <div class="farmer-preview">
                                <span>Farmer Preview Mode</span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='empty-state'>
                    <i class='fas fa-seedling'></i>
                    <p>No crops found. Check back soon!</p>
                  </div>";
        }
        ?>
    </div>

    <?php if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'consumer'): ?>
        <div class="register-cta">
            <div style="max-width: 700px; margin: 0 auto;">
                <i class="fas fa-hand-holding-seedling seedling"></i>
                <h3>Ready to Support Local Farmers?</h3>
                <p>Join our community and get fresh produce directly from the source with transparent, fair bidding.</p>
                <a href="register.php" class="cta-btn">Create Your Account <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    <?php endif; ?>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============================================
        // SPLASH SCREEN ANIMATION
        // ============================================
        (function () {
            const splash = document.getElementById('splash');
            const htmlEl = document.documentElement;
            if (!splash) {
                htmlEl.classList.remove('is-loading');
                return;
            }

            const MIN_VISIBLE_MS = 2500;
            const start = Date.now();

            function dismiss() {
                const elapsed = Date.now() - start;
                const wait = Math.max(MIN_VISIBLE_MS - elapsed, 0);
                setTimeout(function () {
                    splash.classList.add('splash-hide');
                    htmlEl.classList.remove('is-loading');
                    setTimeout(function () {
                        splash.remove();
                    }, 900);
                }, wait);
            }

            if (document.readyState === 'complete') {
                dismiss();
            } else {
                window.addEventListener('load', dismiss);
                setTimeout(dismiss, 5000);
            }
        })();

        // ============================================
        // SCROLL REVEAL ANIMATIONS
        // ============================================
        (function () {
            const targets = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                targets.forEach(el => el.classList.add('is-visible'));
                return;
            }

            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -80px 0px'
            });

            targets.forEach(el => io.observe(el));
        })();

        // ============================================
        // SMOOTH SCROLL
        // ============================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // ============================================
        // PARALLAX & MOUSE FOLLOW EFFECTS
        // ============================================
        document.addEventListener('mousemove', (e) => {
            const particles = document.querySelectorAll('.hero-particles span, .splash-particles span');
            const mouseX = (e.clientX / window.innerWidth) - 0.5;
            const mouseY = (e.clientY / window.innerHeight) - 0.5;

            particles.forEach((particle, index) => {
                const moveX = mouseX * (20 + index * 5);
                const moveY = mouseY * (20 + index * 5);
                particle.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });

        // ============================================
        // ADAPTIVE PERFORMANCE
        // ============================================
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) {
            document.documentElement.style.scrollBehavior = 'auto';
        }
    </script>
</body>

</html>