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



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Clients</title>

    <link rel="stylesheet" href="../css/admin_style.css">
 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="./css/admin_style.css">

</head>
<body>
   
<style>
  .forms1 {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding-top: 30px
  }
  .inputs1, .butts1, .button-style {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
  }
  .butts1 {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
  }
  .butts1:hover {
    background-color: #45a049;
  }
  .button-style {
    background-color: #008CBA;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    padding: 10px 20px;
  }
  .button-style:hover {
    background-color: #007B9E;
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
                    
                    <a href="#" class="active">
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
                    
                    <a href="../admin_add_product.html" >
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
        <!--aside section end-->

        <!-- main section start-->
        
            
        <div class="main">

            <form action="" method="get" class="forms1" style="flex-direction: row;">
                <input type="text" name="search" placeholder="Search Users" class="inputs1">
                <button type="submit" class="butts1">Search</button>
                <a href="admin_clients.php" class="button-style">View All Users</a>
            </form>
 


        <div class="addform">
        <?php
    // Establish database connection
    // Replace 'your_host', 'your_username', 'your_password', and 'your_database' with appropriate values
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_GET['search'])){
        // Get search query and prevent SQL injection
        $search = mysqli_real_escape_string($conn, $_GET['search']);

        // Prepare and execute query
        $search_query = "SELECT * FROM user WHERE user_username LIKE ?";
        $stmt = mysqli_prepare($conn, $search_query);
        mysqli_stmt_bind_param($stmt, "s", $search_param);
        $search_param = "%$search%";
        mysqli_stmt_execute($stmt);
        $display_product = mysqli_stmt_get_result($stmt);

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // If search parameter is not set, display all users
        $display_product = mysqli_query($conn, "SELECT * FROM user");
    }

    // Check if there are results
    if ($display_product->num_rows > 0) {
        // Start the table and add styles for the table, th, and td elements
        echo "<h2 style='text-align: center; padding-top: 20px'>Users</h2>";
        echo "<table style='width:100%; text-align: center; border-collapse: collapse;'>";
        echo "<tr style='background-color: #f2f2f2;'><th style='padding: 15px; border: 1px solid #ddd;'>ID</th><th style='padding: 15px; border: 1px solid #ddd;'>Username</th><th style='padding: 15px; border: 1px solid #ddd;'>Phone Number</th><th style='padding: 15px; border: 1px solid #ddd;'>Actions</th></tr>";
        // Output data of each row
        while($row = $display_product->fetch_assoc()) {
            echo "<tr><td style='padding: 15px; border: 1px solid #ddd;'>" . 
            $row["user_id"] . "</td><td style='padding: 15px; border: 1px solid #ddd;'>" . 
            $row["user_username"] . "</td><td style='padding: 15px; border: 1px solid #ddd;'>" . $row["user_phone_number"] . "</td>";
            echo "<td style='padding: 15px; border: 1px solid #ddd;'>
            <a href='remove_user.php?delete=" . $row['user_id'] . "' onclick=\"return confirm('Are You Sure You Want To Delete This User?');\">Delete</a> |
            <a href='remove_user.php?user_id=" . $row["user_id"] . "'>Edit</a>
            </td></tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>0 results</p>";
    }

    // Close connection
    mysqli_close($conn);
?>


        </div>
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