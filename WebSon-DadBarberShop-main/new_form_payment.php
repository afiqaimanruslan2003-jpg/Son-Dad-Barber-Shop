<?php
$conn = new mysqli("localhost", "root", "", "bms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Catch the name from the previous form via URL
$passed_name = isset($_GET['name']) ? $_GET['name'] : '';

// Generate Booking ID
$generated_id = "BK" . date("YmdHis") . rand(10, 99);

// Fetch services for the dropdown
$service_query = "SELECT service_name, description, barber_name, amount, duration_minutes FROM service_list ORDER BY service_name ASC";
$all_services = $conn->query($service_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customer Form</title>
    <style>
        :root {
            --gold: #d4af37;
            --gold-light: #e6c158;
            --gold-dark: #a9871d;
            --dark-bg: #0a0a0a;
            --dark-bg-alt: #121212;
            --input-bg: #1e1e1e;
            --input-focus: #2a2a2a;
            --border-color: #3a3a3a;
            --border-focus: #d4af37;
            --text-dim: #999;
            --text-bright: #fff;
            --red: #ff3b3b;
            --blue: #3b59ff;
            --white: #ffffff;
            --success: #4caf50;
            --error: #f44336;
        }

        /* Reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        body {
            background:
                radial-gradient(ellipse at 20% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(59, 89, 255, 0.03) 0%, transparent 50%),
                linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.95)),
                url('n1.jpg');
            background-size: cover, cover, cover, cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Merriweather', serif;
            min-height: 100vh;
            min-height: 100svh;
            /* Better mobile support */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: clamp(15px, 5vw, 30px);
            color: var(--gold);
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle floating particles */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.03) 1px, transparent 1px),
                radial-gradient(circle at 80% 70%, rgba(59, 89, 255, 0.02) 2px, transparent 2px);
            background-size: 50px 50px, 100px 100px;
            animation: floatParticles 20s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes floatParticles {
            0% {
                background-position: 0 0, 0 0;
            }

            100% {
                background-position: 50px 50px, 100px 100px;
            }
        }

        .outer-box {
            background: linear-gradient(145deg, var(--dark-bg), #0f0f0f);
            width: min(100%, 500px);
            padding: 4px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            position: relative;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.9),
                0 0 0 1px rgba(212, 175, 55, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            animation: slideDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 1;
        }

        @keyframes slideDown {
            0% {
                transform: translateY(-40px) scale(0.95);
                opacity: 0;
                filter: blur(5px);
            }

            70% {
                transform: translateY(5px) scale(1.02);
                opacity: 0.8;
                filter: blur(0);
            }

            100% {
                transform: translateY(0) scale(1);
                opacity: 1;
                filter: blur(0);
            }
        }

        /* Enhanced Barber Pole */
        .outer-box::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 12px;
            background: repeating-linear-gradient(90deg,
                    var(--red), var(--red) 20px,
                    var(--white) 20px, var(--white) 40px,
                    var(--blue) 40px, var(--blue) 60px,
                    var(--white) 60px, var(--white) 80px);
            background-size: 80px 100%;
            border-radius: 8px 8px 0 0;
            animation: poleMove 3s linear infinite;
            z-index: 2;
        }

        @keyframes poleMove {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 80px 0;
            }
        }

        /* Corner Accents */
        .outer-box::after {
            content: "";
            position: absolute;
            top: 15px;
            right: 15px;
            width: 30px;
            height: 30px;
            border-right: 2px solid rgba(212, 175, 55, 0.3);
            border-top: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 0 8px 0 0;
            pointer-events: none;
        }

        .inner-content {
            padding: clamp(30px, 5vw, 50px) clamp(25px, 4vw, 40px);
            color: var(--text-bright);
            position: relative;
            background: rgba(18, 18, 18, 0.7);
            border-radius: 4px;
            animation: contentFadeIn 0.6s ease-out 0.3s both;
            z-index: 1;
        }

        @keyframes contentFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0 0 40px 0;
            font-size: clamp(1.5rem, 4vw, 2rem);
            color: var(--text-bright);
            font-weight: 700;
            position: relative;
            padding-bottom: 25px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        h2::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg,
                    transparent,
                    var(--gold),
                    transparent);
            border-radius: 2px;
        }

        label {
            display: block;
            color: var(--gold);
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: color 0.3s ease;
        }

        label.required::after {
            content: "*";
            color: var(--error);
            margin-left: 4px;
            font-size: 1.1em;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        /* Input and Select Styles */
        input,
        select {
            width: 100%;
            background-color: var(--input-bg);
            border: 2px solid var(--border-color);
            padding: 15px;
            color: var(--text-dim);
            font-size: 16px;
            outline: none;
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
            border-radius: 6px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        input:hover,
        select:hover {
            border-color: rgba(212, 175, 55, 0.4);
            background-color: rgba(42, 42, 42, 0.8);
        }

        input:focus,
        select:focus {
            border-color: var(--border-focus);
            color: var(--text-bright);
            background-color: var(--input-focus);
            box-shadow:
                0 0 0 4px rgba(212, 175, 55, 0.15),
                0 4px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-1px);
        }

        input::placeholder,
        select::placeholder {
            color: var(--text-dim);
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        input:focus::placeholder,
        select:focus::placeholder {
            opacity: 0.5;
        }

        /* Enhanced ID Field */
        .id-field {
            border: 2px dashed rgba(212, 175, 55, 0.4);
            background: rgba(10, 10, 10, 0.6);
            color: var(--gold-light);
            font-family: 'Courier New', monospace;
            font-weight: 600;
            letter-spacing: 2px;
            cursor: not-allowed;
            position: relative;
            user-select: all;
        }

        .id-field::after {
            content: "READ ONLY";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.7rem;
            color: var(--text-dim);
            background: rgba(0, 0, 0, 0.4);
            padding: 3px 10px;
            border-radius: 3px;
            letter-spacing: 1px;
            pointer-events: none;
        }

        /* Filled State */
        .filled {
            color: var(--text-bright) !important;
            border-color: rgba(212, 175, 55, 0.6);
            background-color: rgba(42, 42, 42, 0.9);
        }

        /* Input with Icon */
        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            pointer-events: none;
            z-index: 1;
        }

        .input-with-icon input,
        .input-with-icon select {
            padding-left: 45px;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: #000;
            border: none;
            width: 100%;
            padding: 18px;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            cursor: pointer;
            margin-top: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 4px 15px rgba(212, 175, 55, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .btn-submit::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.2),
                    transparent);
            transition: left 0.7s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            transform: translateY(-3px);
            box-shadow:
                0 8px 25px rgba(212, 175, 55, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(-1px);
            box-shadow:
                0 4px 10px rgba(212, 175, 55, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .btn-submit:focus-visible {
            outline: 3px solid var(--text-bright);
            outline-offset: 3px;
        }

        /* Loading State */
        .btn-submit.loading {
            opacity: 0.9;
            cursor: wait;
            color: transparent;
            position: relative;
        }

        .btn-submit.loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 22px;
            height: 22px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-top-color: #000;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Success State */
        .btn-submit.success {
            background: linear-gradient(135deg, var(--success), #388e3c);
            color: white;
            position: relative;
            padding-right: 50px;
        }

        .btn-submit.success::after {
            content: "✓";
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3em;
        }

        /* Form Validation */
        input.invalid,
        select.invalid {
            border-color: var(--error);
            background-color: rgba(244, 67, 54, 0.05);
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        input.valid,
        select.valid {
            border-color: var(--success);
            background-color: rgba(76, 175, 80, 0.05);
        }

        @keyframes shake {

            10%,
            90% {
                transform: translateX(-1px);
            }

            20%,
            80% {
                transform: translateX(2px);
            }

            30%,
            50%,
            70% {
                transform: translateX(-2px);
            }

            40%,
            60% {
                transform: translateX(2px);
            }
        }

        .error-message {
            display: none;
            font-size: 0.85rem;
            color: var(--error);
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(244, 67, 54, 0.1);
            border-radius: 4px;
            border-left: 3px solid var(--error);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                align-items: flex-start;
                padding-top: 30px;
            }

            .outer-box {
                margin-top: 20px;
                border-radius: 12px;
            }

            .outer-box::before {
                height: 10px;
            }

            .outer-box::after {
                display: none;
            }

            .inner-content {
                padding: 30px 20px;
            }

            h2 {
                font-size: 1.4rem;
                margin-bottom: 30px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .btn-submit {
                padding: 16px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            body {
                background-attachment: scroll;
            }

            .outer-box {
                border: none;
                box-shadow:
                    0 15px 30px rgba(0, 0, 0, 0.9),
                    0 0 0 1px rgba(212, 175, 55, 0.1);
            }

            .inner-content {
                padding: 25px 15px;
            }

            h2 {
                font-size: 1.3rem;
                letter-spacing: 2px;
            }

            input,
            select {
                padding: 13px;
                font-size: 15px;
            }

            .btn-submit {
                padding: 15px;
                font-size: 14px;
            }
        }

        /* Focus Accessibility */
        input:focus-visible,
        select:focus-visible {
            outline: 3px solid var(--gold);
            outline-offset: 2px;
            border-color: transparent;
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }

            .outer-box {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                background: white !important;
            }

            .outer-box::before,
            .outer-box::after {
                display: none;
            }

            .btn-submit {
                display: none;
            }

            input,
            select {
                background: white !important;
                color: black !important;
                border: 1px solid #ccc !important;
            }
        }
    </style>
</head>

<body>
    <div class="outer-box">
        <div class="inner-content">
            <h2>Payment Checkout</h2>

            <form action="paymentHistoryInsert.php" method="POST">

                <label>System Reference (Payment ID):</label>
                <input type="text" class="id-field" name="payment_id" style="margin-bottom: 20px" value="<?= $generated_id ?>" readonly>

                <div class="form-group">
                    <label>Customer Name:</label>
                    <input type="text" name="name" class="form-control filled"
                        value="<?= htmlspecialchars($passed_name) ?>" readonly
                        style="background-color: rgba(255,255,255,0.05); cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Select Service:</label>
                    <select name="service_provided" id="service_select" required onchange="syncDetails()">
                        <option value="">-- Choose Service --</option>

                        <?php while ($row = $all_services->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['service_name']) ?>"
                                data-description="<?= htmlspecialchars($row['description']) ?>"
                                data-price="<?= htmlspecialchars($row['amount']) ?>"
                                data-duration="<?= htmlspecialchars($row['duration_minutes']) ?>"
                                data-barber="<?= htmlspecialchars($row['barber_name']) ?>">
                                <?= htmlspecialchars($row['service_name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="description_input">Description:</label>
                        <input type="text" class="form-control" name="description" id="description_input" readonly
                            placeholder="Auto-filled">
                    </div>

                    <div class="form-group">
                        <label for="barber_input">Assigned Barber:</label>
                        <input type="text" class="form-control" name="barber_name" id="barber_input" readonly
                            placeholder="Auto-filled">
                    </div>

                    <div class="form-group">
                        <label for="amount_input">Amount (RM):</label>
                        <input type="text" class="form-control" name="total_amount" id="amount_input" readonly
                            placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label for="duration_input">Duration (Minutes):</label>
                        <input type="text" class="form-control" name="duration_minutes" id="duration_input" readonly
                            placeholder="0">
                    </div>
                </div>


                <div class="form-group">
                    <label>Payment Method:</label>
                    <select name="payment_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Card">Card / QR</option>
                        <option value="Online_Transfer">Online Transfer</option>
                    </select>
                </div>

                <button action="confirm_payment.php" type="submit" class="btn-submit">Complete Payment</button>
            </form>
        </div>
    </div>

    <script>
        function syncDetails() {
            const select = document.getElementById('service_select');
            const selectedOption = select.options[select.selectedIndex];

            const amountInput = document.getElementById('amount_input');
            const barberInput = document.getElementById('barber_input');
            const descriptionInput = document.getElementById('description_input');
            const durationInput = document.getElementById('duration_input');

            const price = selectedOption.dataset.price;
            const barber = selectedOption.dataset.barber;
            const description = selectedOption.dataset.description;
            const duration = selectedOption.dataset.duration;

            if (price) {
                amountInput.value = price;
                barberInput.value = barber;
                descriptionInput.value = description;
                durationInput.value = duration;

                amountInput.classList.add('filled');
                barberInput.classList.add('filled');
                descriptionInput.classList.add('filled');
                durationInput.classList.add('filled');
                select.classList.add('filled');
            } else {
                amountInput.value = '';
                barberInput.value = '';
                descriptionInput.value = '';
                durationInput.value = '';

                amountInput.classList.remove('filled');
                barberInput.classList.remove('filled');
                descriptionInput.classList.remove('filled');
                durationInput.classList.remove('filled');
                select.classList.remove('filled');
            }
        }

        // Run this when page loads to highlight the Customer Name if it's already filled
        window.onload = function () {
            const custInput = document.getElementsByName('name')[0];
            if (custInput && custInput.value !== "") {
                custInput.classList.add('filled');
            }
        };
    </script>

</body>

</html>