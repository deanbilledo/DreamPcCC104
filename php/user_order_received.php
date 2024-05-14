<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Start session
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_received"])) {
    // Retrieve data from the user_order table
    $select_query = "SELECT * FROM user_order";
    $result = mysqli_query($conn, $select_query);

    // Check if there are any orders
    if (mysqli_num_rows($result) > 0) {
        // Loop through each order and insert it into the order_received table
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row["user_id"];
            $product_id = $row["product_id"];
            $product_name = $row["product_name"];
            $product_img = $row["product_img"];
            $product_price = $row["product_price"];
            $quantity = $row["quantity"];
            $order_date = $row["order_date"];

            // Insert data into order_received table
            $insert_query = "INSERT INTO order_received (user_id, product_id, product_name, product_img, product_price, quantity, order_date) 
                             VALUES ('$user_id', '$product_id', '$product_name', '$product_img', '$product_price', '$quantity', '$order_date')";
            mysqli_query($conn, $insert_query);
        }

        // Delete all records from user_order table
        $delete_query = "DELETE FROM user_order";
        mysqli_query($conn, $delete_query);

        // Redirect back to the previous page or to a success page
        header("Location: loggedin_profile.php?user_id=" . urlencode($user_id));
        exit();
    } else {
        // No orders to process
        echo "No orders to process.";
    }
} else {
    // If the form is not submitted, redirect back to the previous page
    header("Location: previous_page.php");
    exit();
}
?>