<?php
session_start();

require_once('..\config\dbconnect.php');

$maxFailedAttempts = 3;
$lockoutDuration = 60; // in seconds (1 minute)

// Check if the user has exceeded the maximum failed attempts
if (isset($_SESSION['failedAttempts']) && $_SESSION['failedAttempts'] >= $maxFailedAttempts) {
    // Check if the lockout duration has passed
    if (isset($_SESSION['lockoutTime']) && (time() - $_SESSION['lockoutTime']) < $lockoutDuration) {
        // Account is locked, display an error message
        echo "<p>Account locked. Please try again later.</p>";
        header("Refresh: 5; url: login.php");
    } else {
        // Lockout duration has passed, reset the failed attempts
        $_SESSION['failedAttempts'] = 0;
        unset($_SESSION['lockoutTime']);
    }
}

// Validate login credentials
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Query the database to check the credentials
    $sql = 'SELECT username, password, admin FROM People WHERE username = :username';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch();

    if (!$result) {
        // User not found
        $_SESSION['failedAttempts'] = isset($_SESSION['failedAttempts']) ? $_SESSION['failedAttempts'] + 1 : 1;

        // Check if the maximum failed attempts have been reached
        if ($_SESSION['failedAttempts'] >= $maxFailedAttempts) {
            // Set the lockout time
            $_SESSION['lockoutTime'] = time();
            echo "<p>Invalid username or password. Account locked. Please try again later.</p>";
        } else {
            echo "<p>Invalid username or password</p>";
        }

        header("Refresh: 5; url=login.php");
        exit();
    }

    $encryptedPassword = $result['password'];

    if (password_verify($password, $encryptedPassword)) {
        // Passwords match
        $_SESSION['username'] = $username;
        $_SESSION['admin'] = $result['admin'];
        header("Location: index.php");
        exit();
    } else {
        // Passwords don't match
        $_SESSION['failedAttempts'] = isset($_SESSION['failedAttempts']) ? $_SESSION['failedAttempts'] + 1 : 1;

        // Check if the maximum failed attempts have been reached
        if ($_SESSION['failedAttempts'] >= $maxFailedAttempts) {
            // Set the lockout time
            $_SESSION['lockoutTime'] = time();
            echo "<p>Invalid username or password. Account locked. Please try again later.</p>";
        } else {
            echo "<p>Invalid username or password</p>";
        }

        header("Refresh: 5; url=login.php");
        exit();
    }
}
?>
