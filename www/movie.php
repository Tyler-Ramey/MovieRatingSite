<?php
require_once('../config/dbconnect.php');
require_once('../config/header.php');
include('../config/styles.css');
?>

<div class="movie-box">
    <?php
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

    // Check if the user has already rated the movie
    $userRating = null;
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $sql = 'SELECT Rating FROM ratings WHERE MovieID = :id AND Username = :username';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $movieID);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userRating = $stmt->fetchColumn();
    }
    ?>

    <!-- Movie information -->
    <div class="movie-info">
        <h1><?php echo $movie['Title']; ?></h1>
        <p>Release Date: <?php echo $movie['ReleaseDate']; ?></p>
        <p>Summary: <?php echo $movie['Summary']; ?></p>

        <!-- Display the movie image -->
        <?php
        if (!empty($movie['ImagePath'])) {
            echo '<img src="' . $movie['ImagePath'] . '" alt="Movie Image">';
        }
        ?>
    </div>

    <!-- Average rating -->
    <div class="rating">
        <h2>Average Rating</h2>
        <p><?php echo number_format($averageRating, 1); ?></p>
    </div>

    <!-- Form for users to rate the movie -->
    <?php
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        echo '
            <div class="rating-form">
                <form action="process-rating.php" method="POST">
                    <input type="hidden" name="movieID" value="' . $movieID . '">
                    <input type="hidden" name="username" value="' . $_SESSION['username'] . '">
                    <label for="rating">Your Rating:</label>
                    <input type="number" name="rating" min="1" max="10" step="0.5" value="' . $userRating . '" required>
                    <br>
                    <input type="submit" value="Submit Rating">
                </form>
            </div>
        ';
    }
    ?>

    <!-- Form for users to leave comments -->
    <?php
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        echo '
            <div class="comment-form">
                <form action="process-comment.php" method="POST">
                    <input type="hidden" name="movieID" value="' . $movieID . '">
                    <input type="hidden" name="username" value="' . $_SESSION['username'] . '">
                    <label for="comment">Leave a Comment:</label>
                    <textarea name="comment" rows="4" cols="50"></textarea>
                    <br>
                    <input type="submit" value="Submit Comment">
                </form>
            </div>
        ';
    }
    ?>

    <!-- Display comments -->
    <?php
    $sql = 'SELECT * FROM comments WHERE MovieID = :id ORDER BY PostDate DESC LIMIT 10';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $movieID);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($comments) {
        echo '<div class="comments">';
        echo '<h2>Comments</h2>';
        echo '<ul>';
        foreach ($comments as $index => $comment) {
            echo '<li>';
            echo '<p><strong>Username:</strong> ' . $comment['Username'] . '</p>';
            echo '<p><strong>Comment:</strong> ' . $comment['Comment'] . '</p>';
            echo '<p><strong>Post Date:</strong> ' . $comment['PostDate'] . '</p>';

            // Display the friend request button only if the comment is not made by the current user
            if ($comment['Username'] !== $_SESSION['username']) {
                echo '<button class="friend-request-button">Send Friend Request</button>';
            }

            echo '</li>';

            // Add a line break after each comment, except for the last one
        if ($index < count($comments) - 1) {
            echo '<hr>';
        }
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo '<p>No comments found.</p>';
    }
    ?>
</div>

<?php
require_once('../config/footer.php');
?>
