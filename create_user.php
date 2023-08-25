 <?php
    include_once 'connect.php';
if(isset($_POST['submit'])) 
   {
      $firstname=$_POST['firstname'];
      $lastname=$_POST['lastname'];
      $email=$_POST['email'];
      $password=$_POST['password'];
      $confirmpassword=$_POST['confirmpassword'];



$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$hashedConfirmPassword = password_hash($confirmpassword, PASSWORD_DEFAULT);
      $sql = "INSERT INTO signup (firstname,lastname,email,password,confirmpassword)
     VALUES ('$firstname','$lastname','$email','$hashedPassword','$hashedConfirmPassword')";

     
   if ($conn->query($sql) === TRUE) {
        header('Location:home.php');
     }
      else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }
}


   if (isset($_POST['firstname'])
    && isset($_POST['lastname']) && isset($_POST['email']) 
    && isset($_POST['password']) && isset($_POST['confirmpassword'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
  }

    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $confirmpassword = validate($_POST['confirmpassword']);
    

    if($password !== $confirmpassword){
        header("Location: sign-up.php?error=The confirmation password  does not match");
        exit();
    }

    else{

        // hashing the password
        $password = md5($password);
    }
   
   ?>