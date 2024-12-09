<?php
start_session();
require 'db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist = $_POST['artist'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "UPDATE concerts SET artist = :artist, venue = :venue, date = :date, time = :time WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['artist' => $artsit, 'venue' => $venue, 'date' => $date, 'time' => $time, 'id' => $id]);

    echo "Concert updated successfully!";
    header("Location: dashboard.php");

} else {
    $sql = "SELECT * FROM concerts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $concert = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Concert</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Concert</h1>
    <form method="POST">
        <label for="artist">Artist:</label>
        <input type="text" name="artist" value="<?php echo $concert['artist']; ?>" required><br>

        <label for="venue">Vanue:</label>
        <input type="text" name="venue" value="<?php echo $concert['venue']; ?>" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $concert['date']; ?>" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" value="<?php echo $concert['time']; ?>" required><br>

        <button type="submit">Edit Concert</button>
    </form>
</body>
</html>