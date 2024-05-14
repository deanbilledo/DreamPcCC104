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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["user_username"];
    echo $name; // Debugging line
    $password = $_POST["user_password"];
    $phone_number = $_POST["user_phone_number"];

    // Hash the password
    $options = [
      'cost' => 12,
    ];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);

    $sql = "INSERT INTO user (user_username, user_password, user_phone_number)
    VALUES ('$name', '$hashed_password', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "Login successful!";
        header("Location: ../login.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>