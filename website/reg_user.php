<?php

$types = array('image/gif', 'image/jpeg', 'image/png');
$size = 10240000;
$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/avatars/';
$uploadfile = $uploaddir . $_FILES['avatar']['name'];

include 'includes/utils.inc.php';

if (isset($_POST['username']) && !empty($_POST['username']))
	$username = makeIfSafe($_POST['username']);

if (isset($_POST['email']) && !empty($_POST['email'])) {
	$email = makeIfSafe($_POST['email']);
}

if (isset($_POST['password']) && !empty($_POST['password']))
	$password = md5(makeIfSafe($_POST['password']) . 'donthackme');

if (isset($_POST['age']) && !empty($_POST['age']))
	$age = (int) makeIfSafe($_POST['age']);

if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {

	if (!in_array($_FILES['avatar']['type'], $types)) {
		$error = 'Incorrent type of the file. Accepts: jpeg, png, gif';
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

} else {
	$avatarname = 'not-found.png';
}

$gender = $_POST['gender'];

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

if ($result) {
	$output = 'This username is already taken';
	include 'failed.php';
	exit();
}
else {
	try {
		$sql = 'INSERT INTO users SET
			username = :username,
			email = :email,
			password = :password,
			age = :age,
			gender = :gender,
			avatar = :avatar';

		$s = $pdo->prepare($sql);
		$s->bindValue(':username', $username);
		$s->bindValue(':email', $email);
		$s->bindValue(':password', $password);
		$s->bindValue(':age', $age);
		$s->bindValue(':gender', $gender);
		$s->bindValue(':avatar', $avatarname);

		$s->execute();

	} catch (PDOException $e) {
		$error = 'Error inserting data into database: ' . $e->getMessage();
		include 'error.php';
		exit();
	}

}

$output = "<br>You signed up successfully";
include 'success.php';
exit();