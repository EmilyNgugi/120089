<?php
// Establish a database connection (replace with your own database credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'registration';

// Create a database connection
$db = new mysqli($host, $username, $password, $database);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize the $user array
$user = [];

// Assuming the user's username is stored in a session variable
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare and execute a SELECT query to retrieve user data
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Now, the $user variable contains the user's data
        // You can access user data as $user['field_name']
    }

    // Close the database connection
    $stmt->close();
}

// Close the database connection
$db->close();
?>
