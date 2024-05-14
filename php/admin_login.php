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
    $password = $_POST["admin_password"];

    // Get the user record
    $sql = "SELECT * FROM admin WHERE admin_username='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            // Here, we get the hashed password from the database
            $hashed_password = $row['admin_password'];
            if (password_verify($password, $hashed_password)) {
                echo "Login successful";
                header("Location: ../admin_dashboard.html");
                exit();

            } else {               
                echo "Username: " . $name . "<br>";
                echo "Hashed password from database: " . $hashed_password . "<br>";
                echo "Entered password from form: " . $password . "<br>";
                echo "Invalid password";
            }
        }
    } else {
        echo "No user found with this username";
    }
}

$conn->close();
?>
