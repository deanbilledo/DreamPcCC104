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

// Retrieve all products
$product_query = "SELECT product_id, product_name FROM product";
$result = $conn->query($product_query);

if ($result->num_rows > 0) {
    // Products found
    while ($row = $result->fetch_assoc()) {
        $product_id = $row["product_id"];
        $product_name = $row["product_name"];
        
        // Check product quantity
        $quantity_query = "SELECT product_quantity FROM product WHERE product_id = $product_id";
        $quantity_result = $conn->query($quantity_query);

        if ($quantity_result->num_rows > 0) {
            $quantity_row = $quantity_result->fetch_assoc();
            $product_quantity = $quantity_row["product_quantity"];
            
            // Delete product if quantity is 0
            if ($product_quantity <= 0) {
                $delete_query = "DELETE FROM product WHERE product_id = $product_id";
                if ($conn->query($delete_query) === TRUE) {
                    echo "Product '$product_name' (ID: $product_id) deleted successfully due to zero quantity.<br>";
                } else {
                    echo "Error deleting product '$product_name' (ID: $product_id): " . $conn->error . "<br>";
                }
            }
        }
    }
} else {
    echo "No products found.<br>";
}

$conn->close();
?>
