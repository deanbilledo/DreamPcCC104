<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Start session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if user_id and cart_details are set in $_GET
if(isset($_GET['user_id'])) {
  // Assign values if they are set
  $user_id = $_GET['user_id'];
} else {
  // Handle the case where one or both parameters are not set
  die("Error: user_id or cart_details not provided.");
}

// Now you can use $user_id and $product_id safely

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Dream PC | Ecommerce Website</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/button_style.css">
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
                    <img src="../images/dreampc logo.png" width="125px">
                </div>
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search...">
                    <button class="search-button" type="button">Search</button>
                </div>
                    <nav>
                        <ul id="MenuItems">
                            <li><a href="loggedin_index.php">Home</a></li>    
                            <li><a href="products.html" style="background-color: wheat; color: black; border-radius: 10px; padding: 5px 10px;">Products</a></li>
                            <li><a href="loggedin_about.php?user_id=<?php echo urlencode($user_id); ?>">About</a></li>
                            <li><a href="loggedin_contacts.php?user_id=<?php echo urlencode($user_id); ?>">Contact</a></li>
                            <li><a href="loggedin_profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
                        </ul>
                    </nav>
                    <!-- Modify the link to pass the user_id -->
                    <a href="user_cart.php?user_id=<?php echo $user_id; ?>">
                        <i class='bx bxs-cart' width="30px" height="30px"></i>
                    </a>
                    <img src="../images/images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>
    
     <div class="small-cointainer">

        <div class="row row-2">
            <h2 class="all">All Products</h2>
            <select>
                <option>Default</option>
                <option>By Price</option>
                <option>By Popularity</option>
                <option>By Rating</option>
                <option>By Sale</option>
            </select>
        </div>
        <div class="row">

        <?php
$display_product = mysqli_query($conn, "SELECT * FROM product");

if(mysqli_num_rows($display_product) > 0){
    // logic to fetch data here

    while($row = mysqli_fetch_assoc($display_product)){
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_description = $row['product_description'];
        $product_quantity = $row['product_quantity']; // Add product quantity
        
        // Check if product quantity is greater than 0
        if($product_quantity > 0) {
?>
            <div class="col-4">
                <div class="card">
                    <img src="../images/product_img/<?php echo $row['product_img']; ?>" style="width: 200px; height: 200px;">
                    <h4><?php echo $product_name ?></h4>
                    <h6><?php echo $product_description ?></h6>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;"><?php echo $product_price ?> PHP</p>
                    <div class="button-container">
                        <a href="user_cart.php?product_id=<?php echo $row['product_id']; ?>&user_id=<?php echo $user_id; ?>" class="product-btn add-to-cart">Add to Cart →</a>
                        <a href="#" class="product-btn buy-now">Buy Now →</a>
                    </div>
                    <a href="./php/product_select.php?details=<?php echo $row['product_id']; ?>" class="product-btn add-to-cart">More Details→</a>
                </div>    
            </div>
<?php
        }
    }
} else {
    echo "<div class='empty_text'>No Products Available</div>";
}
?>

        

        </div>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <img src="../images/all8.jpg">
                    <h4>Hydra I5</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">52,995,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/all7.jpg">
                    <h4>Colorful RTX 3060</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">32,900,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/all6.jpg">
                    <h4>Acer Predetor 12</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">56,995,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/all5.jpg">
                    <h4>Falcon Fury</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">30,500,00 PHP</p>
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <img src="../images/all4.jpg">
                    <h4>PCX Juego</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">37,995,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/all3.jpg">
                    <h4>Morph Pro Art I7</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">185,995,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/all2.jpg">
                    <h4>Griffin Pro</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">44,500,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat8.jpg">
                    <h4>Centaur Studio</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">233,995,00 PHP</p>
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat7.jpg">
                    <h4>Wyvern Studio</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">149,800,00 PHP</p>
                </div>   
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat6.jpg">
                    <h4>Wyrm Pro</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">99,995,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat5.jpg">
                    <h4>Spynx G</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">16,495,00 PHP</p>
                </div>      
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/all1.jpg">
                    <h4>Lenovo LOQ</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">55,500,00 PHP</p>
                </div>  
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat3.jpg">
                    <h4>Chimera NX</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">42,995,00 PHP</p>
                </div>  
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat2.jpg">
                    <h4>Lenovo LOQ</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">55,500,00 PHP</p>
                </div>  
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat4.jpg">
                    <h4>Wyvern Red</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">59,995,00 PHP</p>
                </div>  
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/lat1.jpg">
                    <h4>Inspiron 24</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">51,995,00 PHP</p>
                </div>     
            </div>
        </div>
        <div class="page-btn">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>&#8594;</span>
        </div>
    </div>
    
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
    function navigateTo(url) {
        window.location.href = url; // Redirect to the specified URL
    }
    </script>

</body>
</html>