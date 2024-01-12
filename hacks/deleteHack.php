<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

$hack_name = stripChars($_GET['hack_name']);
$hack_id = intval($_GET['hack_id']);

$twitch_handle = strtolower($_COOKIE['twitch_handle']);
$name = strtolower($_COOKIE['name']);
$authors_patch = strtolower(getPatchFromDatabase($pdo, $hack_id)[0]['authors']);
$authors_hack = strtolower(getHackFromDatabase($pdo, $hack_name)[0]['authors']);

$is_author = isUserAuthor($authors_patch) || isUserAuthor(($authors_hack));
if (strlen($hack_name) == 0 && $hack_id == 0 || strlen($hack_name) != 0 && $hack_id != 0 || !filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || (!$is_author && !in_array($_COOKIE['discord_id'], ADMIN_SITE))) {
	header("Location: /hacks/" . getURLEncodedName($hack_name));
	die();
}

//Gets executed if a whole hack should be deleted
if (strlen($hack_name) != 0) {
	//Get data
	$data = getHackFromDatabase($pdo, $hack_name);
	$hack_tags = $data[0]['hack_tags'];
	$img_name = stripChars($hack_name);
	//Get all image names corresponding the hack name
	$images = (glob($_SERVER['DOCUMENT_ROOT'] . "/api/images/img_" . $img_name . "_*.{png,jpg}", GLOB_NOSORT | GLOB_BRACE));
	$images = array_map(fn ($image) => explode("/", $image)[sizeof(explode("/", $image)) - 1], $images);

	//Delete corresponding images
	foreach ($images as $image) {
		unlink($_SERVER['DOCUMENT_ROOT'] . '/api/images/' . $image);
	}

	//Delete Patch and linked entires in the data base
	foreach ($data as $entry) {
		deleteHackAuthorFromDatabase($pdo, $entry['hack_id']);
		deleteHackTagFromDatabase($pdo, $entry['hack_id']);
		unlink($_SERVER['DOCUMENT_ROOT'] . '/patch/' . $entry['hack_patchname'] . '.zip');
		deletePatchFromDatabase($pdo, $entry['hack_id']);
	}
	//Iterate through the hack tags, delete tag from database if not needed anymore
	$hack_tags = explode(", ", $hack_tags);
	foreach ($hack_tags as $tag) {
		if (getHacksByTagFromDatabase($pdo, $tag)[0]['count'] == 0) {
			deleteTagFromDatabase($pdo, $tag);
		}
	}
	header("Location: /hacks");
	die();
}

//Gets executed if a singular patch should be deleted
else {
	//Delete patchfile and linked entires in database
	$data = getPatchFromDatabase($pdo, $hack_id);
	$hack_patchname = $data[0]['hack_patchname'];
	unlink($_SERVER['DOCUMENT_ROOT'] . '/patch/' . $hack_patchname . '.zip');
	deleteHackAuthorFromDatabase($pdo, $hack_id);
	deleteHackTagFromDatabase($pdo, $hack_id);
	deletePatchFromDatabase($pdo, $hack_id);
	header("Location: /hacks/" .  getURLEncodedName($data[0]['hack_name']));
	die();
}
