<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Update logic
if (isset($_POST['update_product'])) {
    $update_product_id = $_POST['update_product_id'];
    $update_product_name = $_POST['update_product_name'];
    $update_product_price = $_POST['update_product_price'];
    $update_product_description = $_POST['update_product_description'];
    $update_product_quantity = $_POST['update_product_quantity']; // New line to get product quantity

    // Check if file upload was attempted
    if (isset($_FILES['update_product_image'])) {
        // File upload was attempted
        if ($_FILES['update_product_image']['error'] === 0) {
            // File upload was successful
            $update_product_image = $_FILES['update_product_image']['name'];
            $update_product_image_tmp_name = $_FILES['update_product_image']['tmp_name'];
            $update_product_image_folder = '../images/product_img/' . $update_product_image;

            // Move uploaded file to destination folder
            move_uploaded_file($update_product_image_tmp_name, $update_product_image_folder);
        } else {
            // File upload failed or no file was selected
            // Handle the case where no file was uploaded or display an error message
            echo "File upload failed or no file was selected.";
        }
    }

    // Update query including product_quantity
    $update_products = mysqli_query($conn, "UPDATE product SET 
    product_name = '$update_product_name' , product_price = '$update_product_price' , 
    product_description = '$update_product_description' , product_img = '$update_product_image', 
    product_quantity = '$update_product_quantity' 
    WHERE  product_id =  $update_product_id");

    if ($update_products) {
        //echo "Product Updated" . "<br>";
        header("Location: admin_products.php");
    } else {
        echo "Error Updating Product";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/viewstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/ 6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pUCosxcg1QRNAq/
    DZjVsc01E40xSADs feQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Update</title>
</head>
<body>
    <section class="edit_container">
        <?php
            if(isset($_GET['update'])){
                $update_id = $_GET['update'];
                $update_query = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $update_id") or die("Query Failed");

                if(mysqli_num_rows($update_query) > 0){
                    $fetch_data = mysqli_fetch_assoc($update_query);
        ?>
           <form action="" method="post" enctype="multipart/form-data" class="update_product product_container_box">
    <img src="../images/product_img/<?php echo $fetch_data['product_img']; ?>" style="width: 100px; height: 100px;">
                
    <input type="hidden" value="<?php echo $fetch_data['product_id'] ?>" name="update_product_id">
    <input type="text" id="product_name" value="<?php echo $fetch_data['product_name'] ?>" name="update_product_name" class="input_fields fields" required>
    <label for="product_price">Product Price:</label>
    <input type="number" id="product_price" value="<?php echo $fetch_data['product_price'] ?>" name="update_product_price" class="input_fields fields" required>
    <label for="product_description">Product Description:</label>
    <input type="text" id="product_description" value="<?php echo $fetch_data['product_description'] ?>" name="update_product_description" class="input_fields fields" required>
    <label for="product_quantity">Product Quantity:</label>
    <input type="number" id="product_quantity" value="<?php echo $fetch_data['product_quantity'] ?>" name="update_product_quantity" class="input_fields fields" required>
    <label for="product_image">Product Image:</label>
    <input type="file" id="product_image" name="update_product_image" class="input_fields fields" required accept="image/png, image/jpg, image/jpeg">
    <div class="btn">
        <input type="submit" class="edit_btn" value="Update Product" name="update_product">
        <a href="admin_products.php">
            <input type="button" id="close-edit" value="Cancel" class="cancel_btn">
        </a>
    </div>
</form>

        <?php
                }
            }
        ?>
    </section>
</body>
</html>
