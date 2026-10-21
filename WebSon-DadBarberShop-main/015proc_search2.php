<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Search Result | Barber Elite</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Merriweather Font -->
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

  <!-- Custom Style -->
  <style>
    :root {
      --gold: #d4af37;
      --dark-bg: #121212;
      --card-bg: rgba(30, 30, 30, 0.95);
      --input-bg: #2a2a2a;
      --border-color: #444;
      --text-dim: #888;
      --text-bright: #ffffff;
      --red: #ff0000;
      --blue: #0000ff;
      --success: #2ecc71;
      --warning: #e74c3c;
      --info: #3498db;
    }

    body {
      background: #1a1a1a;
      background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('n1.jpg');
      background-size: cover;
      background-attachment: fixed;
      font-family: 'Merriweather', serif;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
      color: var(--text-bright);
    }

    .container {
      max-width: 1300px;
      margin: 30px auto;
      background-color: var(--card-bg);
      padding: 5px;
      border: 2px solid var(--gold);
      position: relative;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
      animation: slideIn 0.8s ease-out;
      overflow: hidden;
    }

    /* Barber Pole Top Border */
    .container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 10px;
      background: repeating-linear-gradient(45deg, 
          var(--red), var(--red) 20px,
          var(--text-bright) 20px, var(--text-bright) 40px,
          var(--blue) 40px, var(--blue) 60px,
          var(--text-bright) 60px, var(--text-bright) 80px);
      z-index: 1;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; }
    }

    .content-wrapper {
      padding: 40px 30px;
      position: relative;
      z-index: 2;
    }

    .page-title {
      font-weight: 700;
      font-size: 28px;
      color: var(--gold);
      margin-bottom: 30px;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 2px;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 20px;
      animation: fadeIn 0.6s ease-out 0.3s both;
    }

    /* Results Card */
    .results-card {
      background-color: var(--dark-bg);
      border: 1px solid var(--border-color);
      padding: 25px;
      margin-bottom: 30px;
      animation: fadeInUp 0.6s ease-out 0.4s both;
      overflow-x: auto;
    }

    /* Table Styling */
    .results-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      font-size: 14px;
    }

    .results-table th {
      background-color: rgba(212, 175, 55, 0.1);
      color: var(--gold);
      text-transform: uppercase;
      font-size: 12px;
      letter-spacing: 1px;
      padding: 15px 10px;
      text-align: left;
      border-bottom: 2px solid var(--border-color);
      white-space: nowrap;
    }

    .results-table td {
      padding: 12px 10px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-bright);
    }

    .results-table tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.03);
    }

    .results-table tr:hover {
      background-color: rgba(212, 175, 55, 0.08);
      transition: background-color 0.2s;
    }

    /* Selected row style */
    .results-table tr.selected {
      background-color: rgba(212, 175, 55, 0.15) !important;
      outline: 2px solid var(--gold);
    }

    /* Status Alert */
    .status-alert {
      background-color: rgba(52, 152, 219, 0.1);
      border: 1px solid var(--info);
      color: var(--text-bright);
      padding: 15px;
      border-radius: 2px;
      text-align: center;
      margin-bottom: 25px;
      animation: fadeIn 0.6s ease-out 0.5s both;
      font-weight: bold;
      font-size: 16px;
    }

    .status-alert strong {
      color: var(--gold);
      font-size: 18px;
      margin-right: 10px;
    }

    /* Buttons */
    .button-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
      animation: fadeIn 0.6s ease-out 0.6s both;
    }

    .btn {
      background-color: transparent;
      border: 1px solid var(--gold);
      color: var(--gold);
      padding: 12px 30px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s;
      font-family: inherit;
      cursor: pointer;
      font-size: 14px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 160px;
    }

    .btn:hover {
      background-color: var(--gold);
      color: var(--dark-bg);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
      text-decoration: none;
    }

    .btn-primary {
      background-color: var(--gold);
      color: var(--dark-bg);
    }

    .btn-primary:hover {
      background-color: var(--text-bright);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 40px;
      color: var(--text-dim);
      font-size: 16px;
      animation: fadeIn 0.6s ease-out 0.4s both;
    }

    .empty-state td {
      padding: 30px !important;
      font-size: 16px;
      color: var(--text-dim);
    }

    /* Search Info */
    .search-info {
      color: var(--text-dim);
      font-size: 14px;
      text-align: center;
      margin-bottom: 20px;
      padding: 10px;
      background-color: rgba(0, 0, 0, 0.2);
      border-radius: 2px;
      animation: fadeIn 0.6s ease-out 0.5s both;
    }

    .search-info strong {
      color: var(--gold);
    }

    /* Focus states */
    .btn:focus-visible {
      outline: 2px solid var(--text-bright);
      outline-offset: 2px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .content-wrapper {
        padding: 30px 20px;
      }
      
      .page-title {
        font-size: 24px;
        margin-bottom: 25px;
      }
      
      .results-table {
        font-size: 13px;
      }
      
      .results-table th,
      .results-table td {
        padding: 10px 8px;
      }
      
      .button-group {
        flex-direction: column;
        gap: 15px;
      }
      
      .btn {
        width: 100%;
        min-width: auto;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 10px;
      }
      
      .container {
        margin: 10px auto;
        border-width: 1px;
      }
      
      .content-wrapper {
        padding: 25px 15px;
      }
      
      .page-title {
        font-size: 20px;
        padding-bottom: 15px;
      }
      
      .results-table {
        display: block;
        overflow-x: auto;
      }
    }
  </style>
