<?php
// signup.php

$host = "localhost";
$dbname = "techcessore";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_POST['username'];
  $email = $_POST['email'];
  $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO app_users (username, email, password_hash) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $user, $email, $pass);

  if ($stmt->execute()) {
    // Redirect to login page
    header("Location: login.php");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Sign Up - Techcessoré</title>
  <link rel="stylesheet" href="form-style.css">
</head>
<body>
<div class="cart-container">
  <h1>Create an Account</h1>
  <form action="signup.php" method="post">
    <div class="input-group">
      <input type="text" name="username" placeholder="Username" required>
    </div>
    <div class="input-group">
      <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="input-group">
      <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" class="submit-btn">Sign Up</button>
  </form>
</div>
</body>
</html>
