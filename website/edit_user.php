<?php

session_start();

$types = array('image/gif', 'image/jpeg', 'image/png');
$size = 10240000;
$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/avatars/';
$uploadfile = $uploaddir . $_FILES['avatar']['name'];

include 'includes/utils.inc.php';

if (isset($_POST['username']) && !empty($_POST['username']))
	$username = makeIfSafe($_POST['username']);
else
	$username = $_SESSION['username'];

if (isset($_POST['email']) && !empty($_POST['email']))
	$email = makeIfSafe($_POST['email']);
else
	$email = $_SESSION['email'];

if (isset($_POST['password']) && !empty($_POST['password']))
	$password = md5(makeIfSafe($_POST['password']) . 'donthackme');
else
	$password = $_SESSION['password'];

if (isset($_POST['age']) && !empty($_POST['age']))
	$age = (int) makeIfSafe($_POST['age']);
else
	$age = $_SESSION['age'];

if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {

	if (!in_array($_FILES['avatar']['type'], $types)) {
		$error = 'Incorrent type of the file. Correct: jpeg, png, gif';
		include 'error.php';
		exit();
	}

	if ($_FILES['avatar']['size'] > $size) {
		$error = "Size of the file too big";
		include 'error.php';
		exit();
	}

	if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
		$avatarname = $_FILES['avatar']['name'];
	}

} else
	$avatarname = $_SESSION['avatar'];

$gender = $_SESSION['gender'];

include 'includes/db.inc.php';

try {
	$sql = 'SELECT id FROM users WHERE username = :username';
	$s = $pdo->prepare($sql);
	$s->bindValue(':username', $username);
	$s->execute();
} catch (PDOException $e) {
	$error = 'Error selecting items from database: ' . $e->getMessage();
	include 'error.php';
	exit();
}

$result = $s->fetch();

try {
	$sql = 'UPDATE users SET
		username = :username,
		email = :email,
		password = :password,
		age = :age,
		gender = :gender,
		avatar = :avatar 
		WHERE id = :id';

	$s = $pdo->prepare($sql);
	$s->bindValue(':username', $username);
	$s->bindValue(':email', $email);
	$s->bindValue(':password', $password);
	$s->bindValue(':age', $age);
	$s->bindValue(':gender', $gender);
	$s->bindValue(':avatar', $avatarname);
	$s->bindValue(':id', $_SESSION['id']);

	$s->execute();

	$_SESSION['username'] = $username;
	$_SESSION['avatar'] = $avatarname;

} catch (PDOException $e) {
	$error = 'Error inserting data into database: ' . $e->getMessage();
	include 'error.php';
	exit();
}

header('Location: /');
exit();