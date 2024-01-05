<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);

if (isset($_GET['id'])) {
	print(json_encode(getNewspostFromDatabase($pdo, intval($_GET['id']))));
} else {
	print(json_encode(array("news" => getAllNewspostsFromDatabase($pdo))));
}
