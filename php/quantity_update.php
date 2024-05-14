<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_SESSION['user_id'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and the update_product_quantity button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product_quantity'])) {
    // Get the cart ID, product ID, and updated quantity from the form
    $cart_id = $_POST['cart_id'];
    $product_id = $_POST['update_quantity_id'];
    $updated_quantity = $_POST['update_quantity'];

    // Update the product quantity in the cart table based on both cart_id and product_id
    $update_query = $conn->prepare("UPDATE cart SET product_quantity = ? WHERE cart_id = ? AND product_id = ?");
    $update_query->bind_param("iii", $updated_quantity, $cart_id, $product_id);
    $update_query->execute();
    // Redirect back to the cart page
    header("Location: user_cart.php?user_id=" . urlencode($user_id));
    exit();
}
?>