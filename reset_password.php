<?php
global $conn;
include('includes/db.php');
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_token_expire > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user = $result->fetch_assoc();

            // Update the password
            $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expire = NULL WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_password, $user['id']);
            if ($stmt->execute()) {
                echo "Password successfully reset. <a href='login.php'>Login here</a>";
            } else {
                echo "Error resetting password.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>

<!-- HTML Form -->
<form method="POST" action="reset_password.php?token=<?php echo $_GET['token']; ?>">
    <label>New Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Reset Password</button>
</form>
