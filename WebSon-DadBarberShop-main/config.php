<?php
// config.php - Database configuration
$host = "localhost";
$dbname = "bms";
$username = "root";
$password = ""; // Your MySQL password here (XAMPP/Laragon usually empty)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: Set timezone
    $conn->exec("SET time_zone = '+08:00'"); // Malaysia time
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>