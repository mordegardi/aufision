<?php session_start() ?>
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

		<section class="about">
			<h3>About</h3>
			<div class="description">
				<p>Aufision in an audio player that will be using Last.fm web-service to play, search and scrobble music in the future. It also can play local files.</p>
				<p>The audio player has written on Qt framework, uses QtMultimedia module to provide multimedia possibilities.</p>
				<p>The audio player has dark skin, but it will be able to change his appearance to different (light, default)</p>
				<p>Authors: <br />Desktop application - Ivan Nikulin <br> Web-development: Vitaly Shonov</p>
			</div>
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
