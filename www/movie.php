<?php
require_once('../config/dbconnect.php');

// Get the movie ID from the query parameters or any other source
$movieID = $_GET['id'];

// Prepare and execute the SQL query to fetch the movie details
$sql = 'SELECT * FROM movies WHERE MovieID = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $movieID);
$stmt->execute();
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the movie exists
if (!$movie) {
    // Movie not found, display an error message
    echo 'Movie not found';
    exit();
}
?>

<!-- HTML section to display the movie information -->
<h1><?php echo $movie['Title']; ?></h1>
<p>Release Date: <?php echo $movie['ReleaseDate']; ?></p>
<p>Summary: <?php echo $movie['Summary']; ?></p>
<!-- Add more HTML elements as needed to display other movie details -->
