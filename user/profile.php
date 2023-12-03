<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
 include('connect.php'); 

if (!isset($_SESSION['username'])) {
   
    exit();
}

$username = $_SESSION['username'];

?>


<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; 
        }

        form {
            text-align: center;
        }

    </style>
   
</head>
<body>
    <div class="header">
         <h1><b>USER</b>-PROFILE</h1>
  </div>
    <form method="post">
    
        <p>Welcome, <?php echo $username; ?>!</p>
        
         <div class="input-group">
        <button type="submit" name="edit_profile" formaction="update_profile.php" class="btn">Edit Profile</button>
    </div>
         <div class="input-group">
        <button type="submit" name="change_password" formaction="change_password.php" class="btn">Change Password</button>
    </div>
         <div class="input-group">
        <button type="submit" name="delete_account" formaction="delete_account_form.php"class="btn">Delete Account</button>
    </div>
         <div class="input-group">
        <button type="submit" name="logout"  onclick="return confirmLogout();" class="btn">Logout</button>
    </div>
    </form>
    <script>
    
    function confirmLogout() {
        var result = confirm("Are you sure you want to log out?");
        if (result) {
            // User clicked "OK", redirect to index page
            window.location.href = 'index.php';
        } else {
          
        }
        return false;
    }
</script>
   
</body>
</html>
