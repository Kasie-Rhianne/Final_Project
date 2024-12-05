<?php
require_once 'db_connect.php'; 

try {
    $query = $pdo->query('SELECT concerts.concert_id, artists.name AS artist_name, venue.venue_name, concerts.date, concerts.time 
    FROM concerts
    JOIN artists ON concerts.artists_id = artists.artist_id
    JOIN venue ON concert.venue_id = venue.venue_id 
    LIMIT 5');
    $items = $query->fetchAll();
} catch (PDOException $e) {
    die('Error fetching data: ' . $e->getMessage());
}
?>