<?php
include('001link_db2.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the themed form
    // We use the same field names from the HTML we just built
    $service_type_id = mysqli_real_escape_string($conn, $_POST['service_type_id']);
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $barber_name  = mysqli_real_escape_string($conn, $_POST['barber_name']);
    $amount       = mysqli_real_escape_string($conn, $_POST['amount']);
    $duration_minutes = mysqli_real_escape_string($conn, $_POST['duration_minutes']);

    // Generate service ID (optional based on your table, but good for tracking)
    // Your table image shows service_name, barber_name, and amount as primary keys/main columns
    $sql = "INSERT INTO service_list (service_type_id, service_name, description, barber_name, amount, duration_minutes) 
            VALUES ('$service_type_id', '$service_name', '$description', '$barber_name', '$amount', '$duration_minutes')";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to the view page with a success status
        header("Location: serviceHistoryView.php?status=success");
        exit;
    } else {
        // Handle potential errors (like duplicate service names if they are keys)
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>