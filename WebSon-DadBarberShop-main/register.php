<?php
// register.php - USER SELF-REGISTRATION
ob_start();
session_start();
require_once 'config.php';

// If already logged in, redirect
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: framebarber.php");
    exit();
}

$username = $full_name = $password = $confirm_password = "";
$username_err = $full_name_err = $password_err = $confirm_password_err = $register_err = $success_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $username = trim($_POST["username"]);
        // Check if username exists
        $sql = "SELECT id FROM users WHERE username = :username";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                }
            }
            unset($stmt);
        }
    }
    
    // Validate full name
    if(empty(trim($_POST["full_name"]))){
        $full_name_err = "Please enter your full name.";
    } else {
        $full_name = trim($_POST["full_name"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // If no errors, insert new user
    if(empty($username_err) && empty($full_name_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Default role for self-registration is 'barber' or 'staff'
        $default_role = 'barber'; // Change to 'staff' if needed
        
        $sql = "INSERT INTO users (username, password_hash, full_name, role) 
                VALUES (:username, :password, :full_name, :role)";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
            $stmt->bindParam(":role", $default_role, PDO::PARAM_STR);
            
            if($stmt->execute()){
                $success_msg = "✅ Account created successfully! You can now login.";
                // Clear form
                $username = $full_name = $password = $confirm_password = "";
            } else {
                $register_err = "❌ Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    
    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Barber Shop</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Oswald', sans-serif;
        }
        
        body { 
            margin: 0;
            padding: 0;
            background: #1a1a1a;
            color: #d4af37;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('n1.jpg');
            background-size: cover;
            background-position: center;
        }
        
        .register-container {
            width: 100%;
            max-width: 450px;
            background: rgba(30, 30, 30, 0.95);
            padding: 40px;
            border-radius: 15px;
            border: 2px solid #d4af37;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: white;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0;
            font-size: 28px;
        }
        
        .logo p {
            color: #ccc;
            margin-top: 5px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #d4af37;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
        }
        
        input {
            width: 100%;
            padding: 14px;
            background: #2b2b2b;
            border: 1px solid #444;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            transform: translateY(-2px);
        }
        
        .invalid-feedback {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #d4af37 0%, #b8962e 100%);
            color: black;
            border: none;
            padding: 16px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, #e6c158 0%, #d4af37 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
        }
        
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #28a745;
        }
        
        .error {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #dc3545;
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #aaa;
            font-size: 15px;
        }
        
        .login-link a {
            color: #d4af37;
            text-decoration: none;
            font-weight: bold;
        }
        
        .login-link a:hover {
            color: white;
            text-decoration: underline;
        }
        
        .requirements {
            background: rgba(212, 175, 55, 0.1);
            border-left: 3px solid #d4af37;
            padding: 12px 15px;
            margin: 20px 0;
            font-size: 13px;
            color: #ccc;
        }
        
        .requirements ul {
            margin: 5px 0;
            padding-left: 20px;
        }
        
        .requirements li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>✄ Barber Shop</h1>
            <p>Create Your Account</p>
        </div>
        
        <?php if($success_msg): ?>
            <div class="message success">
                <?php echo $success_msg; ?>
                <br>
                <a href="login.php" style="color: #28a745; text-decoration: underline;">Click here to login</a>
            </div>
        <?php endif; ?>
        
        <?php if($register_err): ?>
            <div class="message error"><?php echo $register_err; ?></div>
        <?php endif; ?>
        
        <div class="requirements">
            <strong>Account Requirements:</strong>
            <ul>
                <li>Username: Letters, numbers, underscores only</li>
                <li>Password: Minimum 6 characters</li>
                <li>All accounts require admin approval (status: pending)</li>
            </ul>
        </div>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" 
                       value="<?php echo htmlspecialchars($username); ?>"
                       placeholder="Choose a username"
                       class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" 
                       value="<?php echo htmlspecialchars($full_name); ?>"
                       placeholder="Your full name"
                       class="<?php echo (!empty($full_name_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $full_name_err; ?></span>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" 
                       placeholder="Create password (min. 6 chars)"
                       class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" 
                       placeholder="Repeat password"
                       class="<?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <input type="submit" class="btn-register" value="CREATE ACCOUNT">
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>