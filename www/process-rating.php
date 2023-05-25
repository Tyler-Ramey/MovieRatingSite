<?php
require_once('../config/dbconnect.php');

// Get the movie ID from the query parameters or any other source
$movieID = $_POST['movieID'];
$username = $_POST['username'];
$rating = $_POST['rating'];

// Insert the rating into the ratings table
$sql = 'INSERT INTO ratings (MovieID, Rating, Username) VALUES (:movieID, :rating, :username)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':movieID', $movieID);
$stmt->bindParam(':rating', $rating);
$stmt->bindParam(':username', $username);
$stmt->execute();
?>
