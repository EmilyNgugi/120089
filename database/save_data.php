<?php
session_start();
if (isset($_POST['email'], $_POST['gender'], $_POST['activity'], $_POST['weight'], $_POST['height'], $_POST['age'], $_POST['goal'], $_POST['targetWeight'], $_POST['weeksToGoal'], $_POST['calories'])) {
    $email = $_POST['email'];
$gender = $_POST['gender'];
$activity = $_POST['activity'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$age = $_POST['age'];
$goal = $_POST['goal'];
$targetWeight = $_POST['targetWeight'];
$weeksToGoal = $_POST['weeksToGoal'];
$calories = $_POST['calories'];
$email = $_SESSION['email'];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$gender = filter_var($gender, FILTER_SANITIZE_STRING);
$activity = filter_var($activity, FILTER_SANITIZE_STRING);
$weight = filter_var($weight, FILTER_SANITIZE_NUMBER_FLOAT);
$height = filter_var($height, FILTER_SANITIZE_NUMBER_FLOAT);
$age = filter_var($age, FILTER_SANITIZE_NUMBER_INT);
$goal = filter_var($goal, FILTER_SANITIZE_STRING);
$targetWeight = filter_var($targetWeight, FILTER_SANITIZE_NUMBER_FLOAT);
$weeksToGoal = filter_var($weeksToGoal, FILTER_SANITIZE_NUMBER_INT);
$calories = filter_var($calories, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


$conn = new mysqli('localhost', 'root', '', 'registration');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $checkEmailQuery = $conn->prepare("SELECT email FROM user_data WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $checkEmailQuery->store_result();

    if ($checkEmailQuery->num_rows > 0) {
        // Update the existing record
        $updateQuery = $conn->prepare("UPDATE user_data SET gender = ?, activity = ?, weight = ?, height = ?, age = ?, goal = ?, targetWeight = ?, weeksToGoal = ?, calories = ? WHERE email = ?");
        $updateQuery->bind_param("ssssssssss", $gender, $activity, $weight, $height, $age, $goal, $targetWeight, $weeksToGoal, $calories, $email);

        if ($updateQuery->execute()) {
            echo "Data updated successfully.";
        } else {
            echo "Error: " . $updateQuery->error;
        }

        $updateQuery->close();
    } else {
        // Insert a new record
        $insertQuery = $conn->prepare("INSERT INTO user_data (email, gender, activity, weight, height, age, goal, targetWeight, weeksToGoal, calories) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertQuery->bind_param("sssssssssd", $email, $gender, $activity, $weight, $height, $age, $goal, $targetWeight, $weeksToGoal, $calories);

        if ($insertQuery->execute()) {
            echo "Data saved successfully.";
        } else {
            echo "Error: " . $insertQuery->error;
        }

        $insertQuery->close();
    }

    
    $checkEmailQuery->close();
    $conn->close();
} else {
    echo "Invalid or missing POST data.";
}
?>