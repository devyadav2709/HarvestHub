<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    /* ============================================================
       Harvest Hub — Premium Navbar
       Scoped variables to prevent conflicts with parent pages
    ============================================================ */
    .modern-navbar-scope {
        --nav-primary: #0d3311;
        --nav-primary-light: #1b5e20;
        --nav-accent: #fbbf24;
        --nav-accent-dark: #f59e0b;
        --nav-light: #f8f9fa;
        --nav-text-dark: #212529;
        --nav-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --nav-transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        --nav-spring: all 0.55s cubic-bezier(0.34, 1.56, 0.64, 1);
        --nav-glass-bg: rgba(255, 255, 255, 0.55);
        --nav-glass-border: rgba(255, 255, 255, 0.35);
        --nav-radius: 26px;
        --mx: 50%;
        --my: 50%;
    }

    /* ---------- Outer wrapper: creates the floating stage ---------- */
    .modern-navbar-wrap {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1030;
        display: flex;
        justify-content: center;
        padding: 18px 16px 0;
        pointer-events: none;
        transition: var(--nav-spring);
        font-family: var(--font-body, 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif);
    }

    .modern-navbar-wrap.wrap-scrolled {
        padding-top: 10px;
    }

    /* ---------- Modern Navbar Base (floating glass capsule) ---------- */
    .modern-navbar {
        position: relative;
        pointer-events: auto;
        width: 100%;
        max-width: 1240px;
        background: var(--nav-glass-bg);
        backdrop-filter: blur(18px) saturate(160%);
        -webkit-backdrop-filter: blur(18px) saturate(160%);
        border: 1px solid var(--nav-glass-border);
        border-radius: var(--nav-radius);
        box-shadow: var(--nav-shadow);
        padding: 0.65rem 0.5rem;
        transition: var(--nav-spring);
        overflow: visible;
        isolation: isolate;
    }

    /* Gradient border glow ring */
    .modern-navbar::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: inherit;
        padding: 1px;
        background: linear-gradient(120deg,
                rgba(251, 191, 36, 0.55),
                rgba(255, 255, 255, 0.15) 35%,
                rgba(13, 51, 17, 0.35) 65%,
                rgba(251, 191, 36, 0.5));
        background-size: 240% 240%;
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0.7;
        pointer-events: none;
        animation: navBorderShift 8s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes navBorderShift {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }

    /* Soft aurora glow blobs floating behind the capsule */
    .modern-navbar .nav-aurora {
        position: absolute;
        inset: -40px -10px;
        z-index: -2;
        pointer-events: none;
        overflow: visible;
        filter: blur(30px);
        opacity: 0.55;
    }

    .modern-navbar .nav-aurora span {
        position: absolute;
        border-radius: 50%;
        opacity: 0.5;
        animation: navBlobFloat 14s ease-in-out infinite;
    }

    .modern-navbar .nav-aurora span:nth-child(1) {
        width: 180px;
        height: 90px;
        left: 6%;
        top: -10px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.55), transparent 70%);
        animation-delay: 0s;
    }

    .modern-navbar .nav-aurora span:nth-child(2) {
        width: 220px;
        height: 110px;
        right: 8%;
        top: 0;
        background: radial-gradient(circle, rgba(13, 51, 17, 0.4), transparent 70%);
        animation-delay: -5s;
    }

    .modern-navbar .nav-aurora span:nth-child(3) {
        width: 140px;
        height: 90px;
        left: 45%;
        bottom: -20px;
        background: radial-gradient(circle, rgba(27, 94, 32, 0.35), transparent 70%);
        animation-delay: -9s;
    }

    @keyframes navBlobFloat {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        33% {
            transform: translate(12px, 8px) scale(1.08);
        }

        66% {
            transform: translate(-10px, -6px) scale(0.95);
        }
    }

    /* Faint noise texture for a tactile glass feel */
    .modern-navbar .nav-noise {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        z-index: -1;
        opacity: 0.035;
        pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        mix-blend-mode: overlay;
    }

    .navbar-scrolled {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(22px) saturate(160%);
        -webkit-backdrop-filter: blur(22px) saturate(160%);
        box-shadow: 0 14px 40px rgba(13, 51, 17, 0.14);
        padding: 0.45rem 0.5rem;
    }

    /* ---------- Brand / Logo ---------- */
    .brand-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        opacity: 0;
        animation: navBrandIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s forwards;
    }

    @keyframes navBrandIn {
        from {
            opacity: 0;
            transform: translateX(-14px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .brand-icon {
        position: relative;
        width: 46px;
        height: 46px;
        background: linear-gradient(145deg, var(--nav-accent), var(--nav-accent-dark));
        border-radius: 40% 60% 55% 45% / 45% 40% 60% 55%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--nav-primary);
        font-size: 1.5rem;
        transform: rotate(-5deg);
        transition: var(--nav-spring);
        box-shadow: 0 6px 18px rgba(251, 191, 36, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.6);
        animation: navBlobMorph 9s ease-in-out infinite;
    }

    .brand-icon::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: inherit;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.55), transparent 70%);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: -1;
    }

    @keyframes navBlobMorph {

        0%,
        100% {
            border-radius: 40% 60% 55% 45% / 45% 40% 60% 55%;
        }

        50% {
            border-radius: 55% 45% 40% 60% / 55% 60% 40% 45%;
        }
    }

    .brand-text {
        font-family: var(--font-display, 'Changa One', sans-serif);
        font-weight: 400;
        font-size: 1.75rem;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--nav-primary), var(--nav-primary-light), var(--nav-primary));
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
    }

    .brand-modern:hover .brand-icon {
        transform: rotate(6deg) scale(1.12);
    }

    .brand-modern:hover .brand-icon::after {
        opacity: 1;
    }

    .brand-modern:hover .brand-text {
        background-position: right center;
    }

    /* Compact brand on scroll */
    .navbar-scrolled .brand-icon {
        width: 38px;
        height: 38px;
        font-size: 1.25rem;
    }

    .navbar-scrolled .brand-text {
        font-size: 1.45rem;
    }

    /* ---------- Nav Links ---------- */
    .nav-modern {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        position: relative;
    }

    /* the sliding "magic" highlight that glides between hovered links */
    .nav-hover-pill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        border-radius: 12px;
        background: rgba(13, 51, 17, 0.07);
        opacity: 0;
        transform: translateX(0);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), width 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        pointer-events: none;
        z-index: 0;
    }

    @media (max-width: 991.98px) {
        .nav-hover-pill {
            display: none;
        }
    }

    .nav-link-modern {
        color: var(--nav-text-dark) !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.55rem 1.05rem !important;
        border-radius: 12px;
        transition: color 0.3s ease, transform 0.3s ease;
        position: relative;
        text-decoration: none;
        z-index: 1;
        overflow: hidden;
        isolation: isolate;
    }

    /* light-sweep shimmer on hover */
    .nav-link-modern::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(100deg, transparent 30%, rgba(255, 255, 255, 0.55) 50%, transparent 70%);
        transform: translateX(-120%);
        transition: transform 0.6s ease;
        z-index: -1;
        pointer-events: none;
    }

    .nav-link-modern:hover::before {
        transform: translateX(120%);
    }

    .nav-link-modern i {
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-block;
    }

    .nav-link-modern:hover {
        color: var(--nav-primary) !important;
        transform: translateY(-1px);
    }

    .nav-link-modern:hover i {
        transform: translateY(-2px) scale(1.1);
    }

    .nav-link-modern.active {
        color: var(--nav-primary) !important;
        background: linear-gradient(135deg, rgba(13, 51, 17, 0.1), rgba(251, 191, 36, 0.16));
        font-weight: 600;
        box-shadow: 0 0 0 1px rgba(251, 191, 36, 0.45), 0 6px 16px rgba(251, 191, 36, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.5);
        animation: navActivePulse 3.2s ease-in-out infinite;
    }

    @keyframes navActivePulse {

        0%,
        100% {
            box-shadow: 0 0 0 1px rgba(251, 191, 36, 0.45), 0 6px 16px rgba(251, 191, 36, 0.22), inset 0 1px 1px rgba(255, 255, 255, 0.5);
        }

        50% {
            box-shadow: 0 0 0 1px rgba(251, 191, 36, 0.65), 0 8px 22px rgba(251, 191, 36, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.6);
        }
    }

    /* Role Badges */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--nav-spring);
        border: 2px solid transparent;
    }

    .badge-consumer-modern {
        background: linear-gradient(135deg, #fff8e1, #ffe0b2);
        color: #8d6e00;
        border-color: #ffcc80;
    }

    .badge-farmer-modern {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: var(--nav-primary-light);
        border-color: #81c784;
    }

    .badge-consumer-modern:hover,
    .badge-farmer-modern:hover {
        background: linear-gradient(135deg, var(--nav-primary), var(--nav-primary-light));
        color: white;
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 8px 24px rgba(13, 51, 17, 0.32);
    }

    /* ---------- Premium CTA Buttons ---------- */
    .btn-modern {
        position: relative;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--nav-spring);
        border: 2px solid transparent;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        overflow: hidden;
        isolation: isolate;
    }

    /* mouse-follow glow */
    .btn-modern::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: radial-gradient(120px circle at var(--mx) var(--my), rgba(255, 255, 255, 0.55), transparent 60%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        z-index: 2;
    }

    .btn-modern:hover::before {
        opacity: 1;
    }

    .btn-modern .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.55);
        transform: scale(0);
        animation: navRipple 0.6s ease-out forwards;
        pointer-events: none;
        z-index: 3;
    }

    @keyframes navRipple {
        to {
            transform: scale(2.4);
            opacity: 0;
        }
    }

    .btn-login-modern {
        background: rgba(13, 51, 17, 0.04);
        color: var(--nav-primary);
        border-color: var(--nav-primary);
    }

    .btn-login-modern:hover {
        background: var(--nav-primary);
        color: var(--nav-accent);
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(13, 51, 17, 0.35);
    }

    .btn-logout-modern {
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        color: #d32f2f;
        border-color: #ef9a9a;
    }

    .btn-logout-modern:hover {
        background: linear-gradient(135deg, #d32f2f, #b71c1c);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(211, 47, 47, 0.32);
    }

    .btn-admin-modern {
        background: linear-gradient(135deg, var(--nav-accent), var(--nav-accent-dark));
        background-size: 200% auto;
        color: var(--nav-primary);
        border: none;
    }

    .btn-admin-modern:hover {
        background-position: right center;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(251, 191, 36, 0.45);
    }

    /* ---------- Toggler (animated hamburger -> X) ---------- */
    .navbar-toggler-modern {
        border: none;
        padding: 10px;
        border-radius: 12px;
        background: rgba(13, 51, 17, 0.08);
        transition: var(--nav-spring);
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-toggler-modern:hover {
        background: rgba(13, 51, 17, 0.16);
        transform: scale(1.06);
    }

    .navbar-toggler-modern:focus {
        box-shadow: none;
        outline: none;
    }

    .navbar-toggler-modern[aria-expanded="true"] {
        background: rgba(13, 51, 17, 0.2);
    }

    .navbar-toggler-icon-modern {
        position: relative;
        width: 22px;
        height: 16px;
        display: inline-block;
    }

    .navbar-toggler-icon-modern span {
        position: absolute;
        left: 0;
        width: 100%;
        height: 2.5px;
        border-radius: 2px;
        background: var(--nav-primary);
        transition: var(--nav-spring);
    }

    .navbar-toggler-icon-modern span:nth-child(1) {
        top: 0;
    }

    .navbar-toggler-icon-modern span:nth-child(2) {
        top: 7px;
    }

    .navbar-toggler-icon-modern span:nth-child(3) {
        top: 14px;
    }

    .navbar-toggler-modern[aria-expanded="true"] .navbar-toggler-icon-modern span:nth-child(1) {
        top: 7px;
        transform: rotate(45deg);
    }

    .navbar-toggler-modern[aria-expanded="true"] .navbar-toggler-icon-modern span:nth-child(2) {
        opacity: 0;
        transform: scaleX(0);
    }

    .navbar-toggler-modern[aria-expanded="true"] .navbar-toggler-icon-modern span:nth-child(3) {
        top: 7px;
        transform: rotate(-45deg);
    }

    /* ---------- Mobile: fullscreen premium menu ---------- */
    @media (max-width: 991.98px) {
        .modern-navbar-wrap {
            padding: 14px 12px 0;
        }

        .navbar-collapse-modern {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            border-radius: 0;
            background: rgba(13, 51, 17, 0.92);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 1.75rem;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.98);
            transition: opacity 0.35s ease, visibility 0.35s, transform 0.35s ease;
            z-index: 1040;
        }

        .navbar-collapse-modern.show {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .nav-modern {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .navbar-collapse-modern .nav-item {
            opacity: 0;
            transform: translateY(14px);
        }

        .navbar-collapse-modern.show .nav-item {
            animation: navItemStagger 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .navbar-collapse-modern.show .nav-item:nth-child(1) {
            animation-delay: 0.08s;
        }

        .navbar-collapse-modern.show .nav-item:nth-child(2) {
            animation-delay: 0.14s;
        }

        .navbar-collapse-modern.show .nav-item:nth-child(3) {
            animation-delay: 0.2s;
        }

        .navbar-collapse-modern.show .nav-item:nth-child(4) {
            animation-delay: 0.26s;
        }

        .navbar-collapse-modern.show .nav-item:nth-child(5) {
            animation-delay: 0.32s;
        }

        @keyframes navItemStagger {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-link-modern,
        .role-badge,
        .btn-modern {
            width: 100%;
            justify-content: center;
            margin: 0.3rem 0;
            padding: 16px !important;
            font-size: 1.15rem;
            color: #fff !important;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-link-modern.active {
            color: var(--nav-accent) !important;
            background: rgba(251, 191, 36, 0.15);
        }

        .user-actions-modern {
            flex-direction: column;
            gap: 0.6rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.18);
            opacity: 0;
            transform: translateY(14px);
        }

        .navbar-collapse-modern.show .user-actions-modern {
            animation: navItemStagger 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.38s forwards;
        }

        .btn-login-modern {
            border-color: var(--nav-accent);
            color: var(--nav-accent) !important;
        }
    }

    /* ---------- Desktop leaf-underline accent ---------- */
    @media (min-width: 992px) {
        .nav-link-modern::after {
            content: '\f06c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            bottom: -1px;
            left: 50%;
            font-size: 0.65rem;
            color: var(--nav-accent-dark);
            opacity: 0;
            transform: translateX(-50%) translateY(3px) scale(0.4) rotate(-20deg);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none;
            z-index: 2;
        }

        .nav-link-modern:hover::after,
        .nav-link-modern.active::after {
            opacity: 1;
            transform: translateX(-50%) translateY(0) scale(1) rotate(0deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .brand-text {
            font-size: 1.4rem;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            font-size: 1.25rem;
        }
    }

    /* Respect reduced motion preference */
    @media (prefers-reduced-motion: reduce) {

        .brand-modern,
        .brand-icon,
        .modern-navbar::before,
        .nav-aurora span,
        .nav-link-modern.active,
        .navbar-collapse-modern.show .nav-item,
        .navbar-collapse-modern.show .user-actions-modern {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }

        .nav-link-modern::after,
        .nav-link-modern::before,
        .nav-hover-pill {
            transition: none !important;
        }
    }
</style>

<div class="modern-navbar-wrap" id="modernNavbarWrap">
    <nav class="navbar navbar-expand-lg modern-navbar modern-navbar-scope" id="modernNavbar">
        <span class="nav-aurora" aria-hidden="true"><span></span><span></span><span></span></span>
        <span class="nav-noise" aria-hidden="true"></span>
        <div class="container position-relative">
            <a class="navbar-brand brand-modern" href="index.php">
                <div class="brand-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <span class="brand-text">Harvest Hub</span>
            </a>

            <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse"
                data-bs-target="#modernNavbarContent" aria-controls="modernNavbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon navbar-toggler-icon-modern">
                    <span></span><span></span><span></span>
                </span>
            </button>

            <div class="collapse navbar-collapse navbar-collapse-modern" id="modernNavbarContent">
                <ul class="navbar-nav nav-modern mx-auto mb-2 mb-lg-0">
                    <span class="nav-hover-pill" id="navHoverPill" aria-hidden="true"></span>

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"
                            href="index.php">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"
                            href="about.php">
                            <i class="fas fa-info-circle me-1"></i> About
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"
                            href="contact.php">
                            <i class="fas fa-envelope me-1"></i> Contact
                        </a>
                    </li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'consumer'): ?>
                        <li class="nav-item">
                            <a href="my_purchases.php"
                                class="nav-link nav-link-modern role-badge badge-consumer-modern <?php echo basename($_SERVER['PHP_SELF']) == 'my_purchases.php' ? 'active' : ''; ?>">
                                <i class="fas fa-shopping-bag"></i> My Purchases
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'farmer'): ?>
                        <li class="nav-item">
                            <a href="farmer_dashboard.php"
                                class="nav-link nav-link-modern role-badge badge-farmer-modern <?php echo basename($_SERVER['PHP_SELF']) == 'farmer_dashboard.php' ? 'active' : ''; ?>">
                                <i class="fas fa-tractor"></i> Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="user-actions-modern d-flex align-items-center gap-2">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <a href="admin_panel.php" class="btn btn-modern btn-admin-modern">
                            <i class="fas fa-eye me-1"></i> Admin Panel
                        </a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="btn btn-modern btn-logout-modern">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-modern btn-login-modern">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('modernNavbar');
        const wrap = document.getElementById('modernNavbarWrap');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
                if (wrap) wrap.classList.add('wrap-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
                if (wrap) wrap.classList.remove('wrap-scrolled');
            }
        }
    });

    // Mobile menu close on click
    document.addEventListener('DOMContentLoaded', function () {
        const mobileLinks = document.querySelectorAll('.nav-link-modern');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        if (navbarCollapse) {
            mobileLinks.forEach(link => {
                link.addEventListener('click', function () {
                    // Check if bootstrap is available
                    if (typeof bootstrap !== 'undefined' && window.innerWidth < 992) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                        bsCollapse.hide();
                    }
                });
            });
        }
    });
