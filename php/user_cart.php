<?php
session_start();

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
$user_id = $_GET['user_id'];
// Check if user_id and product_id are set in the URL parameters
if (isset($_GET['user_id']) && isset($_GET['product_id'])) {
    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];

    // Fetch product details from the database
    $product_query = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product_result = $product_query->get_result();

    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();

        // Insert product into the cart table
        $insert_query = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, product_price, product_description, product_img) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_query->bind_param("iisdss", $user_id, $product_id, $product_row['product_name'], $product_row['product_price'], $product_row['product_description'], $product_row['product_img']);
        $insert_query->execute();



        // Redirect back to the products page
        header("Location: user_cart.php?user_id=" . urlencode($user_id));
        exit();
    } else {
        echo "Product not found.";
    }
    
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Dream PC | Ecommerce Website</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cart_style.css">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
    <style>
        .active a {
            background-color: red;
            color: black;
            border-radius: 10px; 
            padding: 5px 10px;
        }


        li a:hover {
            background-color: #717171;
            color: white;
            border-radius: 10px; 
        }
    </style>

    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="cart.html">
                        <img src="../images/dreampc logo.png" width="125px">
                    </a>
                </div>
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search...">
                    <button class="search-button" type="button">Search</button>
                </div>
                <nav>
                    <ul id="MenuItems">
                            <li><a href="loggedin_index.php?user_id=<?php echo urlencode($user_id); ?>">Home</a></li>    
                            <li><a href="user_products.php?user_id=<?php echo urlencode($user_id); ?>">Products</a></li>
                            <li><a href="loggedin_about.php?user_id=<?php echo urlencode($user_id); ?>">About</a></li>
                            <li><a href="loggedin_contacts.php?user_id=<?php echo urlencode($user_id); ?>">Contact</a></li>
                            <li><a href="loggedin_profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
                </nav>
                <a href="cart.html"   style="background-color: wheat; color: black; border-radius: 10px; padding: 5px 10px;">
                    <i class='bx bxs-cart' width="30px" height="30px"></i>
                </a>
                <img src="images/images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>
   

    <?php

// Fetch all products in the user's cart
$cart_query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$result = $cart_query->get_result();

if ($result->num_rows > 0) {
?>
    <div class="small-container cart-page" style="padding: 10px 250px;">
        <table >
            <tr class="alltopay">
                <th>Products</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php

            $total_price = 0;

            // Loop through each cart item
            while ($cart_item = $result->fetch_assoc()) {
                $product_id = $cart_item['product_id'];
                $product_name = $cart_item['product_name'];
                $product_price = $cart_item['product_price'];
                $product_img_url = $cart_item['product_img'];
                $product_quantity = $cart_item['product_quantity'];
                
                $total_price += $product_price; // Add product price to total

                ?>
                <tr>
                    <td>
                        <div class="cart-info">
                            <img src="../images/product_img/<?php echo $product_img_url; ?>" style="width: 100px; height: 100px;">
                            <div>
                                <p><?php echo $product_name; ?></p>
                                <small>Price: <?php echo $product_price; ?> PHP</small>
                                <br>
                                <a href="remove_cart_items.php?cart_id=<?php echo urlencode($cart_item['cart_id']); ?>&user_id=<?php echo urlencode($user_id); ?>" onclick="return confirm('Are You Sure You Want To Delete This Product');">
                                Remove</a>
                            </div>
                        </div>
                    </td>
                    <form id="updateForm" action="quantity_update.php" method="post">
                        <input type="hidden" value="<?php echo $cart_item['cart_id']; ?>" name="cart_id">
                        <input type="hidden" value="<?php echo $product_id; ?>" name="update_quantity_id">
                        <td>
                            <input type="number" min="1" value="<?php echo $product_quantity; ?>" name="update_quantity">
                            <input type="submit" value="Update" name="update_product_quantity" onclick="showPopup()">
                        </td>
                        <td>
                            <?php echo $product_price * $product_quantity; ?> PHP
                        </td>
                    </form>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3"> Total:  <?php echo number_format($total_price * $product_quantity, 2); ?> PHP</td>
            </tr>
            
        </table>
        
        

        <div class="table_bottom">
        <a href="user_products.php?user_id=<?php echo urlencode($user_id); ?>" class="bottom_btn">Continue Shopping</a>
        <form action="user_checkout.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit" name="place_order" class="bottom_btn">Proceed To Checkout</button>
        </form>

            <h3 class="total-price" >Grand Total: <span><?php echo number_format($total_price * $product_quantity, 2); ?> PHP</span></h3>
        </div>

    </div>
    
<?php
} else {
    echo "Your cart is empty.";
    echo $user_id;
}
?>
 
    <script>
        function showPopup() {
            alert("Product quantity updated!");
        }
    </script>

    <script>
        var MenuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";
        function menutoggle(){
            if(MenuItems.style.maxHeight == "0px"){
                MenuItems.style.maxHeight = "200px"
            }
            else{
                MenuItems.style.maxHeight = "0px"
            }
        }
    </script>

</body>
</html>
