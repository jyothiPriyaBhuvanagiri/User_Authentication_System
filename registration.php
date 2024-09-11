<?php
global $conn;
include ('includes/db.php');

 if($_SERVER["REQUEST_METHOD"] == 'POST')
 {
     $username= $_POST['username'];
     $email=$_POST['email'];
     $password=password_hash($_POST['password'], PASSWORD_BCRYPT);
     $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

     $stmt = $conn->prepare($sql);

     try {
         $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
         echo "Registration successful!";
     } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
     }


 }
?>
<!-- HTML Form -->
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
</form>
