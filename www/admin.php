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
    <form action="add-movie.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="release-date">Release Date:</label>
        <input type="date" name="release-date" id="release-date" required>
        <br>
        <label for="summary">Summary:</label>
        <textarea name="summary" id="summary" rows="4" required></textarea>
        <br>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        <br>
        <input type="submit" value="Add Movie">
    </form>

</div>

<?php require('..\config\footer.php'); ?>


