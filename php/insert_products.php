<?php
// Database Credentials
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

if (isset($_POST['add_product'])) {
    // Validate product name, price, description, and quantity
    $product_name = trim($_POST['product_name']);
    $category_id = $_POST['category_id'];
    $product_price = floatval($_POST['product_price']);
    $product_description = trim($_POST['product_description']);
    $product_quantity = intval($_POST['product_quantity']); // Convert to integer for quantity

    // Image Upload (Optional) with Validation
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        // Validate and process the uploaded file
        $product_image_name = $_FILES['product_image']['name'];
        $product_image_temp_name = $_FILES['product_image']['tmp_name'];
        $product_image_destination = '../images/product_img/' . $product_image_name;

        if (move_uploaded_file($product_image_temp_name, $product_image_destination)) {
            // Prepare and execute statement for inserting product into database
            $stmt = $conn->prepare("INSERT INTO product (product_name, category_id, product_price, product_description, product_quantity, product_img) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssis', $product_name, $category_id, $product_price, $product_description, $product_quantity, $product_image_name);

            // Execute statement
            if ($stmt->execute()) {
                // Success message and redirect
                header("Location: ./admin_products.php");
                echo "Product added successfully<br>";
                echo "Name: " . $product_name . "<br>";
                echo "Price: " . $product_price . "<br>";
                echo "Description: " . $product_description . "<br>";
                echo "Quantity: " . $product_quantity . "<br>";
            } else {
                echo "Error in adding product to the database.";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error in moving uploaded file.";
        }
    } else {
        // Handle cases where no file is uploaded or there's an upload error
        if ($_FILES['product_image']['error'] === UPLOAD_ERR_NO_FILE) {
            echo "No file uploaded.";
        } else {
            echo "Error uploading file: " . $_FILES['product_image']['error'];
        }
    }
}

// Close the database connection
$conn->close();
?>
