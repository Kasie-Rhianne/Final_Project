<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();

    }

}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Create an Account</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="password" required><br>

        <button type="submit">Register</button>
    </form>
</body>