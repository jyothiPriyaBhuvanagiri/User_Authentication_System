<?php
global $conn;
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE users SET password = :password, reset_token = NULL WHERE reset_token = :token";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['password' => $new_password, 'token' => $token])) {
        echo "Password successfully reset!";
    } else {
        echo "Invalid or expired token!";
    }
}
?>

<!-- HTML Form -->
<form method="POST" action="reset_password.php">
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <label>New Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Reset Password</button>
</form>
