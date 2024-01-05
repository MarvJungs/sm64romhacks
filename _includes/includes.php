<?php

include($_SERVER['DOCUMENT_ROOT'].'/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);
createTagsDatabase($pdo);
createHacksTagsDatabase($pdo);

setcookie("redirect", "/", time() + (86400 * 30), "/");

if(filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN)) {
	$avatar_url = "https://cdn.discordapp.com/avatars/" . $_COOKIE['discord_id']. "/" . $_COOKIE['avatar'] . ".jpg";
}
else setcookie("logged_in", "false", time() + (86400 * 30), "/");
?>
