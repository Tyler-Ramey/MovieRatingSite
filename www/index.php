<!DOCTYPE html>
<html>
<head>
	<title>Movie Site</title>
	<style>
	* {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}

	body {
		font-family: Arial, sans-serif;
		font-size: 16px;
		line-height: 1.5;
	}

	.header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100px;
      padding: 10px;
      background-color: #eee;
    }

    .logo {
      width: auto;
      height: auto;
      flex-shrink: 0;
      padding: 10px;
    }

    .search-container {
      display: flex;
      flex-grow: 1;
      margin: 10px;
      justify-content: center;
      align-items: center;
    }

    .search {
      flex-grow: 1;
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      background-color: #fff;
    }

    .search-button {
      background-color: #555;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      padding: 10px;
      cursor: pointer;
    }

    .login {
      display: flex;
      margin: 10px;
      flex-shrink: 0;
      padding-left: 10px;
    }

	.main {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		align-items: flex-start;
		padding: 10px;
	}

	.left-sidebar,
	.right-sidebar {
		flex: auto;
		min-width: auto;
		margin: 10px;
		background-color: #eee;
		padding: 10px;
		border-radius: 5px;
	}

	.content {
		flex: 2;
		min-width: 400px;
		margin: 10px;
		background-color: #fff;
		padding: 10px;
		border-radius: 5px;
		max-width: 800px;
		margin: 0 auto;
	}

	.footer {
		background-color: #eee;
		padding: 10px;
		text-align: center;
	}
</style>

</head>
<body>
	<header class="header">
		<div class="logo">
			<img src="https://www.w3schools.com/images/w3schools_green.jpg" alt="Movie Site Logo">
		</div>
        <div class="search-container">
          <input class="search" type="text" placeholder="Actors, Movies, Users...">
          <button class="search-button">&#10148;</button>
        </div>
		<div class="login">
			<button>Login / Register</button>
		</div>
	</header>
	<main class="main">
		<div class="left-sidebar">
			<div class="friends-box">
				<h2>Friends</h2>
				<p>John Doe</p>
				<p>Jane Smith</p>
                <p>John Doe</p>
				<p>Jane Smith</p>
                <p>John Doe</p>
				<p>Jane Smith</p>
                <p>John Doe</p>
				<p>Jane Smith</p>
                <p>John Doe</p>
				<p>Jane Smith</p>
                <p>John Doe</p>
				<p>Jane Smith</p>
			</div>
		</div>
		<div class="content">
			<h2>Dynamic Content Goes Here</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar est at euismod efficitur. Aliquam eu arcu leo. Nulla facilisi. Etiam rutrum urna quis eros suscipit, in sodales ipsum pretium. Fusce ac elit elit. Maecenas luctus ipsum sed ex posuere, non fringilla lorem imperdiet. Curabitur eget massa vel velit rhoncus egestas vel sit amet lectus. Sed euismod justo vel turpis facilisis interdum.</p>
		</div>
		<div class="right-sidebar">
			<div class="activity-box">
				<h2>Activity</h2>
				<p>Star Wars was added by John Doe</p>
				<p>Jane Smith liked The Matrix</p>
			</div>
		</div>
	</main>
	<footer class="footer">
		Designed by Tyler Ramey for CPSC 365 - Muskingum University
	</footer>
</body>
</html>
