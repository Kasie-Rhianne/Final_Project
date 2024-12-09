<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if ($username && $password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $conn = new mysqli('localhost', 'root', '', 'the_music_map');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        

    }

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

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>