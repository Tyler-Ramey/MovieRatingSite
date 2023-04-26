<!DOCTYPE html>
<html>
<head>
	<title>Movie Site</title>

    <?php
    // require('config.php');
    include_once('..\config\styles.css');
    ?>
</head>
<body>
	<?php require('..\config\header.php'); ?>
	<main class="main">
		<div class="left-sidebar">
            <?php require('..\config\friends.php'); ?>
		</div>
		<div class="content">
			<h2>Dynamic Content Goes Here</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar est at euismod efficitur. Aliquam eu arcu leo. Nulla facilisi. Etiam rutrum urna quis eros suscipit, in sodales ipsum pretium. Fusce ac elit elit. Maecenas luctus ipsum sed ex posuere, non fringilla lorem imperdiet. Curabitur eget massa vel velit rhoncus egestas vel sit amet lectus. Sed euismod justo vel turpis facilisis interdum.</p>
		</div>
		<div class="right-sidebar">
            <?php require('..\config\activity.php'); ?>
		</div>
	</main>

    <?php require('..\config\footer.php'); ?>

</body>
</html>
