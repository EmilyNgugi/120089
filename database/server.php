<?php
session_start();

// initializing variables
$firstname = "";
$lastname = "";
$email    = "";
$errors = array(); 



$db = mysqli_connect('localhost', 'root', '', 'admin');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM admin_credentials WHERE firstname='$firstname' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['firstname'] === $firstname) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO admin_credentials (firstname, lastname, email, password) 
                          VALUES('$firstname','$lastname', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['firstname'] = $firstname;
        $_SESSION['success'] = "You are now logged in";
        header('location: home.php');
  }
}

// ... 
// LOGIN USER
if (isset($_POST['login_user'])) {
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($firstname)) {
        array_push($errors, "First name is required");
  }
  if (empty($password)) {
        array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM admin_credentials WHERE firstname='$firstname' AND lastname='$lastname' AND password='$password' AND email='$email'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['firstname'] = $firstname;
          $_SESSION['success'] = "You are now logged in";
          header('location: verify2fa.php');
        }else {
                array_push($errors, "Wrong username/password combination");
        }
  }
}

?>