<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $password]);

    echo "Registration Successful!";
}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>