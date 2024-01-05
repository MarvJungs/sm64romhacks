<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);

if (isset($_GET['user_name'])) {
	$user_name = $_GET['user_name'];
	print(json_encode(getHacksByUserFromDatabase($pdo, $user_name)));
} else print(json_encode(getAllUsersFromDatabase($pdo)));
