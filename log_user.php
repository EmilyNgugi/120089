<?php
include_once 'connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the user registration (INSERT) query into the "signup" table
    $stmt_insert = $conn->prepare("INSERT INTO signup (firstname, email, password) VALUES (?, ?, ?)");
    $stmt_insert->bind_param("sss", $username, $email, $hashedPassword);
    $stmt_insert->execute();
    $stmt_insert->close();

    // Redirect to the home page after successful registration
    header('Location: home.php');
    exit();
}

if (isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SELECT query to retrieve hashed password from the "signup" table
    $stmt_select = $conn->prepare("SELECT password, username FROM signup WHERE email = ?");
    $stmt_select->bind_param("s", $email);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $username = $row['username'];

        // Verify the password with the hashed password from the "signup" table
        if (password_verify($password, $storedPassword)) {
            // Prepare and execute the INSERT query to store login details in the "userlogin" table
            $stmt_login = $conn->prepare("INSERT INTO userlogin (username, email) VALUES (?, ?)");
            $stmt_login->bind_param("ss", $username, $email);
            $stmt_login->execute();
            $stmt_login->close();

            // Redirect to the home page after successful login
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
