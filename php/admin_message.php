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


//echo $user_id;
//echo $product_id;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Messages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
   
    <div class="container">

        <!--aside section start-->
            <aside>
                 <div class="top">
                    <div class="logo">
                        <h2>DREAM<span class="danger">PC</span></h2>
                    </div>
                    <div class="close" id='close_btn'>
                        <span class="material-symbols-outlined">close</span>
                    </div>
                 </div>
                 <!-- end top -->

                 <div class="sidebar">

                    <a href="../admin_dashboard.html">
                        <span class="material-symbols-outlined">grid_view</span>
                        <h3>Dashboard</h3>
                    </a>
                    
                    <a href="admin_clients.php">
                        <span class="material-symbols-outlined">person_outline</span>
                        <h3>Clients</h3>
                    </a>
                    
                    <a href="#">
                        <span class="material-symbols-outlined">insights</span>
                        <h3>Analytics</h3>
                    </a>
                    
                    <a href="#"  class="active">
                        <span class="material-symbols-outlined">mail_outline</span>
                        <h3>Messages</h3>
                        <span class="msg_count"></span>
                    </a>
                    
                    <a href="admin_products.php">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <h3>Products</h3>
                    </a>
                    
                    <a href="#">
                        <span class="material-symbols-outlined">report_gmailerrorred</span>
                        <h3>Reports</h3>
                    </a>

                    <a href="#">
                        <span class="material-symbols-outlined">settings</span>
                        <h3>settings</h3>
                    </a>
                    
                    <a href="admin_add_product.php">
                        <span class="material-symbols-outlined">add</span>
                        <h3>Add Product</h3>
                    </a>
                    
                    <a href="admin_add_category.php">
                        <span class="material-symbols-outlined">add</span>
                        <h3>Add Category</h3>
                    </a>

                    <a href="../admin_login.html">
                        <span class="material-symbols-outlined">logout</span>
                        <h3>logout</h3>
                    </a>
                 </div>

            </aside>

        <main>
        <?php    
            $result = $conn->query("SELECT * FROM admin_message");

            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<h2 style='text-align: center;'>Messages from Contact Us</h2>";
                echo "<table style='width:100%; text-align: center; border-collapse: collapse;'>";
                echo "<tr style='background-color: #f2f2f2;'><th style='padding: 15px; border: 1px solid #ddd;'>Name</th><th style='padding: 15px; border: 1px solid #ddd;'>Email</th><th style='padding: 15px; border: 1px solid #ddd;'>Phone Number</th><th style='padding: 15px; border: 1px solid #ddd;'>Message</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["message_name"] . "</td>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["message_address"] . "</td>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["message_phone_number"] . "</td>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["message_content"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center;'>No messages found</p>";
            }
            $conn->close();
        ?>


        </main>

        <!-- start right section-->
        <div class="right">
            <div class="top">
                    <button id="menu_bar">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                <div class="theme-toggler">
                    <span class="material-symbols-outlined active">light_mode</span>
                    <span class="material-symbols-outlined">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p><b>Dean</b></p>
                        <p>Admin</p>
                        <small class="text-muted"></small>
                    </div>
                    <div class="profile-photo">
                        <img src="../images/admin3.jpg" alt="" >
                    </div>
                </div>
            </div>
            <!-- end top-->

            <!-- start recent updates-->
        <div class="recent_updates">
            <h2>Recent Update</h2>
            <div class="updates">
            <div class="update">
                <div class="profile-photo">
                    <img src="../images/feedback1.jpg" alt="">
                </div>
                <div class="message">
                    <p><b>Cakey</b> Received his order</p>
                </div>
            </div>

            <div class="update">
                <div class="profile-photo">
                    <img src="../images/profile-4.jpg" alt="">
                </div>
                <div class="message">
                    <p><b>Steven</b> Received his order</p>
                </div>
            </div>

            <div class="update">
                <div class="profile-photo">
                    <img src="../images/profile-5.jpg" alt="">
                </div>
                <div class="message">
                    <p><b>Goblin</b> Received his order</p>
                </div>
            </div>

        </div>
        </div>
            <!-- end recent updates-->
        <!-- start sale analytic-->
        <div class="sales_analytics">
            <h2>Sales Analytics</h2>

            <div class="item online">
                <div class="icon">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </div>
                <div class="right_text">
                    <div class="info">
                        <h3>online orders</h3>
                        <small class="text-muted">Last seen 2 Hours</small>
                    </div>
                    <h5 class="danger">-17%</h5>
                    <h3>3849</h3>
                </div>
            </div>

            <div class="item online">
                <div class="icon">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </div>
                <div class="right_text">
                    <div class="info">
                        <h3>online orders</h3>
                        <small class="text-muted">Last seen 2 Hours</small>
                    </div>
                    <h5 class="danger">-17%</h5>
                    <h3>3849</h3>
                </div>
            </div>

            <div class="item online">
                <div class="icon">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </div>
                <div class="right_text">
                    <div class="info">
                        <h3>online orders</h3>
                        <small class="text-muted">Last seen 2 Hours</small>
                    </div>
                    <h5 class="danger">-17%</h5>
                    <h3>3849</h3>
                </div>
            </div>
            
        </div>


        <!-- start sale analytic-->
        <div class="item add_products">
            <div>
                <span class="material-symbols-outlined">add</span>
            </div>
        </div>
        </div>
        <!-- end right section-->
    </div>

    <script src="script.js"></script>
</body>
</html>