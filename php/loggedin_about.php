<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_SESSION['user_id'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Dream PC | Ecommerce Website</title>
    <link rel="stylesheet" href="../css/style.css">
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
                            <li><a href="about.html" style="background-color: wheat; color: black; border-radius: 10px; padding: 5px 10px;">About</a></li>
                            <li><a href="loggedin_contacts.php?user_id=<?php echo urlencode($user_id); ?>">Contact</a></li>
                            <li><a href="loggedin_profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
                        </ul>
                    </nav>
                    <a href="user_cart.php?user_id=<?php echo $user_id; ?>">
                        <i class='bx bxs-cart' width="30px" height="30px"></i>
                    </a>
                    <img src="images/images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>
    
    <!------- about us --------->
    
    <div class="about">
        <div class="about-text">
            <h1 style="background: transparent; color: transparent;">Dream PC</h1>
        </div>
        <img src="../images/dreampc logo.png">
        <div class="row">
            <div class="payment-form">
                <div class="col-2">
                    <div class="about-text">
                        <h5>Founded as a college project at Western Mindanao State University, our PC parts selling site quickly grew beyond campus borders. 
                            With Mia's web development skills and Alex's business savvy, we curated top-notch components and offered educational content. 
                            Our dedication to quality and service garnered a loyal following, fueling expansion across the Philippines and into neighboring markets. 
                            Today, we stand as a trusted destination for PC enthusiasts, with a bright future ahead.</h5>
                    </div>
                </div>
            </div>    
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
                        <img src="images/logoPlaceholder.png">
                    </div>
                </div>
                <div class="footer-col-2">
                    <img src="images/dreampc logo.png">
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