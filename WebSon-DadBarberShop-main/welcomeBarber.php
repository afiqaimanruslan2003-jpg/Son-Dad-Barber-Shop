<?php include 'headerBarber.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Son & Dad Barber Shop - Premium Grooming Experience</title>
  <meta name="description"
    content="Son & Dad Barber Shop - Professional grooming services in Penang and Selangor. Book your appointment online for the perfect haircut.">
  <meta name="keywords" content="barber shop, haircut, grooming, Penang, Selangor, Malaysia, beard trim, styling">
  <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <style>
    :root {
      --sage-green: #b5bcab;
      --dark-charcoal: #3d3939;
      --gold-accent: #d4af37;
      --transition-smooth: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: "Oswald", sans-serif;
      background-color: #fff;
      overflow-x: hidden;
    }

    /* --- HERO SECTION with Parallax & Typewriter --- */
    .hero {
      height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
        url("n1.jpg");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      /* Parallax effect */
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
      z-index: 1;
      animation: shimmer 8s infinite linear;
    }

    @keyframes shimmer {
      0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
      }

      100% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
      }
    }

    .hero-text {
      position: relative;
      z-index: 2;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeUp 1s ease-out 0.3s forwards;
    }

    .hero-text h1 {
      font-size: 4rem;
      font-style: italic;
      text-transform: uppercase;
      letter-spacing: 3px;
      margin: 0;
      text-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
      position: relative;
      display: inline-block;
    }

    .hero-text h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 150px;
      height: 3px;
      background: var(--gold-accent);
      animation: lineGrow 1.2s ease-out 1.5s forwards;
      transform-origin: center;
      transform: translateX(-50%) scaleX(0);
    }

    .hero-text p {
      font-size: 2rem;
      font-style: italic;
      margin-bottom: 5px;
      font-weight: 300;
      opacity: 0;
      animation: fadeIn 1s ease-out 0.8s forwards;
    }

    .scroll-indicator {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      color: white;
      font-size: 14px;
      letter-spacing: 2px;
      opacity: 0;
      animation: fadeIn 1s ease-out 2s forwards;
    }

    .scroll-indicator i {
      display: block;
      margin-top: 10px;
      font-size: 24px;
      animation: bounce 2s infinite;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }

    @keyframes lineGrow {
      to {
        transform: translateX(-50%) scaleX(1);
      }
    }

    @keyframes bounce {

      0%,
      20%,
      50%,
      80%,
      100% {
        transform: translateY(0);
      }

      40% {
        transform: translateY(-10px);
      }

      60% {
        transform: translateY(-5px);
      }
    }

    /* --- BOOKING SECTION --- */
    .booking-section {
      padding: 80px 20px;
      text-align: center;
      background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);
      position: relative;
    }

    .booking-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--dark-charcoal), var(--gold-accent), var(--dark-charcoal));
      background-size: 200% 100%;
      animation: gradientShift 3s infinite linear;
    }

    @keyframes gradientShift {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .booking-section h3 {
      font-size: 2.2rem;
      margin-bottom: 40px;
      font-weight: 600;
      position: relative;
      display: inline-block;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s ease-out 0.2s forwards;
    }

    .booking-section h3 i {
      color: var(--gold-accent);
      margin-left: 10px;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.2);
      }

      100% {
        transform: scale(1);
      }
    }

    .booking-flex-wrapper {
      display: flex;
      max-width: 1200px;
      margin: 0 auto;
      background: white;
      padding: 40px;
      border-radius: 20px;
      gap: 40px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      opacity: 0;
      transform: translateY(30px);
      animation: fadeUp 0.8s ease-out 0.4s forwards;
      transition: var(--transition-smooth);
    }

    .booking-flex-wrapper:hover {
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      transform: translateY(-5px);
    }

    .booking-container {
      flex: 1;
      padding: 20px;
    }

    .select-box {
      width: 100%;
      padding: 18px 20px;
      margin-bottom: 20px;
      border-radius: 10px;
      border: 2px solid #e0e0e0;
      font-family: "Oswald", sans-serif;
      font-size: 18px;
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 1px;
      background: white;
      cursor: pointer;
      transition: var(--transition-smooth);
      position: relative;
      overflow: hidden;
    }

    .select-box:hover {
      border-color: var(--gold-accent);
      box-shadow: 0 5px 15px rgba(212, 175, 55, 0.2);
      transform: translateY(-2px);
    }

    .select-box:focus {
      outline: none;
      border-color: var(--dark-charcoal);
      box-shadow: 0 0 0 3px rgba(61, 57, 57, 0.1);
    }

    /* Animated option appearance */
    .select-box option {
      padding: 12px;
      background: white;
      transition: background 0.3s;
    }

    .select-box option:hover {
      background: var(--gold-accent) !important;
      color: white;
    }

    .map-container {
      flex: 1;
      min-height: 400px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: var(--transition-smooth);
    }

    .map-container:hover {
      transform: scale(1.01);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    iframe {
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 15px;
    }

    /* --- BUTTON STYLES --- */
    .button-container {
      text-align: center;
      margin-top: 40px;
      opacity: 0;
      animation: fadeIn 1s ease-out 0.6s forwards;
    }

    .confirm-btn {
      background: linear-gradient(135deg, var(--dark-charcoal) 0%, #2a2626 100%);
      color: white;
      font-family: "Oswald", sans-serif;
      font-size: 1.3rem;
      padding: 18px 50px;
      border: none;
      cursor: pointer;
      letter-spacing: 2px;
      border-radius: 50px;
      position: relative;
      overflow: hidden;
      transition: var(--transition-smooth);
      text-transform: uppercase;
      font-weight: 600;
      box-shadow: 0 10px 20px rgba(61, 57, 57, 0.2);
    }

    .confirm-btn:hover {
      background: linear-gradient(135deg, #25d366 0%, #1da851 100%);
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 15px 30px rgba(37, 211, 102, 0.3);
      letter-spacing: 3px;
    }

    .confirm-btn:active {
      transform: translateY(-2px) scale(1.02);
    }

    .confirm-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .confirm-btn:hover::before {
      left: 100%;
    }

    /* --- VIDEO SECTION --- */
    .video-section {
      text-align: center;
      padding: 80px 20px;
      background: var(--dark-charcoal);
      color: white;
      position: relative;
      overflow: hidden;
    }

    .video-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(212,175,55,0.05)" d="M0,0 L100,0 L100,100 Z"/></svg>');
      background-size: cover;
      animation: float 20s infinite linear;
    }

    @keyframes float {
      0% {
        transform: translateY(0) translateX(0);
      }

      50% {
        transform: translateY(-20px) translateX(20px);
      }

      100% {
        transform: translateY(0) translateX(0);
      }
    }

    .video-section h1 {
      font-size: 3.5rem;
      margin-bottom: 20px;
      position: relative;
      display: inline-block;
      opacity: 0;
      animation: fadeUp 1s ease-out 0.3s forwards;
    }

    .video-section h1::after {
      content: '✄';
      position: absolute;
      right: -40px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gold-accent);
      font-size: 2rem;
      animation: spin 10s infinite linear;
    }

    @keyframes spin {
      0% {
        transform: translateY(-50%) rotate(0deg);
      }

      100% {
        transform: translateY(-50%) rotate(360deg);
      }
    }

    .video-subtitle {
      font-size: 1.4rem;
      max-width: 800px;
      margin: 0 auto 40px;
      line-height: 1.6;
      color: rgba(255, 255, 255, 0.9);
      opacity: 0;
      animation: fadeUp 1s ease-out 0.5s forwards;
    }

    .video-container {
      max-width: 900px;
      margin: 0 auto;
      opacity: 0;
      transform: scale(0.95);
      animation: zoomIn 1s ease-out 0.7s forwards;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    @keyframes zoomIn {
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .video-responsive {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
      transition: var(--transition-smooth);
    }

    .video-responsive:hover {
      transform: scale(1.02);
    }

    /* --- FOOTER --- */
    footer {
      background: linear-gradient(135deg, #2a2626 0%, var(--dark-charcoal) 100%);
      color: white;
      padding: 60px 30px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
      position: relative;
      overflow: hidden;
    }

    footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--gold-accent), transparent, var(--gold-accent));
      animation: gradientShift 3s infinite linear;
    }

    .footer-col {
      position: relative;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s ease-out forwards;
    }

    .footer-col:nth-child(1) {
      animation-delay: 0.2s;
    }

    .footer-col:nth-child(2) {
      animation-delay: 0.4s;
    }

    .footer-col h4 {
      font-size: 1.8rem;
      margin-bottom: 25px;
      position: relative;
      display: inline-block;
      letter-spacing: 1px;
    }

    .footer-col h4::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 50px;
      height: 3px;
      background: var(--gold-accent);
      transition: width 0.3s ease;
    }

    .footer-col:hover h4::after {
      width: 100%;
    }

    .contact-info {
      font-size: 1.1rem;
      line-height: 1.8;
    }

    .contact-info strong {
      color: var(--gold-accent);
      display: block;
      margin-bottom: 10px;
      font-size: 1.2rem;
    }

    .contact-info i {
      color: var(--gold-accent);
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    /* Social Icons */
    .social-icons {
      display: flex;
      gap: 20px;
      margin-top: 30px;
      justify-content: center;
    }

    .social-icons a {
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      text-decoration: none;
      font-size: 24px;
      transition: var(--transition-smooth);
      position: relative;
      overflow: hidden;
    }

    .social-icons a::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.1);
      transform: scale(0);
      border-radius: 50%;
      transition: transform 0.3s ease;
    }

    .social-icons a:hover::before {
      transform: scale(1);
    }

    .social-icons a:hover {
      transform: translateY(-5px) scale(1.1);
    }

    .fa-facebook {
      background: #4661b0;
      color: white;
      border: 2px solid #4661b0;
    }

    .fa-whatsapp {
      background: #25d366;
      color: white;
      border: 2px solid #25d366;
    }

    .fa-instagram {
      background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
      color: white;
      border: 2px solid transparent;
      background-clip: padding-box;
    }

    .footer-bottom {
      grid-column: 1 / -1;
      text-align: center;
      padding-top: 40px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: 20px;
      opacity: 0;
      animation: fadeIn 1s ease-out 0.8s forwards;
    }

    .footer-bottom p {
      font-size: 1.1rem;
      letter-spacing: 1px;
      margin-bottom: 20px;
      font-style: italic;
      color: rgba(255, 255, 255, 0.8);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .hero-text h1 {
        font-size: 3rem;
      }

      .booking-flex-wrapper {
        flex-direction: column;
      }

      .map-container {
        height: 350px;
      }
    }

    @media (max-width: 768px) {
      .hero-text h1 {
        font-size: 2.5rem;
      }

      .hero-text p {
        font-size: 1.5rem;
      }

      .booking-section h3 {
        font-size: 1.8rem;
      }

      .video-section h1 {
        font-size: 2.5rem;
      }

      .confirm-btn {
        padding: 15px 35px;
        font-size: 1.1rem;
      }

      .social-icons a {
        width: 45px;
        height: 45px;
        font-size: 20px;
      }
    }

    @media (max-width: 480px) {
      .hero-text h1 {
        font-size: 2rem;
      }

      .booking-flex-wrapper {
        padding: 20px;
      }

      .select-box {
        padding: 15px;
        font-size: 16px;
      }

      .video-container {
        border-radius: 10px;
      }
    }

    /* Loading Animation */
    .loading-bar {
      position: fixed;
      top: 0;
      left: 0;
      width: 0%;
      height: 3px;
      background: var(--gold-accent);
      z-index: 9999;
      transition: width 0.3s ease;
    }

    /* Floating Elements */
    .floating-icon {
      position: absolute;
      font-size: 24px;
      color: var(--gold-accent);
      opacity: 0.3;
      animation: floatRandom 20s infinite linear;
      pointer-events: none;
    }

    @keyframes floatRandom {
      0% {
        transform: translate(0, 0) rotate(0deg);
      }

      25% {
        transform: translate(100px, 50px) rotate(90deg);
      }

      50% {
        transform: translate(50px, 100px) rotate(180deg);
      }

      75% {
        transform: translate(-50px, 50px) rotate(270deg);
      }

      100% {
        transform: translate(0, 0) rotate(360deg);
      }
    }

    /* Progress indicator for form */
    .form-progress {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 30px;
    }

    .progress-step {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: #666;
      position: relative;
      transition: all 0.3s ease;
    }

    .progress-step.active {
      background: var(--gold-accent);
      color: white;
      transform: scale(1.1);
      box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    .progress-step.completed {
      background: var(--dark-charcoal);
      color: white;
    }

    .whatsapp-fixed {
      display: inline-flex !important;
      width: 40px !important;
      height: 40px !important;
      align-items: center !important;
      justify-content: center !important;
      background: #25d366 !important;
      color: white !important;
      border-radius: 50% !important;
      text-decoration: none !important;
      border: 2px solid #25d366 !important;
      margin: 0 !important;
      padding: 0 !important;
      font-size: 20px !important;
    }
  </style>
</head>

<body>
  <!-- Loading Bar -->
  <div class="loading-bar" id="loadingBar"></div>

  <!-- Floating Decorative Icons -->
  <div class="floating-icon" style="top: 20%; left: 10%;">✄</div>
  <div class="floating-icon" style="top: 40%; right: 15%;">✂</div>
  <div class="floating-icon" style="bottom: 30%; left: 20%;">💈</div>

  <!-- Hero Section -->
  <section class="hero" id="welcome">
    <div class="hero-text">
      <p class="welcome-text">WELCOME TO</p>
      <h1>SON & DAD BARBER SHOP</h1>
      <p class="tagline">Where Tradition Meets Style</p>
    </div>
    <div class="scroll-indicator">
      SCROLL DOWN
      <i class="fa fa-chevron-down"></i>
    </div>
  </section>

  <!-- Booking Section -->
  <section class="booking-section" id="booking">
    <h3>
      Choose Which Barber location you want to make a booking
      <i class="fa fa-map-marker"></i>
    </h3>

    <!-- Progress Indicator -->
    <div class="form-progress">
      <div class="progress-step active">1</div>
      <div class="progress-step">2</div>
      <div class="progress-step">3</div>
    </div>

    <div class="booking-flex-wrapper">
      <div class="booking-container">
        <select id="negeri" class="select-box" onchange="updateDaerah()">
          <option value="">SELECT STATE</option>
          <option value="penang">PENANG</option>
          <option value="selangor">SELANGOR</option>
        </select>

        <select id="daerah" class="select-box" onchange="updateKawasan()">
          <option value="">SELECT DISTRICT</option>
        </select>

        <select id="kawasan" class="select-box" onchange="updateMap()">
          <option value="">SELECT AREA</option>
        </select>

        <div class="button-container">
          <a href="new_form_customer.php" id="bookingLink">
            <button class="confirm-btn">
              <i class="fa fa-calendar-check-o" style="margin-right: 10px;"></i>
              CONFIRM BOOKING
            </button>
          </a>
        </div>
      </div>

      <div class="map-container">
        <iframe id="googleMap"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.3384218765324!2d100.33446007584443!3d5.411130534569528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ac396dfc64e6b%3A0xe67e4368538749a!2sSon%20%26%20Dad%20Barber%20Shop!5e0!3m2!1sen!2smy!4v1715843467431!5m2!1sen!2smy"
          width="100%" height="100%" style="border: 0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </section>

  <!-- Video Section -->
  <section class="video-section" id="video">
    <h1>SON & DAD BARBERSHOP</h1>
    <p class="video-subtitle">
      When you know how to truly see a haircut, you'll never look at the world
      in the same way again. Experience craftsmanship at its finest.
    </p>

    <div class="video-container">
      <div class="video-responsive">
        <div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.25%;"><iframe
            src="https://www.youtube.com/embed/gaMJvd-uJTQ?rel=0"
            style="top: 0; left: 0; width: 100%; height: 100%; position: absolute; border: 0;" allowfullscreen
            scrolling="no"
            allow="accelerometer *; clipboard-write *; encrypted-media *; gyroscope *; picture-in-picture *; web-share *;"
            referrerpolicy="strict-origin"></iframe></div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="contact">
    <div class="footer-col">
      <h4>PENANG</h4>
      <div class="contact-info">
        <strong>CONTACT INFORMATION</strong>
        <div><i class="fa fa-map-marker"></i> 49 Lebuh Acheh, Penang, Malaysia</div>
        <div><i class="fa fa-phone"></i> 04-266 3661</div>
        <div>
          <a href="https://wa.me/60194419214" class="fa fa-whatsapp whatsapp-fixed"></a>
          <span style="color: white; margin-left: 10px; font-weight: bold;">019 4419 214</span>
          <span style="color: #d4af37; margin-left: 10px; font-style: italic;">(CLICK TO CHAT)</span>
        </div>
      </div>
    </div>

    <div class="footer-col">
      <h4>SELANGOR</h4>
      <div class="contact-info">
        <strong>CONTACT INFORMATION</strong>
        <div><i class="fa fa-map-marker"></i> 128-M Jalan SS21/35 Damansara Utama, PJ</div>
        <div><i class="fa fa-phone"></i> 03-7731 0656</div>
        <div>
          <a href="https://wa.me/60194009214" class="fa fa-whatsapp whatsapp-fixed"></a>
          <span style="color: white; margin-left: 10px; font-weight: bold;">019 400 9 214</span>
          <span style="color: #d4af37; margin-left: 10px; font-style: italic;">(CLICK TO CHAT)</span>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>
        <i class="fa fa-scissors" style="margin-right: 15px; color: var(--gold-accent);"></i>
        "Nothing much better than classic shit"
        <i class="fa fa-scissors" style="margin-left: 15px; color: var(--gold-accent); transform: rotate(180deg);"></i>
      </p>
      <div class="social-icons">
        <a href="https://www.instagram.com/sonanddadofficial" class="fa fa-instagram" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://www.facebook.com/sonanddadbarbershop" class="fa fa-facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://wa.me/60194419214" class="fa fa-whatsapp" target="_blank"> <i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
  </footer>

  <script>
    // Loading Bar Simulation
    window.addEventListener('load', function () {
      const loadingBar = document.getElementById('loadingBar');
      loadingBar.style.width = '100%';
      setTimeout(() => {
        loadingBar.style.opacity = '0';
        setTimeout(() => loadingBar.style.display = 'none', 300);
      }, 500);
    });

    // Data for locations
    const data = {
      penang: ["Georgetown"],
      selangor: ["Petaling Jaya"]
    };

    const data1 = {
      georgetown: ["Lebuh Aceh"],
      "petaling-jaya": ["Damansara Utama"]
    };

    const mapLinks = {
      "lebuh-aceh": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3553.0927895383857!2d100.33401197441536!3d5.414472935057805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ac3923c0ebe07%3A0xcd2cb749b0d6b6b4!2sSon%20%26%20Dad%20Barbershop%20Penang!5e1!3m2!1sen!2smy!4v1767138209830!5m2!1sen!2smy",
      "damansara-utama": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3563.680850112936!2d101.62188307441035!3d3.13356235324944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49d38405550d%3A0xa18369e59bf8473e!2sSon%20%26%20Dad%20Barbershop%20Damansara!5e1!3m2!1sen!2smy!4v1767138183359!5m2!1sen!2smy"
    };

    // Form progress indicator
    const progressSteps = document.querySelectorAll('.progress-step');

    function updateDaerah() {
      const negeriValue = document.getElementById("negeri").value;
      const daerahSelect = document.getElementById("daerah");
      const kawasanSelect = document.getElementById("kawasan");

      // Clear and reset
      daerahSelect.innerHTML = '<option value="">SELECT DISTRICT</option>';
      kawasanSelect.innerHTML = '<option value="">SELECT AREA</option>';

      // Update progress
      progressSteps[0].classList.add('completed');
      progressSteps[1].classList.add('active');
      progressSteps[1].classList.remove('completed');
      progressSteps[2].classList.remove('active');

      if (data[negeriValue]) {
        data[negeriValue].forEach((place) => {
          let opt = document.createElement("option");
          opt.value = place.toLowerCase().replace(/\s+/g, "-");
          opt.text = place.toUpperCase();
          opt.classList.add('animated', 'fadeIn');
          daerahSelect.add(opt);
        });

        // Animate select box
        daerahSelect.classList.add('animated', 'pulse');
        setTimeout(() => daerahSelect.classList.remove('animated', 'pulse'), 1000);
      }
    }

    function updateKawasan() {
      const selectedDaerah = document.getElementById("daerah").value;
      const kawasanSelect = document.getElementById("kawasan");

      kawasanSelect.innerHTML = '<option value="">SELECT AREA</option>';

      // Update progress
      progressSteps[1].classList.add('completed');
      progressSteps[2].classList.add('active');

      if (data1[selectedDaerah]) {
        data1[selectedDaerah].forEach((street) => {
          let opt = document.createElement("option");
          opt.value = street.toLowerCase().replace(/\s+/g, "-");
          opt.text = street.toUpperCase();
          opt.classList.add('animated', 'fadeIn');
          kawasanSelect.add(opt);
        });

        // Animate select box
        kawasanSelect.classList.add('animated', 'pulse');
        setTimeout(() => kawasanSelect.classList.remove('animated', 'pulse'), 1000);
      }
    }

    function updateMap() {
      const selectedValue = document.getElementById("kawasan").value;
      const mapFrame = document.getElementById("googleMap");
      const mapContainer = document.querySelector('.map-container');

      // Add loading animation
      mapContainer.style.opacity = '0.7';
      mapContainer.style.transform = 'scale(0.98)';

      if (mapLinks[selectedValue]) {
        setTimeout(() => {
          mapFrame.src = mapLinks[selectedValue];
          // Animate back
          mapContainer.style.opacity = '1';
          mapContainer.style.transform = 'scale(1)';

          // Add completion animation
          mapContainer.classList.add('animated', 'pulse');
          setTimeout(() => mapContainer.classList.remove('animated', 'pulse'), 1000);
        }, 300);
      }
    }

    // Fixed booking link handler
    document.getElementById('bookingLink').addEventListener('click', function (e) {
      e.preventDefault(); // Always prevent default first

      const negeri = document.getElementById("negeri").value;
      const daerah = document.getElementById("daerah").value;
      const kawasan = document.getElementById("kawasan").value;
      const bookingLink = this.href; // Store the original link
      const button = document.querySelector('.confirm-btn');

      if (!negeri || !daerah || !kawasan) {
        // Animate error
        const selects = [
          document.getElementById("negeri"),
          document.getElementById("daerah"),
          document.getElementById("kawasan")
        ];

        selects.forEach(select => {
          if (!select.value) {
            select.classList.add('animated', 'shake');
            select.style.borderColor = '#ff4757';
            setTimeout(() => {
              select.classList.remove('animated', 'shake');
              select.style.borderColor = '';
            }, 1000);
          }
        });

        // Show error message
        alert('Please complete all location selections before booking!');
        return false;
      }

      // All good - show success animation
      button.innerHTML = '<i class="fa fa-check"></i> BOOKING CONFIRMED!';
      button.style.background = 'linear-gradient(135deg, #25d366 0%, #1da851 100%)';

      // Store selection in localStorage
      localStorage.setItem('booking_location', JSON.stringify({
        negeri: negeri,
        daerah: daerah,
        kawasan: kawasan
      }));

      // Redirect after animation
      setTimeout(() => {
        window.location.href = bookingLink;
      }, 800); // Give time for animation to show
    });

    // Scroll animations
    window.addEventListener('scroll', function () {
      const scrollPosition = window.scrollY;
      const hero = document.querySelector('.hero');

      // Parallax effect
      hero.style.backgroundPositionY = scrollPosition * 0.5 + 'px';

      // Fade in elements on scroll
      const elements = document.querySelectorAll('.booking-section, .video-section, .footer-col');
      elements.forEach(el => {
        const position = el.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (position < screenPosition) {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        }
      });
    });

    // Initialize animations on load
    window.addEventListener('DOMContentLoaded', function () {
      // Add typing effect to welcome text
      const welcomeText = document.querySelector('.welcome-text');
      const text = welcomeText.textContent;
      welcomeText.textContent = '';
      let i = 0;

      function typeWriter() {
        if (i < text.length) {
          welcomeText.textContent += text.charAt(i);
          i++;
          setTimeout(typeWriter, 100);
        }
      }
      setTimeout(typeWriter, 1000);
    });
  </script>
</body>

</html>