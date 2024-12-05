<?php
// Include database connection
require_once 'db_connect.php'; // Ensure this file has your PDO setup

// Fetch example data from a generic table (adjust query for your data)
try {
    $query = $pdo->query('SELECT * FROM items LIMIT 5'); // Replace 'items' with your table name
    $items = $query->fetchAll();
} catch (PDOException $e) {
    die('Error fetching data: ' . $e->getMessage());
}
?>