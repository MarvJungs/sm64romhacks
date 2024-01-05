<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);

$user_id = $_COOKIE['discord_id'];
$is_Admin = in_array($user_id, ADMIN_SITE) ? true : false;

if (isset($_GET['hack_name'])) {
	$hack_name = $_GET['hack_name'];
	$img_name = stripChars($hack_name);
	$img_name = str_replace(':', '_', $img_name);
	$images = (glob($_SERVER['DOCUMENT_ROOT'] . "/api/images/img_" . $img_name . "_*.{png,jpg}", GLOB_NOSORT | GLOB_BRACE));
	$images = array_map(fn ($image) => explode("/", $image)[sizeof(explode("/", $image)) - 1], $images);
	print(json_encode(array("patches" => getHackFromDatabase($pdo, $hack_name), "images" => $images)));
} else if (isset($_GET['hack_id'])) {
	$hack_id = intval($_GET['hack_id']);
	print(json_encode(getPatchFromDatabase($pdo, $hack_id)));
} else if (!$_GET['hack_name']) {
	print(json_encode(array("hacks" => getAllUniqueHacksFromDatabase($pdo), "tags" => getAllTagsFromDatabase($pdo))));
}
