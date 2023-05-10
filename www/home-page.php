<?php
require_once('../config/dbconnect.php');
$sql = 'SELECT * FROM movies ORDER BY releasedate DESC LIMIT 10';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<ul>
    <?php foreach($movies as $movie): ?>
        <li><?php echo $movie['Title']; ?></li>
    <?php endforeach; ?>
</ul>
