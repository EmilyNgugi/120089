<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>SIGN-UP</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
    body.sign-up {
     height: 80% ;
    width: 100%;
    background-image: url("images/weight.jpeg");
    background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
  
  }
  </style>
</head>
<body class="sign-up">
  <div class="header">
        <h1><b>SIGN</b>-UP</h1>
  </div>
        
  <form method="post" action="admin_register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
          <label>First Name</label>
          <input type="text" name="firstname" value="<?php echo $firstname; ?>">
        </div>
         <div class="input-group">
          <label>Last Name</label>
          <input type="text" name="lastname" value="<?php echo $lastname; ?>">
        </div>
        <div class="input-group">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" name="password_1">
        </div>
        <div class="input-group">
          <label>Confirm password</label>
          <input type="password" name="password_2">
        </div>
        <div class="input-group">
          <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p>
                Already a member? <a href="admin_login.php">Sign in</a>
        </p>
  </form>
</body>
</html>