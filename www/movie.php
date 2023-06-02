<?php
require_once('../config/dbconnect.php');
require_once('image-upload.php');

$title = $_POST['title'];
$releaseDate = $_POST['release-date'];
$summary = $_POST['summary'];

// Verify the uploaded image file
if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imagePath = uploadImage($title, $_FILES['image']);

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
