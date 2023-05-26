<?php session_start(); ?>
<header class="header">
    <div class="logo">
        <img src="logo.png" alt="Movie Site Logo">
    </div>
    <div class="search-container">
        <input class="search" type="text" placeholder="Actors, Movies, Users...">
        <button class="search-button">&#10148;</button>
    </div>
    <div class="login">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<h2>' . $_SESSION['username'] . '</h2><br>';
            echo '<a href="logout.php" class="logout-button style="color: blue;">Logout</a>';
        } else {
            echo '<a href="login.php" class="login-button">Login / Register</a>';
        }
        ?>
    </div>
</header>
