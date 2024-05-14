<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get cart_id and user_id from the URL parameters
$cart_id = $_GET['cart_id'];
$user_id = $_GET['user_id'];

// Prepare and execute SQL to delete the product from the cart
$sql = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();

// Check if the product was successfully removed
if ($stmt->affected_rows > 0) {
    //echo "Product successfully removed from the cart.";
    header("Location: user_cart.php?user_id=" . urlencode($user_id));
    exit();
} else {
    echo "Failed to remove product from the cart.";
}

$stmt->close();
$conn->close();
?>
