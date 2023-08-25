<?php
include_once 'connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt_insert = $conn->prepare("INSERT INTO signup (firstname, email, password) VALUES (?, ?, ?)");
    $stmt_insert->bind_param("sss", $username, $email, $hashedPassword);
    $stmt_insert->execute();
    $stmt_insert->close();

    
    header('Location: home.php');
    exit();
}

if (isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt_select = $conn->prepare("SELECT password, username FROM signup WHERE email = ?");
    $stmt_select->bind_param("s", $email);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $username = $row['username'];

        
        if (password_verify($password, $storedPassword)) {
            
            $stmt_login = $conn->prepare("INSERT INTO userlogin (username, email) VALUES (?, ?)");
            $stmt_login->bind_param("ss", $username, $email);
            $stmt_login->execute();
            $stmt_login->close();

            
            header('Location: home.php');
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }
    $stmt_select->close();
}
?>
