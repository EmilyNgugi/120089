<?php

include('connect.php'); // Include your database connection code

if (isset($_POST['delete_account'])) {
    $password = $_POST['password'];
    $user_id = $_SESSION['user_id'];

    // Hash the entered password for comparison
    $entered_password = md5($password); // Use the appropriate hashing method

    $query = "SELECT * FROM users WHERE id='$user_id' AND password='$entered_password'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        // Password is correct; proceed with account deletion
        // Implement account deletion logic here

        session_destroy();

        $delete_query = "DELETE FROM users WHERE id='$user_id'";
        mysqli_query($db, $delete_query);

        header('location: confirmation.php');
    } else {
        // Password is incorrect; display an error message
        echo "Incorrect password. Account deletion failed.";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
</head>
<body>
    <h2>Delete Your Account</h2>

    <form method="post" action="delete_account.php">
        <label for="password">Enter Your Password to Confirm Deletion:</label>
        <input type="password" name="password" required>
        <button type="submit" name="delete_account">Delete Account</button>
    </form>
    <p><a href="profile.php">Go back to your profile</a></p>
</body>
</html>
