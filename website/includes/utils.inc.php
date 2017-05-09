<?php

function makeIfSafe($value) {
	$value = trim($value);
	$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	$value = stripslashes($value);

	return $value;
}