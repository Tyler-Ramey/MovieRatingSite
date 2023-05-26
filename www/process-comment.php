<?php
require_once('../config/dbconnect.php');

// Get the movie ID from the form submission
$movieID = $_POST['movieID'];

// Get the username and comment from the form submission
$username = $_POST['username'];
$comment = $_POST['comment'];

// Insert the comment into the comments table
$sql = 'INSERT INTO comments (MovieID, Username, Comment, PostDate) VALUES (:movieID, :username, :comment, NOW())';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':movieID', $movieID);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':comment', $comment);
$stmt->execute();

// Redirect back to the movie page after the comment is posted
header('Location: movie.php?id=' . $movieID);
exit();
?>
