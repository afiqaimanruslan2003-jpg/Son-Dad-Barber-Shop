<?php
// process.php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cybercafe";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_GET['action'] ?? '';

switch($action) {
    case 'add_computer':
        $pc_name = $_POST['pc_name'];
        $location = $_POST['location'];
        $status = $_POST['status'];
        
        $stmt = $conn->prepare("INSERT INTO computers (pc_name, location, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $pc_name, $location, $status);
        
        if($stmt->execute()) {
            header("Location: index.php?message=Computer+added+successfully&type=success");
        } else {
            header("Location: index.php?message=Error+adding+computer&type=error");
        }
        break;
        
    case 'start_session':
        $customer_id = $_POST['customer_id'];
        $computer_id = $_POST['computer_id'];
        
        // Update computer status to 'In Use'
        $conn->query("UPDATE computers SET status='In Use' WHERE computer_id=$computer_id");
        
        $stmt = $conn->prepare("INSERT INTO sessions (customer_id, computer_id, start_time, session_status) VALUES (?, ?, NOW(), 'Active')");
        $stmt->bind_param("ii", $customer_id, $computer_id);
        
        if($stmt->execute()) {
            header("Location: index.php?message=Session+started+successfully&type=success");
        } else {
            header("Location: index.php?message=Error+starting+session&type=error");
        }
        break;
        
    case 'add_payment':
        $session_id = $_POST['session_id'];
        $rate_id = $_POST['rate_id'];
        $amount = $_POST['amount'];
        $payment_method = $_POST['payment_method'];
        
        // Calculate minutes and end session
        $session = $conn->query("SELECT start_time FROM sessions WHERE session_id=$session_id")->fetch_assoc();
        $start_time = strtotime($session['start_time']);
        $end_time = time();
        $total_minutes = round(($end_time - $start_time) / 60);
        
        // Update session
        $conn->query("UPDATE sessions SET end_time=NOW(), total_minutes=$total_minutes, session_status='Completed' WHERE session_id=$session_id");
        
        // Update computer status back to Available
        $computer_id = $conn->query("SELECT computer_id FROM sessions WHERE session_id=$session_id")->fetch_assoc()['computer_id'];
        $conn->query("UPDATE computers SET status='Available' WHERE computer_id=$computer_id");
        
        // Add payment
        $stmt = $conn->prepare("INSERT INTO payments (session_id, rate_id, amount, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iids", $session_id, $rate_id, $amount, $payment_method);
        
        if($stmt->execute()) {
            header("Location: index.php?message=Payment+recorded+successfully&type=success");
        } else {
            header("Location: index.php?message=Error+recording+payment&type=error");
        }
        break;
        
    case 'delete_computer':
        $id = $_GET['id'];
        if($conn->query("DELETE FROM computers WHERE computer_id=$id")) {
            header("Location: index.php?message=Computer+deleted+successfully&type=success");
        } else {
            header("Location: index.php?message=Error+deleting+computer&type=error");
        }
        break;
        
    case 'end_session':
        $id = $_GET['id'];
        // Similar logic to add_payment but without recording payment
        $session = $conn->query("SELECT computer_id FROM sessions WHERE session_id=$id")->fetch_assoc();
        $computer_id = $session['computer_id'];
        
        $conn->query("UPDATE sessions SET end_time=NOW(), session_status='Completed' WHERE session_id=$id");
        $conn->query("UPDATE computers SET status='Available' WHERE computer_id=$computer_id");
        
        header("Location: index.php?message=Session+ended+successfully&type=success");
        break;
        
    default:
        header("Location: index.php");
}

$conn->close();
?>