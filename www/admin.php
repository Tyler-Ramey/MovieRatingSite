<?php
session_start();
if ($_SESSION['admin'] != 1) {
    header('Location: index.php');
    exit();
}
include_once('..\config\styles.css');
?>

<?php require('..\config\header.php'); ?>
<div class='add-movie-container'>
    <form action="add-movie.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>

        <label for="releasedate">Release Date:</label>
        <input type="date" id="releasedate" name="releasedate" required>
        <br>

        <label for="summary">Summary:</label><br>
        <textarea id="summary" name="summary" rows="4" cols="50" required></textarea>
        <br>

        <input type="submit" value="Add Movie">
    </form>
</div>

<?php require('..\config\footer.php'); ?>


