<?php
require_once 'db_connect.php'; 

try {
    $query = $pdo->query('
        SELECT 
            concerts.concert_id, 
            concerts.date,
            concerts.time,
            concerts.ticket_url,
            artists.name AS artist_name, 
            artists.genre AS artist_genre,
            venue.venue_na me,
            venue.city
            venue.state
        FROM concerts
        JOIN artists ON concerts.artists_id = artists.artist_id
        JOIN venue ON concert.venue_id = venue.venue_id
        ORDER BY concerts.date ASC 
        LIMIT 5
    ');
    $concerts = $query->fetchAll();
} catch (PDOException $e) {
    die('Error fetching data: ' . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Music Map</title>
</head>
<body>
    <header class="hero-section">
        <div class="hero-content">
            <h1>The Music Map</h1>
            <p>Your ultimate guide to live music and concerts.</p>
            <a href="about.php" class="cta-button">Learn More</a>
        </div>
    </header>

    <section class="concerts-section">
        <h2>Upcoming Concerts</h2>
        <div class="concerts-container">
            <?php foreach ($concerts as $concert): ?>
            <div class="concert-card">
                <h3><?= htmlspecialchars($concert['artist_name']); ?></h3>
                <p><strong>Venue:</strong> <?= htmlspecialchars($concert['venue_name']); ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($concert['date']); ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($concert['time']); ?></p>
                <a href="<?= htmlspecialchars($concert["ticket_url"]); ?>" target="_blank">Buy Tickets</a>
            </div>
            <?php endforeach; ?>    
        </div>
    </section>

</body>
</html>