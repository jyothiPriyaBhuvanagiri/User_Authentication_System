<?php

if(isset($_SESSION['user_id'])){
    header("Location:dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <h1>Welcome to Our Website!</h1>
    <p>Please <a href="login.php">log in</a> or <a href="register.php">sign up</a>.</p>
</body>
</html>