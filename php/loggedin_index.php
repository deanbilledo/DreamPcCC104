<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Start session
session_start();

// Check if user_username is set in session
if(isset($_SESSION['user_username'])) {
    // Retrieve user username from session
    $user_username = $_SESSION['user_username'];
    $user_id = $_SESSION['user_id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user has a cart_id
    if(!isset($_SESSION['cart_id'])) {
        // User doesn't have a cart_id, so create a new cart for the user

        // Insert a new cart record for the user
        $insert_cart_query = $conn->prepare("INSERT INTO cart (user_id, user_username) VALUES (?, ?)");
        $insert_cart_query->bind_param("is", $user_id, $user_username);
        $insert_cart_query->execute();

        // Retrieve the auto-generated cart_id
        $cart_id = $insert_cart_query->insert_id;

        // Store the cart_id in session for future use
        $_SESSION['cart_id'] = $cart_id;

        // Close prepared statement
        $insert_cart_query->close();
    } else {
        // User already has a cart_id
        $cart_id = $_SESSION['cart_id'];
    }

    // Now you have the cart_id associated with the user, either newly created or existing
    // You can use $cart_id in further operations

    // Check if user_id is provided
    if(isset($_GET['user_id'])) {
        // Retrieve user_id from GET parameter
        $user_id = $_GET['user_id'];

        // Retrieve user_username from the user table
        $user_username_query = $conn->prepare("SELECT user_username FROM user WHERE user_id = ?");
        $user_username_query->bind_param("i", $user_id);
        $user_username_query->execute();
        $user_username_result = $user_username_query->get_result();

        if ($user_username_result->num_rows > 0) {
            $user_username_row = $user_username_result->fetch_assoc();
            $user_username = $user_username_row['user_username'];
        } else {
            echo "User not found.";
        }

        // Close prepared statement
        $user_username_query->close();

        // Update cart with user_username
        // $update_cart_query = $conn->prepare("UPDATE cart SET user_username = ? WHERE user_id = ?");
        // $update_cart_query->bind_param("si", $user_username, $user_id);
        // $update_cart_query->execute();

        // // Close prepared statement
        // $update_cart_query->close();
    }
} else {
    echo "User not logged in"; // Display an error message
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream PC | Ecommerce Website</title>
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

    
    <!-----Header----->

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
                            <a href="loggedin_index.php" style="background-color: wheat; color: black; border-radius: 10px; padding: 5px 10px;">Home</a>
                            <li><a href="user_products.php?user_id=<?php echo urlencode($user_id); ?>">Products</a></li>
                            <li><a href="loggedin_about.php?user_id=<?php echo urlencode($user_id); ?>">About</a></li>
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
 

    <!--------  Limited products -------->

    <div class="offer">
        <div class="small-cointainer">
            <div class="row">
                <div class="col-2">
                <h1 style="font-size: 50px">Welcome, <?php echo $_SESSION['user_username']; ?>!</h1>
                    <img src="../images/redpc.jpg" class="offer-img2">
                </div>
                <div class="col-2">
                    <p>Limited Products only available on weskita</p>
                    <h1>Weskita Versikulo 999</h1>
                    <small>Introducing the fiery powerhouse: the Red Gaming PC. With its sleek crimson chassis accented by bold black accents, 
                        this beastly machine is more than just looks. Engineered for performance, it boasts top-of-the-line components,
                         ensuring seamless gameplay and lightning-fast processing. Powered by cutting-edge technology, 
                         it's ready to conquer the most demanding games with ease. From its blazing-fast graphics card 
                         to its overclocked processor, every detail is optimized for an unparalleled gaming experience. 
                         Dominate the virtual battlefield in style with the Red Gaming PC.</small>
                    <a href="#" class="btn">Add to Cart &#8594;</a>
                    <a href="#" class="btn">Buy Now &#8594;</a>
                </div>
            </div>
        </div>
    </div>


    <!-------- Slider Limited products -------->
   

        <div class="slideshow-container">

            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">         
            <img src="../images/rand1.jpg" style="width:100%">         
            </div>
        
            <div class="mySlides fade">         
            <img src="../images/rand2.webp" style="width:100%">          
            </div>
        
            <div class="mySlides fade">          
            <img src="../images/rand3.jpg" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="../images/rand4.webp" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="../images/rand5.png" style="width:100%">
            </div>
        
            <div class="mySlides fade">
                <img src="../images/rand6.webp" style="width:100%">
            </div>
        </div>


     <!-------- Featured Products -------->

     <div class="container">
        <h2 class="title">Featured Products</h2>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <img src="../images/feat1.jpg">
                    <h4>PCX Juego</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">17,995,00 PHP</p>
                </div>    
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="../images/feat2.jpg">
                    <h4>Morphine Prime</h4>
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
                    <img src="../images/feat3.jpg">
                    <h4>Morph G</h4>
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
                    <img src="../images/feat4.jpg">
                    <h4>Morph Hydra</h4>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <p style="color: black;">28,995,00 PHP</p>
                </div>    
            </div>
        </div>

        <!-------- Latest Product -------->

        <!-------- Latest Product -------->

        <h2 class="title">Latest Product</h2>
        <div class="row">
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
        </div>
        <div class="row">
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
     </div>

     <!-------- Limited Product -------->

     <div class="col-1">
        <img src="../images/amd2.png" width="1300px" height="650px">
    </div>

    
 
    

     <!--------- Testimonial --------->

     <div class="Testimonial">
        <div class="small-cointainer">
            <div class="row">
                <div class="col-3">
                    <i class='bx bxs-quote-left' ></i>
                    <p>Incredible value for the quality you get! I was hesitant to buy a PC online, but after reading the reviews and seeing the customizable options available on this e-commerce platform, I decided to take the plunge. I'm so glad I did! The PC exceeded my expectations in every way, and I couldn't be happier with my purchase.</p>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <img src="../images/feedback1.jpg">
                    <h3>Jelo Memo</h3>
                </div>
                <div class="col-3">
                    <i class='bx bxs-quote-left' ></i>
                    <p>I can recommend this e-commerce app enough! The PC I ordered arrived promptly and was expertly packaged to ensure it arrived in perfect condition. The performance is stellar, and the attention to detail in the build is evident. It's clear that this company takes pride in their products and values customer satisfaction.</p>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <img src="../images/feedback2.jpg">
                    <h3>Westika Toria</h3>
                </div>
                <div class="col-3">
                    <i class='bx bxs-quote-left' ></i>
                    <p>Absolutely blown away by the PC I purchased from this e-commerce app! The build quality is superb, and the performance is unmatched. It handles every game I throw at it with ease. Plus, the customer service was excellent, guiding me through the customization process to ensure I got exactly what I needed.</p>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star' ></i>
                    </div>
                    <img src="../images/feedback3.jpg">
                    <h3>Doria Soria Mishima</h3>
                </div>
            </div>
        </div>
     </div>

     <!--------- Brands --------->

     <div class="brands">
        <div class="small-cointainer">
            <h5>In partners with:</h5>
            <div class="row">
                <div class="col-5">
                    <img src="../images/Nvidia_Logo_PNG-removebg-preview.png">
                </div>
                <div class="col-5">
                    <img src="../images/Intel-Logo-1200x911.webp">
                </div>
                <div class="col-5">
                    <img src="../images/amd-symbol.webp">
                </div>
                <div class="col-5">
                    <img src="../images/Gigabyte-Logo.png">
                </div>
                <div class="col-5">
                    <img src="../images/Asus-Logo-1989-removebg-preview.png">
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
                        <p>Please support us!</p>
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

    <!---------loader --------->

    <script>
        // Function to handle click event on menu links
        function handleMenuLinkClick(event) {
            // Prevent the default navigation behavior
            event.preventDefault();
    
            // Get the target URL from the clicked link
            var targetUrl = event.target.getAttribute('href');
    
            // Add a delay before navigating to the target URL
            setTimeout(function() {
                window.location.href = targetUrl; // Navigate to the target URL after 3 seconds
            }, 100); // 3 seconds delay (3000 milliseconds)
        }
    
        // Add event listeners to all the menu links
        window.onload = function() {
            var menuItems = document.getElementById('MenuItems').getElementsByTagName('a');
            for (var i = 0; i < menuItems.length; i++) {
                menuItems[i].addEventListener('click', handleMenuLinkClick);
            }
        };
    </script>

    <!---------slider --------->

    <script>
        let slider = document.querySelector('.slider .list');
        let items = document.querySelectorAll('.slider .list .item');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let dots = document.querySelectorAll('.slider .dots li');

        let lengthItems = items.length - 1;
        let active = 0;
        next.onclick = function(){
            active = active + 1 <= lengthItems ? active + 1 : 0;
            reloadSlider();
        }
        prev.onclick = function(){
            active = active - 1 >= 0 ? active - 1 : lengthItems;
            reloadSlider();
        }
        let refreshInterval = setInterval(()=> {next.click()}, 1111000);
        function reloadSlider(){
            slider.style.left = -items[active].offsetLeft + 'px';
            // 
            let last_active_dot = document.querySelector('.slider .dots li.active');
            last_active_dot.classList.remove('active');
            dots[active].classList.add('active');

            clearInterval(refreshInterval);
            refreshInterval = setInterval(()=> {next.click()}, 3243000);

            
        }

        dots.forEach((li, key) => {
            li.addEventListener('click', ()=>{
                active = key;
                reloadSlider();
            })
        })
        window.onresize = function(event) {
            reloadSlider();
        };
    </script>



</body>
</html>