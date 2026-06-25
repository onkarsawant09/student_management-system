<?php
require_once 'config/database.php';

if (!isset($_SESSION['reset_email'])) {
    redirect('forgot-password.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_SESSION['reset_email'];
    
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$password, $email]);
    
    unset($_SESSION['reset_email']);
    $success = "Password reset successful! Please login.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="glass-card" style="max-width: 400px; width: 100%; padding: 40px;">
            <h2>Reset Password</h2>
            
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <a href="index.php" class="btn btn-primary">Login Now</a>
            <?php else: ?>
                <form method="POST">
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="New Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Reset Password</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>