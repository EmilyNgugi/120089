<?php
session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

// Get the user's username from the session
$username = $_SESSION['username'];

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// Check the database connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to retrieve user data
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // Display the user's details
    $fullname = $user['username']; // Change to the actual field name in your database
    $email = $user['email']; // Change to the actual field name in your database
    // Add more fields as needed

    mysqli_free_result($result);
} else {
    // Handle the case where the user's data is not found
    echo "User data not found.";
}

// Close the database connection
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <!-- Include your CSS stylesheets and other header content here -->
</head>
<body>
   
    <h1>User Profile</h1>
    <p>Welcome, <?php echo $username; ?>!</p>
    <p><a href="edit_profile.php">Edit Profile</a></p>
    <p><a href="change_password.php">Change Password</a></p>
    <p><a href="delete_account.php">Delete Account</a></p>
  
    <p><a href="logout.php">Logout</a></p>
   
</body>
</html>
