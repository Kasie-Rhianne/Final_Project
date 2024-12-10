<?php
start_session();
require 'db_connect.php';

if(!isset($_GET['artist_id']) &&  !empty($_GET['artist_id'])) {
    $artist_id = $_GET['artist_id'];
    
    try {
        $query =$pdo->prepare('
        SELECT
            artists.name,
            artists.genre,
            artists.bio,
            artists.image_url
            artists.website,
            concerts.concert_id,
            concerts.date,
            concerts.time,
            venue.venue_name,
            venue.city,
            venue.state
        FROM artists
        LEFT JOIN concerts ON concerts.artist_id = artists.artist_id
        LEFT JOIN venue ON concerts.venue_id = venue.venue_id
        WHERE artists.artist_id = :artist_id
        ');
        $query->execute(['artist_id' => $artist_id]);
        $artist = $query->fetch();

        if (!$artist) {
            die('Artist not found!');           
        }
    } catch (PDOException $e) {
        die('Error fetching artist data: ' . $e->getMessage());
    }
} else {
    die('Artist ID is required');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($artist['name']); ?> - The Music Map</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="hero.section">
        <h1>Artist Profile: <?= htmlspecialchars($artist['name']); ?></h1>
        <p>Genre: <?= htmlspecialchars($artist['genre']); ?></p>
        <p>Bio: <?= nl2br(htmlspecialchars($artist['bio'])); ?></p>
        <?php if ($artist['image_url']): ?>
            <img src="<?= htmlspecialchars($artist['image']); ?>" alt="Artist Image">
            <?php endif; ?>
            <p><a href="<?= htmlspecialchars($artist['website']); ?>" target="_blank">Visit Website</a></p>
    </header>
</body>
