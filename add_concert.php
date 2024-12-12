<?php
session_start();
require 'db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artists = $_POST['artist_id'];
    $venues = $_POST['venue_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO concerts (artist_id, venue_id, date, time) VALUES (:artist_id, :venue_id, :date, :time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['artist_id' => $artists, 'venue_id' => $venues, 'date' => $date, 'time' => $time]);

    echo "Concert added successfully!";
    header("Location: dashboard.php");
    exit();

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
        <label for="artist_id">Artist:</label>
        <select name="artist_id" required>
            <?php
            $artists = $pdo->query("SELECT id, name FROM artists")->fetchAll();
            foreach ($artists as $artist) {
                echo "<option value='" . $artist['id'] . "'>" . $artist['name'] . "</option>";
            }
            ?>
        </select><br>

        <label for="venue_id">Venue:</label>
        <select name="venue_id" required>
            <?php
            $venues = $pdo->query("SELECT id, name FROM venue")->fetchAll();
            foreach ($venues as $venue) {
                echo "<option value='" . $venue['id'] . "'>" . $venue['name'] . "</option>";
            }
            ?>
        </select><br>
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" required><br>

        <button type="submit">Add Concert</button>
    </form>
</body>
</html>