<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h1>Hello, <?php echo $_SESSION['username']; ?>!</h1>
<p>Welcome to your dashboard.</p>
<a href="logout.php">Logout</a>
</body>
</html>
