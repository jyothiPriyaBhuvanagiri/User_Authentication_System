<?php
// db.php
$host = 'localhost';
$dbname = 'user_auth';
$username = 'root';  // Default username for XAMPP/MAMP
$password = '';      // Default password for XAMPP/MAMP (empty string)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

