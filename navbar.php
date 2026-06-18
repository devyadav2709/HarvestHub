<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    /* Scoped variables to prevent conflicts with parent pages */
    .modern-navbar-scope {
        --nav-primary: #0d3311;
        /* Matched to footer dark green */
        --nav-primary-light: #1b5e20;
        --nav-accent: #fbbf24;
        /* Matched to footer gold */
        --nav-accent-dark: #f59e0b;
        --nav-light: #f8f9fa;
        --nav-text-dark: #212529;
        --nav-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --nav-transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Modern Navbar Base */
    .modern-navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: var(--nav-shadow);
        padding: 0.75rem 0;
        transition: var(--nav-transition);
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1030;
    }

    .navbar-scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
    }

    /* Modern Brand - MATCHING FOOTER STYLE */
    .brand-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .brand-icon {
        width: 45px;
        height: 45px;
        background: var(--nav-accent);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--nav-primary);
        font-size: 1.6rem;
        transform: rotate(-5deg);
        transition: var(--nav-transition);
    }

    .brand-text {
        font-weight: 700;
        font-size: 1.8rem;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--nav-primary), var(--nav-primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
    }

    .brand-modern:hover .brand-icon {
        transform: rotate(0deg) scale(1.1);
        background: var(--nav-primary);
        color: var(--nav-accent);
    }

    /* Modern Nav Links */
    .nav-modern {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-link-modern {
        color: var(--nav-text-dark) !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem !important;
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
        text-decoration: none;
    }

    .nav-link-modern:hover {
        color: var(--nav-primary) !important;
        background: rgba(13, 51, 17, 0.05);
        transform: translateY(-1px);
    }

    .nav-link-modern.active {
        color: var(--nav-primary) !important;
        background: rgba(13, 51, 17, 0.1);
        font-weight: 600;
    }

    /* Role Badges - Modern Design */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--nav-transition);
        border: 2px solid transparent;
    }

    .badge-consumer-modern,
    .badge-farmer-modern {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #1565c0;
        border-color: #90caf9;
    }

    .badge-consumer-modern:hover,
    .badge-farmer-modern:hover {
        background: linear-gradient(135deg, var(--nav-primary), var(--nav-primary-light));
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 51, 17, 0.3);
    }

    /* Modern Buttons */
    .btn-modern {
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--nav-transition);
        border: 2px solid transparent;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-login-modern {
        background: transparent;
        color: var(--nav-primary);
        border-color: var(--nav-primary);
    }

    .btn-login-modern:hover {
        background: var(--nav-primary);
        color: var(--nav-accent);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 51, 17, 0.3);
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
        box-shadow: 0 6px 20px rgba(211, 47, 47, 0.3);
    }

    .btn-admin-modern {
        background: linear-gradient(135deg, var(--nav-accent), var(--nav-accent-dark));
        color: var(--nav-primary);
        border: none;
    }

    .btn-admin-modern:hover {
        background: linear-gradient(135deg, var(--nav-accent-dark), #f57f17);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
    }

    /* Modern Toggler */
    .navbar-toggler-modern {
        border: none;
        padding: 8px;
        border-radius: 10px;
        background: rgba(13, 51, 17, 0.1);
        transition: var(--nav-transition);
    }

    .navbar-toggler-modern:hover {
        background: rgba(13, 51, 17, 0.2);
        transform: scale(1.05);
    }

    .navbar-toggler-modern:focus {
        box-shadow: none;
    }

    .navbar-toggler-icon-modern {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(13, 51, 17, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        width: 24px;
        height: 24px;
    }

    /* Mobile Menu */
    @media (max-width: 991.98px) {
        .navbar-collapse-modern {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            margin-top: 1rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-modern {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .nav-link-modern,
        .role-badge,
        .btn-modern {
            width: 100%;
            justify-content: center;
            margin: 0.25rem 0;
            padding: 12px !important;
        }

        .user-actions-modern {
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
    }

    /* Desktop Enhancements */
    @media (min-width: 992px) {
        .nav-link-modern {
            position: relative;
        }

        .nav-link-modern::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--nav-primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link-modern:hover::after,
        .nav-link-modern.active::after {
            width: 70%;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .brand-text {
            font-size: 1.5rem;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            font-size: 1.3rem;
        }
    }
</style>

<nav class="navbar navbar-expand-lg modern-navbar modern-navbar-scope" id="modernNavbar">
    <div class="container">
        <a class="navbar-brand brand-modern" href="index.php">
            <div class="brand-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <span class="brand-text">Harvest Hub</span>
        </a>

        <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse"
            data-bs-target="#modernNavbarContent" aria-controls="modernNavbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon navbar-toggler-icon-modern"></span>
        </button>

        <div class="collapse navbar-collapse navbar-collapse-modern" id="modernNavbarContent">
            <ul class="navbar-nav nav-modern mx-auto mb-2 mb-lg-0">
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

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('modernNavbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
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