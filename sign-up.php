<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="" type="php" href="connect.php">
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    
    <div class="signup-box">
      <h1><b>S</b>ign Up</h1>
      <h4>It's free and only takes a minute</h4>
      <form action="create_user.php" method="post" >
        <label>First Name</label>
        <input type="text" placeholder="" id="firstname" name="firstname" />
        <label>Last Name</label>
        <input type="text" placeholder="" id="lastname"name="lastname" />
        <label>Email</label>
        <input type="email" placeholder=""id="email" name="email" />
        <label>Password</label>
        <input type="password" placeholder="" id="password" name="password" />
        <label>Confirm Password</label>
        <input type="password" placeholder="" id="confirmpassword"name="confirmpassword" />
        <input type="submit" name="submit" value="Submit" />
      
        
      </form>
      <p>
        By clicking the Sign Up button,you agree to our <br />
        <a href="#">Terms and Condition</a> and <a href="#">Policy Privacy</a>
      </p>
    </div>
    <p class="para-2">
      Already have an account? <a href="Log in.php">Login here</a>
    </p>
   
  </body>
</html>

