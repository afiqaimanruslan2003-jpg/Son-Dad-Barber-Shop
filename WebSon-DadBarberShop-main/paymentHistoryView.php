<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment History - BMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --gold: #d4af37;
            --dark-bg: #121212;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('n1.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Times New Roman', serif;
            color: white;
        }

        .container {
            background: rgba(18, 18, 18, 0.95);
            padding: 30px;
            border: 2px solid var(--gold);
            border-radius: 0;
            margin-top: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 3px;
            border-bottom: 2px solid var(--gold);
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .table {
            background: transparent;
            color: #ccc;
        }

        .table thead th {
            color: var(--gold) !important;
            text-transform: uppercase;
            border-bottom: 2px solid var(--gold) !important;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.1) !important;
        }

        .btn-gold {
            background: var(--gold);
            color: black;
            font-weight: bold;
            border: none;
            border-radius: 0;
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
        }

        .btn-outline:hover {
            background: var(--gold);
            color: black;
        }

        /* Dashboard Container */
        .dashboard-container {
            background: var(--dark-bg);
            border: 1px solid var(--gold);
            padding: 20px;
            margin-bottom: 30px;
        }

        /* Chart Cards */
        .chart-card {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid #333;
            padding: 15px;
            margin-bottom: 20px;
            height: 300px;
        }

        .chart-title {
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-size: 16px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid #333;
            padding: 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: var(--gold);
            margin-bottom: 5px;
        }

        .stat-label {
            color: #ccc;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Receipt Hidden Print Area */
        @media print {
            body * {
                visibility: hidden;
            }

            #receipt-print-container,
            #receipt-print-container * {
                visibility: visible;
            }

            #receipt-print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }

        /* Add to your existing CSS */
        canvas {
            max-height: 220px !important;
            /* Control chart height */
        }

        /* Add to your existing CSS in the <style> section */
        .table td:nth-child(9) {
            /* Target the 9th column (Date) */
            white-space: nowrap;
            min-width: 120px;
            /* Ensure enough width for date */
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    // FIX 1: Database connection must come FIRST
    include('001link_db2.php');

    // ========== STATISTICS SECTION ==========
    // Get today's date
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    // Calculate total statistics
    $total_query = "SELECT 
        COUNT(*) as total_transactions,
        SUM(amount) as total_revenue,
        AVG(amount) as avg_transaction
        FROM payment_history";
    $total_result = mysqli_query($conn, $total_query);
    $total_stats = mysqli_fetch_assoc($total_result);

    // Calculate today's statistics
    $today_query = "SELECT 
        COUNT(*) as today_transactions,
        SUM(amount) as today_revenue
        FROM payment_history 
        WHERE DATE(payment_date) = '$today'";
    $today_result = mysqli_query($conn, $today_query);
    $today_stats = mysqli_fetch_assoc($today_result);

    // Calculate yesterday's statistics
    $yesterday_query = "SELECT 
        SUM(amount) as yesterday_revenue
        FROM payment_history 
        WHERE DATE(payment_date) = '$yesterday'";
    $yesterday_result = mysqli_query($conn, $yesterday_query);
    $yesterday_stats = mysqli_fetch_assoc($yesterday_result);

    // Get last 7 days data for chart
    $week_data = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $query = "SELECT COALESCE(SUM(amount), 0) as revenue 
                  FROM payment_history 
                  WHERE DATE(payment_date) = '$date'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $week_data[] = [
            'date' => date('M d', strtotime($date)),
            'revenue' => $row['revenue']
        ];
    }

    // Get payment methods distribution
    $methods_query = "SELECT 
        payment_method,
        COUNT(*) as count,
        SUM(amount) as total
        FROM payment_history 
        GROUP BY payment_method";
    $methods_result = mysqli_query($conn, $methods_query);
    $payment_methods = [];
    while ($row = mysqli_fetch_assoc($methods_result)) {
        $payment_methods[] = $row;
    }

    // Get main payment data for table
    $sql = "SELECT * FROM payment_history ORDER BY payment_date DESC";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    ?>

    <div class="container">
        <div class="text-center">
            <h2>Payment History</h2>
        </div>

        <!-- FIX 2: Dashboard should be HERE, before the table -->
        <div class="dashboard-container">
            <h3 style="color: var(--gold); border-bottom: 1px solid var(--gold); padding-bottom: 10px;">
                📊 Business Dashboard
            </h3>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value">RM <?= number_format($total_stats['total_revenue'] ?? 0, 2) ?></div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $total_stats['total_transactions'] ?? 0 ?></div>
                    <div class="stat-label">Total Transactions</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">RM <?= number_format($today_stats['today_revenue'] ?? 0, 2) ?></div>
                    <div class="stat-label">Today's Revenue</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $today_stats['today_transactions'] ?? 0 ?></div>
                    <div class="stat-label">Today's Transactions</div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="chart-card">
                        <div class="chart-title">📈 Revenue Last 7 Days</div>
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-card">
                        <div class="chart-title">🥧 Payment Methods</div>
                        <canvas id="methodsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Today vs Yesterday -->
            <div
                style="background: rgba(212, 175, 55, 0.1); padding: 20px; margin: 20px 0; border-left: 4px solid var(--gold);">
                <h4 style="color: var(--gold); margin-top: 0; border-bottom: 1px solid #333; padding-bottom: 10px;">
                    Daily Comparison</h4>
                <div style="display: flex; justify-content: space-between; text-align: center; padding-top: 10px;">
                    <div style="flex: 1;">
                        <div style="font-size: 18px; color: #2ecc71; font-weight: bold;">Today</div>
                        <div style="font-size: 22px; font-weight: bold; color: white; margin: 10px 0;">
                            RM <?= number_format($today_stats['today_revenue'] ?? 0, 2) ?>
                        </div>
                        <div style="font-size: 14px; color: #ccc;">
                            <?= $today_stats['today_transactions'] ?? 0 ?> transactions
                        </div>
                    </div>
                    <div style="width: 1px; background: #333; margin: 0 20px;"></div>
                    <div style="flex: 1;">
                        <div style="font-size: 18px; color: #95a5a6; font-weight: bold;">Yesterday</div>
                        <div style="font-size: 22px; font-weight: bold; color: white; margin: 10px 0;">
                            RM <?= number_format($yesterday_stats['yesterday_revenue'] ?? 0, 2) ?>
                        </div>
                        <div style="font-size: 14px; color: #ccc;">
                            <?= isset($yesterday_stats['yesterday_revenue']) && $yesterday_stats['yesterday_revenue'] > 0 ? 'Previous day' : 'No transactions' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Table -->
        <div style="overflow-x: auto;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 150px;">Payment ID</th>
                        <th style="width: 120px;">Service Name</th>
                        <th style="width: 100px;">Customer</th>
                        <th style="width: 80px;">Duration</th>
                        <th style="width: 100px;">Amount</th>
                        <th style="width: 120px;">Method</th>
                        <th style="width: 120px;">Date</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['payment_id']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['service_name']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['name']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['duration_minutes']); ?></td>
                            <td class="text-center" style="color: var(--gold);">RM
                                <?= number_format($row['amount'], 2); ?>
                            </td>
                            <td class="text-center"><?= htmlspecialchars($row['payment_method']); ?></td>
                            <td class="text-center" style="white-space: nowrap;">
                                <?= date('d/m/Y', strtotime($row['payment_date'])) ?>
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    <button class="btn btn-xs btn-gold"
                                        onclick="printReceipt(<?= htmlspecialchars(json_encode($row)); ?>)"
                                        title="Print Receipt">
                                        <i class="glyphicon glyphicon-print"></i>
                                    </button>
                                    <a href="010form_updatebs.php?payment_id=<?= $row['payment_id']; ?>"
                                        class="btn btn-xs btn-outline" title="Edit">
                                        Edit
                                    </a>
                                    <!-- FIXED DELETE BUTTON - Use button not anchor -->
                                    <button class="btn btn-xs btn-danger" title="Delete" onclick="if(confirm('Delete payment <?= htmlspecialchars($row['payment_id']); ?>?')) {
                                                window.location.href='012pros_delete.php?payment_id=<?= $row['payment_id']; ?>'
                                            }">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Receipt Print Container (separate, hidden) -->
        <div id="receipt-print-container" style="display: none;">
            <div id="receipt-content"
                style="width: 80mm; padding: 20px; font-family: 'Courier New', monospace; color: #000; background: #fff; margin: auto;">
                <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px;">
                    <h3 style="margin: 0;">BMS BARBERSHOP</h3>
                    <p style="font-size: 12px;">Premium Grooming Services</p>
                </div>
                <div style="margin-top: 15px; font-size: 14px;">
                    <p><strong>ID:</strong> <span id="r-id"></span></p>
                    <p><strong>Customer:</strong> <span id="r-customer"></span></p>
                    <p><strong>Service:</strong> <span id="r-service"></span></p>
                    <p><strong>Payment:</strong> <span id="r-method"></span></p>
                    <hr style="border-top: 1px dashed #000;">
                    <h3 style="text-align: right;">Total: RM <span id="r-amount"></span></h3>
                </div>
                <div style="text-align: center; margin-top: 20px; font-size: 11px;">
                    <p>Thank you for choosing us!</p>
                    <p><?= date('Y-m-d H:i'); ?></p>
                </div>
            </div>
        </div>

        <script>
            // 1. SweetAlert2 Success Popup
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                Swal.fire({
                    title: 'Payment Recorded!',
                    text: 'The transaction has been successfully saved.',
                    icon: 'success',
                    background: '#121212',
                    color: '#d4af37',
                    confirmButtonColor: '#d4af37'
                });
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // 2. Receipt Print Function
            function printReceipt(data) {
                document.getElementById('r-id').innerText = data.payment_id;
                document.getElementById('r-customer').innerText = data.name;
                document.getElementById('r-service').innerText = data.service_name;
                document.getElementById('r-method').innerText = data.payment_method;
                document.getElementById('r-amount').innerText = parseFloat(data.amount).toFixed(2);

                const receiptHtml = document.getElementById('receipt-print-container').innerHTML;
                const originalBody = document.body.innerHTML;

                document.body.innerHTML = receiptHtml;
                window.print();
                document.body.innerHTML = originalBody;
                window.location.reload();
            }

            // 3. Chart Code
            document.addEventListener('DOMContentLoaded', function () {
                // Revenue Chart (Last 7 Days)
                const revenueCtx = document.getElementById('revenueChart');
                if (revenueCtx) {
                    const revenueLabels = <?php echo json_encode(array_column($week_data, 'date')); ?>;
                    const revenueData = <?php echo json_encode(array_column($week_data, 'revenue')); ?>;

                    new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: revenueLabels,
                            datasets: [{
                                label: 'Revenue (RM)',
                                data: revenueData,
                                borderColor: '#d4af37',
                                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#ccc',
                                        font: { size: 12 }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: '#ccc',
                                        stepSize: 10,
                                        callback: function (value) {
                                            return 'RM ' + value;
                                        }
                                    },
                                    max: 60
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: '#ccc',
                                        font: { size: 11 }
                                    }
                                }
                            }
                        }
                    });
                }

                // Payment Methods Chart
                const methodsCtx = document.getElementById('methodsChart');
                const paymentMethodsData = <?php echo json_encode($payment_methods); ?>;

                if (methodsCtx && paymentMethodsData.length > 0) {
                    const labels = paymentMethodsData.map(method => method.payment_method);
                    const data = paymentMethodsData.map(method => method.count);

                    new Chart(methodsCtx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: ['#d4af37', '#2ecc71', '#3498db', '#e74c3c', '#9b59b6']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        color: '#ccc',
                                        font: { size: 11 }
                                    }
                                }
                            }
                        }
                    });
                } else if (methodsCtx) {
                    methodsCtx.parentElement.innerHTML = '<div style="color: #888; text-align: center; padding: 50px;">No payment data available for chart</div>';
                }
            });
        </script>
</body>

</html>