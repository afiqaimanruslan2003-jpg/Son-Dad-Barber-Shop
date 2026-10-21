<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        :root {
            --sage-green: #b5bcab;
            --dark-charcoal: #3d3939;
            --gold-accent: #d4af37;
            --light-gray: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Oswald', sans-serif;
            background-color: #fff;
            color: #333;
            line-height: 1.6;
        }

        /* Navigation */
        .nav-bar {
            background: rgba(0, 0, 0, 0.9);
            padding: 20px 40px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            text-align: center;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .brand-sub {
            font-size: 12px;
            letter-spacing: 4px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 30px;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--gold-accent);
        }

        /* Main Content */
        .main-content {
            margin-top: 100px;
            padding: 40px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 80px;
            padding: 60px 20px;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9));
            border-radius: 10px;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--dark-charcoal), var(--gold-accent), var(--dark-charcoal));
        }

        .welcome-text {
            font-size: 18px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--dark-charcoal);
            margin-bottom: 20px;
            font-weight: 300;
        }

        .main-title {
            font-size: 72px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 30px;
            color: var(--dark-charcoal);
            line-height: 1.1;
        }

        .tagline {
            font-size: 24px;
            font-style: italic;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 300;
        }

        /* Divider */
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold-accent), transparent);
            width: 200px;
            margin: 40px auto;
        }

        /* Services Section */
        .services-section {
            margin-top: 80px;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 50px;
            color: var(--dark-charcoal);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--gold-accent);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-top: 40px;
        }

        .service-card {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .service-card h3 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            color: var(--dark-charcoal);
        }

        .service-card p {
            font-size: 16px;
            color: #666;
            line-height: 1.8;
        }

        /* Hot Towel Shave Section */
        .featured-service {
            background: linear-gradient(135deg, var(--dark-charcoal) 0%, #2a2626 100%);
            color: white;
            padding: 60px 40px;
            border-radius: 10px;
            margin-top: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .featured-service::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--gold-accent), transparent, var(--gold-accent));
        }

        .featured-service h4 {
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 25px;
            color: var(--gold-accent);
            position: relative;
            display: inline-block;
        }

        .featured-service h4::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: var(--gold-accent);
        }

        .featured-service p {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Footer */
        footer {
            background: var(--dark-charcoal);
            color: white;
            padding: 60px 40px;
            margin-top: 80px;
            text-align: center;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .social-icons a {
            color: white;
            font-size: 20px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: var(--gold-accent);
        }

        .copyright {
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-title {
                font-size: 48px;
            }

            .tagline {
                font-size: 20px;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-bar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .nav-links a {
                margin: 0 10px;
            }

            .main-content {
                margin-top: 140px;
                padding: 20px;
            }

            .main-title {
                font-size: 36px;
            }

            .tagline {
                font-size: 18px;
            }

            .section-title {
                font-size: 28px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="nav-bar">
        <div class="logo">
            <div class="brand-name">SON & DAD</div>
            <div class="brand-sub">BARBER SHOP</div>
        </div>
        <div class="nav-links">
            <a href="welcomeBarber.php#welcome">HOME</a>
            <a href="welcomeBarber.php#booking">BOOK</a>
            <a href="welcomeBarber.php#video">VIDEO</a>
            <a href="welcomeBarber.php#contact">CONTACT</a>
            <a href="logout.php">LOG OUT</a>
        </div>
    </nav>

    <script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function () {
            // Add animation class to elements on load
            const elements = document.querySelectorAll('.animate-fade-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                }, index * 200);
            });

            // Make navigation bar transparent on scroll
            window.addEventListener('scroll', function () {
                const nav = document.querySelector('.nav-bar');
                if (window.scrollY > 100) {
                    nav.style.background = 'rgba(0, 0, 0, 0.95)';
                } else {
                    nav.style.background = 'rgba(0, 0, 0, 0.9)';
                }
            });
        });

        (function () {
            // Disable browser's scroll memory
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            // Scroll to welcome section on page load
            window.addEventListener('load', function () {
                setTimeout(function () {
                    const welcomeSection = document.querySelector('.hero-section');
                    if (welcomeSection) {
                        // Smooth scroll to welcome section
                        welcomeSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else {
                        // Fallback: scroll to top
                        window.scrollTo(0, 0);
                    }
                }, 100);
            });
        })();
    </script>

</body>

</html>