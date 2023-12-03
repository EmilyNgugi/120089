<?php
session_start();
include ('connect.php');


if (!isset($_SESSION['email'])) {
    
    header("Location: login.php");
    exit();
}

if (isset($_POST['changePassword'])) {
   
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    
    $email = $_SESSION['email'];
    $currentPasswordFromDatabase = "";

    if (password_verify($currentPassword, $currentPasswordFromDatabase)) {
        // Current password is correct
        if ($newPassword === $confirmPassword) {
           
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            
            $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE email = $email";

            
            if ($conn->query($updateQuery) === TRUE) {
                echo "Password changed successfully!";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "New password and confirm password do not match.";
        }
    } else {
        echo "Incorrect current password.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form method="post" action="change_password.php">
            <label for="currentPassword">Current Password:</label>
            <input type="password" name="currentPassword" required>

            <label for="newPassword">New Password:</label>
            <input type="password" name="newPassword" required>

            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" name="confirmPassword" required>

            <button type="submit" name="changePassword">Change Password</button>
        </form>
    </div>
</body>
</html>
