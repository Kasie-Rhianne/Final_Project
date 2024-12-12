<?php
session_start();
require 'db_connect.php';

if(!isset($_GET['artist_id']) || empty($_GET['artist_id'])) {
    die('Artist ID is required');
}
    $artist_id = $_GET['artist_id'];
    
    try {
        $query =$pdo->prepare('
        SELECT
            artists.name,
            artists.genre,
            artists.bio,
            artists.image_url
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
            concerts.ticket_url,
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
    <header class="hero-section">
        <div class="hero-overlay">
            <h1 class="hero-title">Artist Profile: <?= htmlspecialchars($artist['name']); ?></h1>
            <a href="#concerts" class="cta-button">See Upcoming Concerts</a>
        </div>
    </header>

    <main class="artist-page">
        <div class="artist-profile">
        <?php if ($artist['image_url']): ?>
                <img src="<?= htmlspecialchars($artist['image_url']); ?>" alt="<?= htmlspecialchars($artist['name']); ?>" class="artist-image">
            <?php endif; ?>

            <div class="details">
                <h2><?= htmlspecialchars($artist['name']); ?></h2>
                <p><strong>Genre:</strong> <?= htmlspecialchars($artist['genre']); ?></p>
                <p class="bio"><?= nl2br(htmlspecialchars($artist['bio'])); ?></p>
            </div>           
        </div>

        <section class="concerts-section" id="concerts">
            <h2 class="section-title">Upcoming Concerts</h2>
            <div class="concerts-container">
                <?php if (empty($concerts)): ?>
                    <p>No upcoming concerts for this artist</p>
                <?php else: ?> 
                    <?php foreach ($concerts as $concert): ?>
                        <div class="concert-card">
                        <h3>Concert at <?= htmlspecialchars($concert['venue_name']); ?></h3>
                        <p><strong>City:</strong> <?= htmlspecialchars($concert['city']); ?>, <?= htmlspecialchars($concert['state']); ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($concert['date']); ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($concert['time']); ?></p>
                        <a href="<?= htmlspecialchars($concert['ticket_url']); ?>" target="_blank">Buy Tickets</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

<footer class="footer">
    <p>&copy; 2024 The Music Map. All Rights Reserved</p>
</footer>

<button onclick="window.location.href='index.php';">Back to Home</button>

</body>
</html>
