<?php 

include('connect.php'); 



if (!isset($_SESSION['username'])) {
   
    exit();
}


$db = mysqli_connect('localhost', 'root', '', 'registration');

$username = $_SESSION['username'];


$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
} else {
     
}


?>
<form method="post" action="update_profile.php">
    <label for="new_email">New Email:</label>
    <input type="email" name="new_email" required>
    
    <label for="new_full_name">New Full Name:</label>
    <input type="text" name="new_full_name" required>
    
    <button type="submit" name="update_details">Update Details</button>
</form>
