<!DOCTYPE html>
<html>
<head>
  <title>Customer Search | Barber Elite</title>

  <!-- Bootstrap (optional - you can remove if you want pure CSS) -->
  <link rel="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

  <!-- Merriweather Font -->
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

  <!-- Custom Style -->
  <style>
    :root {
      --gold: #d4af37;
      --gold-light: #e8c158;
      --gold-dark: #b8941c;
      --dark-bg: #0a0a0a;
      --dark-bg-alt: #121212;
      --card-bg: linear-gradient(145deg, rgba(30, 30, 30, 0.97), rgba(20, 20, 20, 0.99));
      --input-bg: rgba(42, 42, 42, 0.9);
      --input-bg-focus: rgba(50, 50, 50, 0.95);
      --border-color: rgba(68, 68, 68, 0.6);
      --border-focus: rgba(212, 175, 55, 0.7);
      --text-dim: #aaaaaa;
      --text-bright: #ffffff;
      --text-gold: #f1c40f;
      --red: #ff3333;
      --blue: #3366ff;
      --white-stripe: #f8f8f8;
      --success: #2ecc71;
      --error: #e74c3c;
      --warning: #f39c12;
    }

    /* High Contrast Support */
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
      background: 
        radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
        radial-gradient(circle at 80% 20%, rgba(255, 51, 51, 0.03) 0%, transparent 40%),
        linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)),
        url('n1.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      font-family: 'Merriweather', serif;
      min-height: 100vh;
      min-height: 100svh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      color: var(--gold);
      margin: 0;
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
        radial-gradient(1px 1px at 20px 30px, rgba(212, 175, 55, 0.15), transparent),
        radial-gradient(1px 1px at 40px 70px, rgba(255, 51, 51, 0.1), transparent),
        radial-gradient(1px 1px at 60px 20px, rgba(51, 102, 255, 0.1), transparent);
      background-repeat: no-repeat;
      background-size: 200px 200px;
      animation: floatParticles 30s linear infinite;
      pointer-events: none;
      z-index: 0;
    }

    @keyframes floatParticles {
      0% { background-position: 0 0, 30px 60px, 60px 20px; }
      100% { background-position: 200px 200px, 230px 260px, 260px 220px; }
    }

    .search-container {
      background: var(--card-bg);
      padding: clamp(30px, 5vw, 50px) clamp(25px, 4vw, 40px);
      border: 2px solid rgba(212, 175, 55, 0.3);
      width: min(500px, 95vw);
      position: relative;
      box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.9),
        0 0 0 1px rgba(212, 175, 55, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
      animation: slideDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-radius: 8px;
      overflow: hidden;
      z-index: 1;
    }

    /* Corner accents */
    .search-container::after {
      content: "";
      position: absolute;
      top: 15px;
      right: 15px;
      width: 35px;
      height: 35px;
      border-right: 2px solid rgba(212, 175, 55, 0.3);
      border-top: 2px solid rgba(212, 175, 55, 0.3);
      border-radius: 0 6px 0 0;
      pointer-events: none;
    }

    @keyframes slideDown {
      0% {
        opacity: 0;
        transform: translateY(-40px) scale(0.95);
        filter: blur(5px);
      }
      70% {
        opacity: 0.8;
        transform: translateY(5px) scale(1.02);
        filter: blur(0);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
      }
    }

    /* Enhanced Barber Pole Top Border with Animation */
    .search-container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 12px;
      background: repeating-linear-gradient(45deg, 
          var(--red), var(--red) 20px,
          var(--white-stripe) 20px, var(--white-stripe) 40px,
          var(--blue) 40px, var(--blue) 60px,
          var(--white-stripe) 60px, var(--white-stripe) 80px);
      background-size: 80px 100%;
      animation: poleSlide 4s linear infinite;
      z-index: 2;
    }

    @keyframes poleSlide {
      0% { background-position: 0 0; }
      100% { background-position: 80px 0; }
    }

    h2 {
      font-weight: 700;
      margin-bottom: 35px;
      color: var(--text-bright);
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 3px;
      font-size: clamp(1.5rem, 4vw, 2rem);
      border-bottom: 1px solid rgba(68, 68, 68, 0.5);
      padding-bottom: 20px;
      position: relative;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    h2::after {
      content: "";
      position: absolute;
      bottom: -1px;
      left: 25%;
      width: 50%;
      height: 2px;
      background: linear-gradient(90deg, 
        transparent, 
        var(--gold), 
        transparent);
    }

    .form-label {
      font-weight: bold;
      color: var(--gold);
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 1.5px;
      margin-bottom: 10px;
      display: block;
      transition: color 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-label.required::after {
      content: "*";
      color: var(--error);
      font-size: 1.1em;
      margin-left: 2px;
    }

    .form-control,
    .form-select {
      background-color: var(--input-bg);
      border: 2px solid var(--border-color);
      color: var(--text-bright);
      padding: 14px 16px;
      font-size: 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-family: inherit;
      width: 100%;
      box-sizing: border-box;
      border-radius: 6px;
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
    }

    .form-control:hover,
    .form-select:hover {
      border-color: rgba(212, 175, 55, 0.4);
      background-color: var(--input-bg-focus);
    }

    .form-control:focus,
    .form-select:focus {
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
      color: var(--text-dim);
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .form-control:focus::placeholder {
      opacity: 0.5;
    }

    /* Enhanced dropdown styling */
    .form-select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23d4af37' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 16px;
      padding-right: 45px;
    }

    /* Form Validation States */
    .form-control.valid,
    .form-select.valid {
      border-color: var(--success);
      background-color: rgba(46, 204, 113, 0.05);
    }

    .form-control.invalid,
    .form-select.invalid {
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
      animation: slideDownMsg 0.3s ease;
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

    .btn-primary {
      background: linear-gradient(135deg, var(--gold), var(--gold-dark));
      border: none;
      padding: 15px 30px;
      font-weight: bold;
      color: var(--dark-bg);
      text-transform: uppercase;
      letter-spacing: 2px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      font-family: inherit;
      cursor: pointer;
      min-width: 140px;
      font-size: 15px;
      border-radius: 6px;
      position: relative;
      overflow: hidden;
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

    .btn-secondary {
      background: transparent;
      border: 2px solid var(--gold);
      padding: 15px 30px;
      font-weight: bold;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 2px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      font-family: inherit;
      cursor: pointer;
      min-width: 140px;
      font-size: 15px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .btn-secondary::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(212, 175, 55, 0.1), 
        transparent);
      transition: left 0.7s ease;
    }

    .btn-secondary:hover {
      background-color: var(--gold);
      color: var(--dark-bg);
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
      text-decoration: none;
    }

    .btn-secondary:hover::before {
      left: 100%;
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .mb-3 {
      margin-bottom: 30px !important;
    }

    /* Search icon in inputs */
    .search-icon {
      position: relative;
    }

    .search-icon::before {
      content: "🔍";
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gold);
      opacity: 0.7;
      pointer-events: none;
      z-index: 1;
    }

    .search-icon .form-control {
      padding-left: 45px;
    }

    /* Loading State */
    .btn-primary.loading,
    .btn-secondary.loading {
      opacity: 0.9;
      cursor: wait;
      color: transparent;
      position: relative;
    }

    .btn-primary.loading::after,
    .btn-secondary.loading::after {
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

    .btn-secondary.loading::after {
      border-top-color: var(--gold);
    }

    @keyframes spin {
      to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Success State */
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

    /* Focus states for accessibility */
    .btn-primary:focus-visible,
    .btn-secondary:focus-visible,
    .form-control:focus-visible,
    .form-select:focus-visible {
      outline: 3px solid var(--gold-light);
      outline-offset: 3px;
    }

    /* Animation for form elements */
    .form-label,
    .form-control,
    .form-select,
    .btn-primary,
    .btn-secondary {
      animation: fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
      opacity: 0;
    }

    .form-label { animation-delay: 0.1s; }
    .form-select { animation-delay: 0.2s; }
    .form-control { animation-delay: 0.3s; }
    .btn-primary { animation-delay: 0.4s; }
    .btn-secondary { animation-delay: 0.5s; }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .search-container {
        padding: 30px 25px;
      }
      
      h2 {
        font-size: 1.4rem;
        margin-bottom: 30px;
      }
      
      .button-group {
        flex-direction: column;
        gap: 15px;
      }
      
      .btn-primary,
      .btn-secondary {
        width: 100%;
        min-width: auto;
      }
    }

    @media (max-width: 480px) {
      .search-container {
        padding: 25px 20px;
        border-width: 1px;
      }
      
      h2 {
        font-size: 1.3rem;
        padding-bottom: 15px;
        letter-spacing: 2px;
      }
      
      .form-control,
      .form-select {
        padding: 12px 14px;
        font-size: 15px;
      }
      
      .btn-primary,
      .btn-secondary {
        padding: 14px;
        font-size: 14px;
      }

      /* Hide decorative elements on mobile */
      .search-container::after {
        display: none;
      }
    }

    /* Print Styles */
    @media print {
      body {
        background: white !important;
        color: black !important;
      }
      
      .search-container {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        background: white !important;
      }
      
      .search-container::before,
      .search-container::after {
        display: none;
      }
      
      .form-control,
      .form-select {
        background: white !important;
        border: 1px solid #ccc !important;
        color: black !important;
      }
      
      .button-group {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="search-container">
    <h2>Search Customer</h2>

    <form action="015proc_search2.php" method="post">

      <div class="mb-3">
        <label class="form-label">Search By</label>
        <select name="searchtype" class="form-select" required>
          <option value="booking_id">Booking ID</option>
          <option value="IC">IC</option>
          <option value="name">Customer Name</option>
          <option value="no_phone">Phone Number</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Enter Search Term</label>
        <input type="text" name="searchterm" class="form-control" required 
               placeholder="Enter search term...">
      </div>

      <div class="button-group">
        <button type="submit" class="btn-primary">Search</button>
        <a href="customerHistoryView.php" class="btn-secondary">View All</a>
      </div>

    </form>
  </div>

  <script>
    // Add animation on load
    document.addEventListener('DOMContentLoaded', function() {
      // Add filled class to inputs with values
      document.querySelectorAll('.form-control, .form-select').forEach(element => {
        element.addEventListener('input', function() {
          if (this.value) {
            this.classList.add('filled');
          } else {
            this.classList.remove('filled');
          }
        });
        
        // Check on page load
        if (element.value) {
          element.classList.add('filled');
        }
      });
      
      // Add keyboard shortcut (Enter to submit)
      document.querySelector('form').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.target.matches('a')) {
          e.preventDefault();
          this.submit();
        }
      });
    });
  </script>

</body>
</html>