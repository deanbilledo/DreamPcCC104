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
    $name = $_POST["admin_username"];
    echo $name; // Debugging line
    $password = $_POST["admin_password"];
    $email = $_POST["admin_email"];

    // Hash the password
    $options = [
      'cost' => 12,
    ];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);

    $sql = "INSERT INTO admin (admin_username, admin_password, admin_email)
    VALUES ('$name', '$hashed_password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "Login successful!";
        header("Location: ../admin_login.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "Username: " . $name . "<br>";
    }
}

$conn->close();
?>
