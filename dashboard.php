<?php
session_start();
require 'db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT 
            concerts.concert_id, 
            concerts.date, 
            concerts.time, 
            artists.name AS artist_name, 
            venue.venue_name AS venue_name 
        FROM concerts
        JOIN artists ON concerts.artist_id = artists.artist_id
        JOIN venue ON concerts.venue_id = venue.venue_id";
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

    <ul>
    <?php foreach ($concerts as $concert): ?>
            <li>
                <?= htmlspecialchars($concert['artist_name']); ?>
                at
                <?= htmlspecialchars($concert['venue_name']); ?>
                on
                <?= htmlspecialchars($concert['date']); ?> at <?= htmlspecialchars($concert['time']); ?>
                <a href="edit_concert.php?id=<?= $concert['concert_id']; ?>">Edit</a>
                <a href="delete_concert.php?id=<?= $concert['concert_id']; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <button onclick="window.location.href='index.php';">Back to Home</button>

    
</body>