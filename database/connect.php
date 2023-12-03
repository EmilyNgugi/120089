<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$username = "";
$email    = "";
$errors = array(); 



$conn = mysqli_connect('localhost', 'root', '', 'registration');

if (isset($_POST['reg_user'])) {
  
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

 
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
  }

  
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { 
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

 
  if (count($errors) == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password) 
                          VALUES('$username', '$email', '$password')";
        mysqli_query($conn, $query);
        $id = mysqli_insert_id($conn);
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: home.php');
  }


}

// ... 
// LOGIN USER


$conn = new mysqli('localhost', 'root', '', 'registration');
if (isset($_POST['login_user'])) {
  $username =isset($POST['username'])?mysqli_real_escape_string($conn, $_POST['username']):'';
  $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = isset($_POST['password'])? mysqli_real_escape_string($conn, $_POST['password']):'';

  if (empty($username)) {
        array_push($errors, "Username is required");
  }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password)) {
        array_push($errors, "Password is required");
  }
 
       if (count($errors) == 0) {
        // Perform the login authentication here
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);



        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];


                $_SESSION['success'] = "You are now logged in";
                header("Location: verify2fa.php?email=" . $row['email']);
                exit();
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "User not found");
        }

        mysqli_stmt_close($stmt);
    }
}




//update profile
if (isset($_POST['update_details'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
    $new_full_name = mysqli_real_escape_string($conn, $_POST['new_full_name']);
    $username = $_SESSION['username'];
    
    $update_query = "UPDATE users SET email='$new_email', full_name='$new_full_name' WHERE username='$username'";
    mysqli_query($conn, $update_query);
    
}






//delete account
if (isset($_POST['delete_account'])) {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $username = $_SESSION['username'];
    $password = md5($password);
    
    $delete_query = "DELETE FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $delete_query);
    
    if (mysqli_affected_rows($conn) > 0) {
       
        session_destroy(); 
    } else {
        array_push($errors, "Incorrect password");
    }
}


?>