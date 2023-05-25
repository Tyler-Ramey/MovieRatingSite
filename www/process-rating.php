<?php
require_once('../config/dbconnect.php');

// Get the movie ID, username, and rating from the form
$movieID = $_POST['movieID'];
$username = $_POST['username'];
$rating = $_POST['rating'];

// Check if the user already has a rating for the movie
$sql = 'SELECT COUNT(*) FROM ratings WHERE MovieID = :movieID AND Username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':movieID', $movieID);
$stmt->bindParam(':username', $username);
$stmt->execute();
$count = $stmt->fetchColumn();

if ($count > 0) {
    // User already has a rating, update the existing rating
    $sql = 'UPDATE ratings SET Rating = :rating WHERE MovieID = :movieID AND Username = :username';
} else {
    // User does not have a rating, insert a new rating
    $sql = 'INSERT INTO ratings (MovieID, Rating, Username) VALUES (:movieID, :rating, :username)';
}

// Prepare and execute the SQL statement
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':movieID', $movieID);
$stmt->bindParam(':rating', $rating);
$stmt->bindParam(':username', $username);
$stmt->execute();

// Redirect back to the movie page
header("Location: movie.php?id=$movieID");
exit();
?>
