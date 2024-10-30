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
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $checkUser = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
      
        header("Location: shop.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}

$conn->close();
?>