</script>

<script>
    // ------------------------------------------------------------
    // Premium interaction layer (purely additive / decorative —
    // does not alter any PHP, Bootstrap, or existing JS behavior)
    // ------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {

        // 1) Sliding "magic" hover pill behind desktop nav links
        const navList = document.querySelector('.nav-modern');
        const pill = document.getElementById('navHoverPill');

        if (navList && pill && window.matchMedia('(min-width: 992px)').matches) {
            const links = navList.querySelectorAll('.nav-item .nav-link-modern');

            function movePill(el) {
                const listRect = navList.getBoundingClientRect();
                const rect = el.getBoundingClientRect();
                pill.style.width = rect.width + 'px';
                pill.style.transform = 'translateX(' + (rect.left - listRect.left) + 'px)';
                pill.style.opacity = '1';
            }

            links.forEach(link => {
                link.addEventListener('mouseenter', () => movePill(link));
            });

            navList.addEventListener('mouseleave', () => {
                pill.style.opacity = '0';
            });
        }

        // 2) Mouse-follow glow + ripple click on premium buttons
        const glowTargets = document.querySelectorAll('.btn-modern');
        glowTargets.forEach(btn => {
            btn.addEventListener('mousemove', function (e) {
                const rect = btn.getBoundingClientRect();
                btn.style.setProperty('--mx', (e.clientX - rect.left) + 'px');
                btn.style.setProperty('--my', (e.clientY - rect.top) + 'px');
            });

            btn.addEventListener('click', function (e) {
                const rect = btn.getBoundingClientRect();
                const ripple = document.createElement('span');
                const size = Math.max(rect.width, rect.height);
                ripple.className = 'ripple';
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                btn.appendChild(ripple);
                setTimeout(() => ripple.remove(), 650);
            });
        });

        // 3) Subtle magnetic pull on the logo icon
        const brand = document.querySelector('.brand-modern');
        const brandIcon = document.querySelector('.brand-icon');
        if (brand && brandIcon && window.matchMedia('(pointer: fine)').matches) {
            brand.addEventListener('mousemove', function (e) {
                const rect = brand.getBoundingClientRect();
                const relX = (e.clientX - rect.left - rect.width / 2) / rect.width;
                const relY = (e.clientY - rect.top - rect.height / 2) / rect.height;
                brandIcon.style.transform = 'translate(' + (relX * 6) + 'px,' + (relY * 6) + 'px)';
            });
            brand.addEventListener('mouseleave', function () {
                brandIcon.style.transform = '';
            });
        }
    });
</script>