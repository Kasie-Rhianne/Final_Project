<?php
session_start();
require 'db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id === null) {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist_name = $_POST['artist'];    
    $venue_name = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "SELECT artist_id FROM artists WHERE name = :artist_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['artist_name' => $artist_name]);
    $artist = $stmt->fetch();

    if ($artist) {
        $artist_id = $artist['artist_id'];

        $sql = "UPDATE concerts SET artist_id = :artist_id, venue_name = :venue, date = :date, time = :time WHERE concert_id = :concert_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'artist_id' => $artist_id,
            'venue' => $venue_name,
            'date' => $date,
            'time' => $time,
            'concert_id' => $id
        ]);

    echo "Concert updated successfully!";
    header("Location: dashboard.php");
    }
} else {
    $sql = "SELECT c.*, a.name AS artist_name, v.name AS venue_name FROM concerts c
            JOIN artists a ON c.artist_id = a.artist_id
            JOIN venue v ON c.venue_id = v.venue_id
            WHERE concert_id = :concert_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['concert_id' => $id]);
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
        <select name="artist" required>
            <?php
                $stmt = $pdo->prepare("SELECT * FROM artists");
                $stmt->execute();
                $artists = $stmt->fetchAll();

                foreach ($artists as $artist) {
                    $selected = ($artist['artist_id'] == $concert['artist_id']) ? 'selected' : '';
                echo "<option value=\"" . htmlspecialchars($artist['name']) . "\" $selected>" . htmlspecialchars($artist['name']) . "</option>";
            }
            ?>

        <label for="venue">Venue:</label>
        <input type="text" name="venue" value="<?php echo $concert['venue']; ?>" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $concert['date']; ?>" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" value="<?php echo $concert['time']; ?>" required><br>

        <button type="submit">Edit Concert</button>
    </form>
</body>
</html>