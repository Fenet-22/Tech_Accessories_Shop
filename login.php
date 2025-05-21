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

$error = ""; // Holds login errors

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
      header("Location: index.php");
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "User not found.";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Techcessoré</title>
  <link rel="stylesheet" href="form-style.css">
  <style>
    .error-message {
      color: red;
      margin-bottom: 10px;
      background: #1a1a1a;
      padding: 10px;
      border-radius: 5px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="cart-container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
      <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="input-group">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="submit-btn">Login</button>
    </form>

    <p style="text-align:center; margin-top:15px; color:fuchsia;">
      Don't have an account? <a href="signup.php">Sign up</a>
    </p>
  </div>
</body>
</html>
