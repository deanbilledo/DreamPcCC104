<?php
// Database Credentials
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Product</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
    <style>
        .input_fields {
            border-radius: 8px; /* This will give a rounded appearance to the input fields */
            padding: 10px; /* Add padding to make the inputs taller and more balanced */
            border: 1px solid #ddd; /* A subtle border can make the inputs stand out */
            margin-bottom: 10px; /* Adds space between the inputs */
            width: calc(100% - 22px); /* Adjusts the width to account for padding and border */
        }

        .submit_btn {
            border-radius: 8px; /* Consistency in button styling */
            padding: 10px 20px; /* More padding for a better touch area */
            border: none; /* Removes the default border */
            font-size: 16px; /* Increases the font size for better readability */
            margin-top: 10px; /* Adds space above the submit button */
        }
    </style>

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
                    
                    <a href="admin_message.php">
                        <span class="material-symbols-outlined">mail_outline</span>
                        <h3>Messages</h3>
                        <span class="msg_count">14</span>
                    </a>
                    
                    <a href="admin_products.php" >
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
                    
                    <a href="admin_add_product.php" >
                        <span class="material-symbols-outlined">add</span>
                        <h3>Add Product</h3>
                    </a>
                    
                    <a href="#" class="active">
                        <span class="material-symbols-outlined">add</span>
                        <h3>Add Category</h3>
                    </a>

                    <a href="../admin_login.html">
                        <span class="material-symbols-outlined">logout</span>
                        <h3>logout</h3>
                    </a>

                 </div>

            </aside>
        <!--aside section end-->

        <!-- main section start-->
        
            
        <div class="addform" style="width: 50%; margin: 0 auto; text-align: center; border-collapse: collapse; padding-top: 20px;">
            <h2 style='text-align: center;'>Add Products</h2>
            <form action="insert_category.php" class="add_products" method="post" enctype="multipart/form-data">
                <div style="background-color: #f2f2f2; padding: 15px; border: 1px solid #ddd;">
                    <label for="category_name" style="padding-right: 10px;">Category Name:</label>
                    <input type="text" name="category_name" id="category_name" placeholder="Enter Product Name" class="input_fields">
                </div>

                <div style="background-color: #f2f2f2; padding: 15px; border: 1px solid #ddd;">
                    <label for="category_description" style="padding-right: 10px;">Category Description:</label>
                    <input type="text" name="category_description" id="category_description" placeholder="Enter Product Description" class="input_fields" style="height: 60px;">
                </div>

                <div style="padding: 15px; border: 1px solid #ddd;">
                    <input type="submit" name="add_product" class="submit_btn" value="Add Product" style="cursor: pointer; background-color: #4CAF50; color: white;">
                </div>
            </form>

            <?php
            $result = $conn->query("SELECT * FROM product_category");

            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<h2 style='text-align: center;'>Product Categories</h2>";
                echo "<table style='width:100%; text-align: center; border-collapse: collapse;'>";
                echo "<tr style='background-color: #f2f2f2;'><th style='padding: 15px; border: 1px solid #ddd;'>Category ID</th><th style='padding: 15px; border: 1px solid #ddd;'>Category Name</th><th style='padding: 15px; border: 1px solid #ddd;'>Category Description</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["category_id"] . "</td>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["category_name"] . "</td>";
                    echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row["category_description"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align: center;'>No categories found</p>";
            }
            $conn->close();
            ?>


        </div>
        
          
          
          
          
            
        
      
        <!-- main section end-->

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
                        <img src="images/admin3.jpg" alt="" >
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
                    <img src="images/feedback1.jpg" alt="">
                </div>
                <div class="message">
                    <p><b>Cakey</b> Received his order</p>
                </div>
            </div>

            <div class="update">
                <div class="profile-photo">
                    <img src="images/profile-4.jpg" alt="">
                </div>
                <div class="message">
                    <p><b>Steven</b> Received his order</p>
                </div>
            </div>

            <div class="update">
                <div class="profile-photo">
                    <img src="images/profile-5.jpg" alt="">
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