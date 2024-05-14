<?php

// Database connection parameters
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $message = $_POST['message'];

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO admin_message (message_name, message_address, message_phone_number, message_content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $address, $phone_number, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you for messaging us!'); window.location.href = '../index.html';</script>";
        exit(); // Ensure script execution stops after showing the pop-up
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>
