<?php
require_once 'db_connect.php'; 

try {
    $artistQuery = $pdo->query('SELECT artist_id, name AS artist_name, genre, image_url FROM artists LIMIT 5');
    $featuredArtists = $artistQuery->fetchAll();
} catch (PDOException $e) {
    die('Error fetching genres: ' . $e->getMessage());
}

try {
    $genreQuery = $pdo->query('SELECT DISTINCT genre FROM artists');
    $genres = $genreQuery->fetchAll();
} catch (PDOException $e) {
    die('Error fetching genres: ' . $e->getMessage());
}

$concerts = [];
if (isset($_GET['genre']) && !empty($_GET['genre'])) {
    $genre = $_GET['genre'];

    try {
        $query = $pdo->prepare('
        SELECT 
            concerts.concert_id, 
            concerts.date,
            concerts.time,
            concerts.ticket_url,
            artists.name AS artist_name, 
            artists.genre AS artist_genre,
            artists.artist_id,
            venue.venue_name,
            venue.city,
            venue.state
        FROM concerts
        JOIN artists ON concerts.artist_id = artists.artist_id
        JOIN venue ON concerts.venue_id = venue.venue_id
        WHERE artists.genre = :genre
        ORDER BY concerts.date ASC 
        LIMIT 5
    ');
    $query->execute(['genre' => $genre]);
    $concerts = $query->fetchAll();
    } catch(PDOException $e) {
        die('Error fetching data: ' . $e->getMessage());
    }
} else {
    $query = $pdo->query('
        SELECT 
            concerts.concert_id, 
            concerts.date,
            concerts.time,
            concerts.ticket_url,
            artists.name AS artist_name, 
            artists.genre AS artist_genre,
            artists.artist_id,
            venue.venue_name,
            venue.city,
            venue.state
        FROM concerts
        JOIN artists ON concerts.artist_id = artists.artist_id
        JOIN venue ON concerts.venue_id = venue.venue_id
        ORDER BY concerts.date ASC 
        LIMIT 5
    ');
    $concerts = $query->fetchAll();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Music Map</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="hero-section">
        <div class="hero-content">
            <h1>The Music Map</h1>
            <p>Your ultimate guide to live music and concerts.</p>
            <a href="login.php" class="cta-button">Login</a>
            <a href="about.html" class="cta-button">Learn More</a>
        </div>
        <form action="search.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Search concerts, artists, or venues" required>
            <button type="submit">Search</button>
        </form>

        <form action="index.php" method="GET" class="genre-form">
            <label for="genre">Select Genre:</label>
            <select name="genre" id="genre">
                <option value="">Select Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?=htmlspecialchars($genre['genre']); ?>"
                        <?php if (isset($_GET['genre']) && $_GET['genre'] === $genre['genre']) echo 'selected'; ?>>
                        <?= htmlspecialchars($genre['genre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
        </form>
    </header>

    <section class="concerts-section">
        <h2>Upcoming Concerts</h2>
        <div class="concerts-container">
            <?php foreach ($concerts as $concert): ?>
            <div class="concert-card">
                <h3>
                    <a href="artist.php?artist_id=<?= htmlspecialchars($concert['artist_id']); ?>">
                        <?= htmlspecialchars($concert['artist_name']); ?>
                    </a>
                </h3>
                <p><strong>Venue:</strong> <?= htmlspecialchars($concert['venue_name']); ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($concert['date']); ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($concert['time']); ?></p>
                <a href="<?= htmlspecialchars($concert["ticket_url"]); ?>" target="_blank">Buy Tickets</a>
            </div>
            <?php endforeach; ?>    
        </div>
    </section>

    <section class="featured-artists">
        <h2 class="section-title">Featured Artists</h2>
        <div id="featuredArtistsCarousel" class="carousel-slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item-active">
                    <?php
                    $isFirstItem = true;
                    foreach ($featuredArtists as $artist):
                        $activeClass = $isFirstItem ? 'active' : ''; 
                        $isFirstItem = false;
                    ?>
                    <div class="artist-card <?= $activeClass; ?>">
                        <img src="<?= htmlspecialchars($artist['image_url']); ?>" class="artist-image" alt="<?= htmlspecialchars($artist['image_url']); ?>">
                        <div class="artist-info">
                            <h5 class="artist-name"><?= htmlspecialchars($artist['artist_name']); ?></h5> 
                            <p class="artist-genre"><?= htmlspecialchars($artist['genre']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-prev-control" type="button" data-bs-target="#artistCarousel" data-bs-slide="prev">
                <span class="control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-next-control" type="button" data-bs-target="#artistCarousel" data-bs-slide="next">
                <span class="control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>


    <footer class="footer">
        <p>&copy; 2024 The Music Map. All Rights Reserved</p>
    </footer>
    <script>
        let currentIndex = 0;
        const items = document.querySelectorAll(".artist-card");
        const totalItems = items.length;

        function changeSlide() {
            // Remove active class from the current item
            items[currentIndex].classList.remove("active-slide");

            // Move to the next item (loop back to the first one if at the end)
            currentIndex = (currentIndex + 1) % totalItems;

            // Add active class to the new item
            items[currentIndex].classList.add("active-slide");
        }

        // Change slide every 3 seconds
        setInterval(changeSlide, 3000);
    </script>
</body>
</html>