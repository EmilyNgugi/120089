


<?php include('connect.php');

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

if (isset($_POST["login_user"]))
{
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $mail = new PHPMailer(true);

  try{
    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = 'emongugi@gmail.com';

    $mail->Password = 'tuvbkyznjqknbxon';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom('emongugi@gmail.com', 'FIT-me');

    $mail->addAddress($email, $username);

    $mail->isHTML(true);

    $verification_code = substr(number_format(rand(), 0, '', ''), 0, 6);
    $mail->Subject = 'FIT-ME Registration and Verification';

// Email body
  $mail->Body = '<p>Dear ' . $username . ',</p>';
  $mail->Body .= '<p>Thank you for registering with FIT-ME. To verify your email address and complete the sign-in process, please use the following verification code:</p>';
  $mail->Body .= '<p><strong>' . $verification_code . '</strong></p>';
  $mail->Body .= '<p>If you did not request this login prompt, please ignore this email.</p>';
  $mail->Body .= '<p>Best regards,<br>FIT-me</p>';


    $mail->send();

    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);


$conn = new mysqli('localhost', 'root', '', 'registration');
$sql = "INSERT INTO users(username, email, password, verification_code, email_verified_at) VALUES ('".$username ."','".$email. "' ,'".$encrypted_password."','".$verification_code."',NULL)";

mysqli_query($conn, $sql);

header("Location:verify2fa.php?email=" . $email);
exit();
  }
  catch(Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
   <style>
    body.login-page {
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

<body class="login-page"> 

  <div class="header">
         <h1><b>LOG</b>-IN</h1>
  </div>
         
  <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" >
        </div>
         <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="">
            </div>
        <div class="input-group">
                <label>Password</label>
                <input type="password" name="password">
        </div>
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
                Not yet a member? <a href="sign-up.php">Sign up</a>
        </p>
        <p>
                For Administrators Only <a href="admin_login.php">Sign in</a>
        </p>

  </form>
</body>
</html>