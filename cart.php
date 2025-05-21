<?php
// Start the session to retrieve the logged-in user's ID
session_start();
require_once "db_connect.php"; // Make sure this file connects to your database

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit;
    }

    // Collect general order data
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $payment_method = $_POST['payment_method'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];

    // Insert into orders table
    $order_sql = "INSERT INTO orders (user_id, full_name, email, phone_number, payment_method, address_line1, address_line2, city, postal_code, country, order_time)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($order_sql);

    if ($stmt === false) {
        error_log("Error preparing order statement: " . $conn->error);
        echo "An error occurred. Please try again later.";
        exit;
    }

    $stmt->bind_param("isssssssss", $user_id, $full_name, $email, $phone_number, $payment_method, $address_line1, $address_line2, $city, $postal_code, $country);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        $cardholder_name = $card_number = $expiration_date = $cvv = $paypal_email = null;

        if ($payment_method === "credit") {
            $cardholder_name = $_POST['cardholder_name'];
            $card_number = $_POST['card_number'];
            $expiration_date = $_POST['expiration_date'];
            $cvv = $_POST['cvv'];
        } elseif ($payment_method === "paypal") {
            $paypal_email = $_POST['paypal_email'];
        }

        $payment_sql = "UPDATE orders SET cardholder_name = ?, card_number = ?, expiration_date = ?, cvv = ?, paypal_email = ? WHERE id = ?";
        $stmt2 = $conn->prepare($payment_sql);

        if ($stmt2 === false) {
            error_log("Error preparing payment statement: " . $conn->error);
            echo "An error occurred. Please try again later.";
            exit;
        }

        $stmt2->bind_param("sssssi", $cardholder_name, $card_number, $expiration_date, $cvv, $paypal_email, $order_id);

        if ($stmt2->execute()) {
            echo "success"; // ✅ This is what we are checking in JS
        } else {
            error_log("Error inserting payment details: " . $stmt2->error);
            echo "An error occurred. Please try again later.";
        }

    } else {
        error_log("Error inserting order: " . $stmt->error);
        echo "An error occurred. Please try again later.";
    }

    $stmt->close();
    $stmt2->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cart Page</title>
  <link rel="stylesheet" href="form-style.css"/>
  <style>
    .hidden { display: none; }
  </style>
</head>
    
<body>
  <div class="cart-container">
    <h2>Checkout</h2>
    <form id="cartForm" method="POST">
      <div class="input-group">
        <label>Full Name</label>
        <input type="text" name="full_name" required />
      </div>
      <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" required />
      </div>
      <div class="input-group">
        <label>Address Line 1</label>
        <input type="text" name="address_line1" required />
      </div>
      <div class="input-group">
        <label>Address Line 2</label>
        <input type="text" name="address_line2" />
      </div>
      <div class="input-group">
        <label>City</label>
        <input type="text" name="city" required />
      </div>
      <div class="input-group">
        <label>Postal Code</label>
        <input type="text" name="postal_code" required />
      </div>
      <div class="input-group">
        <label>Country</label>
        <input type="text" name="country" required />
      </div>
      <div class="input-group">
        <label>Phone Number</label>
        <input type="tel" name="phone_number" required />
      </div>
      <div class="input-group">
        <label>Payment Method</label>
        <select id="paymentMethod" name="payment_method" required>
          <option value="">Select...</option>
          <option value="credit">Credit Card</option>
          <option value="paypal">PayPal</option>
        </select>
      </div>

      <!-- Credit Card Fields -->
      <div id="creditFields" class="payment-details hidden">
        <div class="input-group">
          <label>Cardholder Name</label>
          <input type="text" name="cardholder_name" />
        </div>
        <div class="input-group">
          <label>Card Number</label>
          <input type="text" name="card_number" maxlength="16" />
        </div>
        <div class="input-group">
          <label>Expiration Date</label>
          <input type="month" name="expiration_date" />
        </div>
        <div class="input-group">
          <label>CVV</label>
          <input type="text" name="cvv" maxlength="4" />
        </div>
      </div>

      <!-- PayPal Fields -->
      <div id="paypalFields" class="payment-details hidden">
        <div class="input-group">
          <label>PayPal Email</label>
          <input type="email" name="paypal_email" />
        </div>
      </div>

      <button type="submit" class="submit-btn">Place Order</button>
      <p id="confirmationMessage" class="hidden">Your order is placed successfully. We’ll deliver within 3–5 business days!</p>
    </form>
  </div>

  <script>
    const paymentMethod = document.getElementById('paymentMethod');
    const creditFields = document.getElementById('creditFields');
    const paypalFields = document.getElementById('paypalFields');
    const confirmationMessage = document.getElementById('confirmationMessage');
    const cartForm = document.getElementById('cartForm');

    paymentMethod.addEventListener('change', () => {
      creditFields.classList.add('hidden');
      paypalFields.classList.add('hidden');

      if (paymentMethod.value === 'credit') {
        creditFields.classList.remove('hidden');
      } else if (paymentMethod.value === 'paypal') {
        paypalFields.classList.remove('hidden');
      }
    });

    cartForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const formData = new FormData(cartForm);

      fetch('cart.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(result => {
        const trimmed = result.trim().toLowerCase();
        if (trimmed === "success") {
          cartForm.reset(); // ✅ Clear form
          confirmationMessage.classList.remove('hidden'); // ✅ Show success
        } else {
          alert("Something went wrong: " + result); // Show error message
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong.");
      });
    });
  </script>
</body>
</html>
