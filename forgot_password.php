<?php
global $conn;
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        try {
            $token = bin2hex(random_bytes(50));
        } catch (Exception $e) {
        } // Generate a 50-character token
        $expire_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour

        // Save the token and expiration time to the database
        $sql = "UPDATE users SET reset_token = ?, reset_token_expire = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $expire_time, $email);
        $stmt->execute();

        // Send the password reset link via email (simplified for demonstration)
        $reset_link = "http://localhost:8001/reset_password.php?token=" . $token;
        echo "A password reset link has been sent to your email: <a href='$reset_link'>Reset Password</a>";
        // In production, you would use mail() to send the email.
    } else {
        echo "No account found with that email address!";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Forgot Password</h2>
    <p>Enter your email address to receive a password reset link.</p>
    <form method="POST" action="forgot_password.php">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
    </form>
</div>
</body>
</html>

