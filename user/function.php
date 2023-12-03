<?php

$username = "";
$email    = "";
$errors = array(); 



$db = mysqli_connect('localhost', 'root', '', 'registration');



if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
        array_push($errors, "Username is required");
  }
  if (empty($password)) {
        array_push($errors, "Password is required");
  }
 
   
       
        if (count($errors) == 0) {
   if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
           if (password_verify($_POST['password'], $row['password'])) {
          $_SESSION['username'] = $username;
          $_SESSION['id'] = $row['id'];
          $_SESSION['email'] = $row['email']; 
         
             $_SESSION['success'] = "You are now logged in";
          header("Location:verify2fa.php?email=" . $email);
          exit();
        }else {
                array_push($errors, "Wrong username/password combination");
        }
      } else {
         array_push($errors, "Email not found. Please register first.");
      }
    
     mysqli_stmt_close($stmt);
   }
 }
 
}
  
?>