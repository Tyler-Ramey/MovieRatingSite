<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Movie Site</title>

        <?php
        include_once('..\config\styles.css');
        ?>
    </head>
    <body>
        <?php require('..\config\header.php'); ?>
        <main class="main">
            <div class="left-sidebar">
                <?php require('friends.php'); ?>
            </div>
            <div class="content">
                <h2>Recent Movies</h2>
                <?php require('home-page.php'); ?>
            </div>
            <div class="right-sidebar">
                <?php require('activity.php'); ?>
            </div>
        </main>

        <?php require('..\config\footer.php'); ?>
    </body>
</html>