</head>

<body>
<div class="container">
  <div class="content-wrapper">
    <h1 class="page-title">Customer Search Results</h1>

    <?php
    include('001link_db2.php');

    // Check database connection
    if (!$conn) {
        echo '<div class="status-alert" style="border-color: #e74c3c; background-color: rgba(231, 76, 60, 0.1);">
                Database connection failed. Please try again later.
              </div>';
        exit;
    }

    // Get and sanitize search parameters
    $searchtype = $_POST['searchtype'] ?? '';
    $searchterm = trim($_POST['searchterm'] ?? '');

    // Validate input
    if (!$searchtype || !$searchterm) {
        echo '<div class="status-alert" style="border-color: #e74c3c; background-color: rgba(231, 76, 60, 0.1);">
                Please enter your search term.
              </div>';
        exit;
    }

    // Validate search type
    $allowed = ['booking_id', 'IC', 'name', 'no_phone'];
    if (!in_array($searchtype, $allowed)) {
        echo '<div class="status-alert" style="border-color: #e74c3c; background-color: rgba(231, 76, 60, 0.1);">
                Invalid search type.
              </div>';
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM customer WHERE $searchtype LIKE ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        echo '<div class="status-alert" style="border-color: #e74c3c; background-color: rgba(231, 76, 60, 0.1);">
                Database query error.
              </div>';
        exit;
    }

    $searchterm_like = "%$searchterm%";
    mysqli_stmt_bind_param($stmt, "s", $searchterm_like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $num_results = mysqli_num_rows($result);

    // Human readable search type
    $search_labels = [
        'booking_id' => 'Booking ID',
        'IC' => 'IC Number',
        'name' => 'Customer Name',
        'no_phone' => 'Phone Number'
    ];
    $search_label = $search_labels[$searchtype] ?? $searchtype;
    ?>

    <!-- Search Information -->
    <div class="search-info">
      Searching by <strong><?php echo htmlspecialchars($search_label); ?></strong> for: 
      <strong>"<?php echo htmlspecialchars($searchterm); ?>"</strong>
    </div>

    <!-- Results Count -->
    <div class="status-alert">
      <strong>📊 <?php echo $num_results; ?></strong> record<?php echo $num_results == 1 ? '' : 's'; ?> found
    </div>

    <!-- Results Table -->
    <div class="results-card">
      <?php if ($num_results > 0): ?>
        <table class="results-table">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>IC Number</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Age</th>
              <th>Date of Birth</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $row_counter = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $row_counter++;
                $row_animation = "animation-delay: " . (0.1 * $row_counter) . "s;";
                echo "<tr style='opacity: 0; animation: fadeInUp 0.5s ease-out forwards; animation-delay: " . (0.1 * $row_counter) . "s;'>";
                echo "<td class='booking-id'><strong>" . htmlspecialchars($row['booking_id']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($row['IC']) . "</td>";
                echo "<td class='customer-name'><strong>" . htmlspecialchars($row['name']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($row['no_phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="empty-state">
          <p style="font-size: 18px; margin-bottom: 15px;">🔍 No records found</p>
          <p style="color: var(--text-dim);">Try searching with different terms</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Action Buttons -->
    <div class="button-group">
      <a href="014frm_search.php" class="btn btn-primary">
        ← Back to Search
      </a>
      <a href="003data_tbl_View.php" class="btn">
        👥 View All Customers
      </a>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Add click effect to table rows
    const tableRows = document.querySelectorAll('.results-table tbody tr');
    
    if (tableRows.length > 0) {
      tableRows.forEach(row => {
        row.addEventListener('click', function() {
          // Remove selected class from all rows
          tableRows.forEach(r => r.classList.remove('selected'));
          
          // Add selected class to clicked row
          this.classList.add('selected');
          
          // Get customer details from clicked row
          const nameElement = this.querySelector('.customer-name strong');
          const idElement = this.querySelector('.booking-id strong');
          
          if (nameElement && idElement) {
            const customerName = nameElement.textContent;
            const bookingId = idElement.textContent;
            
            // Show notification
            showNotification(`Selected: ${customerName} (${bookingId})`);
          }
        });
      });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        window.history.back();
      }
    });
  });
  
  function showNotification(message) {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.custom-notification');
    if (existingNotification) {
      existingNotification.remove();
    }
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.textContent = message;
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: var(--gold);
      color: var(--dark-bg);
      padding: 12px 20px;
      border-radius: 2px;
      font-weight: bold;
      z-index: 1000;
      animation: slideInRight 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove notification after 2 seconds
    setTimeout(() => {
      notification.style.animation = 'fadeOut 0.3s ease-out forwards';
      setTimeout(() => notification.remove(), 300);
    }, 2000);
  }
</script>
</body>
</html>