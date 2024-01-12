<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

$path = ltrim($_SERVER['REQUEST_URI'], '/');
$user_id = explode('/', $path);
$user_id = $user_id[1];
if (strlen($user_id) == 0) {
	include("users.php");
} else {
	$user = getUserFromDatabase($pdo, $user_id);
	if (!$user) {
		header("Location: /404.php");
		die();
	}
	include("template.php");
}
