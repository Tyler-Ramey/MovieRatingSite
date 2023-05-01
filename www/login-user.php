<?php
require_once('..\config\dbconnect.php');

$username = trim($_POST['username']);
$password = $_POST['password'];

$sql = 'SELECT username, password, admin FROM People WHERE username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetch();

if (!$result) {
    //User not found
    $error = "Invalid username or password";
    echo "<p>" . $error . "</p>";
    header("Refresh:5; url=login.php");
    exit();
}

$encryptedPassword = $result['password'];

if (password_verify($password, $encryptedPassword)) {
        // Passwords match
        session_start();
        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        $_SESSION['admin'] = $result['admin'];
        header("Location: index.php");
        exit();
    } else {
        // Passwords don't match
        $error = "Invalid username or password";
        echo "<p>" . $error . "</p>";
        header("Refresh:5; url=login.php");
    }
?>
