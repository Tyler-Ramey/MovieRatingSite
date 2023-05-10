<!DOCTYPE html>
<html>
<head>
	<title>Login/Register</title>
	<?php include_once('..\config\styles.css'); ?>
</head>
<body>
	<?php require('..\config\header.php'); ?>
    <div class="login-container">
      <div class="login-box">
        <h2>Login</h2>
        <form method="post" action="login-user.php">
          <label for="username">Username:</label>
          <input type="text" name="username" id="username">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password">
          <br>
          <input type="submit" value="Login">
        </form>
      </div>
      <div class="register-box">
        <h2>Register</h2>
        <form method="post" action="register-user.php">
          <label for="firstname">First Name:</label>
          <input type="text" name="firstname" id="firstname">
          <br>
          <label for="lastname">Last Name:</label>
          <input type="text" name="lastname" id="lastname">
          <br>
          <label for="email">Email:</label>
          <input type="email" name="email" id="email">
          <br>
          <label for="username">Username:</label>
          <input type="text" name="username" id="username">
          <br>
          <label for="password">Password:</label>
          <input type="password" name="password" id="password">
          <br>
          <label for="confirm_password">Confirm Password:</label>
          <input type="password" name="confirm_password" id="confirm_password">
          <br>
          <input type="submit" value="Register">
        </form>
      </div>
    </div>

    <?php require('..\config\footer.php'); ?>
</body>
</html>
