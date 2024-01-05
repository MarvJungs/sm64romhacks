<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);

if ($_COOKIE['logged_in'] == "false") print(json_encode(http_response_code(418)));
else print(json_encode(array("data" => getUserFromDatabase($pdo, $_COOKIE['discord_id']), "admin" => filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) && in_array($_COOKIE['discord_id'], ADMIN_SITE), "logged_in" => filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN))));
