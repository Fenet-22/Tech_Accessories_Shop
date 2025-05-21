<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product or increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    // Redirect to cart page
    header("Location: cart.php");
    exit;
} else {
    // If no product_id in POST, redirect somewhere safe (like homepage)
    header("Location: index.php");
    exit;
}
?>
