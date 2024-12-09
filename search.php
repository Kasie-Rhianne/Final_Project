<?php   
require_once 'db_connect.php'; 

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

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
}

?>