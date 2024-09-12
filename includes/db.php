<?php
$servername = "localhost"; // Docker MySQL will be available on localhost
$username = "root";
$password = "my-secret-pw"; // Your MySQL root password
$dbname = "user_auth"; // Your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

