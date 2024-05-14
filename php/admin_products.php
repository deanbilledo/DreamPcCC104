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
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/admin_style.css">

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
                    
                    <a href="admin_clients.php" >
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
                    
                    <a href="admin_products.php" class="active" >
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
                <a href="admin_products.php" class="button-style">View All Users</a>
            </form>

            <main style="display: flex; justify-content: center;  min-height: 100vh; text-align: center;">

                <div class="addform" style="">
                <section class="display_product">
                <?php

                    if(isset($_GET['search'])){
                        // Establish database connection
                        // Replace 'your_host', 'your_username', 'your_password', and 'your_database' with appropriate values
                        
                        // Get search query and prevent SQL injection
                        $search = mysqli_real_escape_string($conn, $_GET['search']);

                        // Prepare and execute query
                        $search_query = "SELECT * FROM product WHERE product_name LIKE ?";
                        $stmt = mysqli_prepare($conn, $search_query);
                        mysqli_stmt_bind_param($stmt, "s", $search_param);
                        $search_param = "%$search%";
                        mysqli_stmt_execute($stmt);
                        $display_product = mysqli_stmt_get_result($stmt);

                        // Close statement and connection
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                    } else {
                        // If search parameter is not set, display all products
                        // Establish database connection here if not already done
                      

                        $display_product = mysqli_query($conn, "SELECT * FROM product");
                        mysqli_close($conn);
                    }


                    //$display_product = mysqli_query($conn, "SELECT * FROM product");

                    if(mysqli_num_rows($display_product) > 0){
                        echo "<h2>Product Catalog</h2>";
                        echo "<table style='margin-left: auto; width: 1200px; margin-right: auto; border-collapse: collapse;'>";
                        echo "<tr style='background-color: #f2f2f2;'><th style='padding: 15px; border: 1px solid #ddd;'>Product Image</th><th style='padding: 15px; border: 1px solid #ddd;'>Product Name</th><th style='padding: 15px; border: 1px solid #ddd;'>Product Quantity</th><th style='padding: 15px; border: 1px solid #ddd;'>Product Price</th><th style='padding: 15px; border: 1px solid #ddd;'>Product Description</th><th style='padding: 15px; border: 1px solid #ddd;'>Action</th></tr>";
                    
                        while($row = mysqli_fetch_assoc($display_product)) {
                            // Check if product quantity is greater than 0
                            $row_style = ($row['product_quantity'] == 0) ? "style='background-color: rgba(255, 0, 0, 0.2); color: red;'" : ""; // Apply transparent red background if quantity is 0
                            echo "<tr $row_style>";
                            echo "<td style='padding: 15px; border: 1px solid #ddd;'><img src='../images/product_img/" . $row['product_img'] . "' style='width: 100px; height: 100px;'></td>";
                            echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row['product_name'] . "</td>";
                            echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row['product_quantity'] . "</td>";
                            echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row['product_price'] . "</td>";
                            echo "<td style='padding: 15px; border: 1px solid #ddd;'>" . $row['product_description'] . "</td>";
                            echo "<td style='padding: 15px; border: 1px solid #ddd;'>";
                            echo "<a href='product_delete.php?delete=" . $row['product_id'] . "' onclick=\"return confirm('Are You Sure You Want To Delete This Product');\">Delete | </a>";
                            echo " <a href='product_edit.php?update=" . $row['product_id'] . "'>Edit</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</table>";
                    } else {
                        echo "<p style='text-align: center;'>No Products Available</p>";
                    }
                    
                    ?>
                </section>

                </div>
                </main>

        </div>





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
                    <img src="../images/feedback3.jpg" alt="">
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

    <script>
         const  sideMenu = document.querySelector('aside');
        const menuBtn = document.querySelector('#menu_bar');
        const closeBtn = document.querySelector('#close_btn');


        const themeToggler = document.querySelector('.theme-toggler');



        menuBtn.addEventListener('click',()=>{
            sideMenu.style.display = "block"
        })
        closeBtn.addEventListener('click',()=>{
            sideMenu.style.display = "none"
        })

        themeToggler.addEventListener('click',()=>{
            document.body.classList.toggle('dark-theme-variables')
            themeToggler.querySelector('span:nth-child(1').classList.toggle('active')
            themeToggler.querySelector('span:nth-child(2').classList.toggle('active')
        })
    </script>
</body>
</html>