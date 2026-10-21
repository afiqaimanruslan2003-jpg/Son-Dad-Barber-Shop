<?php
include('001link_db2.php');

if (!$conn) die("Database connection failed");

// 1️⃣ Handle Payment Deletion with Prepared Statement
if (isset($_GET['payment_id'])) {
    $query = "DELETE FROM payment_history WHERE payment_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $_GET['payment_id']);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: paymentHistoryView.php?status=success&msg=Payment+deleted");
    } else {
        header("Location: paymentHistoryView.php?status=error&msg=Delete+failed");
    }
    exit();
}

// 2️⃣ Handle Customer Deletion with Prepared Statement
if (isset($_GET['booking_id'])) {
    $query = "DELETE FROM customer WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $_GET['booking_id']);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: 003data_tbl_View.php?status=success&msg=Customer+deleted");
    } else {
        header("Location: 003data_tbl_View.php?status=error&msg=Delete+failed");
    }
    exit();
}

// 3️⃣ Handle Service Deletion with Prepared Statement
if (isset($_GET['service_type_id'])) {
    $query = "DELETE FROM service_list WHERE service_type_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $_GET['service_type_id']);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: serviceHistoryView.php?status=success&msg=Service+deleted");
    } else {
        header("Location: serviceHistoryView.php?status=error&msg=Delete+failed");
    }
    exit();
}

// Default redirect if no valid parameters
header("Location: index.php?status=error&msg=Invalid+request");
exit();
?>