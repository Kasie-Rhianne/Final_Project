<?php
start_session();
require 'db_connect.php'

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist = $_POST['artist'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "UPDATE concerts SET artist = :artist, venue = :venue, date = :date, time = :time WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['artist' => $artsit, 'venue' => $venue, 'date' => $date, 'time' => $time, 'id' => $id]);

    echo "Concert updated successfully!";
    header("Location: dashboard.php");

} else {
    $sql
}