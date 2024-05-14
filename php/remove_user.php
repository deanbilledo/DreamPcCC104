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

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    // Delete the user from the user table
    $delete_query = mysqli_query($conn, "DELETE FROM user WHERE user_id = $delete_id") or 
    die("Query Failed: " . mysqli_error($conn));
    echo "Query: DELETE FROM user WHERE user_id = $delete_id";
    

    if($delete_query){
        // If the user is successfully deleted, redirect to admin_clients.php
        header("Location: admin_clients.php");
    }else{
        // If deletion fails, display an error message and redirect to admin_clients.php
        echo "User Not Deleted";
        header("Location: admin_clients.php");
    }
}

?>
