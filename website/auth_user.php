<?php 

session_start();

include 'includes/utils.inc.php';

if (isset($_POST['username']) && !empty($_POST['username']))
	$username = makeIfSafe($_POST['username']);

if (isset($_POST['password']) && !empty($_POST['password']))
	$password = md5(makeIfSafe($_POST['password']) . 'donthackme');

include 'includes/db.inc.php';

try {
	$sql = 'SELECT * FROM users WHERE username = :username';
	$s = $pdo->prepare($sql);
	$s->bindValue(':username', $username);
	$s->execute();
} catch (PDOException $e) {
	$error = 'Error while selecting items from database: ' . $e->getMessage();
	include 'error.php';
	exit();
}

$result = $s->fetch();

if (!$result) {
	$output = 'User isn\'t exist';
	include 'failed.php';
	exit();
} else {

	if ($password == $result['password']) {
		$_SESSION['id'] = $result['id'];
		$_SESSION['username'] = $result['username'];
		$_SESSION['email'] = $result['email'];
		$_SESSION['age'] = $result['age'];
		$_SESSION['password'] = $result['password'];
		$_SESSION['gender'] = $result['gender'];
		$_SESSION['avatar'] = $result['avatar'];
	} else {
		$output = 'Incorrect password';
		include 'failed.php';
		exit();
	}

}

header('Location: .');
exit();