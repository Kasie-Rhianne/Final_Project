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
    die('Artist ID is required')
}
