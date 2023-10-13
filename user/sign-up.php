<?php include('connect.php'); ?>
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
        
  <form method="post" action="sign-up.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" value="<?php echo $username; ?>">
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
                Already a member? <a href="login.php">Sign in</a>
        </p>
        <p>
                For Administrators Only <a href="admin_register.php">Sign up</a>
        </p>

  </form>
</body>
</html>