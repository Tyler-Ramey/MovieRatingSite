<div class="activity-box">
    <?php
    session_start();

    require_once('../config/dbconnect.php');

    // Check if the user is logged in
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        echo "<p>Login to see activity.</p>";
        exit();
    }

    // Get the logged-in user's friends
    $username = $_SESSION['username'];
    $sql = 'SELECT IF(User1Name = :username, User2Name, User1Name) AS friendUsername
        FROM friends
        WHERE User1Name = :username OR User2Name = :username
        AND RequestStatus = 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the user has any friends
    if (!$friends) {
        echo "<p>No friends found.</p>";
        exit();
    }

    // Build an array of friend usernames
    $friendUsernames = array_column($friends, 'friendUsername');

    // Get the 10 most recent comments on movies made by friends
    $sql = 'SELECT c.Comment, c.PostDate, m.Title, p.Username
        FROM comments AS c
        JOIN movies AS m ON c.MovieID = m.MovieID
        JOIN people AS p ON c.Username = p.Username
        -- Dynamically fills an array with ? placeholders and replaces the ? with the friends username to be used for the IN clause
        WHERE p.Username IN (' . implode(',', array_fill(0, count($friendUsernames), '?')) . ')
        ORDER BY c.PostDate DESC
        LIMIT 10';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($friendUsernames);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the comments
    if ($comments) {
        echo '<h2>Recent Comments by Friends</h2>';
        echo '<ul>';
        foreach ($comments as $comment) {
            echo '<li>';
            echo '<p><strong>Username:</strong> ' . $comment['Username'] . '</p>';
            echo '<p><strong>Movie:</strong> ' . $comment['Title'] . '</p>';
            echo '<p><strong>Comment:</strong> ' . $comment['Comment'] . '</p>';
            echo '<p><strong>Timestamp:</strong> ' . $comment['PostDate'] . '</p>';
            echo '</li>';
            if ($comment !== end($comments)) {
                echo '<hr>'; // Add a horizontal rule after each activity except the last one
            }
        }
        echo '</ul>';
    } else {
        echo "<p>No recent comments found.</p>";
    }
    ?>

</div>
