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

session_start();

// Check if user_id is set in session
if (!isset($_SESSION["user_id"])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Get user_id from session
$user_id = $_SESSION["user_id"];

// Check if the request is a POST request and if user_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["place_order"])) {
    // Fetch all products in the user's cart
    $cart_query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $cart_query->bind_param("i", $user_id);
    $cart_query->execute();
    $result = $cart_query->get_result();

    // Check if there are any items in the cart
    if ($result->num_rows > 0) {
        // Prepare and bind parameters for the insert statement
        $insert_order = $conn->prepare("INSERT INTO user_order (user_id, product_id, product_name, product_img, product_price, quantity, order_date)
        SELECT ?, product_id, product_name, product_img, product_price, product_quantity, CURRENT_TIMESTAMP()
        FROM cart
        WHERE user_id = ?");
        $insert_order->bind_param("ii", $user_id, $user_id);
    

        // Execute the insert statement
        $insert_order->execute();

        // Close the prepared statement
        $insert_order->close();

         // Update product quantity in the product table based on the ordered quantity
         while ($cart_item = $result->fetch_assoc()) {
            $product_id = $cart_item['product_id'];
            $ordered_quantity = $cart_item['product_quantity'];

            // Subtract the ordered quantity from the product quantity in the product table
            $update_product_quantity = $conn->prepare("UPDATE product SET product_quantity = product_quantity - ? WHERE product_id = ?");
            $update_product_quantity->bind_param("ii", $ordered_quantity, $product_id);
            $update_product_quantity->execute();
            $update_product_quantity->close();
        }

        // Clear the user's cart after placing the order
        $clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $clear_cart->bind_param("i", $user_id);
        $clear_cart->execute();
        $clear_cart->close();

        // Redirect the user to a confirmation page or any other page
        // header("Location: user_order_placed.php");
        // exit;
    } else {
        // No items in the cart
        //echo "Your cart is empty.";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed - Dream PC | Ecommerce Website</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cart_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
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
                        </ul>
                    </nav>
                    <a href="cart.html">
                        <i class='bx bxs-cart' width="30px" height="30px"></i>
                    </a>
                    <img src="../images/images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>
        
    




    <div class="offer">
        <div class="small-cointainer">
        <h5 style = "font-size: 50px" >Order Placed</h5>
            <div class="row">
            <div class="table_bottom">
                <a href="products.php?user_id=<?php echo urlencode($user_id); ?>" class="bottom_btn">Continue Shopping</a>
                    <a href="user_cart.php?user_id=<?php echo urlencode($user_id); ?>" class="bottom_btn">Back To Cart</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    
    $user_id = $_SESSION["user_id"];

    // Fetch all products in the user's cart
    $cart_query = $conn->prepare("SELECT * FROM user_order WHERE user_id = ?");
    $cart_query->bind_param("i", $user_id);
    $cart_query->execute();
    $result = $cart_query->get_result();
    
    if ($result->num_rows > 0) {
        ?>
    
        <div class="small-container cart-page" style="padding: 10px 250px;">
            <table>
                <tr class="alltopay">
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
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
                    $product_quantity = $cart_item['quantity'];
                    
                    $total_price += $product_price; // Add product subtotal to total
                    ?>
                    <tr>
                        <td>
                            <div class="cart-info">
                                <!-- Display product image, name, and remove link -->
                                <img src="../images/product_img/<?php echo $cart_item['product_img']; ?>" style="width: 100px; height: 100px;">
                                <div>
                                    <p><?php echo $product_name; ?></p>
                                    <small>Price: <?php echo $product_price; ?> PHP</small>
                                    <br>
                            
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" min="1" value="<?php echo $product_quantity; ?>" name="update_quantity">    
                        </td>
                        <td><?php echo $product_price; ?> PHP</td>
                        
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3">Total:</td>
                    <td><?php echo number_format($total_price, 2); ?> PHP</td>
                </tr>
            </table>
        </div>
    
    <?php
    } else {
        // No items in the cart
        echo "Your cart is empty.";
    }
    ?>
        
      
   

    <!------- Footer --------->

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download Our App</h3>
                    <p>Please support me</p>
                    <div class="app-logo">
                        <img src="../images/dreampc logo.png">
                    </div>
                </div>
                <div class="footer-col-2">
                    <img src="../images/dreampc logo.png">
                    <p>By Reigh And Weskita</p>
                </div>
                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Discount</li>
                        <li>Blogs</li>
                        <li>Policy</li>
                        <li>Shipping</li>
                        <li>Coupons</li>
                    </ul>
                </div>
                <div class="footer-col-4">
                    <h3>Follow Us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Instagram</li>
                        <li>Twitter</li>
                        <li>LinkedIn</li>
                        <li>Youtube</li>
                    </ul>
                </div>
            </div>
            <hr>
                <p class="copyright">Copyright 2024 - Dean Billedo - </p>
            </hr>
        </div>
    </div>

    <!---------JS for toggle menu --------->

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