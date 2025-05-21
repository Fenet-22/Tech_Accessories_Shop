<?php
session_start();
$host = "localhost";
$dbname = "techcessore";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $passwordInput = $_POST['password'];

  $sql = "SELECT id, username, password_hash FROM app_users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($passwordInput, $user['password_hash'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      echo "success";
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "User not found.";
  }

  $stmt->close();
}
$conn->close();
?>
