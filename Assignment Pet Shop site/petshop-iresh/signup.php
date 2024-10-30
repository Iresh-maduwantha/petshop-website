<?php

$host = 'localhost';
$dbname = 'petshop';
$username = 'root';
$password = '';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    
    $checkEmail = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email already exists.";
    } else {
     
        $insertQuery = "INSERT INTO user (name, email, password, confirmpassword) VALUES ('$name', '$email', '$password', '$confirmPassword')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Sign up successful. Please <a href='login.html'>login here</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
