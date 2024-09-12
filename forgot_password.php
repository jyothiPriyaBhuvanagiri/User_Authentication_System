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
<form method="POST" action="forgot_password.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Password Reset Link</button>
</form>
