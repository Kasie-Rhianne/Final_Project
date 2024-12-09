<?php   
require_once 'db_connect.php'; 

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$results = [];

if (!empty($query)) {
    $sql = "
    SELECT
    concerts.concert_id, 
            concerts.date,
            concerts.time,
            concerts.ticket_url,
            artists.name AS artist_name, 
            artists.genre AS artist_genre,
            venue.venue_name,
            venue.city,
            venue.state
        FROM concerts
        JOIN artists ON concerts.artist_id = artists.artist_id
        JOIN venue ON concerts.venue_id = venue.venue_id
        WHERE
            artists.name LIKE :query OR
            venue.venue_name LIKE :query OR
            venue.city LIKE :query OR
            venue.state LIKE :query
        ORDER BY concerts.date";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="hero-section">
        <div class="hero-content">
            <h1>Search Results</h1>
            <a href="index.php" class="cta-button">Back To Home</a>
        </div>
    </header>

    <section class="concerts-section">
        <h2>Results for: "<?= htmlspecialchars($query); ?>"</h2>
        <div class="concerts-container">
            <?php if ($results): ?>
                <?php foreach ($results as $concert): ?>
                <div class="concert-card">
                    <h3><?= htmlspecialchars($concert['artist_name']); ?></h3>
                    <p><strong>Venue:</strong> <?= htmlspecialchars($concert['venue_name']); ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($concert['date']); ?></p>
                    <p><strong>Time:</strong> <?= htmlspecialchars($concert['time']); ?></p>
                    <a href="<?= htmlspecialchars($concert["ticket_url"]); ?>" target="_blank">Buy Tickets</a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found for your query.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2024 The Music Map. All Rights Reserved</p>
    </footer>

</body>
</html>