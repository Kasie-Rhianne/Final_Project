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

    <form action="submit1.html" method="GET">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name_sent" placeholder="Type your name here">
        <br><br>

        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password here">
        <br><br>

        <button type="submit">Submit</button>
    </form>

</body>
</html>