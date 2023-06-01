<?php
session_start();

// Include the database connection
require_once('..\config\dbconnect.php');
include('..\config\styles.css');

// Get the search query from the URL parameters
$searchQuery = $_GET['query'] ?? '';

// Perform the search query on movies and users
$movies = searchMovies($searchQuery);
$users = searchUsers($searchQuery);

// Function to search movies based on the query
function searchMovies($query) {
    global $pdo;
    $sql = "SELECT * FROM movies WHERE title LIKE '%$query%'";
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $movies;
}

// Function to search users based on the query
function searchUsers($query) {
    global $pdo;
    $sql = "SELECT * FROM people WHERE username LIKE '%$query%'";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Search Results</title>
        <link rel="stylesheet" type="text/css" href="../config/styles.css">
    </head>
    <body>
        <?php require('../config/header.php'); ?>
        <main class="main">
            <div class="left-sidebar">
                <?php require('friends.php'); ?>
            </div>
            <div class="content">
                <div class="container">
                    <h1>Search Results</h1>

                    <?php if (!empty($movies)): ?>
                    <div class="box">
                        <h2>Movies</h2>
                        <ul>
                            <?php foreach ($movies as $movie): ?>
                            <li>
                                <a href="movie.php?id=<?php echo $movie['MovieID']; ?>">
                                    <?php echo $movie['Title']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($users)): ?>
                    <div class="box">
                        <h2>Users</h2>
                        <ul>
                            <?php foreach ($users as $user): ?>
                            <li>
                                <a href="user.php?username=<?php echo $user['Username']; ?>">
                    <?php echo $user['Username']; ?>
                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if (empty($movies) && empty($users)): ?>
                    <p>No results found.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="right-sidebar">
                <?php require('activity.php'); ?>
            </div>
        </main>
        <?php require('../config/footer.php'); ?>
    </body>
</html>
