<?php session_start(); ?>
<header class="header">
    <div class="logo">
        <img src="logo.png" alt="Movie Site Logo">
    </div>
    <form class="search-form" action="../www/search.php" method="GET">
        <div class="search-container">
            <input class="search" type="text" name="query" placeholder="Search Movies and Users...">
            <button class="search-button" type="submit">&#10148;</button>
        </div>
    </form>
    <div class="login">
        <?php
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo '<h3 class="username"><a href="user.php?username=' . $username . '">' . $username . '</a></h3>';
            echo '<a href="logout.php" class="logout-button">Logout</a>';
        } else {
            echo '<a href="login.php" class="login-button">Login / Register</a>';
        }
        ?>
    </div>
</header>
