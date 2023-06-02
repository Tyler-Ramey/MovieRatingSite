<?php
require_once('../config/dbconnect.php');
require_once('image-upload.php');

$title = $_POST['Title'];
$releaseDate = $_POST['ReleaseDate'];
$summary = $_POST['Summary'];

// Insert the movie into the database with the image path
$sql = 'INSERT INTO movies (Title, ReleaseDate, Summary, ImagePath) VALUES (:title, :releaseDate, :summary, :imagePath)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':releaseDate', $releaseDate);
$stmt->bindParam(':summary', $summary);
$stmt->bindParam(':imagePath', $imagePath);
$stmt->execute();

// Redirect to the admin page after adding the movie
header('Location: admin.php');
exit();
} else {
    die('Error: File upload failed. Please try again.');
}
?>
