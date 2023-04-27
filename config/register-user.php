<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('dbconnect.php');


$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);
$username = trim($_POST['username']);
$password = $_POST['password'];

// Check if user already exists
$sql = 'SELECT * FROM people WHERE username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($result);
//exit();

if ($result['Username'] == $username) {
    //User already exists
    $error = "Username already taken";
    echo "<p>" . $error . "</p>";
    header("Refresh:5; url=..\www\login.php");
} else {
    // Hash password
    $encryptedPass = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user into database
    $sql = 'INSERT INTO people (username, email, firstname, lastname, admin, password)
            VALUES(:username, :email, :firstname, :lastname, 0, :password)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':password', $encryptedPass);
    $stmt->execute();

    // Start session
    session_start();
    session_regenerate_id(true);
    $_SESSION['username'] = $username;
    header("Location: ..\www\index.php");
    exit();
}
?>
