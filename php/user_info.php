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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign the form data to variables
    $user_info_name = $_POST['user_info_name'];
    $user_info_email = $_POST['user_info_email'];
    
    // Retrieve the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Check if the user already has a record in the user_info table
    $check_stmt = $conn->prepare("SELECT user_info_id FROM user_info WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $check_stmt->close();

    

    if ($result->num_rows > 0) {
        // If a record exists, update it
        $update_stmt = $conn->prepare("UPDATE user_info SET user_info_name = ?, user_info_email = ? WHERE user_id = ?");
        $update_stmt->bind_param("ssi", $user_info_name, $user_info_email, $user_id);
        if ($update_stmt->execute()) {
            // Redirect to the profile page after successful update
            $_SESSION['profile_action'] = 'updated';
            header("Location: loggedin_profile.php");
            exit();
        } else {
            // Handle error if update fails
            $_SESSION['profile_action'] = 'saved';
            echo "ERROR: Could not execute query: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        // If no record exists, insert a new one
        $insert_stmt = $conn->prepare("INSERT INTO user_info (user_info_name, user_info_email, user_id) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("ssi", $user_info_name, $user_info_email, $user_id);
        if ($insert_stmt->execute()) {
            // Redirect to the profile page after successful insertion
            header("Location: loggedin_profile.php");
            exit();
        } else {
            // Handle error if insertion fails
            echo "ERROR: Could not execute query: " . $insert_stmt->error;
        }
        $insert_stmt->close();
    }

    // Close the select statement and database connection
    $select_stmt->close();
    $conn->close();
} else {
    // Handle case where user ID is not set
    echo "ERROR: User ID is not set";
}


// Close connection
$conn->close();
?>

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