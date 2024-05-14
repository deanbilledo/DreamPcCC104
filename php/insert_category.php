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

    // Validate category name and description (optional)
    // You can add checks for emptiness, data types, etc.
    $category_name = trim($_POST['category_name']); // Trim leading/trailing whitespace
    $category_description = trim($_POST['category_description']);

    // Prepare statement for security
    $stmt = $conn->prepare("INSERT INTO product_category (category_name, category_description) VALUES (?, ?)");
    $stmt->bind_param('ss', $category_name, $category_description);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo "<script>
                alert('Product category added successfully');
                setTimeout(function() {
                    window.location.href = 'admin_add_category.php';
                }, 500); // Adjust the delay time as needed (in milliseconds)
              </script>";
        echo "Product category added successfully" . "<br>";
        echo $category_name . "<br>";
        echo $category_description . "<br>";
    } else {
        echo "Error in adding product category to the database.";
    }
    

    $stmt->close(); // Close the prepared statement
}


$conn->close(); // Close the database connection
?>
