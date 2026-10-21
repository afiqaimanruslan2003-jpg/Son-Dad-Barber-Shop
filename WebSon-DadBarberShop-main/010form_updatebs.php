<?php
include('001link_db2.php');

// 1. DETECTION LOGIC
if (isset($_GET['payment_id'])) {
  $mode = "payment";
  $id = mysqli_real_escape_string($conn, $_GET['payment_id']);
  $query = "SELECT * FROM payment_history WHERE payment_id='$id'";
} elseif (isset($_GET['booking_id'])) {
  $mode = "customer";
  $id = mysqli_real_escape_string($conn, $_GET['booking_id']);
  $query = "SELECT * FROM customer WHERE booking_id='$id'";
} elseif (isset($_GET['service_type_id'])) {
  $mode = "service";
  $id = mysqli_real_escape_string($conn, $_GET['service_type_id']);
  $query = "SELECT * FROM service_list WHERE service_type_id='$id'";
} else {
  header("Location: dashboard.php");
  exit();
}

$result = mysqli_query($conn, $query);
if (!$result) {
  die("Query error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
  die("Record not found! Please check your table structure.");
}

// Fetch services for dropdown (for payment form)
$service_query = "SELECT service_name, description, barber_name, amount, duration_minutes FROM service_list ORDER BY service_name ASC";
$all_services = $conn->query($service_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit System Record</title>
  <style>
    :root {
      --gold: #d4af37;
      --dark-bg: #121212;
      --input-bg: #2a2a2a;
      --border-color: #444;
      --text-dim: #888;
      --text-bright: #ffffff;
    }

    body {
      background: #1a1a1a;
      background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('n1.jpg');
      background-size: cover;
      background-attachment: fixed;
      font-family: 'Merriweather', serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: var(--gold);
      margin: 0;
    }

    .outer-box {
      background-color: var(--dark-bg);
      width: 100%;
      max-width: 450px;
      padding: 5px;
      border: 2px solid var(--gold);
      position: relative;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
      animation: slideDown 0.8s ease-out;
    }

    @keyframes slideDown {
      from {
        transform: translateY(-30px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .outer-box::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 10px;
      background: repeating-linear-gradient(-45deg,
          #ff3b3b, #ff3b3b 20px,
          #ffffff 20px, #ffffff 40px,
          #3b59ff 40px, #3b59ff 60px,
          #ffffff 60px, #ffffff 80px);
    }

    .inner-content {
      padding: 40px 30px;
      color: white;
      position: relative;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 30px;
      font-size: 28px;
      border-bottom: 1px solid #444;
      padding-bottom: 20px;
    }

    label {
      display: block;
      color: var(--gold);
      font-size: 11px;
      font-weight: bold;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .form-row {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    /* Standard Input Styling */
    input,
    select {
      width: 100%;
      background-color: var(--input-bg);
      border: 1px solid var(--border-color);
      padding: 12px;
      color: var(--text-dim);
      font-size: 16px;
      outline: none;
      box-sizing: border-box;
      transition: all 0.3s ease;
      font-family: inherit;
    }

    /* When user clicks into a field */
    input:focus,
    select:focus {
      border-color: var(--gold);
      color: var(--text-bright);
      box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
    }

    /* Class to be added via JS when a field has data */
    .filled {
      color: var(--text-bright) !important;
      border-color: #666;
    }

    .id-field {
      border: 1px dashed #666;
      background-color: transparent;
      color: #666;
      margin-bottom: 25px;
      font-family: monospace;
      letter-spacing: 1px;
      cursor: not-allowed;
    }

    .readonly-field {
      background-color: rgba(255, 255, 255, 0.05) !important;
      cursor: not-allowed;
      color: #ccc;
    }

    .btn-submit {
      background-color: var(--gold);
      color: black;
      border: none;
      width: 100%;
      padding: 15px;
      font-size: 18px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 2px;
      cursor: pointer;
      margin-top: 10px;
      transition: 0.3s;
      font-family: inherit;
    }

    .btn-submit:hover {
      background-color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
      .inner-content {
        padding: 30px 20px;
      }

      .form-row {
        grid-template-columns: 1fr;
        gap: 10px;
      }

      h2 {
        font-size: 24px;
        margin-bottom: 20px;
      }

      .btn-submit {
        padding: 12px;
        font-size: 16px;
      }
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-bottom: 20px;
    }

    .input-group-addon {
      background-color: #333;
      color: #d4af37;
      border: 1px solid #444;
      border-left: none;
    }

    .input-group .form-control {
      border-right: none;
    }

    .status-options {
      display: flex;
      gap: 20px;
      margin-top: 8px;
    }

    .radio-inline {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .status-active {
      color: #2ecc71;
    }

    .status-inactive {
      color: #e74c3c;
    }

    .status-pending {
      color: #f39c12;
    }

    .button-group {
      display: flex;
      gap: 15px;
      margin-top: 25px;
    }

    .btn-cancel {
      background: transparent;
      border: 1px solid #d4af37;
      color: #d4af37;
      padding: 12px 30px;
      width: 100%;
      font-weight: bold;
      text-transform: uppercase;
      transition: 0.3s;
    }

    .btn-cancel:hover {
      background: #d4af37;
      color: #000;
    }

    .text-muted {
      color: #888;
      font-size: 11px;
      display: block;
      margin-top: 5px;
    }

    @media (max-width: 480px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .status-options {
        flex-direction: column;
        gap: 10px;
      }

      .button-group {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="outer-box">
    <div class="inner-content">
      <h2>Edit
        <?php
        if ($mode == 'payment')
          echo 'Payment Record';
        elseif ($mode == 'customer')
          echo 'Customer Profile';
        elseif ($mode == 'service')
          echo 'Service Details';
        ?>
      </h2>

      <form method="post" action="011pros_update.php">

        <?php if ($mode == 'payment'): ?>
          <!-- PAYMENT EDIT FORM (Matches your new payment form style) -->
          <input type="hidden" name="payment_id" value="<?= htmlspecialchars($row['payment_id']) ?>">

          <label>Payment ID:</label>
          <input type="text" class="id-field" value="<?= htmlspecialchars($row['payment_id']) ?>" readonly>

          <div class="form-group">
            <label>Customer Name:</label>
            <input type="text" name="name" class="form-control filled" value="<?= htmlspecialchars($row['name'] ?? '') ?>"
              required style="background-color: rgba(255,255,255,0.05);">
          </div>

          <div class="form-group">
            <label>Select Service:</label>
            <select name="service_type_id" id="service_select" required onchange="syncDetails()">
              <option value="">-- Choose Service --</option>
              <?php while ($service_row = $all_services->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($service_row['service_type_id']) ?>"
                  data-service-name="<?= htmlspecialchars($service_row['service_name']) ?>"
                  data-description="<?= htmlspecialchars($service_row['description']) ?>"
                  data-price="<?= htmlspecialchars($service_row['amount']) ?>"
                  data-duration="<?= htmlspecialchars($service_row['duration_minutes']) ?>"
                  data-barber="<?= htmlspecialchars($service_row['barber_name']) ?>">
                  <?= htmlspecialchars($service_row['service_name']) ?>
                  (RM <?= htmlspecialchars($service_row['amount']) ?>,
                  <?= htmlspecialchars($service_row['duration_minutes']) ?> mins)
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="description_input">Description:</label>
              <input type="text" class="form-control readonly-field" name="description" id="description_input"
                value="<?= htmlspecialchars($row['description'] ?? '') ?>" readonly>
            </div>

            <div class="form-group">
              <label for="barber_input">Assigned Barber:</label>
              <input type="text" class="form-control readonly-field" name="barber_name" id="barber_input"
                value="<?= htmlspecialchars($row['barber_name'] ?? '') ?>" readonly>
            </div>

            <div class="form-group">
              <label for="amount_input">Amount (RM):</label>
              <input type="text" class="form-control" name="total_amount" id="amount_input"
                value="<?= htmlspecialchars($row['amount'] ?? '0.00') ?>" required>
            </div>

            <div class="form-group">
              <label for="duration_input">Duration (Minutes):</label>
              <input type="text" class="form-control readonly-field" name="duration_minutes" id="duration_input"
                value="<?= htmlspecialchars($row['duration_minutes'] ?? '') ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label>Payment Method:</label>
            <select name="payment_method" required>
              <?php
              $current_method = $row['payment_method'] ?? '';
              // Use EXACT ENUM values - adjust based on your actual ENUM
              $methods = [
                'Cash' => 'Cash',
                'Card' => 'Card',  // NOT 'Card / QR'
                'Online Transfer' => 'Online Transfer'  // NOT 'Online_Transfer'
              ];

              foreach ($methods as $value => $label) {
                $selected = ($current_method == $value) ? 'selected' : '';
                echo "<option value='$value' $selected>$label</option>";
              }
              ?>
            </select>
          </div>

          <button type="submit" class="btn-submit">UPDATE PAYMENT RECORD</button>

        <?php elseif ($mode == 'customer'): ?>
          <!-- CUSTOMER EDIT FORM -->
          <input type="hidden" name="booking_id" value="<?= htmlspecialchars($row['booking_id']) ?>">

          <label>Booking ID:</label>
          <input type="text" class="id-field" value="<?= htmlspecialchars($row['booking_id']) ?>" readonly>

          <div class="form-group">
            <label>IC Number:</label>
            <input type="text" name="IC" class="form-control" value="<?= htmlspecialchars($row['IC']) ?>" required>
          </div>

          <div class="form-group">
            <label>Customer Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Phone Number:</label>
              <input type="text" name="no_phone" class="form-control" value="<?= htmlspecialchars($row['no_phone']) ?>"
                required>
            </div>

            <div class="form-group">
              <label>Age:</label>
              <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($row['age']) ?>" required>
            </div>
          </div>

          <button type="submit" class="btn-submit">UPDATE CUSTOMER PROFILE</button>

        <?php elseif ($mode == 'service'): ?>
          <!-- SERVICE EDIT FORM -->
          <input type="hidden" name="service_type_id" value="<?= htmlspecialchars($row['service_type_id']) ?>">

          <div class="form-group">
            <label>Service Type ID:</label>
            <input type="text" class="id-field" value="<?= htmlspecialchars($row['service_type_id']) ?>" readonly>
          </div>

          <div class="form-group">
            <label>Service Name:</label>
            <input type="text" name="service_name" class="form-control"
              value="<?= htmlspecialchars($row['service_name']) ?>" required>
          </div>

          <div class="form-group">
            <label>Description:</label>
            <input type="text" name="description" class="form-control"
              value="<?= htmlspecialchars($row['description']) ?>">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Duration (minutes):</label>
              <input type="number" name="duration_minutes" class="form-control"
                value="<?= htmlspecialchars($row['duration_minutes']) ?>" required>
            </div>

            <div class="form-group">
              <label>Amount (RM):</label>
              <input type="number" name="amount" class="form-control" step="0.01"
                value="<?= htmlspecialchars($row['amount']) ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label>Barber Name:</label>
            <input type="text" name="barber_name" class="form-control"
              value="<?= htmlspecialchars($row['barber_name']) ?>">
          </div>

          <button type="submit" class="btn-submit">UPDATE SERVICE DETAILS</button>

        <?php endif; ?>

        <div style="text-align: center; margin-top: 15px;">
          <a href="javascript:history.back()" style="color: var(--gold); text-decoration: none; font-size: 14px;">
            ← Back to Previous Page
          </a>
        </div>
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

    // Initialize on page load
    window.onload = function () {
      // Highlight Customer Name if it's filled
      const custInput = document.getElementsByName('name')[0];
      if (custInput && custInput.value !== "") {
        custInput.classList.add('filled');
      }

      // Trigger sync if service is pre-selected
      const serviceSelect = document.getElementById('service_select');
      if (serviceSelect && serviceSelect.value) {
        syncDetails();
      }

      // Auto-format phone number for customer form
      const phoneInput = document.querySelector('input[name="no_phone"]');
      if (phoneInput) {
        phoneInput.addEventListener('input', function (e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 3 && value.length <= 6) {
            value = value.replace(/(\d{3})(\d+)/, '$1-$2');
          } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
          }
          e.target.value = value;
        });
      }
    };


    // Custom barber input toggle
    document.querySelector('select[name="barber_name"]').addEventListener('change', function () {
      const customBarberInput = document.getElementById('custom_barber');
      if (this.value === 'Other') {
        customBarberInput.style.display = 'block';
        customBarberInput.focus();
      } else {
        customBarberInput.style.display = 'none';
        customBarberInput.value = '';
      }
    });

    // Price formatting
    function formatPrice(input) {
      let value = parseFloat(input.value);
      if (!isNaN(value)) {
        input.value = value.toFixed(2);
      }
    }

    // Auto-populate custom barber if value exists
    document.addEventListener('DOMContentLoaded', function () {
      const barberSelect = document.querySelector('select[name="barber_name"]');
      const customBarberInput = document.getElementById('custom_barber');
      const currentBarber = '<?= htmlspecialchars($row['barber_name'] ?? '') ?>';

      // Check if current barber exists in options
      let barberExists = false;
      Array.from(barberSelect.options).forEach(option => {
        if (option.value === currentBarber) {
          barberExists = true;
        }
      });

      if (currentBarber && !barberExists) {
        barberSelect.value = 'Other';
        customBarberInput.style.display = 'block';
        customBarberInput.value = currentBarber;
      }
    });
  </script>

</body>

</html>