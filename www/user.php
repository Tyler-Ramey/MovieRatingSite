<?php
session_start();

// Include the database connection
require_once('..\config\dbconnect.php');
include('..\config\styles.css');

// Get the username from the URL parameter
$username = $_GET['username'] ?? '';

// Check if the username is empty or not found
if (empty($username)) {
    echo "<p>User not found.</p>";
    exit();
}

// Get the user's information from the database
$sql = 'SELECT * FROM people WHERE Username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user exists
if (!$user) {
    echo "<p>User not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Page</title>
    </head>
    <body>
        <?php require('..\config\header.php'); ?>

        <main class="main">
            <div class="left-sidebar">
                <?php require('friends.php'); ?>
            </div>
            <div class="content">
                <div class="user-profile">
                    <h1><?php echo $user['Username']; ?></h1>
                    <div class="profile-picture">
                        <!-- Display the user's profile picture here -->
                        <img src="<?php echo $user['ProfilePicture']; ?>" alt="Profile Picture">
                    </div>
                    <div class="user-info">
                        <h2>User Information</h2>
                        <?php if ($user['Username'] === $_SESSION['username']): ?>
                        <!-- Editable form for the currently logged-in user -->
                        <form action="update-user.php" method="POST" enctype="multipart/form-data">
                            <p><strong>Username:</strong> <?php echo $user['Username']; ?></p>
                            <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo $user['Email']; ?>"></p>
                            <p><strong>First Name:</strong> <input type="text" name="firstname" value="<?php echo $user['FirstName']; ?>"></p>
                            <p><strong>Last Name:</strong> <input type="text" name="lastname" value="<?php echo $user['LastName']; ?>"></p>
                            <input type="file" name="profile_picture">
                            <button type="submit">Update Information</button>
                        </form>
                        <?php else: ?>
                        <!-- Display user information for other users -->
                        <p><strong>Username:</strong> <?php echo $user['Username']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
                        <p><strong>First Name:</strong> <?php echo $user['FirstName']; ?></p>
                        <p><strong>Last Name:</strong> <?php echo $user['LastName']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Display the user's 10 most recent rated movies -->
                <div class="recent-movies">
                    <h2>Recent Rated Movies</h2>
                    <?php
                    // Get the user's recent rated movies from the database
                    $sql = 'SELECT m.Title, r.Rating
                FROM movies AS m
                JOIN ratings AS r ON m.MovieID = r.MovieID
                WHERE r.Username = :username
                LIMIT 10';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':username', $user['Username']);
                    $stmt->execute();
                    $recentMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($recentMovies) {
                        echo '<ul>';
                        $count = count($recentMovies);
                        foreach ($recentMovies as $key => $movie) {
                            echo '<li>';
                            echo '<p><strong>Title:</strong> ' . $movie['Title'] . '</p>';
                            echo '<p><strong>Rating:</strong> ' . $movie['Rating'] . '</p>';
                            if ($key < $count - 1) {
                                echo '<hr>'; // Add line break between each movie except the last one
                            }
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo "<p>No recent rated movies found.</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="right-sidebar">
                <?php require('activity.php'); ?>
            </div>
        </main>

        <?php require('..\config\footer.php'); ?>
    </body>
</html>
