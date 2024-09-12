<?php
global $conn;
include ('includes/db.php');
session_start();
if ($_SERVER['REQUEST_METHOD']== 'POST'){
$email = $_POST['email'];
$password =$_POST['password'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    // Bind the email parameter
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: forgot_password.php");
    }
}
?>

<!-- HTML Form -->
<form method="POST" action="login.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>