<?php
// receipt.php - Animated Receipt Page

// Get data from URL parameters
$payment_data = [
    'payment_id' => isset($_GET['payment_id']) ? $_GET['payment_id'] : 'BK' . date('YmdHis'),
    'service_name' => isset($_GET['service']) ? $_GET['service'] : 'Service Not Specified',
    'description' => isset($_GET['desc']) ? $_GET['desc'] : 'No description',
    'name' => isset($_GET['name']) ? $_GET['name'] : 'Guest',
    'barber_name' => isset($_GET['barber']) ? $_GET['barber'] : 'Available Barber',
    'duration_minutes' => isset($_GET['duration']) ? $_GET['duration'] : 0,
    'amount' => isset($_GET['amount']) ? $_GET['amount'] : 0.0,
    'payment_method' => isset($_GET['payment_method']) ? $_GET['payment_method'] : 'Cash',
    'date' => isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'),
    'time' => isset($_GET['time']) ? $_GET['time'] : date('H:i')
];

$js_payment_data = [
    'payment_id' => htmlspecialchars($payment_data['payment_id'], ENT_QUOTES, 'UTF-8'),
    'service_name' => htmlspecialchars($payment_data['service_name'], ENT_QUOTES, 'UTF-8'),
    'description' => htmlspecialchars($payment_data['description'], ENT_QUOTES, 'UTF-8'),
    'name' => htmlspecialchars($payment_data['name'], ENT_QUOTES, 'UTF-8'),
    'barber_name' => htmlspecialchars($payment_data['barber_name'], ENT_QUOTES, 'UTF-8'),
    'duration_minutes' => htmlspecialchars($payment_data['duration_minutes'], ENT_QUOTES, 'UTF-8'),
    'amount' => htmlspecialchars($payment_data['amount'], ENT_QUOTES, 'UTF-8'),
    'payment_method' => htmlspecialchars($payment_data['payment_method'], ENT_QUOTES, 'UTF-8'),
    'date' => htmlspecialchars($payment_data['date'], ENT_QUOTES, 'UTF-8'),
    'time' => htmlspecialchars($payment_data['time'], ENT_QUOTES, 'UTF-8')
];

// Determine emoji based on service
$emoji_map = [
    'Hot Towel Shave' => '🧔✂️',
    'Beard Trim & Shape' => '🧔‍♂️✂️',
    'Classic Haircut' => '💇✂️',
    'Haircut' => '💇‍♂️✂️',
    'Shave' => '🧔‍♂️🧴',
    'default' => '💈✨'
];

$service_emoji = isset($emoji_map[$payment_data['service_name']])
    ? $emoji_map[$payment_data['service_name']]
    : $emoji_map['default'];

$message_map = [
    'Hot Towel Shave' => 'Smooth shave achieved! 🪒✨',
    'Beard Trim & Shape' => 'Beard looking sharp! 🔥',
    'Classic Haircut' => 'Fresh cut, fresh look! 💯',
    'default' => 'Looking good! 😎'
];

