<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Start session
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_username is set in session
if(isset($_SESSION['user_username'])) {
    // Retrieve user username and user_id from session
    $user_username = $_SESSION['user_username'];
    $user_id = $_SESSION['user_id'];

    // Prepare a SQL statement to retrieve the user's phone number, name, and email
    $stmt_user = $conn->prepare("SELECT user_phone_number FROM user WHERE user_id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $stmt_user->store_result(); // Store the result to free up the statement
    $stmt_user->bind_result($user_phone);
    if ($stmt_user->num_rows > 0) {
        $stmt_user->fetch();
    } else {
        echo "Phone number not found."; // Handle the case where no phone number is found
    }
    $stmt_user->free_result(); // Free the result set
    $stmt_user->close(); // Close the statement for user's phone number

    // Prepare a SQL statement to retrieve the user_info_name and user_info_email
    $stmt_info = $conn->prepare("SELECT user_info_name, user_info_email FROM user_info WHERE user_id = ?");
    $stmt_info->bind_param("i", $user_id);
    $stmt_info->execute();
    $stmt_info->store_result(); // Store the result to free up the statement
    $stmt_info->bind_result($user_info_name, $user_info_email);
    if ($stmt_info->num_rows > 0) {
        $stmt_info->fetch();
        $user_info_name = $user_info_name ?: 'No name yet, please add';
        $user_info_email = $user_info_email ?: 'No email yet, please add';
    } else {
        $user_info_name = 'No name yet, please add';
        $user_info_email = 'No email yet, please add';
    }
    $stmt_info->free_result(); // Free the result set
    $stmt_info->close(); // Close the statement for user's name and email

    // Prepare a SQL statement to retrieve the address_id from the user_address table
    $stmt_link = $conn->prepare("SELECT address_id FROM user_address WHERE user_id = ?");
    $stmt_link->bind_param("i", $user_id);
    $stmt_link->execute();
    $stmt_link->store_result(); // Store the result to free up the statement
    $stmt_link->bind_result($address_id);
    if ($stmt_link->num_rows > 0) {
        $stmt_link->fetch();
        $stmt_address = $conn->prepare("SELECT region, city, barangay, street FROM address WHERE address_id = ?");
        $stmt_address->bind_param("i", $address_id);
        $stmt_address->execute();
        $stmt_address->store_result(); // Store the result to free up the statement
        $stmt_address->bind_result($region, $city, $barangay, $street);
        if ($stmt_address->num_rows > 0) {
            $stmt_address->fetch(); // Fetch the address details
        }
        $stmt_address->free_result(); // Free the result set
        $stmt_address->close(); // Close the statement for address details
    } else {
        //echo "User address link not found."; // Handle the case where no address link is found
    }
    $stmt_link->free_result(); // Free the result set
    $stmt_link->close(); // Close the statement for user's address link
} else {
    echo "User not logged in"; // Display an error message
}

// Handle form submission for updating user info and address
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign the form data to variables
    $user_info_name = $_POST['user_info_name'] ?? '';
    $user_info_email = $_POST['user_info_email'] ?? '';
    $region = $_POST['region'] ?? '';
    $city = $_POST['city'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $street = $_POST['street'] ?? '';

    // Update user info
    $stmt_update_info = $conn->prepare("UPDATE user_info SET user_info_name = ?, user_info_email = ? WHERE user_id = ?");
    $stmt_update_info->bind_param("ssi", $user_info_name, $user_info_email, $user_id);
    if ($stmt_update_info->execute()) {
        $_SESSION['update_action'] = 'user_info_updated';
    } else {
        echo "ERROR: Could not execute query: " . $stmt_update_info->error;
    }
    $stmt_update_info->close();

    // Update address
    $stmt_update_address = $conn->prepare("UPDATE address SET region = ?, city = ?, barangay = ?, street = ? WHERE address_id = ?");
    $stmt_update_address->bind_param("ssssi", $region, $city, $barangay, $street, $address_id);
    if ($stmt_update_address->execute()) {
        $_SESSION['update_action'] = 'address_updated';
    } else {
        echo "ERROR: Could not execute query: " . $stmt_update_address->error;
    }
    $stmt_update_address->close();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Profile - Dream PC | Ecommerce Website</title>
    <link rel="stylesheet" href="../css/style2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
    <style>
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .profile-container h2,
        .profile-container p,
        .profile-container label {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group input[type="file"] {
            border: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkred;
        }
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

        .contain {
            display: flex; /* Use flexbox */
            justify-content: space-between; /* Distribute items evenly along the main axis */
        }

        .row1, .row2, .row3 {
            flex: 1; /* Allow the rows to grow and fill available space */
            padding: 50px;
        }

        .row1 {
            margin-right: 10px; /* Add some spacing between the rows */
        }

        .row2, .row3 {
            margin-right: 10px; /* Add some spacing between the rows */
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
                        </ul>
                    </nav>
                    <a href="user_cart.php?user_id=<?php echo $user_id; ?>">
                        <i class='bx bxs-cart' width="30px" height="30px"></i>
                    </a>  
                    <img src="../images/images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>

    <div class="contain">

        <div class="row1">
            <div class="profile-container">
                <h2>My Profile</h2>
                <form action="user_info.php" method="post">
                    <div class="form-group">
                        <p id="username">Username: <?php echo $_SESSION['user_username']; ?></p>
                    </div>
                    <div class="form-group">
                        <p id="username">Phone Number: <?php echo $user_phone; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="user_info_name" value="<?php echo htmlspecialchars($user_info_name); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="user_info_email" value="<?php echo htmlspecialchars($user_info_email); ?>">
                    </div>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
        
        <div class="row2">
            <div class="profile-container">
                <h2>My Address</h2>
                <form action="user_address.php" method="post">
                    <div class="form-group">
                        <label for="region">Region</label>
                        <input type="text" id="region" name="region" value="<?php echo isset($region) ? htmlspecialchars($region) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo isset($city) ? htmlspecialchars($city) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" id="barangay" name="barangay" value="<?php echo isset($barangay) ? htmlspecialchars($barangay) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" value="<?php echo isset($street) ? htmlspecialchars($street) : ''; ?>">
                    </div>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>

        <div class="row3">
            <div class="profile-container">
                <h2>My Payment</h2>
                <form action="user_payment.php" method="post">
                <div class="form-group">
                    <label for="card-number">Credit Card Number:</label>
                    <input type="text" id="card-number" name="card_number" placeholder="Credit Card Number" required>
                </div>

                <div class="form-group">
                    <label for="exp-month">Exp Month:</label>
                    <input type="text" id="exp-month" name="exp_month" placeholder="MM" maxlength="2" required>
                </div>

                <div class="form-group">
                    <label for="exp-year">Exp Year:</label>
                    <input type="text" id="exp-year" name="exp_year" placeholder="YYYY" maxlength="4" required>
                </div>

                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="CCV" required>
                </div>
                    <button type="submit">Save</button>
                </form>
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
                <tr class = "total-price">
                    <td colspan="3">Total:</td>                    
                    <td><?php echo number_format($total_price, 2); ?> PHP</td>
                </tr>
            </table>
                <td colspan="3">
                    <form action="user_order_received.php" method="post">
                        <button type="submit" name="order_received" class="order-received-btn">Order Received</button>
                    </form>
                </td>
        </div>
    
    <?php
    } else {
        // No items in the cart
        echo "No orders to process.";
    }

    // Close connection
    $conn->close();

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

    <script>
        window.onload = function() {
            // Check if the session variable 'profile_action' is set
            <?php if(isset($_SESSION['profile_action'])): ?>
                var action = "<?php echo $_SESSION['profile_action']; ?>";
                if(action === 'saved') {
                    alert('Profile saved.');
                } else if(action === 'updated') {
                    alert('Profile updated.');
                }
                <?php unset($_SESSION['profile_action']); // Clear the session variable ?>
            <?php endif; ?>
        };
    </script>

</body>
</html>