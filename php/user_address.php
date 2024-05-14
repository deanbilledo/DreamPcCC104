<?php
// Start the session
session_start();

// Include your database connection script
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dream_pc_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign the form data to variables
    $region = $_POST['region'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    
    // Retrieve the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Check if the user already has an address record linked in the address_user_link table
    $check_stmt = $conn->prepare("SELECT address_id FROM user_address WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $check_stmt->close();

    if ($result->num_rows > 0) {
        // If an address record exists, update it
        $row = $result->fetch_assoc();
        $address_id = $row['address_id'];
        $update_stmt = $conn->prepare("UPDATE address SET region = ?, city = ?, barangay = ?, street = ? WHERE address_id = ?");
        $update_stmt->bind_param("ssssi", $region, $city, $barangay, $street, $address_id);
        $update_stmt->execute();
        $update_stmt->close();
        $_SESSION['address_action'] = 'updated'; // Set session variable to 'updated'
    } else {
        // If no address record exists, insert a new one
        $insert_stmt = $conn->prepare("INSERT INTO address (region, city, barangay, street) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssss", $region, $city, $barangay, $street);
        $insert_stmt->execute();
        $address_id = $conn->insert_id; // Get the last inserted address_id
        $insert_stmt->close();

        // Link the new address with the user_id in the address_user_link table
        $link_stmt = $conn->prepare("INSERT INTO user_address (user_id, address_id, default_address) VALUES (?, ?, ?)");
        $default_address = 1; // Assuming this is the default address
        $link_stmt->bind_param("iii", $user_id, $address_id, $default_address);
        $link_stmt->execute();
        $link_stmt->close();
        $_SESSION['address_action'] = 'saved'; // Set session variable to 'saved'
    }
}

// Close connection
$conn->close();
?>

<script>
    window.onload = function() {
        // Check if the session variable 'address_action' is set
        <?php if(isset($_SESSION['address_action'])): ?>
            var action = "<?php echo $_SESSION['address_action']; ?>";
            if(action === 'saved') {
                alert('User address saved.');
            } else if(action === 'updated') {
                alert('User address updated.');
            }
            <?php unset($_SESSION['address_action']); // Clear the session variable ?>

            // Redirect to loggedin_profile.php after displaying the alert
            window.location.href = 'loggedin_profile.php';
        <?php endif; ?>
    };
</script>