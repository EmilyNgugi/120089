<?php 

session_start();
include('function.php');

?>
    
<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="header">
         <h1><b>DELETE</b> ACCOUNT</h1>
  </div>

    <form method="post" action="delete_account.php">
        <div class="input-group">
    <label for="email">Your Email:</label>
    <input type="email" name="email" required>
</div>

 <div class="input-group">
        <label for="password">Enter Your Password to Confirm Deletion:</label>
        <input type="password" name="password" required>
    </div>
 <div class="input-group">
        <button type="submit" class="btn" name="delete_account">Delete Account</button>
    </div>
    </form>
    <p><a href="profile.php">Go back to your profile</a></p>
</body>
</html>
