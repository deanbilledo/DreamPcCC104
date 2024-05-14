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
    //echo $delete_id;


    //delete sa cart
    $delete_cart_query = mysqli_query($conn, "DELETE FROM cart WHERE product_id = $delete_id") or
    die("Query Failed to delete users cart products");

    //delete sa admin part
    $delete_query = mysqli_query($conn, "DELETE FROM product WHERE product_id = $delete_id") or 
    die("Query Failed to delete products in the database");

    if($delete_query){
        
        header("Location: admin_products.php");
    }else{
        echo "Product Not Added";
        header("Location: ../adminproducts.php");
    }

}


?>