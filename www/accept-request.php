<?php
require_once('..\config\dbconnect.php');

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Check if the sender username is provided
if (!isset($_POST['senderUsername']) || empty($_POST['senderUsername'])) {
    echo json_encode(['success' => false, 'message' => 'Sender username not provided']);
    exit();
}

$receiverUsername = $_SESSION['username'];
$senderUsername = $_POST['senderUsername'];

// Update the friend request status to accepted (set RequestStatus to 1)
$sql = 'UPDATE friends SET RequestStatus = 1 WHERE User1Name = :senderUsername AND User2Name = :receiverUsername';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':senderUsername', $senderUsername);
$stmt->bindParam(':receiverUsername', $receiverUsername);
$stmt->execute();

// Check if the update was successful
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true, 'message' => 'Friend request accepted']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to accept friend request']);
}
?>
