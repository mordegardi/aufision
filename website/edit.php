<?php
	session_start();
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>Aufision</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>

		<header class="clearfix">
			<a class="logo" href="/">Aufision</a>
			<nav>
				<ul>
					<li><a href="/about.php">About</a></li>
					<?php if (!isset($_SESSION['username'])) { ?>
						<li><a href="/signup.php">Sign up</a></li>
						<li><a href="#">Log in</a></li>
					<?php } else { ?>
						<li><a href="/AufisionInstaller.exe">Download</a></li>
						<li><a href="/edit.php">Edit info</a></li>
						<li><a href="/signout.php">Sign out</a></li>
						<span>Hello, <?php echo $_SESSION['username'] . '!' ?></span>
					<?php } ?>
				</ul>
			</nav>
		</header>

		<section>
			<form enctype="multipart/form-data" action="edit_user.php" method="POST">
				<h4>Edit info</h4>
				<hr>
				<img class="avatar" src="<?php echo '/avatars/' . $_SESSION['avatar'] ?>" alt="avatar">
				<label for="username">Username: </label>
				<input type="text" id="username" name="username" value="<?php echo $_SESSION['username'] ?>" autocomplete="off" minlength="3" maxlength="20">
				<label for="email">Email: </label>
				<input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?>" autocomplete="off" minlength="3" maxlength="25">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" autocomplete="off" minlength="3" maxlength="20">
				<label for="age">Age: </label>
				<input type="text" name="age" id="age" value="<?php echo $_SESSION['age'] ?>" maxlength="3">
				<label>Avatar: </label>
				<input type="file" name="avatar" id="avatar" value="<?php echo $_SESSION['avatar'] ?>">
				<button type="submit">Update</button>
			</form>
		</section>

		<form class="login-form" action="auth_user.php" method="POST">
			<img src="images/close_icon.png" alt="close icon">
			<h4>Log in</h4>
			<hr>
			<label for="username"><span>*</span> Username: </label>
			<input type="text" id="username" name="username" maxlength="13" required>
			<label for="password"><span>*</span> Password:</label>
			<input type="password" id="password" maxlength="13" name="password" required>
			<button type="submit">Log in</button>
		</form>
		<div class="overlay"></div>

		<footer class="clearfix">
			<p>&copy; DefaultSoft 2017 </p>
			<a href="https://github.com/mordegardi/aufision" target="_blank" class="github"></a>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>
