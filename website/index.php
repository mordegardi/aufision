<?php session_start(); 
	include 'includes/db.inc.php';
	
	try {
		$result = $pdo->query("SELECT * FROM `comments`; ");
	} catch(PDOException $e) {
		$error = 'Error selecting comments from database: ' . $e->getMessage();
		include 'error.php';
		exit();
	}

	// foreach ($result as $row) {
	// 	echo $row['name'];
	// };
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
					<li><a href="about.php">About</a></li>
					<?php if (!isset($_SESSION['username'])) { ?>
						<li><a href="signup.php">Sign up</a></li>
						<li><a href="#">Log in</a></li>
					<?php } else { ?>
						<li><a href="AufisionInstaller.exe">Download</a></li>
						<li><a href="edit.php">Edit info</a></li>
						<li><a href="signout.php">Sign out</a></li>
						<span>Hello, <?php echo $_SESSION['username'] . '!' ?></span>
					<?php } ?>
				</ul>
			</nav>
		</header>

		<main>
			<h1>Aufision</h1>
			<p class="description">Aufision is a simple audio player that will be improved in the future.</p>
			<img src="images/player.png" alt="player screenshot">
		</main>

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

		<section class="comments">
			<h3>Comments</h4>
			<?php foreach($result as $row)
					echo '<p>' . $row['name'] . ' ' . $row['date'] . ' ' . $row['comment']; ?>
<form enctype="multipart/form-data" class="comment" action="comment.php"  method="post">
	<p><?php if (isset($_SESSION['username'])) echo $_SESSION['username'] . ","; else echo "You"; ?> post a comment:</p>
  
		<br/>
  		<textarea name="text_comment" cols="82" rows="5"></textarea>
  
   		<button type="submit" name="submit">Add</button>
</form>
		</section>

		<footer class="clearfix">
			<p>&copy; DefaultSoft 2017 </p>
			<a href="https://github.com/mordegardi/aufision" target="_blank" class="github"></a>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>
