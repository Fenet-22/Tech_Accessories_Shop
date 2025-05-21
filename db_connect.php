<?php
$servername = "sql306.infinityfree.com";
$username = "if0_39021987";
$password = "6WRrFiDfen6fJ"; // default for XAMPP
$dbname = "if0_39021987_Techcessore"; // Change this to match your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
