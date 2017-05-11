<?php

		session_start();


	
	if (isset($_POST['submit']) && isset($_SESSION['username'])) {
		$comment = $_POST['text_comment'];
		$data = date("d-m-Y H:i:s");

		include 'includes/db.inc.php';

		try {
			$sql = 'INSERT INTO `comments` SET
					`name` = :username,
					`date` = :data,
					`comment` = :comment ';


			$s = $pdo->prepare($sql);
			$s->bindValue(':username', $_SESSION['username']);
			$s->bindValue(':data', $data);
			$s->bindValue(':comment', $comment);

			$s->execute();

			header('Location: /');
		} catch (PDOException $e) {
			$error = 'Can\'t connect to database: ' . $e->getMessage();
	    	include 'error.php';
    		exit();
		}
	} else die('You can\'t leave a comment! You are not logged in!');


