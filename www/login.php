<!DOCTYPE html>
<html>
<head>
	<title>Login/Register</title>
	<?php include_once('..\config\styles.css'); ?>
    <style>
        .login-container, .register-container {
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
        }

        .login-box, .register-box {
              margin: 20px;
              padding: 20px;
              border: 1px solid #ccc;
              border-radius: 5px;
              background-color: #eee;
        }

        .login-box {
            margin-right: 10px;
        }

        .register-box {
            margin-left: 10px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
	<?php require('..\config\header.php'); ?>
    <div class="login-container">
      <div class="login-box">
        <h2>Login</h2>
        <form method="post" action="login.php">
          <label for="username">Username:</label>
          <input type="text" name="username" id="username">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password">
          <input type="submit" value="Login">
        </form>
      </div>
      <div class="register-box">
        <h2>Register</h2>
        <form method="post" action="register.php">
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
          <input type="submit" value="Register">
        </form>
      </div>
    </div>

    <?php require('..\config\footer.php'); ?>
</body>
</html>
