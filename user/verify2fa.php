<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['verification_code'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $entered_code = mysqli_real_escape_string($db, $_POST['verification_code']);
    }

    
    $sql = "SELECT verification_code FROM users WHERE email='$email' AND verification_code ='$entered_code'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_code = $row['verification_code'];

       
        if ($entered_code == $stored_code) {
           
            $update_sql = "UPDATE users SET email_verified_at=NOW() WHERE email='$email'";
            mysqli_query($db, $update_sql);

            $_SESSION['username'] = $email; 
            $_SESSION['success'] = "Email verification successful";
            header('Location: home.php');
            exit();
        } else {
            $error = "Invalid verification code. Please try again.";
        }
    } else {
        $error = "Email not found or verification code expired. Please request a new code.";
    }
}
?>






<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="verify-page">
    <div class="verify">
    <h2>Email Verification</h2>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
        <label for="verification_code">Enter Verification Code:</label>
        <input type="text" name="verification_code" id="verification_code" required>
        <button type="submit">Verify</button>
    </form>
</div>
</body>
</html>
