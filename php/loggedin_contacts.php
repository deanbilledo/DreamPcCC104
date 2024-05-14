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
    <title>Contact Us - Dream PC | Ecommerce Website</title>
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
                        <li>
                            <li><a href="loggedin_index.php?user_id=<?php echo urlencode($user_id); ?>">Home</a></li>    
                            <li><a href="user_products.php?user_id=<?php echo urlencode($user_id); ?>">Products</a></li>
                            <li><a href="loggedin_about.php?user_id=<?php echo urlencode($user_id); ?>">About</a></li>
                            <li><a href="loggedin_contacts.php?user_id=<?php echo urlencode($user_id); ?>"  style="background-color: wheat; color: black; border-radius: 10px; padding: 5px 10px;">Contact</a></li>
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
    
    <div class="offer">
        <div class="small-cointainer">
            <div class="row">
                <div class="col-2">
                    <img src="../images/wmsulocation.png" class="offer-img2">
                </div>
                <div class="col-2">
                    <p>We are located at</p>
                    <h1>Dream PC Head Office</h1>
                    <small>W376+CGQ, Normal Rd, Zamboanga, 7000 Zamboanga del Sur</small>
                    <br>
                    <small>weskita@gmail.com</small>
                    <br>
                    <small>0912873547321</small>
                    <br>
                    <a href="" class="btn">Get Location &#8594;</a>
                </div>
            </div>
        </div>
    </div>


        
        <div class="payment-details">
            <div class="payment-form">
                
                    <header style="text-align: center; font-size: 200%;">Contact Form</header>
                    <form action="insert_message.php" class="form" method="POST">
                        <div class="input-box">
                            <label>Full Name</label>
                            <input type="text" placeholder="Enter full name" required name="full_name"/>
                        </div>
                            <div class="input-box">
                                <label>Address</label>
                                <input type="text" placeholder="Enter address" required name="address"/>
                            </div>
                            <div class="input-box">
                                <div class="input-box">
                                    <label>Phone Number</label>
                                    <input type="text" placeholder="Enter phone number" required name="phone_number"/>
                                </div>
                            </div>
                            <div class="input-box-message">
                                <label for="message">Message</label>
                                <textarea  id="message" placeholder="Enter message" required rows="5" name="message"></textarea>
                            </div>
                            <br>
                            <div style="text-align: center;">
                                <button type="submit" class="btn">Next</button>
                            </div>
                        </div>
                        </form>
                    
            
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