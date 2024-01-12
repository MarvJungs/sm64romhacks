<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

$user_id = $_COOKIE['discord_id'];

$newsposts = getAllNewspostsFromDatabase($pdo);

foreach ($newsposts as $newspost) {
    $newspost_id = $newspost['post_id'];
    $newspost_author = $newspost['post_author'];
    $newspost_title = $newspost['post_title'];
    $newspost_text = $newspost['post_text'];

    if ($newspost_author == $user_id) {
        updateNewspostInDatabase($pdo, $newspost_id, "0", $newspost_title, $newspost_text);
    }
}

deleteUserFromDatabase($pdo, $user_id);
header("Location: /login/logout.php");
die();
