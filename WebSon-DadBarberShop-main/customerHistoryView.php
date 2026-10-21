<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Customer List - BMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --gold: #d4af37;
      --dark-bg: #121212;
    }

    body {
      background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('n1.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Times New Roman', serif;
      color: white;
    }

    .container {
      background: rgba(18, 18, 18, 0.9);
      padding: 30px;
      border: 2px solid var(--gold);
      margin-top: 50px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .page-title {
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 3px;
      margin-bottom: 30px;
      border-bottom: 2px solid var(--gold);
      display: inline-block;
      padding-bottom: 10px;
    }

    .card {
      background: transparent;
      border: none;
    }

    .table {
      background: transparent;
      color: #ccc;
    }

    .table thead th {
      color: var(--gold) !important;
      text-transform: uppercase;
      font-size: 13px;
      border-bottom: 2px solid var(--gold) !important;
      text-align: center;
      background-color: transparent !important;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(212, 175, 55, 0.1) !important;
    }

    tbody td {
      text-align: center;
      vertical-align: middle !important;
      border-color: #333 !important;
    }

    /* Button Styling */
    .btn-gold {
      background: var(--gold);
      color: black;
      font-weight: bold;
      border: none;
      border-radius: 0;
      text-transform: uppercase;
      font-size: 11px;
      transition: 0.3s;
    }

    .btn-gold:hover {
      background: #f1c40f;
      color: black;
    }

    .btn-outline {
      background: transparent;
      border: 1px solid var(--gold);
      color: var(--gold);
      border-radius: 0;
      text-transform: uppercase;
      font-size: 11px;
    }

    .btn-outline:hover {
      background: var(--gold);
      color: black;
    }

    .btn-danger-custom {
      background: transparent;
      border: 1px solid #ff4d4d;
      color: #ff4d4d;
      border-radius: 0;
      text-transform: uppercase;
      font-size: 11px;
    }

    .btn-danger-custom:hover {
      background: #ff4d4d;
      color: white;
    }
  </style>
</head>

<body>

  <?php
  include('001link_db2.php');
  $sql = "SELECT * FROM customer ORDER BY booking_id ASC";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  ?>

  <div class="container">

    <div class="text-center">
      <h2 class="page-title">Customer Database</h2>
    </div>

    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Identification (IC)</th>
              <th>Full Name</th>
              <th>Age</th>
              <th>Contact</th>
              <th>Date of Birth</th>
              <th>Time</th>
              <th colspan="2">Actions</th>
            </tr>
          </thead>
          <tbody>

            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td style="font-family: monospace; color: #888;">
                    <?= htmlspecialchars($row['booking_id']) ?>
                  </td>
                  <td><?= htmlspecialchars($row['IC']) ?></td>
                  <td style="color: white; font-weight: bold;">
                    <?= htmlspecialchars($row['name']) ?>
                  </td>
                  <td><?= htmlspecialchars($row['age']) ?></td>
                  <td><?= htmlspecialchars($row['no_phone']) ?></td>
                  <td><?= htmlspecialchars($row['dob']) ?></td>
                  <td><?= htmlspecialchars($row['time']) ?></td>
                  
                  <td>
                    <a href="010form_updatebs.php?booking_id=<?= urlencode($row['booking_id']) ?>"
                       class="btn btn-sm btn-outline">Edit</a>
                  </td>
                  <td>
                    <a href="012pros_delete.php?booking_id=<?= urlencode($row['booking_id']) ?>" 
                       class="btn btn-sm btn-danger-custom"
                       onclick="return confirm('Are you sure you want to delete this customer record?');">
                       Delete
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center" style="padding: 50px; color: #555;">
                  No customer records found in the system.
                </td>
              </tr>
            <?php endif; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>