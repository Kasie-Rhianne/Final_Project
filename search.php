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
            artists.name LIKE: query OR
            venue.venue_name LIKE: query OR
            venue.city LIKE: query OR
            venue.state LIKE: query
        ORDER BY concerts.date";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['query' => '%' . $query . '%']);
            $results = $stmt->fetchAll();
        } catch (PDOException $e) {
            die('Error fetching search results: ' . $e->getMessage());
        }
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
</body>