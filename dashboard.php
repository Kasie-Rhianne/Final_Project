<?php
session_start();
require 'db_connect';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM concerts";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$concerts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to your Dashboard</h1>
    <a href="logout.php">Logout</a>
    <h2>Manage concerts</h2>

    <a href="add_concert.php">Add New Concert</a>
    
</body>