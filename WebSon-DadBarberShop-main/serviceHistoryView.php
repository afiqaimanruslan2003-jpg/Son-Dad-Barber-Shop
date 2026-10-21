<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Service Menu - BMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
      margin-bottom: 20px;
      border-bottom: 2px solid var(--gold);
      display: inline-block;
      padding-bottom: 10px;
    }

    .table {
      background: transparent;
      color: #ccc;
      margin-top: 20px;
    }

    .table thead th {
      color: var(--gold) !important;
      text-transform: uppercase;
      font-size: 14px;
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
      font-size: 15px;
    }

    .service-name-cell {
      color: white;
      font-weight: bold;
      text-align: left !important;
      padding-left: 20px !important;
    }

    .amount-text {
      color: var(--gold);
      font-weight: bold;
    }

    /* Button Styling */
    .btn-outline-gold {
      background: transparent;
      border: 1px solid var(--gold);
      color: var(--gold);
      border-radius: 0;
      text-transform: uppercase;
      font-size: 11px;
      width: 80px;
      transition: 0.3s;
    }

    .btn-outline-gold:hover {
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
      width: 80px;
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
  $sql = "SELECT service_type_id, service_name, description, barber_name, amount, duration_minutes FROM service_list ORDER BY service_name DESC, barber_name DESC";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  ?>

  <div class="container">
    <div class="text-center">
      <h2 class="page-title">Service & Pricing Menu</h2>
    </div>

    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Service Type ID</th>
            <th class="text-left" style="padding-left: 20px;">Service Name</th>
            <th class="text-left" style="padding-left: 20px;">Description</th>
            <th>Barber Name</th>
            <th>Amount</th>
            <th class="text-left" style="padding-left: 20px;">Duration</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td class="service_type_id"><?php echo htmlspecialchars($row['service_type_id']); ?></td>
              <td class="service-name-cell"><?php echo htmlspecialchars($row['service_name']); ?></td>
              <td class="description"><?php echo htmlspecialchars($row['description']?? ''); ?></td>
              <td class="barber_name"><?php echo htmlspecialchars($row['barber_name']); ?></td>
              <td class="amount-text">RM <?php echo number_format($row['amount'], 2); ?></td>
              <td class="duration_minutes"><?php echo htmlspecialchars($row['duration_minutes']?? ''); ?></td>
              
              <td>
                <a href="010form_updatebs.php?service_type_id=<?= urlencode($row['service_type_id']) ?>"
                   class="btn btn-sm btn-outline-gold">Edit</a>
              </td>
              <td>
                <a href="012pros_delete.php?service_type_id=<?= urlencode($row['service_type_id']) ?>" 
                   class="btn btn-sm btn-danger-custom"
                   onclick="return confirm('Are you sure you want to delete this service?');">
                   Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>