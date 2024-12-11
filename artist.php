<?php
session_start();
require 'db_connect.php';

if(!isset($_GET['artist_id']) || !empty($_GET['artist_id'])) {
    die('Artist ID is required');
}
    $artist_id = $_GET['artist_id'];
    
    try {
        $query =$pdo->prepare('
        SELECT
            artists.name,
            artists.genre,
            artists.bio,
            artists.image_url,
            artists.website,
        FROM artists
        WHERE artists.artist_id = :artist_id
        ');
        $query->execute(['artist_id' => $artist_id]);
        $artist = $query->fetch();

        if (!$artist) {
            die('Artist not found!');           
        }

        $concertsQuery = $pdo->prepare('
        SELECT
            concerts.concert_id, 
            concerts.date,
            concerts.time,
            venue.venue_name,
            venue.city,
            venue.state
        FROM concerts
        LEFT JOIN venue ON concerts.venue_id = venue.venue_id

        WHERE concerts.artist_id = :artist_id
        ');
        $concertsQuery->execute(['artist_id' => $artist_id]);
        $concerts = $concertsQuery->fetchAll();

    } catch (PDOException $e) {
        die('Error fetching artist data: ' . $e->getMessage());
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
            <img src="<?= htmlspecialchars($artist['image_url']); ?>" alt="Artist Image">
            <?php endif; ?>
            <p><a href="<?= htmlspecialchars($artist['website']); ?>" target="_blank">Visit Website</a></p>
    </header>

    <section class="concerts-section">
        <h2>Upcoming Concerts</h2>
        <div class="concerts-container">
            <?php if (empty($artist['concert_id'])): ?>
                <p>No upcoming concerts for this artist.</p>
            <?php else: ?>
                <div class="concert-card">
                    <h3>Concert at <?= htmlspecialchars($artist['venue_name']); ?></h3>
                    <p><strong>City:</strong> <?= htmlspecialchars($artist['city']); ?>, <?= htmlspecialchars($artist['state']); ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($artist['date']); ?></p>
                    <p><strong>Time:</strong> <?= htmlspecialchars($artist['time']); ?></p>
                    <a href="<?= htmlspecialchars($artist['ticket_url']); ?>" target="_blank">Buy Tickets</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2024 The Music Map. All Rights Reserved</p>
    </footer>

</body>
</html>
