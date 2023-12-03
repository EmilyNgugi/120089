    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
include('function.php'); 
$db = mysqli_connect('localhost', 'root', '', 'registration');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['delete_account'])) {
        $entered_email = mysqli_real_escape_string($db, $_POST['email']);


    
    $sql = "SELECT email FROM users WHERE email='$entered_email' ";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) == 1) {
       
            $delete_sql = "DELETE FROM users WHERE email='$entered_email'";
           if (mysqli_query($db, $delete_sql)){

             $_SESSION['success'] = "Account deleted";
                header('Location: home.php');
                exit();
            } else {
                $error = "Account deletion failed.";
            }
        } else {
            
            $error = "Email not found. Please input a valid email.";
        }
         } else {
       
        $error = "Invalid email. Please provide a valid email.";
    }
}

           
?>
