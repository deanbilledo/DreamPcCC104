<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["user_username"];
    $password = $_POST["user_password"];

    // Get the user record
    $sql = "SELECT user_id, user_username, user_password FROM user WHERE user_username='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of the first row (assuming username is unique)
        $row = $result->fetch_assoc();
        // Here, we get the hashed password from the database
        $hashed_password = $row['user_password'];

        if (password_verify($password, $hashed_password)) {
            // Password is correct
            echo "Login successful";
            // Get the user ID
            $user_id = $row['user_id'];
            // Store user ID in session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_username'] = $name;
            // Redirect to loggedin.html
            header("Location: loggedin_index.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid password";
        }
    } else {
        // No user found with this username
        echo "No user found with this username";
    }
}

$conn->close();
?>
