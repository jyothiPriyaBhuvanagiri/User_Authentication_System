<?php
global $conn;
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(50));

    $sql = "UPDATE users SET reset_token = :token WHERE email = :email";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['token' => $token, 'email' => $email])) {
        // For simplicity, we'll just output the reset link
        $reset_link = "http://localhost/user_auth/reset_password.php?token=$token";
        echo "Password reset link: <a href='$reset_link'>$reset_link</a>";
    } else {
        echo "Email not found!";
    }
}
?>

<!-- HTML Form -->
<form method="POST" action="forgot_password.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
