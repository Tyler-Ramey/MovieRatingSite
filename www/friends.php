<?php require_once('../config/dbconnect.php'); ?>

<!-- Friend Requests -->
<div class="friend-requests">
    <h2>Friend Requests</h2>
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        // Get the user's friend requests
        $username = $_SESSION['username'];
        $sql = 'SELECT User1Name AS senderUsername
                FROM friends
                WHERE User2Name = :username AND RequestStatus = 0';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($requests) {
            echo '<ul>';
            foreach ($requests as $request) {
                echo '<li>';
                echo '<p>' . $request['senderUsername'] . '</p>';
                echo '<button class="accept-request-button" data-sender="' . $request['senderUsername'] . '">Accept</button>';
                echo '<button class="reject-request-button" data-sender="' . $request['senderUsername'] . '">Reject</button>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No friend requests found.</p>';
        }
    } else {
        echo '<p>Login to see friend requests.</p>';
    }
    ?>
</div>

<!-- User's Friends -->
<div class="user-friends">
    <h2>User's Friends</h2>
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        // Get the user's friends
        $username = $_SESSION['username'];
        $sql = 'SELECT IF(User1Name = :username, User2Name, User1Name) AS friendUsername
        FROM friends
        WHERE (User1Name = :username OR User2Name = :username) AND RequestStatus = 1';


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($friends) {
            echo '<ul>';
            foreach ($friends as $friend) {
                echo '<li>' . $friend['friendUsername'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No friends found.</p>';
        }
    } else {
        echo '<p>Login to see user\'s friends.</p>';
    }
    ?>
</div>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include custom JavaScript file for processing friend requests -->
<script src="process-friend-request.js"></script>
