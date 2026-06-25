<?php
require_once 'config/database.php';

// If already logged in but missing role, fix it before redirect
if (isLoggedIn()) {
    // Ensure role is set in session (recover from DB if missing)
    if (!isset($_SESSION['role'])) {
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['role'] = $user['role'];
        } else {
            // User not found, destroy session
            session_destroy();
            redirect('index.php');
        }
    }
    
    // Now check role and redirect to correct dashboard
    if ($_SESSION['role'] === 'admin') {
        // Check if admin dashboard exists to avoid infinite redirect
        if (file_exists('admin/dashboard.php')) {
            redirect('admin/dashboard.php');
        } else {
            echo "Admin dashboard file missing. Please create admin/dashboard.php";
            exit;
        }
    } else {
        if (file_exists('student/dashboard.php')) {
            redirect('student/dashboard.php');
        } else {
            echo "Student dashboard file missing. Please create student/dashboard.php";
            exit;
        }
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];          // explicitly set role
        $_SESSION['full_name'] = $user['full_name'];
        
        // Double-check: if role is empty, default to student
        if (empty($_SESSION['role'])) {
            $_SESSION['role'] = 'student';
        }
        
        // Redirect to appropriate dashboard
        if ($_SESSION['role'] === 'admin') {
            if (file_exists('admin/dashboard.php')) {
                redirect('admin/dashboard.php');
            } else {
                $error = "Admin dashboard not found. Please create admin/dashboard.php";
            }
        } else {
            if (file_exists('student/dashboard.php')) {
                redirect('student/dashboard.php');
            } else {
                $error = "Student dashboard not found. Please create student/dashboard.php";
            }
        }
    } else {
        $error = 'Invalid email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div class="glass-card" style="max-width: 450px; width: 100%; padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="background: var(--gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Student Management System</h2>
                <p style="color: var(--gray); margin-top: 10px;">Login to your account</p>
            </div>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login <i class="fas fa-arrow-right"></i></button>
            </form>
            
            <div style="margin-top: 20px; text-align: center;">
                <a href="register.php" style="color: var(--primary); text-decoration: none;">Create an Account</a>
                <span style="margin: 0 10px;">|</span>
                <a href="forgot-password.php" style="color: var(--primary); text-decoration: none;">Forgot Password?</a>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f0f0f0; border-radius: 10px;">
                <small style="color: var(--gray);">Demo Credentials:<br>
                Admin: admin@school.com / password<br>
                Student: student@school.com / password</small>
            </div>
        </div>
    </div>
</body>
</html>