$emoji_message = isset($message_map[$payment_data['service_name']])
    ? $message_map[$payment_data['service_name']]
    : $message_map['default'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt | Barber Shop</title>
    <style>
        :root {
            --gold: #d4af37;
            --gold-light: #e8c158;
            --gold-dark: #b8941c;
            --dark-bg: #0a0a0a;
            --dark-bg-alt: #121212;
            --receipt-bg: linear-gradient(145deg, rgba(25, 25, 25, 0.98), rgba(15, 15, 15, 0.99));
            --border-color: rgba(68, 68, 68, 0.6);
            --border-focus: rgba(212, 175, 55, 0.7);
            --text-bright: #ffffff;
            --text-dim: #aaaaaa;
            --text-gold: #f1c40f;
            --success: #2ecc71;
            --success-light: #27ae60;
            --error: #e74c3c;
            --info: #3498db;
            --highlight: #ffcc00;
            --shadow: rgba(0, 0, 0, 0.8);
        }

        body {
            background:
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(255, 51, 51, 0.03) 0%, transparent 40%),
                linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.95)),
                url('n1.jpg') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Courier New', monospace, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-bright);
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(2px 2px at 20px 30px, rgba(212, 175, 55, 0.15), transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(46, 204, 113, 0.1), transparent),
                radial-gradient(2px 2px at 60px 20px, rgba(52, 152, 219, 0.1), transparent);
            background-repeat: no-repeat;
            background-size: 200px 200px;
            animation: floatParticles 30s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes floatParticles {
            0% {
                background-position: 0 0, 30px 60px, 60px 20px;
            }

            100% {
                background-position: 200px 200px, 230px 260px, 260px 220px;
            }
        }

        /* Receipt Container */
        .receipt-container {
            width: 100%;
            max-width: 520px;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
                filter: blur(5px);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        /* Enhanced Receipt Paper */
        .receipt-paper {
            background: var(--receipt-bg);
            border: 2px solid rgba(212, 175, 55, 0.3);
            padding: 35px;
            position: relative;
            box-shadow:
                0 25px 50px var(--shadow),
                0 0 0 1px rgba(212, 175, 55, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Corner accents */
        .receipt-paper::before,
        .receipt-paper::after {
            content: "";
            position: absolute;
            width: 40px;
            height: 40px;
            pointer-events: none;
        }

        .receipt-paper::before {
            top: 15px;
            left: 15px;
            border-left: 2px solid rgba(212, 175, 55, 0.3);
            border-top: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px 0 0 0;
        }

        .receipt-paper::after {
            bottom: 15px;
            right: 15px;
            border-right: 2px solid rgba(212, 175, 55, 0.3);
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 0 0 8px 0;
        }

        /* Enhanced perforated edges */
        .receipt-paper .top-perforation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 12px;
            background: repeating-linear-gradient(90deg,
                    transparent, transparent 8px,
                    var(--gold) 8px, var(--gold) 10px,
                    transparent 10px, transparent 20px);
            animation: slideRight 4s linear infinite;
        }

        .receipt-paper .bottom-perforation {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 12px;
            background: repeating-linear-gradient(90deg,
                    transparent, transparent 8px,
                    var(--gold) 8px, var(--gold) 10px,
                    transparent 10px, transparent 20px);
            animation: slideLeft 4s linear infinite;
        }

        @keyframes slideRight {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 20px 0;
            }
        }

        @keyframes slideLeft {
            0% {
                background-position: 20px 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        /* Header */
        .receipt-header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--gold);
            position: relative;
            animation: slideDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideDown {
            0% {
                transform: translateY(-40px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .shop-name {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 4px;
            color: var(--gold);
            margin-bottom: 15px;
            text-transform: uppercase;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            position: relative;
            display: inline-block;
        }

        .shop-name::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 25%;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            border-radius: 3px;
        }

        .receipt-title {
            font-size: 1.1rem;
            color: var(--text-bright);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 20px;
            padding: 10px 20px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 6px;
            display: inline-block;
        }

        /* Receipt Content */
        .receipt-content {
            animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding: 12px 15px;
            border-radius: 6px;
            background: rgba(30, 30, 30, 0.5);
            animation: rowAppear 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            opacity: 0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-row::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(212, 175, 55, 0.05),
                    transparent);
            transition: left 0.5s ease;
        }

        .info-row:hover {
            background: rgba(40, 40, 40, 0.6);
            transform: translateX(5px);
        }

        .info-row:hover::before {
            left: 100%;
        }

        @keyframes rowAppear {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Staggered animation for rows */
        .info-row:nth-child(1) {
            animation-delay: 0.4s;
        }

        .info-row:nth-child(2) {
            animation-delay: 0.5s;
        }

        .info-row:nth-child(3) {
            animation-delay: 0.6s;
        }

        .info-row:nth-child(4) {
            animation-delay: 0.7s;
        }

        .info-row:nth-child(5) {
            animation-delay: 0.8s;
        }

        .info-row:nth-child(6) {
            animation-delay: 0.9s;
        }

        .info-label {
            color: var(--text-dim);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label::before {
            content: "•";
            color: var(--gold);
            font-size: 1.2rem;
        }

        .info-value {
            color: var(--text-bright);
            font-size: 1rem;
            font-weight: 600;
            text-align: right;
            transition: all 0.3s ease;
        }

        .info-row:hover .info-value {
            color: var(--gold-light);
        }

        .payment-id {
            font-family: 'Courier New', monospace;
            color: var(--highlight) !important;
            font-size: 1.2rem !important;
            font-weight: 800 !important;
            letter-spacing: 2px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, var(--gold), var(--highlight));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .amount {
            color: var(--success) !important;
            font-size: 1.4rem !important;
            font-weight: 800 !important;
            position: relative;
            padding-right: 25px;
        }

        .amount::after {
            content: "RM";
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
            color: var(--text-dim);
            opacity: 0.7;
        }

        .service {
            color: var(--gold) !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
        }

        /* Enhanced Divider */
        .divider {
            height: 2px;
            background: linear-gradient(90deg,
                    transparent,
                    var(--gold),
                    transparent);
            margin: 30px 0;
            position: relative;
            animation: stretch 1s cubic-bezier(0.34, 1.56, 0.64, 1) 1s both;
            overflow: hidden;
        }

        @keyframes stretch {
            0% {
                width: 0;
                opacity: 0;
            }

            100% {
                width: 100%;
                opacity: 1;
            }
        }

        .divider::before {
            content: "✂️";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: var(--dark-bg);
            padding: 0 15px;
            font-size: 1.2rem;
        }

        /* Enhanced Emoji Section */
        .emoji-section {
            text-align: center;
            margin: 30px 0;
            padding: 25px;
            background: rgba(212, 175, 55, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            animation: bounceIn 1s cubic-bezier(0.34, 1.56, 0.64, 1) 1.2s both;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0) rotate(-180deg);
                opacity: 0;
            }

            60% {
                transform: scale(1.1) rotate(10deg);
                opacity: 1;
            }

            100% {
                transform: scale(1) rotate(0);
                opacity: 1;
            }
        }

        .emoji-display {
            font-size: 4rem;
            margin-bottom: 20px;
            display: inline-block;
            animation:
                float 3s ease-in-out infinite,
                rotate 20s linear infinite;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0);
            }

            50% {
                transform: translateY(-15px) rotate(5deg);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .emoji-message {
            color: var(--text-bright);
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 15px;
            padding: 15px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .emoji-message::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(212, 175, 55, 0.2),
                    transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        /* Enhanced Footer */
        .receipt-footer {
            text-align: center;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px dashed rgba(212, 175, 55, 0.3);
            color: var(--text-dim);
            font-size: 0.85rem;
            animation: fadeIn 1s ease-out 1.5s both;
        }

        .thank-you {
            font-size: 1.2rem;
            color: var(--gold);
            margin-bottom: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation:
                pulse 2s infinite,
                colorShift 4s infinite alternate;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        @keyframes colorShift {
            0% {
                color: var(--gold);
            }

            50% {
                color: var(--gold-light);
            }

            100% {
                color: var(--gold);
            }
        }

        .thank-you::before,
        .thank-you::after {
            content: "✨";
            font-size: 1rem;
            animation: twinkle 1.5s infinite alternate;
        }

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        /* Enhanced Control Buttons */
        .controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            animation: fadeIn 1s ease-out 1.8s both;
        }

        .btn {
            background: transparent;
            color: var(--gold);
            border: 2px solid var(--gold);
            padding: 15px 30px;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
            min-width: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(212, 175, 55, 0.2),
                    transparent);
            transition: left 0.7s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--dark-bg);
            transform: translateY(-5px);
            box-shadow:
                0 10px 25px rgba(212, 175, 55, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border-color: transparent;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:active {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-print {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--dark-bg);
            border: none;
            padding: 16px 32px;
        }

        .btn-print:hover {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            box-shadow:
                0 12px 30px rgba(212, 175, 55, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .receipt-container {
                max-width: 95%;
            }

            .receipt-paper {
                padding: 25px 20px;
            }

            .shop-name {
                font-size: 1.8rem;
                letter-spacing: 3px;
            }

            .controls {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
                padding: 14px;
            }

            /* Hide decorative corners on mobile */
            .receipt-paper::before,
            .receipt-paper::after {
                display: none;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .receipt-paper {
                padding: 20px 15px;
                border-width: 1px;
            }

            .shop-name {
                font-size: 1.5rem;
                letter-spacing: 2px;
            }

            .emoji-display {
                font-size: 3rem;
            }

            .info-value {
                font-size: 0.9rem;
            }

            .amount {
                font-size: 1.2rem !important;
            }
        }

        /* Print-specific styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }

            .receipt-paper {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                background: white !important;
                color: black !important;
            }

            .controls {
                display: none;
            }

            .receipt-paper::before,
            .receipt-paper::after {
                display: none;
            }

            .top-perforation,
            .bottom-perforation {
                display: none;
            }
        }

        /* PDF Button Styling */
        .btn-pdf {
            background: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
        }

        .btn-pdf:hover {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            box-shadow: 0 10px 25px rgba(231, 76, 60, 0.4);
        }

        /* Success message styling */
        .pdf-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(46, 204, 113, 0.95);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            animation: slideInRight 0.5s ease, fadeOut 0.5s ease 2.5s forwards;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
    <!-- Add this AFTER your styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-paper">
            <!-- Header -->
            <div class="receipt-header">
                <div class="shop-name">💈 Barber Elite</div>
                <div class="receipt-title">PAYMENT RECEIPT</div>
            </div>

            <!-- Receipt Content -->
            <div class="receipt-content">
                <!-- Payment ID Row -->
                <div class="info-row" style="animation-delay: 0.4s;">
                    <span class="info-label">Payment ID</span>
                    <span class="info-value payment-id"><?php echo $payment_data['payment_id']; ?></span>
                </div>

                <!-- Service Row -->
                <div class="info-row" style="animation-delay: 0.5s;">
                    <span class="info-label">Service</span>
                    <span class="info-value service"><?php echo $payment_data['service_name']; ?></span>
                </div>

                <!-- Description Row -->
                <div class="info-row" style="animation-delay: 0.6s;">
                    <span class="info-label">Description</span>
                    <span class="info-value"><?php echo $payment_data['description']; ?></span>
                </div>

                <!-- Customer Name Row -->
                <div class="info-row" style="animation-delay: 0.7s;">
                    <span class="info-label">Customer</span>
                    <span class="info-value"><?php echo $payment_data['name']; ?></span>
                </div>

                <!-- Barber Row -->
                <div class="info-row" style="animation-delay: 0.8s;">
                    <span class="info-label">Barber</span>
                    <span class="info-value"><?php echo $payment_data['barber_name']; ?></span>
                </div>

                <!-- Duration Row -->
                <div class="info-row" style="animation-delay: 0.9s;">
                    <span class="info-label">Duration</span>
                    <span class="info-value"><?php echo $payment_data['duration_minutes']; ?> minutes</span>
                </div>

                <!-- Payment Method Row -->
                <div class="info-row" style="animation-delay: 1.0s;">
                    <span class="info-label">Payment Method</span>
                    <span class="info-value"><?php echo $payment_data['payment_method']; ?></span>
                </div>

                <div class="divider"></div>

                <!-- Amount Row -->
                <div class="info-row" style="animation-delay: 1.1s; border-bottom: 2px solid var(--gold);">
                    <span class="info-label">Total Amount</span>
                    <span class="info-value amount">RM <?php echo number_format($payment_data['amount'], 2); ?></span>
                </div>

                <!-- Date & Time -->
                <div class="info-row" style="animation-delay: 1.2s;">
                    <span class="info-label">Date & Time</span>
                    <span class="info-value"><?php echo $payment_data['date']; ?> at
                        <?php echo $payment_data['time']; ?></span>
                </div>
            </div>

            <!-- Emoji Section -->
            <div class="emoji-section">
                <div class="emoji-display"><?php echo $service_emoji; ?></div>
                <div class="emoji-message"><?php echo $emoji_message; ?></div>
            </div>

            <!-- Footer -->
            <div class="receipt-footer">
                <div class="thank-you">Thank you for choosing Barber Elite!</div>
                <p>Please keep this receipt for your records</p>
                <p>📍 123 Premium Street, Kuala Lumpur</p>
                <p>📞 +60 3-1234 5678</p>
            </div>

            <!-- Controls -->
            <div class="controls">
                <button class="btn" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <button class="btn" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i> Return
                </button>
                <button class="btn btn-pdf" onclick="generatePDF()">
                    <i class="fas fa-file-pdf"></i> SAVE PDF
                </button>
            </div>

        </div>
    </div>
    <!-- Add this BEFORE your scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Go back function
        function goBack() {
            if (confirm('Are you sure you want to leave this page?'))
                window.location.href = 'welcomeBarber.php';
        }

        // Print styles
        const printStyle = document.createElement('style');
        printStyle.textContent = `
            @media print {
                body * {
                    visibility: hidden;
                }
                .receipt-paper, .receipt-paper * {
                    visibility: visible;
                }
                .receipt-paper {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    box-shadow: none;
                    border: 2px solid #000;
                }
                .btn {
                    display: none !important;
                }
            }
        `;
        document.head.appendChild(printStyle);

        function generatePDF() {
            // Get the button element
            const button = event.target;

            // Show loading state
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> GENERATING...';
            button.disabled = true;

            // Check if html2pdf is loaded
            if (typeof html2pdf === 'undefined') {
                alert('PDF library not loaded. Please refresh the page.');
                button.innerHTML = originalText;
                button.disabled = false;
                return;
            }

            // Clone the receipt element
            const element = document.querySelector('.receipt-paper');
            const clone = element.cloneNode(true);

            // Remove controls from clone
            clone.querySelectorAll('.controls, .btn').forEach(el => el.remove());

            // Remove animations from clone
            clone.style.animation = 'none';
            clone.querySelectorAll('.info-row, .emoji-section, .receipt-header, .receipt-content').forEach(el => {
                el.style.animation = 'none';
                el.style.opacity = '1';
                el.style.transform = 'none';
            });

            // Add timestamp to receipt for PDF
            const timestamp = document.createElement('div');
            timestamp.style.cssText = 'text-align: center; color: #888; font-size: 10px; margin-top: 20px; padding-top: 15px; border-top: 1px dashed #444;';
            timestamp.innerHTML = `PDF Generated: ${new Date().toLocaleString()}`;
            clone.appendChild(timestamp);

            // PDF options
            const opt = {
                margin: 15,
                filename: `BMS_Receipt_${document.querySelector('.payment-id').textContent.trim()}_${new Date().getTime()}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#1a1a1a',
                    letterRendering: true,
                    logging: false,
                    allowTaint: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait',
                    compress: true
                }
            };

            // Generate and save PDF
            html2pdf()
                .set(opt)
                .from(clone)
                .save()
                .then(() => {
                    // Success - reset button
                    button.innerHTML = originalText;
                    button.disabled = false;

                    // Show success message
                    Swal.fire({
                        title: '✅ PDF Generated!',
                        html: `
                    <div style="text-align: center; padding: 20px;">
                        <i class="fas fa-file-pdf" style="font-size: 48px; color: #e74c3c;"></i>
                        <h3 style="color: var(--gold); margin: 20px 0;">Receipt Saved as PDF</h3>
                        <p style="color: #aaa; margin-bottom: 15px;">The PDF has been downloaded to your device.</p>
                        <div style="background: rgba(212, 175, 55, 0.1); padding: 10px; border-radius: 6px;">
                            <p style="color: var(--text-dim); font-size: 12px; margin: 5px 0;">
                                <i class="fas fa-file-alt"></i>
                                File: BMS_Receipt_${document.querySelector('.payment-id').textContent.trim()}.pdf
                            </p>
                        </div>
                    </div>
                `,
                        icon: 'success',
                        confirmButtonColor: '#d4af37',
                        background: '#121212',
                        color: '#fff',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                })
                .catch(error => {
                    // Error - reset button
                    button.innerHTML = originalText;
                    button.disabled = false;

                    console.error('PDF Generation Error:', error);

                    // Show error message
                    Swal.fire({
                        title: 'PDF Generation Failed',
                        html: `
                    <div style="text-align: center; padding: 20px;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #e74c3c;"></i>
                        <p style="color: #fff; margin: 15px 0;">Failed to generate PDF.</p>
                        <p style="color: var(--text-dim); font-size: 14px;">Please try again or use Print option.</p>
                    </div>
                `,
                        icon: 'error',
                        confirmButtonColor: '#e74c3c',
                        background: '#121212',
                        color: '#fff'
                    });
                });
        }

        window.paymentData = <?php echo json_encode($js_payment_data); ?>;
    </script>
</body>

</html>