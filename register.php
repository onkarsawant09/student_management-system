<?php
require_once 'config/database.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $full_name = sanitize($_POST['full_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $enrollment_no = sanitize($_POST['enrollment_no']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, full_name, enrollment_no) VALUES (?, ?, ?, 'student', ?, ?)");
        $stmt->execute([$username, $email, $password, $full_name, $enrollment_no]);
        
        // Redirect to login page with success flag
        header("Location: index.php?registered=1");
        exit(); // Always call exit after header redirect
    } catch(PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div class="glass-card" style="max-width: 500px; width: 100%; padding: 40px;">
            <h2 style="text-align: center; margin-bottom: 30px;">Student Registration</h2>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Enrollment Number</label>
                    <input type="text" name="enrollment_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
            </form>
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php">Already have an account? Login</a>
            </div>
        </div>
    </div>
</body>
</html>