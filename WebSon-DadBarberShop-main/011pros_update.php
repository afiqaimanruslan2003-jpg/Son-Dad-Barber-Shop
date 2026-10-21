<?php
include('001link_db2.php');

// Check database connection
if (!$conn) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- CASE 1: UPDATE SERVICE (Using service_type_id as primary key) ---
    if (isset($_POST['service_type_id'])) {
        $service_type_id = $_POST['service_type_id'];
        $service_name = $_POST['service_name'] ?? '';
        $description = $_POST['description'] ?? '';
        $barber_name = $_POST['barber_name'] ?? '';
        $amount = $_POST['amount'] ?? '0.00';
        $duration_minutes = $_POST['duration_minutes'] ?? '';

        // Validate
        if (empty($service_type_id) || empty($service_name)) {
            die("Error: Service ID and name cannot be empty");
        }

        // Validate numeric fields
        if (!is_numeric($amount) || !is_numeric($duration_minutes)) {
            die("Error: Amount and duration must be numbers");
        }

        // Update ALL fields from the form
        $stmt = $conn->prepare("UPDATE service_list SET 
        service_name = ?, 
        description = ?, 
        barber_name = ?, 
        amount = ?, 
        duration_minutes = ?
        WHERE service_type_id = ?");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "sssdis",
            $service_name,
            $description,
            $barber_name,
            $amount,
            $duration_minutes,
            $service_type_id
        );

        if ($stmt->execute()) {
            header("Location: serviceHistoryView.php?status=updated&msg=Service+updated");
            exit;
        } else {
            error_log("Service update error: " . $stmt->error);
            echo "Error updating service: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    }

    // --- CASE 2: UPDATE CUSTOMER (Using IC) ---
    elseif (isset($_POST['IC'])) {
        $ic = $_POST['IC'] ?? '';
        $name = $_POST['name'] ?? '';
        $phone = $_POST['no_phone'] ?? '';
        $age = $_POST['age'] ?? 0;

        // Debug log
        error_log("Customer Update - IC: $ic, Name: $name, Phone: $phone, Age: $age");

        // Validate required fields
        if (empty($ic) || empty($name)) {
            die("Error: IC and Name cannot be empty");
        }

        $stmt = $conn->prepare("UPDATE customer SET name=?, no_phone=?, age=? WHERE IC=?");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssis", $name, $phone, $age, $ic);

        if ($stmt->execute()) {
            header("Location: 003data_tbl_View.php?status=updated&msg=Customer+updated");
            exit;
        } else {
            error_log("Customer update error: " . $stmt->error);
            echo "Error updating customer: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    }

    // --- CASE 3: UPDATE PAYMENT HISTORY (Using payment_id) ---
    elseif (isset($_POST['payment_id'])) {
        $payment_id = $_POST['payment_id'] ?? '';
        $service_name = $_POST['service_provided'] ?? '';
        $description = $_POST['description'] ?? '';
        $customer_name = $_POST['name'] ?? '';
        $barber_name = $_POST['barber_name'] ?? '';
        $duration_minutes = $_POST['duration_minutes'] ?? '';
        $amount = $_POST['total_amount'] ?? 0;
        $payment_method_raw = $_POST['payment_method'] ?? '';

        // DEBUG
        error_log("Payment Method Raw Value: '$payment_method_raw'");

        // Map form values to ENUM values (adjust based on your actual ENUM)
        $payment_method_map = [
            'Cash' => 'Cash',
            'Card' => 'Card',
            'Card / QR' => 'Card',  // Map "Card / QR" to "Card"
            'QR' => 'Card',         // Map "QR" to "Card"
            'QR Pay' => 'Card',     // Map "QR Pay" to "Card"
            'Online_Transfer' => 'Online Transfer',  // Map underscore to space
            'Online Transfer' => 'Online Transfer',
            'Online' => 'Online Transfer',
        ];

        // Default to 'Cash' if not found
        $payment_method = $payment_method_map[$payment_method_raw] ?? 'Cash';

        // If still not valid, check common variations
        if (!in_array($payment_method, ['Cash', 'Card', 'Online Transfer'])) {
            // Try to guess based on string contains
            if (stripos($payment_method_raw, 'cash') !== false) {
                $payment_method = 'Cash';
            } elseif (stripos($payment_method_raw, 'card') !== false || stripos($payment_method_raw, 'qr') !== false) {
                $payment_method = 'Card';
            } elseif (stripos($payment_method_raw, 'online') !== false || stripos($payment_method_raw, 'transfer') !== false) {
                $payment_method = 'Online Transfer';
            } else {
                $payment_method = 'Cash'; // Default fallback
            }
        }

        error_log("Payment Method Mapped: '$payment_method'");

        // Check if service exists
        $check_service = $conn->prepare("SELECT COUNT(*) as count FROM service_list WHERE service_name = ?");
        $check_service->bind_param("s", $service_name);
        $check_service->execute();
        $check_result = $check_service->get_result();
        $service_exists = $check_result->fetch_assoc()['count'];
        $check_service->close();

        if ($service_exists == 0) {
            echo "<script>
                alert('Error: Service \"$service_name\" does not exist in service list.');
                window.history.back();
              </script>";
            exit;
        }

        // Prepare update
        $stmt = $conn->prepare("UPDATE payment_history 
                           SET service_name=?, description=?, name=?, barber_name=?, 
                               duration_minutes=?, amount=?, payment_method=?, payment_date=NOW() 
                           WHERE payment_id=?");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "sssssdss",
            $service_name,
            $description,
            $customer_name,
            $barber_name,
            $duration_minutes,
            $amount,
            $payment_method,  // Must match ENUM values exactly
            $payment_id
        );

        if ($stmt->execute()) {
            header("Location: paymentHistoryView.php?status=success&msg=Payment+updated");
            exit;
        } else {
            error_log("Payment update error: " . $stmt->error);
            echo "Error updating payment: " . htmlspecialchars($stmt->error);
            echo "<br>Payment Method tried: '$payment_method'<br>";
            echo "Must be one of the ENUM values defined in the database.<br>";
            echo "<br><a href='paymentHistory.php'>Back to Payment History</a>";
        }
        $stmt->close();
    }

    // --- CASE 4: If no valid form detected ---
    else {
        echo "Error: No valid form data detected. Please check your form fields.";
    }
} else {
    echo "Error: Invalid request method. Must be POST.";
}

$conn->close();
?>