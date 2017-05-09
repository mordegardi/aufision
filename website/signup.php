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
					<li><a href="/signup.php">Sign up</a></li>
					<li><a href="#">Log in</a></li>
				</ul>
			</nav>
		</header>

		<section>
			<form enctype="multipart/form-data" action="reg_user.php" method="POST">
				<h4>Sign up</h4>
				<hr>
				<label for="username"><span>*</span> Username: </label>
				<input type="text" id="username" name="username" minlength="3" maxlength="20" required>
				<label for="email"><span>*</span> Email: </label>
				<input type="email" id="email" name="email" minlength="3" maxlength="25" required>
				<label for="password"><span>*</span> Password:</label>
				<input type="password" id="password" name="password" minlength="3" maxlength="20" required>
				<label for="age">Age: </label>
				<input type="text" name="age" id="age" maxlength="3">
				<input type="radio" name="gender" id="male" value="male" checked>
				<label for="male">Male</label>
				<input type="radio" name="gender" id="female" value="female">
				<label for="female">Female</label> <br>
				<label>Avatar: </label>
				<input type="file" name="avatar" id="avatar">
				<button type="submit">Sign up</button>
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
