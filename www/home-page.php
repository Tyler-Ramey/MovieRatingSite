<?php
session_start(); // Start the session
require_once('../config/dbconnect.php');
$sql = 'SELECT * FROM movies ORDER BY releasedate DESC LIMIT 10';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<ul>
    <?php foreach($movies as $movie): ?>
        <li>
            <a href="movie.php?id=<?php echo $movie['MovieID']; ?>">
                <?php echo $movie['Title']; ?>
            </a>
            <?php $_SESSION['MovieID'] = $movie['MovieID']; // Store the movie ID in session ?>
        </li>
    <?php endforeach; ?>
</ul>
