<?php
start_session();
require 'db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist = $_POST['artist'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO concerts (artist, venue, date, time) VALUES (:artist, :venue, :date, :time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['artist' => $artist, 'venue' => $venue, 'date' => $date, 'time' => $time]);

    echo "Concert added successfully!";
    header("Location: dashboard.php");

}