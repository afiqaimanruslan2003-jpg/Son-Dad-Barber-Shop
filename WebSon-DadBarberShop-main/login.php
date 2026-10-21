<?php
// login.php - ENHANCED VERSION WITH BETTER DESIGN
ob_start();
session_start();
require_once 'config.php';

// Check if already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redirect based on role
    if ($_SESSION["role"] == "admin") {
        header("Location: frameBarber.php"); // admin
    } else {
        header("Location: welcomeBarber.php");  // Regular users
    }
    exit();
}

// Initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check credentials
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password_hash, full_name, role, status 
                FROM users WHERE username = :username AND status = 'active'";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $user = $stmt->fetch();

                if (password_verify($password, $user['password_hash'])) {
                    // Update last login
                    $update_sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bindParam(":id", $user['id'], PDO::PARAM_INT);
                    $update_stmt->execute();

                    // Store session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['id'];
                    $_SESSION["username"] = $user['username'];
                    $_SESSION["full_name"] = $user['full_name'];
                    $_SESSION["role"] = $user['role'];

                    // Reset login attempts
                    $reset_sql = "UPDATE users SET login_attempts = 0, locked_until = NULL WHERE id = :id";
                    $reset_stmt = $conn->prepare($reset_sql);
                    $reset_stmt->bindParam(":id", $user['id'], PDO::PARAM_INT);
                    $reset_stmt->execute();

                    // Redirect based on role
                    if ($_SESSION["role"] == "admin") {
                        header("Location: frameBarber.php");  // Admin goes here
                    } else {
                        header("Location: welcomeBarber.php");  // Regular users go here
                    }
                    exit();

                } else {
                    $login_err = "Invalid username or password.";
                    // Increment failed attempts
                    $attempt_sql = "UPDATE users SET login_attempts = login_attempts + 1 WHERE username = :username";
                    $attempt_stmt = $conn->prepare($attempt_sql);
                    $attempt_stmt->bindParam(":username", $username, PDO::PARAM_STR);
                    $attempt_stmt->execute();
                }
            } else {
                $login_err = "Invalid username or password.";
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
    <title>Son & Dad Barber Shop | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #d4af37;
            --dark-gold: #b8962e;
            --charcoal: #2a2a2a;
            --light-charcoal: #3a3a3a;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --success: #28a745;
            --danger: #dc3545;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        .bg-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .floating-scissors {
            position: absolute;
            font-size: 24px;
            color: var(--gold);
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .floating-scissors:nth-child(1) {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-scissors:nth-child(2) {
            top: 20%;
            right: 10%;
            animation-delay: -5s;
        }

        .floating-scissors:nth-child(3) {
            bottom: 30%;
            left: 15%;
            animation-delay: -10s;
        }

        .floating-scissors:nth-child(4) {
            bottom: 15%;
            right: 20%;
            animation-delay: -15s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            100% {
                transform: translate(100px, 100px) rotate(360deg);
            }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(40, 40, 40, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(212, 175, 55, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
        }

        /* Barber Pole Header */
        .login-header {
            background: linear-gradient(90deg,
                    #ff0000 0%, #ff0000 25%,
                    #ffffff 25%, #ffffff 50%,
                    #0000ff 50%, #0000ff 75%,
                    #ffffff 75%, #ffffff 100%);
            height: 10px;
            width: 100%;
            background-size: 40px 100%;
            animation: barberPole 2s linear infinite;
        }

        @keyframes barberPole {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 40px 0;
            }
        }

        .login-content {
            padding: 40px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            font-size: 48px;
            color: var(--gold);
            margin-bottom: 15px;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .logo-text h1 {
            color: var(--white);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .logo-text p {
            color: #aaa;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            color: var(--gold);
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 50px;
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--white);
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        .form-control::placeholder {
            color: #888;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 13px;
            margin-top: 5px;
            display: block;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
            color: #000;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #e6c158 0%, var(--gold) 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login i {
            font-size: 18px;
        }

        /* Messages */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        /* Demo Section */
        .demo-section {
            background: rgba(212, 175, 55, 0.1);
            border-left: 4px solid var(--gold);
            padding: 15px;
            margin: 25px 0;
            border-radius: 8px;
        }

        .demo-title {
            color: var(--gold);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .demo-accounts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
        }

        .demo-account {
            background: rgba(255, 255, 255, 0.05);
            padding: 10px;
            border-radius: 6px;
            font-size: 12px;
            color: #ccc;
        }

        .demo-account strong {
            color: var(--white);
            display: block;
            margin-bottom: 3px;
        }

        .demo-account .role {
            color: var(--gold);
            font-size: 11px;
            text-transform: uppercase;
        }

        /* Links Section */
        .links-section {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .register-link {
            display: inline-block;
            background: transparent;
            color: var(--gold);
            border: 2px solid var(--gold);
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .register-link:hover {
            background: var(--gold);
            color: #000;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(212, 175, 55, 0.3);
        }

        .forgot-link {
            color: #aaa;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--gold);
            text-decoration: underline;
        }

        /* Role Badges */
        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 8px;
        }

        .role-admin {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .role-barber {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .role-staff {
            background: rgba(0, 123, 255, 0.2);
            color: #007bff;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-content {
                padding: 30px 20px;
            }

            .logo-text h1 {
                font-size: 24px;
            }

            .demo-accounts {
                grid-template-columns: 1fr;
            }

            .register-link {
                width: 100%;
                text-align: center;
            }
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--gold);
        }
    </style>
</head>

<body>
    <!-- Background elements -->
    <div class="bg-pattern"></div>
    <div class="floating-scissors">✄</div>
    <div class="floating-scissors">✂</div>
    <div class="floating-scissors">💈</div>
    <div class="floating-scissors">🧔</div>

    <div class="login-container">
        <!-- Barber Pole Header -->
        <div class="login-header"></div>

        <div class="login-content">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-cut"></i>
                </div>
                <div class="logo-text">
                    <h1>Son & Dad Barbershop</h1>
                    <p>Premium Grooming Experience</p>
                </div>
            </div>

            <!-- Error Message -->
            <?php if (!empty($login_err)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($login_err); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="loginForm">
                <!-- Username -->
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="username"
                            class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo htmlspecialchars($username); ?>" placeholder="Enter your username"
                            required>
                    </div>
                    <?php if (!empty($username_err)): ?>
                        <span class="invalid-feedback">
                            <i class="fas fa-times-circle"></i> <?php echo $username_err; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="passwordInput"
                            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                            placeholder="Enter your password" required>
                        <span class="password-toggle" id="togglePassword">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    <?php if (!empty($password_err)): ?>
                        <span class="invalid-feedback">
                            <i class="fas fa-times-circle"></i> <?php echo $password_err; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-key"></i> ACCESS SYSTEM
                </button>
            </form>

            <!-- Demo Accounts -->
            <div class="demo-section">
                <div class="demo-title">
                    <i class="fas fa-user-secret"></i> Demo Accounts (Click to auto-fill)
                </div>
                <div class="demo-accounts">
                    <div class="demo-account" onclick="fillDemo('owner', 'admin123')">
                        <strong>Manager <span class="role-badge role-admin">Admin</span></strong>
                        <div class="role">Full System Access</div>
                        <div>User: owner</div>
                        <div>Password: admin123</div>
                    </div>
                    <div class="demo-account" onclick="fillDemo('muhdhazwan363', 'mh12mh12')">
                        <strong>First user<span class="role-badge role-barber">User</span></strong>
                        <div class="role">User Access</div>
                        <div>User: muhdhazwan363</div>
                        <div>Password: mh12mh12</div>
                    </div>
                </div>
            </div>

            <!-- Links -->
            <div class="links-section">
                <a href="register.php" class="register-link">
                    <i class="fas fa-user-plus"></i> Create New Account
                </a>
                <div style="margin-top: 15px;">
                    <a href="#" class="forgot-link">
                        <i class="fas fa-question-circle"></i> Forgot Password? Contact Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Demo account auto-fill
        function fillDemo(username, password) {
            document.querySelector('input[name="username"]').value = username;
            document.getElementById('passwordInput').value = password;

            // Animate the filled account
            event.currentTarget.style.transform = 'scale(1.05)';
            event.currentTarget.style.boxShadow = '0 5px 15px rgba(212, 175, 55, 0.3)';
            setTimeout(() => {
                event.currentTarget.style.transform = 'scale(1)';
                event.currentTarget.style.boxShadow = 'none';
            }, 300);

            // Focus on login button
            document.querySelector('.btn-login').focus();
        }

        // Form validation animation
        const form = document.getElementById('loginForm');
        const inputs = form.querySelectorAll('.form-control');

        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function () {
                this.parentElement.style.transform = 'translateY(0)';
            });

            input.addEventListener('input', function () {
                if (this.value.trim() !== '') {
                    this.style.borderColor = 'var(--gold)';
                } else {
                    this.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                }
            });
        });

        // Login button animation on hover
        const loginBtn = document.querySelector('.btn-login');
        loginBtn.addEventListener('mouseenter', function () {
            this.querySelector('i').style.transform = 'rotate(15deg)';
        });

        loginBtn.addEventListener('mouseleave', function () {
            this.querySelector('i').style.transform = 'rotate(0deg)';
        });
    </script>
</body>

</html>
<?php ob_end_flush(); ?>