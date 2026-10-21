<?php 
include('001link_db2.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id'] ?? '');
    // Capture data
    $ic       = mysqli_real_escape_string($conn, $_POST['IC'] ?? '');
    $name     = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $no_phone = mysqli_real_escape_string($conn, $_POST['no_phone'] ?? '');
    $age      = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $dob     = mysqli_real_escape_string($conn, $_POST['dob'] ?? '');
    $time = mysqli_real_escape_string($conn, $_POST['time'] ?? date('H:i:s'));

    // Validation
    if (empty($ic) || empty($name)) {
        die("Error: IC and Name are required!");
    }

    // Insert query
    $query = "INSERT INTO customer (booking_id, IC, name, no_phone, age, dob, time) 
              VALUES ('$booking_id','$ic', '$name', '$no_phone', '$age', '$dob', '$time')";

    if (mysqli_query($conn, $query)) {
        header("Location: new_form_payment.php?status=success&name=" . urlencode($name));
        exit;
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>
