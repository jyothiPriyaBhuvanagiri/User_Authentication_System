<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $conn;
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Prepare the SQL query with positional placeholders
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die('Error in preparing statement: ' . $conn->error);
    }

    // Bind the parameters to the statement
    $stmt->bind_param("sss", $username, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
    include ('includes/db.php');
    session_start();
}
?>

<!-- HTML Form -->
<form method="POST" action="register.php">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
</form>