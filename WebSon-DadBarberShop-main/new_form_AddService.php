<?php
include('001link_db2.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Service History - BMS</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <style>
    :root {
      --gold: #d4af37;
      --gold-light: #e8c158;
      --gold-dark: #b8941c;
      --dark-bg: #121212;
      --dark-bg-alt: #1d1d1d;
      --input-bg: rgba(42, 42, 42, 0.9);
      --input-bg-focus: rgba(50, 50, 50, 0.95);
      --border-color: rgba(68, 68, 68, 0.6);
      --border-focus: rgba(212, 175, 55, 0.7);
      --text-bright: #ffffff;
      --text-gold: #f1c40f;
      --red: #ff3b3b;
      --blue: #3b59ff;
      --white: #ffffff;
      --success: #2ecc71;
      --error: #e74c3c;
    }

    /* High Contrast Support */
    @media (prefers-contrast: high) {
      :root {
        --gold: #ffcc00;
        --dark-bg: #000000;
        --text-bright: #ffffff;
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
      background:
        radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
        radial-gradient(circle at 80% 20%, rgba(255, 59, 59, 0.03) 0%, transparent 40%),
        linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)),
        url("n1.jpg") no-repeat center center fixed;
      background-size: cover;
      background-attachment: fixed;
      font-family: "Times New Roman", serif;
      color: var(--text-bright);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      min-height: 100svh;
      margin: 0;
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }

    /* Subtle animated particles */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image:
        radial-gradient(2px 2px at 20px 30px, rgba(212, 175, 55, 0.2), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(255, 59, 59, 0.2), transparent),
        radial-gradient(2px 2px at 60px 20px, rgba(59, 89, 255, 0.2), transparent);
      background-repeat: no-repeat;
      background-size: 100px 100px;
      animation: particles 20s linear infinite;
      pointer-events: none;
      z-index: 0;
    }

    @keyframes particles {
      0% {
        background-position: 0 0, 30px 60px, 60px 20px;
      }

      100% {
        background-position: 100px 100px, 130px 160px, 160px 120px;
      }
    }

    /* Enhanced registration card */
    .registration-card {
      background: linear-gradient(145deg, var(--dark-bg), var(--dark-bg-alt));
      border: 1px solid var(--gold);
      width: min(520px, 95vw);
      position: relative;
      padding: 5px;
      box-shadow:
        0 25px 50px rgba(0, 0, 0, 0.9),
        0 0 0 1px rgba(212, 175, 55, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
      animation: slideDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      overflow: hidden;
      z-index: 1;
    }

    /* Corner accents */
    .registration-card::after {
      content: "";
      position: absolute;
      top: 15px;
      right: 15px;
      width: 30px;
      height: 30px;
      border-right: 2px solid rgba(212, 175, 55, 0.3);
      border-top: 2px solid rgba(212, 175, 55, 0.3);
      border-radius: 0 6px 0 0;
      pointer-events: none;
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

    /* Enhanced Airmail Border with Animation */
    .registration-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 10px;
      background: repeating-linear-gradient(-45deg,
          var(--red),
          var(--red) 20px,
          var(--white) 20px,
          var(--white) 40px,
          var(--blue) 40px,
          var(--blue) 60px,
          var(--white) 60px,
          var(--white) 80px);
      background-size: 80px 100%;
      animation: airmailSlide 4s linear infinite;
      z-index: 2;
    }

    @keyframes airmailSlide {
      0% {
        background-position: 0 0;
      }

      100% {
        background-position: 80px 0;
      }
    }

    .inner-content {
      padding: clamp(30px, 5vw, 50px) clamp(25px, 4vw, 40px);
      animation: fadeIn 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
      position: relative;
      z-index: 1;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(30px) scale(0.98);
      }

      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
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

    hr {
      border: none;
      height: 1px;
      background: linear-gradient(90deg,
          transparent,
          rgba(68, 68, 68, 0.5),
          transparent);
      margin: 25px 0 35px;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    label {
      display: block;
      color: var(--gold);
      font-size: 0.85rem;
      font-weight: bold;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      transition: color 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    label.required::after {
      content: "*";
      color: var(--error);
      font-size: 1.1em;
      margin-left: 2px;
    }

    .form-control {
      background-color: var(--input-bg);
      border: 2px solid var(--border-color);
      color: var(--text-gold);
      border-radius: 4px;
      height: 48px;
      padding: 0 16px;
      font-family: inherit;
      font-size: 16px;
      width: 100%;
      box-sizing: border-box;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
    }

    .form-control:hover {
      border-color: rgba(212, 175, 55, 0.4);
      background-color: var(--input-bg-focus);
    }

    .form-control:focus {
      border-color: var(--border-focus);
      color: var(--text-bright);
      box-shadow:
        0 0 0 4px rgba(212, 175, 55, 0.15),
        0 4px 12px rgba(0, 0, 0, 0.3);
      outline: none;
      transform: translateY(-1px);
      background-color: var(--input-bg-focus);
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.4);
      font-style: italic;
      transition: opacity 0.3s ease;
    }

    .form-control:focus::placeholder {
      opacity: 0.5;
    }

    /* Enhanced Service ID Field */
    .id-field {
      border: 2px dashed rgba(102, 102, 102, 0.7) !important;
      background-color: rgba(30, 30, 30, 0.7) !important;
      color: rgba(136, 136, 136, 0.9) !important;
      margin-bottom: 30px;
      cursor: not-allowed;
      letter-spacing: 2px;
      font-family: 'Courier New', monospace;
      font-weight: 600;
      position: relative;
      user-select: all;
    }

    .id-field::after {
      content: "AUTO-GENERATED";
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.7rem;
      color: var(--text-gold);
      background: rgba(0, 0, 0, 0.3);
      padding: 3px 10px;
      border-radius: 4px;
      letter-spacing: 1px;
      opacity: 0.7;
    }

    /* Form Validation States */
    .form-control.valid {
      border-color: var(--success);
      background-color: rgba(46, 204, 113, 0.05);
    }

    .form-control.invalid {
      border-color: var(--error);
      background-color: rgba(231, 76, 60, 0.05);
      animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
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

    .validation-message {
      display: none;
      font-size: 0.85rem;
      margin-top: 8px;
      padding: 8px 12px;
      border-radius: 4px;
      animation: slideDownMsg 0.3s ease;
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

    @keyframes slideDownMsg {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Enhanced Submit Button */
    .btn-submit {
      background: linear-gradient(135deg, var(--gold), var(--gold-dark));
      color: black;
      border: none;
      width: 100%;
      padding: 18px;
      font-size: 18px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 30px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      letter-spacing: 3px;
      border-radius: 4px;
      cursor: pointer;
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
      width: 20px;
      height: 20px;
      border: 3px solid rgba(0, 0, 0, 0.1);
      border-top-color: black;
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
      background: linear-gradient(135deg, var(--success), #27ae60);
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
      font-size: 1.2em;
    }

    /* Focus Accessibility */
    .form-control:focus-visible,
    .btn-submit:focus-visible {
      outline: 3px solid var(--gold);
      outline-offset: 2px;
      outline-color: var(--gold-light);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .registration-card {
        width: 95%;
        padding: 3px;
      }

      .inner-content {
        padding: 30px 20px;
      }

      h2 {
        font-size: 1.4rem;
        letter-spacing: 2px;
        padding-bottom: 15px;
      }

      .form-control {
        height: 45px;
        padding: 0 14px;
        font-size: 15px;
      }

      .btn-submit {
        padding: 16px;
        font-size: 16px;
        letter-spacing: 2px;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
        background-attachment: scroll;
      }

      .registration-card {
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
        letter-spacing: 1.5px;
      }

      .form-control {
        height: 42px;
        font-size: 14px;
      }

      .btn-submit {
        padding: 14px;
        font-size: 15px;
        letter-spacing: 1.5px;
      }

      /* Hide decorative elements on mobile */
      .registration-card::after {
        display: none;
      }
    }

    /* Print Styles */
    @media print {
      body {
        background: white !important;
        color: black !important;
      }

      .registration-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        background: white !important;
      }

      .registration-card::before,
      .registration-card::after {
        display: none;
      }

      .btn-submit {
        display: none;
      }

      .form-control {
        background: white !important;
        border: 1px solid #ccc !important;
        color: black !important;
      }
    }
  </style>
</head>

<body>
  <div class="registration-card">
    <div class="inner-content">
      <h1>ADD SERVICE</h1>
      <hr />

      <form action="serviceHistoryInsert.php" method="POST">
        <label>SYSTEM REFERENCE (SERVICE ID):</label>
        <input type="text" name="service_type_id" id="service_type_id" class="form-control id-field" readonly />

        <div class="row">
          <div class="col-md-12 form-group">
            <label>SERVICE NAME:</label>
            <input type="text" name="service_name" id="service_name" class="form-control" placeholder="e.g. Beard Shave"
              required />
          </div>
        </div>

        <div class="form-group">
          <label>DESCRIPTION:</label>
          <input type="text" name="description" id="description" class="form-control" placeholder="e.g. Clean shaving"
            required />
        </div>

        <div class="form-group">
          <label>BARBER NAME:</label>
          <input type="text" name="barber_name" class="form-control" placeholder="e.g. Arif" required />
        </div>

        <div class="row">
          <div class="col-md-12 form-group">
            <label>AMOUNT (RM):</label>
            <input type="number" step="0.01" name="amount" class="form-control" placeholder="e.g RM15.00" required />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 form-group">
            <label>DURATION (MINUTES):</label>
            <input type="number" step="1" name="duration_minutes" id="duration_minutes" class="form-control"
              placeholder="e.g 20 minutes" required />
          </div>
        </div>

        <button type="submit" class="btn-submit">DONE</button>
      </form>
    </div>
  </div>

  <script>
    // Generate the Reference ID matching the image format
    window.onload = function () {
      const now = new Date()
      const timestamp =
        now.getFullYear() +
        String(now.getMonth() + 1).padStart(2, "0") +
        String(now.getDate()).padStart(2, "0") +
        String(now.getHours()).padStart(2, "0") +
        String(now.getMinutes()).padStart(2, "0") +
        String(now.getSeconds()).padStart(2, "0")
      const randomNum = Math.floor(10 + Math.random() * 90)
      document.getElementById("service_type_id").value =
        "SRV" + timestamp + randomNum
    }
  </script>
</body>

</html>