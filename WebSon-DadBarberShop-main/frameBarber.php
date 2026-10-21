<?php
// Add this to framebarber.php (rename from .html to .php)
session_start();
require_once 'config.php';

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit();
}

// Get user info
$user_role = $_SESSION['role'];
$user_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html>
<!-- Your existing framebarber.html content here -->
</html>

<!DOCTYPE html>
<html>
<head>
<title> HTML Frame </title>
</head>
<FRAMESET ROWs="100,*">
<FRAME NAME ="UpperFrame" SRC="headerBarber.php">

<FRAMESET COLS="200,*">
<FRAME NAME ="LeftFrame" SRC="navbar(barber).php">
<FRAME NAME ="RightFrame" SRC="welcomeBarber1.php">
</FRAMESET>
</html>
