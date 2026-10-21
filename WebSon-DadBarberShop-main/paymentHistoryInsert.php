<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "bms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid access attempt.");
}

// 1. Collect and Sanitize Data
$barber_name = $_POST['barber_name'] ?? '';
$payment_id = $_POST['payment_id'] ?? 'Unknown';
$service_name = $_POST['service_provided'] ?? '';
$description = $_POST['description'] ?? '';
$customer_name = $_POST['name'] ?? '';
$amount = (float) ($_POST['total_amount'] ?? 0.00);
$duration_minutes = $_POST['duration_minutes'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$date = date("Y-m-d H:i:s");

// 2. Prepared Statement
$sql = "INSERT INTO payment_history 
        (payment_id, service_name, description, name, barber_name, amount, duration_minutes, payment_method, payment_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // FIXED bind_param format string: sssssdiss (d for double/float)
    $stmt->bind_param(
        "sssssdiss",   // payment_id(s), service_name(s), description(s), name(s), barber_name(s), amount(d), duration_minutes(i), payment_method(s), date(s)
        $payment_id,
        $service_name,
        $description,
        $customer_name,
        $barber_name,
        $amount,
        $duration_minutes,
        $payment_method,
        $date
    );

    if ($stmt->execute()) {
        // REDIRECT TO RECEIPT PAGE WITH ALL DATA
        header("Location: confirm_payment.php?" . http_build_query([
            'payment_id' => $payment_id,
            'name' => $customer_name,
            'service' => $service_name,
            'desc' => $description,
            'barber' => $barber_name,
            'duration' => $duration_minutes,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'date' => date('Y-m-d'),
            'time' => date('H:i')
        ]));
        exit;
    } else {
        // Show error but don't die immediately
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        
        // Redirect to error page
        header("Location: payment_form.php?error=" . urlencode($error));
        exit;
    }
} else {
    $error = $conn->error;
    $conn->close();
    
    // Redirect to error page
    header("Location: payment_form.php?error=" . urlencode($error));
    exit;
}

$stmt->close();
$conn->close();

// NO HTML AFTER THIS - script should have redirected or died
?>