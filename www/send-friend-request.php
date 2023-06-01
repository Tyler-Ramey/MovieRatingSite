<?php
require_once('../config/dbconnect.php');

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect or display an error message
    header('Location: login.php');
    exit();
}

// Get the current user's username from the session
$sender = $_SESSION['username'];

// Get the receiver's username from the form submission
$receiver = $_POST['receiver'];

// Get the movie ID
$movieID = $_POST['movieID'];

// Prepare and execute a query to check if a friend request already exists
$sql = 'SELECT * FROM friends WHERE (User1Name = :sender AND User2Name = :receiver) OR (User1Name = :receiver AND User2Name = :sender)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':sender', $sender);
$stmt->bindParam(':receiver', $receiver);
$stmt->execute();
$existingRequest = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingRequest) {
    // Friend request already exists
    echo 'Friend request already sent.';
    redirectWithDelay('movie.php?id=' . $movieID, 5);
    exit();
}

// Prepare and execute a query to insert the friend request into the database
$sql = 'INSERT INTO friends (User1Name, User2Name, RequestStatus) VALUES (:sender, :receiver, 0)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':sender', $sender);
$stmt->bindParam(':receiver', $receiver);
$stmt->execute();

// Handle the success case
echo 'Friend request sent successfully.';
redirectWithDelay('movie.php?id=' . $movieID, 5);

/**
 * Redirects to the specified URL after a given delay.
 *
 * param string $url - The URL to redirect to.
 * param int $delay - The delay in seconds.
 */
function redirectWithDelay($url, $delay)
{
    header("Refresh: $delay; url=$url");
    exit();
}
?>

