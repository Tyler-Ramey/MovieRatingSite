<?php
session_start();

// Include the database connection
require_once('../config/dbconnect.php');

// Get the user's information from the session
$username = $_SESSION['username'];

// Check if the user is logged in
if (empty($username)) {
    echo "<p>User not logged in.</p>";
    exit();
}

// Get the updated user information from the form
$email = $_POST['email'];
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];

// Update the user information in the database
$sql = 'UPDATE people SET Email = :email, FirstName = :firstName, LastName = :lastName WHERE Username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':firstName', $firstName);
$stmt->bindParam(':lastName', $lastName);
$stmt->bindParam(':username', $username);
$stmt->execute();

// Check if the profile picture was uploaded
if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    // Include the image-upload.php file
    require_once('image-upload.php');

    // Call the processImageUpload function from image-upload.php
    $profilePicturePath = uploadImage($username, $_FILES['profile_picture'],);

    // Update the profile picture path in the database
    $sql = 'UPDATE people SET ProfilePicture = :profilePicturePath WHERE Username = :username';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':profilePicturePath', $profilePicturePath);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
}

// Redirect back to the user page after updating the information
header('Location: user.php?username=' . $username);
exit();
