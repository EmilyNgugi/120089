<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="" type="php" href="connect.php">
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="lognavbar">
  <a href="#" class="logo">F<B>M</B>.</a>
</div>
    <div class="login-box">
      <h1><b>L</b>ogin</h1>
      <form action="log_user.php" method="post" >
        <label>Username</label>
        <input type="text" placeholder="" id="username" name="username" />
        <label>Email</label>
        <input type="email" placeholder=""  id="email" name="email" />
        <label>Password</label>
        <input type="password" placeholder=""  id="password" name="password"/>
        &nbsp<input type="submit" name="submit" value="Submit" />
      
    </form>
    </div>
    <p class="para-2">
      <br><br><br>Not have an account? <a href="sign-up.php">Sign Up Here</a>
    </p>
  </body>
</html>
