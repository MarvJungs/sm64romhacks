<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

$post_id = intval($_GET['id']);

if ($post_id == 0 || !filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || !in_array($_COOKIE['discord_id'], ADMIN_SITE)) {
	header("Location: /");
	die();
}

deleteNewspostFromDatabase($pdo, $post_id);

header("Location: /");
die();
