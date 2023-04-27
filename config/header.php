<style>

</style>

<header class="header">
		<div class="logo">
			<img src="..\config\logo.png" alt="Movie Site Logo">
		</div>
        <div class="search-container">
          <input class="search" type="text" placeholder="Actors, Movies, Users...">
          <button class="search-button">&#10148;</button>
        </div>
		<div class="login">
			<?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo '<h2>' . $_SESSION['username'] . '</h2>';
            } else {
                echo '<a href="login.php" class="login-button">Login / Register</a>';
            }
            ?>
		</div>
	</header>
