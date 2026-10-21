<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Ledger | New Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Enhanced Barber Theme with Better Accessibility */
    :root {
      --gold: #d4af37;
      --gold-light: #e8c158;
      --gold-dark: #b8941c;
      --dark-bg: #0f0f0f;
      --dark-bg-alt: #1a1a1a;
      --card-bg: linear-gradient(145deg, rgba(30, 30, 30, 0.95), rgba(20, 20, 20, 0.98));
      --input-bg: rgba(43, 43, 43, 0.8);
      --input-bg-focus: rgba(50, 50, 50, 0.9);
      --border-color: rgba(68, 68, 68, 0.5);
      --border-focus: rgba(212, 175, 55, 0.6);
      --text-dim: #aaaaaa;
      --text-bright: #ffffff;
      --text-disabled: #666666;
      --red: #ff3333;
      --blue: #3366ff;
      --white-stripe: #f8f8f8;
      --success: #2ecc71;
      --error: #e74c3c;
      --warning: #f39c12;
    }

    /* High Contrast Mode Support */
    @media (prefers-contrast: high) {
      :root {
        --gold: #ffcc00;
        --dark-bg: #000000;
        --text-bright: #ffffff;
        --text-dim: #cccccc;
      }
    }

    /* Reduced Motion Preference */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }

    body {
      background: var(--dark-bg);
      background-image: 
        radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 51, 51, 0.03) 0%, transparent 50%),
        linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.95)), 
        url('n1.jpg');
      background-size: cover, cover, cover, cover;
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Merriweather', serif;
      min-height: 100vh;
      min-height: 100svh; /* Safari Viewport Height */
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: var(--gold);
      margin: 0;
      position: relative;
      overflow-x: hidden;
    }

    /* Subtle animated background particles */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 30% 30%, rgba(212, 175, 55, 0.03) 2px, transparent 2px),
        radial-gradient(circle at 70% 70%, rgba(255, 51, 51, 0.02) 1px, transparent 1px),
        radial-gradient(circle at 50% 20%, rgba(51, 102, 255, 0.02) 3px, transparent 3px);
      background-size: 100px 100px, 150px 150px, 200px 200px;
      animation: particleFloat 20s linear infinite;
      pointer-events: none;
      z-index: 0;
    }

    @keyframes particleFloat {
      0% { background-position: 0 0, 0 0, 0 0; }
      100% { background-position: 100px 100px, 150px 150px, 200px 200px; }
    }

    .card {
      width: min(100%, 600px);
      padding: clamp(30px, 5vw, 50px) clamp(20px, 4vw, 40px);
      border-radius: 8px;
      background: var(--card-bg);
      box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.8),
        0 0 0 1px rgba(212, 175, 55, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(212, 175, 55, 0.2);
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      animation: cardSlideIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
      z-index: 1;
    }

    /* Enhanced Barber Pole with Animation */
    .card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: repeating-linear-gradient(90deg,
          var(--red), var(--red) 15px,
          var(--white-stripe) 15px, var(--white-stripe) 30px,
          var(--blue) 30px, var(--blue) 45px,
          var(--white-stripe) 45px, var(--white-stripe) 60px);
      background-size: 60px 100%;
      z-index: 2;
      animation: poleSlide 3s linear infinite;
    }

    @keyframes poleSlide {
      0% { background-position: 0 0; }
      100% { background-position: 60px 0; }
    }

    /* Subtle corner accents */
    .card::after {
      content: "";
      position: absolute;
      top: 10px;
      right: 10px;
      width: 40px;
      height: 40px;
      border-right: 2px solid rgba(212, 175, 55, 0.3);
      border-top: 2px solid rgba(212, 175, 55, 0.3);
      border-radius: 0 8px 0 0;
      pointer-events: none;
    }

    @keyframes cardSlideIn {
      0% {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
        filter: blur(10px);
      }
      70% {
        opacity: 0.8;
        transform: translateY(-5px) scale(1.02);
        filter: blur(0);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
      }
    }

    h1 {
      text-align: center;
      margin: 0 0 40px 0;
      font-weight: 700;
      color: var(--text-bright);
      font-size: clamp(1.5rem, 4vw, 2rem);
      text-transform: uppercase;
      letter-spacing: 3px;
      padding-bottom: 20px;
      position: relative;
      z-index: 2;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    h1::after {
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

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-label {
      font-weight: 700;
      color: var(--gold);
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 1px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: color 0.3s ease;
    }

    .form-label.required::after {
      content: "*";
      color: var(--error);
      font-size: 1.2em;
      margin-left: 2px;
    }

    .form-control {
      background-color: var(--input-bg);
      border: 2px solid var(--border-color);
      color: var(--text-bright);
      border-radius: 6px;
      padding: 14px 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-family: inherit;
      font-size: 16px;
      width: 100%;
      box-sizing: border-box;
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
    }

    .form-control:hover {
      border-color: rgba(212, 175, 55, 0.4);
      background-color: var(--input-bg-focus);
    }

    .form-control:focus {
      background-color: var(--input-bg-focus);
      border-color: var(--border-focus);
      color: var(--text-bright);
      box-shadow: 
        0 0 0 4px rgba(212, 175, 55, 0.15),
        0 4px 12px rgba(0, 0, 0, 0.3);
      outline: none;
      transform: translateY(-1px);
    }

    .form-control::placeholder {
      color: var(--text-dim);
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .form-control:focus::placeholder {
      opacity: 0.5;
    }

    /* Enhanced Readonly Booking ID */
    #booking_id {
      background-color: rgba(15, 15, 15, 0.8);
      border: 2px dashed rgba(212, 175, 55, 0.3);
      color: var(--gold-light);
      cursor: not-allowed;
      font-family: 'Courier New', monospace;
      letter-spacing: 2px;
      font-weight: 600;
      position: relative;
      user-select: all;
    }

    #booking_id::after {
      content: "READ ONLY";
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.7rem;
      color: var(--text-dim);
      background: rgba(0, 0, 0, 0.3);
      padding: 2px 8px;
      border-radius: 3px;
      letter-spacing: 1px;
    }

    /* Input with icon */
    .input-with-icon {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gold);
      pointer-events: none;
      z-index: 1;
    }

    .input-with-icon .form-control {
      padding-left: 45px;
    }

    .btn-primary {
      width: 100%;
      padding: 18px;
      border-radius: 6px;
      font-weight: 800;
      background: linear-gradient(135deg, var(--gold), var(--gold-dark));
      border: none;
      color: var(--dark-bg);
      text-transform: uppercase;
      letter-spacing: 2.5px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      margin-top: 30px;
      font-size: 16px;
      cursor: pointer;
      font-family: inherit;
      position: relative;
      overflow: hidden;
      z-index: 2;
      box-shadow: 
        0 4px 15px rgba(212, 175, 55, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-primary::before {
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

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--gold-light), var(--gold));
      color: var(--dark-bg);
      transform: translateY(-3px);
      box-shadow: 
        0 8px 25px rgba(212, 175, 55, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .btn-primary:hover::before {
      left: 100%;
    }

    .btn-primary:active {
      transform: translateY(-1px);
      box-shadow: 
        0 4px 10px rgba(212, 175, 55, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .inner-content {
      position: relative;
      animation: contentFadeIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both;
      z-index: 2;
    }

    @keyframes contentFadeIn {
      0% {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Form Validation States */
    .form-control.valid {
      border-color: var(--success);
      background-color: rgba(46, 204, 113, 0.05);
    }

    .form-control.invalid {
      border-color: var(--error);
      background-color: rgba(231, 76, 60, 0.05);
      animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }

    @keyframes shake {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(2px); }
      30%, 50%, 70% { transform: translateX(-2px); }
      40%, 60% { transform: translateX(2px); }
    }

    .validation-message {
      display: none;
      font-size: 0.85rem;
      margin-top: 8px;
      padding: 8px 12px;
      border-radius: 4px;
      animation: slideDown 0.3s ease;
    }

    .validation-message.valid {
      display: block;
      background: rgba(46, 204, 113, 0.1);
      color: var(--success);
      border-left: 3px solid var(--success);
    }

    .validation-message.invalid {
      display: block;
      background: rgba(231, 76, 60, 0.1);
      color: var(--error);
      border-left: 3px solid var(--error);
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

    /* Responsive Design Enhancements */
    @media (max-width: 768px) {
      body {
        padding: 15px;
        align-items: flex-start;
        padding-top: 40px;
      }

      .card {
        padding: 30px 20px;
        border-radius: 12px;
        margin-top: 20px;
      }

      .card::before {
        height: 6px;
      }

      h1 {
        font-size: 1.4rem;
        letter-spacing: 2px;
        margin-bottom: 30px;
      }

      .btn-primary {
        padding: 16px;
        font-size: 15px;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 10px;
        background-attachment: scroll;
      }

      .card {
        padding: 25px 16px;
        border: none;
        box-shadow: 
          0 10px 30px rgba(0, 0, 0, 0.9),
          0 0 0 1px rgba(212, 175, 55, 0.1);
      }

      h1 {
        font-size: 1.3rem;
        letter-spacing: 1.5px;
      }

      .form-control {
        padding: 12px 14px;
        font-size: 15px;
      }

      .btn-primary {
        padding: 15px;
        font-size: 14px;
      }

      /* Hide decorative elements on mobile */
      .card::after {
        display: none;
      }
    }

    /* Focus accessibility improvements */
    .form-control:focus-visible {
      outline: 3px solid var(--gold);
      outline-offset: 2px;
      border-color: transparent;
    }

    .btn-primary:focus-visible {
      outline: 3px solid var(--text-bright);
      outline-offset: 3px;
      outline-offset: 2px;
    }

    /* Loading state with spinner */
    .btn-primary.loading {
      opacity: 0.9;
      cursor: wait;
      color: transparent;
      position: relative;
    }

    .btn-primary.loading::after {
      content: "";
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 20px;
      height: 20px;
      border: 3px solid rgba(0, 0, 0, 0.1);
      border-top-color: var(--dark-bg);
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Success state with icon */
    .btn-primary.success {
      background: linear-gradient(135deg, var(--success), #27ae60);
      color: white;
      position: relative;
      padding-right: 50px;
    }

    .btn-primary.success::after {
      content: "✓";
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.2em;
    }

    /* Progress indicator for multi-step forms */
    .form-progress {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
      position: relative;
    }

    .form-progress::before {
      content: "";
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 2px;
      background: var(--border-color);
      transform: translateY(-50%);
      z-index: 1;
    }

    .progress-step {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--dark-bg-alt);
      border: 2px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      color: var(--text-dim);
      position: relative;
      z-index: 2;
      transition: all 0.3s ease;
    }

    .progress-step.active {
      background: var(--gold);
      border-color: var(--gold);
      color: var(--dark-bg);
      transform: scale(1.1);
    }

    .progress-step.completed {
      background: var(--success);
      border-color: var(--success);
      color: white;
    }

    /* Print styles */
    @media print {
      body {
        background: white !important;
        color: black !important;
      }
      
      .card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        background: white !important;
      }
      
      .card::before,
      .card::after {
        display: none;
      }
      
      .btn-primary {
        display: none;
      }
    }

    /* Custom scrollbar */
    .inner-content::-webkit-scrollbar {
      width: 8px;
    }

    .inner-content::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.1);
      border-radius: 4px;
    }

    .inner-content::-webkit-scrollbar-thumb {
      background: var(--gold);
      border-radius: 4px;
    }

    .inner-content::-webkit-scrollbar-thumb:hover {
      background: var(--gold-light);
    }
  </style>
</head>

<body>
  <div class="card p-4 shadow-sm">
    <div class="inner-content">
      <h1 class="mb-4">New Customer</h1>

      <form id="regForm" action="customerHistoryInsert.php" method="post">
        <div class="mb-3">
          <label class="form-label">System Reference (Booking ID):</label>
          <input type="text" class="form-control" name="booking_id" id="booking_id" readonly />
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="IC" class="form-label">Identification (IC):</label>
            <input type="text" class="form-control" name="IC" id="IC" required placeholder="000000-00-0000" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="no_phone" class="form-label">Contact Number:</label>
            <input type="text" class="form-control" name="no_phone" id="no_phone" required placeholder="012-3456789" />
          </div>
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Full Name:</label>
          <input type="text" class="form-control" name="name" id="name" required placeholder="Afiq Aiman" />
        </div>

        <div class="row">
          <div class="col-md-8 mb-3">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" class="form-control" name="dob" id="dob" required onchange="calculateAge()" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="time" class="form-label">Time:</label>
            <input type="time" class="form-control" name="time" id="time" min="0" required placeholder="--0.00--">
          </div>
          <div class="col-md-4 mb-3">
            <label for="age" class="form-label">Age:</label>
            <input type="number" class="form-control" name="age" id="age" min="0" required placeholder="25" />
          </div>
        </div>

        <button action="new_form_payment.php" type="submit" class="btn btn-primary w-100">Proceed to Payment</button>
      </form>
    </div>
  </div>

  <script>
    // 1. Generate Booking ID on Load
    window.onload = function () {
      const bookingInput = document.getElementById("booking_id");
      const now = new Date();
      const bookingID = "BK" + now.getFullYear() +
        String(now.getMonth() + 1).padStart(2, "0") +
        String(now.getDate()).padStart(2, "0") +
        Math.floor(Math.random() * 1000);
      bookingInput.value = bookingID;
    };

    // 3. Update Link AND Style (White text respond)
    document.getElementById('name').addEventListener('input', function () {
      const nameValue = encodeURIComponent(this.value);
      const link = document.getElementById('redirectLink');

      // Update the URL
      link.href = "new_form_payment.php?name=" + nameValue;

      // Visual feedback: turn text white when typing
      if (this.value.length > 0) {
        this.style.color = "#ffffff";
        this.style.borderColor = "#d4af37";
      } else {
        this.style.color = "#888";
        this.style.borderColor = "#444";
      }
    });

    function calculateAge() {
      const dob = document.getElementById("dob").value;
      if (dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }
        document.getElementById("age").value = age;
      }
    }
  </script>
</body>

</html>