<?php
start_session();
require 'db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist = $_POST['artist'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO concerts (artist, venue, date, time) VALUES (:artist, :venue, :date, :time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['artist' => $artist, 'venue' => $venue, 'date' => $date, 'time' => $time]);

    echo "Concert added successfully!";
    header("Location: dashboard.php");

}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Concert</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Add New Concert</h1>
    <form method="POST">
        <label for="artist">Artist:</label>
        <input type="text" name="artist" required><br>

        <label for="venue">Vanue:</label>
        <input type="text" name="venue" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" required><br>

        <button type="submit">Add Concert</button>
    </form>
</body>
</html>