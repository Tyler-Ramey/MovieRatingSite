<?php
require_once('../config/dbconnect.php');

// Get the movie ID from the query parameters or any other source
session_start();
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

// Prepare and execute the SQL query to fetch the ratings for the movie and calculate the average rating
$sql = 'SELECT SUM(Rating) AS totalRating, COUNT(*) AS totalRatings FROM ratings WHERE MovieID = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $movieID);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$totalRatings = $result['totalRatings'];
$totalRating = $result['totalRating'];
$averageRating = $totalRatings > 0 ? $totalRating / $totalRatings : 0;
?>

<!-- HTML section to display the movie information -->
<h1><?php echo $movie['Title']; ?></h1>
<p>Release Date: <?php echo $movie['ReleaseDate']; ?></p>
<p>Summary: <?php echo $movie['Summary']; ?></p>
<p>Average Rating: <?php echo number_format($averageRating, 1); ?></p>

<!-- Form for users to rate the movie -->
<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo '
        <form action="process-rating.php" method="POST">
            <input type="hidden" name="movieID" value="' . $movieID . '">
            <input type="hidden" name="username" value="' . $_SESSION['username'] . '">
            <label for="rating">Your Rating:</label>
            <input type="number" name="rating" min="1" max="10" step="0.5" required>
            <br>
            <input type="submit" value="Submit Rating">
        </form>
    ';
}
?>


