<?php 

session_start();

if ($_SESSION['username']) {
	unset($_SESSION['id']);
	unset($_SESSION['username']);
}

header('Location: /');