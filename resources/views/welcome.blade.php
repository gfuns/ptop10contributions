<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyPower.ng - Most convenient way to buy electricity</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-green: #8cb82b;
            --dark-green: #6b8e23;
            --orange-accent: #e67e22;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        /* Top Support Banner */
        .support-banner {
            background-color: var(--orange-accent);
            color: white;
            padding: 8px 0;
            font-size: 14px;
            font-weight: 500;
            text-align: right;
            padding-right: 20px;
        }

        /* Navbar Styling */
        .navbar {
            padding: 15px 0;
            background-color: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
        }

        .brand-text h1 {
            color: var(--primary-green);
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        .brand-text p {
            color: #666;
            font-size: 12px;
            margin: 0;
        }

        .nav-link {
            color: #666 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-green) !important;
        }

        .phone-dropdown {
            color: var(--primary-green) !important;
            font-weight: 600;
        }

        /* Verification Alert */
        .verification-alert {
            background-color: #fff8e6;
            border: 1px solid #ffd700;
            border-radius: 8px;
            padding: 15px 20px;
            margin: 30px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-icon {
            color: #e67e22;
            font-size: 24px;
        }

        .alert-text {
            color: #856404;
            margin: 0;
        }

        .btn-complete {
            background-color: #e6b800;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-complete:hover {
            background-color: #d4a700;
            color: white;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .welcome-section p {
            color: #666;
            font-size: 16px;
        }

        /* Section Tabs */
        .section-tabs {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #666;
        }

        .tabs {
            display: flex;
            gap: 20px;
        }

        .tab-item {
            color: #999;
            font-weight: 500;
            cursor: pointer;
            padding-bottom: 12px;
            margin-bottom: -12px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }

        .tab-item.active {
            color: var(--primary-green);
            border-bottom-color: var(--primary-green);
        }

        /* Service Cards */
        .service-card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 30px;
            text-align: left;
            transition: all 0.3s;
            cursor: pointer;
            height: 100%;
        }

        .service-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .service-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .electricity-icon { background-color: #e8f5e9; color: var(--primary-green); }
        .airtime-icon { background-color: #ffebee; color: #e57373; }
        .data-icon { background-color: #e3f2fd; color: #64b5f6; }
        .cable-icon { background-color: #fff3e0; color: #ffb74d; }

        .service-icon i {
            font-size: 28px;
        }

        .service-card h5 {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .service-card p {
            color: #999;
            font-size: 14px;
            margin: 0;
        }

        /* Promo Cards */
        .promo-section {
            margin-top: 40px;
        }

        .promo-card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 25px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            height: 100%;
        }

        .promo-icon {
            width: 50px;
            height: 50px;
            background-color: #fff8e6;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .promo-icon i {
            font-size: 24px;
            color: var(--orange-accent);
        }

        .promo-content h5 {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .promo-content p {
            color: #666;
            font-size: 14px;
            margin: 0;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .support-banner {
                text-align: center;
                font-size: 12px;
            }

            .brand-text h1 {
                font-size: 22px;
            }

            .section-tabs {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .verification-alert {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .service-card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Support Banner -->
    <div class="support-banner">
        24 Hour Support 0908-749-3044
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <svg class="logo-icon" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="5" y="15" width="20" height="30" rx="3" fill="#8cb82b" stroke="#6b8e23" stroke-width="2"/>
                    <rect x="10" y="20" width="10" height="8" rx="1" fill="white"/>
                    <rect x="10" y="32" width="10" height="8" rx="1" fill="white"/>
                    <path d="M35 10 L45 30 L38 30 L42 45 L30 25 L37 25 Z" fill="#e67e22" stroke="#d35400" stroke-width="1.5"/>
                </svg>
                <div class="brand-text">
                    <h1>BuyPower.ng</h1>
                    <p>Most convenient way to buy electricity</p>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pay Bills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Transaction History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle phone-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                            08188664322
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Verification Alert -->
        <div class="verification-alert">
            <div class="alert-content">
                <i class="bi bi-info-circle-fill alert-icon"></i>
                <p class="alert-text">Your account verification is 25% done. please complete your verification.</p>
            </div>
            <button class="btn btn-complete">Complete</button>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2>Hello, 08188664322</h2>
            <p>What do you want to do today?</p>
        </div>

        <!-- Section with Tabs -->
        <div class="section-tabs">
            <span class="section-title">Pay Bills</span>
            <div class="tabs">
                <span class="tab-item active">Products</span>
                <span class="tab-item">Providers</span>
            </div>
        </div>

        <!-- Service Cards -->
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="service-card">
                    <div class="service-icon electricity-icon">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <h5>Electricity</h5>
                    <p>AEDC, IKEDC</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="service-card">
                    <div class="service-icon airtime-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5>Airtime</h5>
                    <p>MTN, GLO</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="service-card">
                    <div class="service-icon data-icon">
                        <i class="bi bi-wifi"></i>
                    </div>
                    <h5>Data</h5>
                    <p>MTN, GLO</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="service-card">
                    <div class="service-icon cable-icon">
                        <i class="bi bi-tv-fill"></i>
                    </div>
                    <h5>Cable</h5>
                    <p>DSTV, GOTV</p>
                </div>
            </div>
        </div>

        <!-- Promo Section -->
        <div class="row promo-section g-4">
            <div class="col-md-6">
                <div class="promo-card">
                    <div class="promo-icon">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div class="promo-content">
                        <h5>Refer & Earn ₦3000!</h5>
                        <p>Invite friends to use BuyPower and earn rewards when they sign up</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="promo-card">
                    <div class="promo-icon">
                        <svg width="30" height="30" viewBox="0 0 60 60" fill="none">
                            <rect x="10" y="20" width="20" height="25" rx="2" fill="#8cb82b"/>
                            <path d="M35 15 L42 28 L37 28 L40 38 L32 25 L37 25 Z" fill="#e67e22"/>
                        </svg>
                    </div>
                    <div class="promo-content">
                        <h5>Get the BuyPower™ Mobile App</h5>
                        <p>Schedule payments, verify meters and other exciting features on the mobile app</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Service card click effect
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    </script>
</body>
</html>
