<?php
session_start();
require_once('..\config\dbconnect.php');

$title = trim($_POST['title']);
$releaseDate = trim($_POST['releasedate']);
$summary = trim($_POST['summary']);
$sql = 'INSERT INTO Movies (title, releasedate, summary) VALUES (:title, :releasedate, :summary)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':releasedate', $releaseDate);
$stmt->bindParam(':summary', $summary);
$stmt->execute();
header('Location: admin.php');
exit();
?>
